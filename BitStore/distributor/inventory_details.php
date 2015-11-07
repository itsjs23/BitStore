<?php

session_start();
if(!isset($_SESSION["myuserid"]) || empty($_SESSION["myuserid"])){
	die('Session is expired. Please do login again.');
}

if(!isset($_GET['store_key']) || empty($_GET['store_key'])){
	die('Request format to access contents is not proper. Select the record properly.');
}

?>
<html>
<head>

<script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
    <link rel="stylesheet"  href="../css/bootstrap.css" type="text/css" />
    <link rel="stylesheet"   href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet"    href="../css/bootstrap-responsive.css" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" type="text/css" />
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    
    
    <style type="text/css">
    	.set-height{
    		height:20px;
    	}
    </style>
</head>
<body class="" style="font-family: sans-serif;">
<?php
    require_once '../config.php';
    require_once '../helper.php';
    require_once '../defines.php';
?>

<table class="table table-stripped">
	<tr>
		<th>S. No.</th>
		<th>Medicine Name</th>
		<th>Medicine Type</th>
		<th>Available Quantity</th>
	</tr>

	<?php 
	$store_key = $_GET['store_key'];
	$dist_id = $_SESSION['myuserid'];
	
	$sql 		= "select * from `category` where `store_key` = '$store_key'";
	$result 	= mysqli_query($con,$sql);
	$category 	= array();
	
	while($row = mysqli_fetch_array($result)){
		$category[$row['category_id']] = $row['name'];
	}
	
	$index = 0;
	$sql = 'select m.`medicine_name`, m.category_id, b.* from medicine as m ';
	$sql .= 'inner join (';
	$sql .= 'select `inventory_id`, `distributor_id`, `medicine_id`, sum(quantity) as quantity, `status`, `store_key` FROM `inventory` ';
	$sql .= "WHERE `distributor_id` = $dist_id and `store_key` = '".$store_key."' and `status` = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED;
	$sql .= ' group by `medicine_id`) as b ';
	$sql .= 'on (m.medicine_id = b.medicine_id) ';
		
	$result = mysqli_query($con,$sql);
	
	while($row = mysqli_fetch_array($result)):?>
		<?php 
			$medicine_id = $row['medicine_id'];
			$result1	= mysqli_query($con,"select sum(quantity) from cust_inventory where medicine_id = $medicine_id");
			$row1	= mysqli_fetch_array($result1);
			$total_sold = $row1['sum(quantity)'];
			$total_sold = ($total_sold == "") ? 0 : $total_sold;
		?>
		<tr>
			<td><?php echo ++$index;?></td>
			<td><?php echo $row['medicine_name'];?></td>
			<td><?php echo isset($category[$row['category_id']]) ? $category[$row['category_id']] : 'N/A' ;?></td>
			<td><?php echo $row['quantity'] - $total_sold;?></td>
		</tr>
	<?php endwhile;?>
	
</table>

</body>
</html>