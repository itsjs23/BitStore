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
	<thead>
		<tr>
			<th>S. No.</th>
			<th>Medicine Name</th>
			<th>Medicine Type</th>
			<th>Requested Quantity</th>
			<th>Requested Date</th>
			<th>Actions</th>
		</tr>
	</thead>
	
	<tbody>
	<?php 
	$distributor_id = $_SESSION['myuserid'];
	$store_key = $_GET['store_key'];
	
	$sql 		= "select * from `category` where `store_key` = '$store_key'";
	$result 	= mysqli_query($con,$sql);
	$category 	= array();
	
	while($row = mysqli_fetch_array($result)){
		$category[$row['category_id']] = $row['name'];
	}
	
	if(!empty($distributor_id)){
	$i = 0;
	$sql = 'select inv.inventory_id, inv.requested_quantity, inv.requested_date, m.medicine_name, m.category_id';
	$sql .= ' from `inventory` as inv';
	$sql .= " left join `medicine` as m on (inv.medicine_id = m.medicine_id and m.`store_key` = '$store_key' and inv.`store_key` = '$store_key')";
	$sql .= ' where inv.`distributor_id` = '.$distributor_id;
	$sql .= ' and inv.`status` = '.DHS_DISTRIBUTOR_INVENTORY_STATUS_PENDING;
	
	$result = mysqli_query($con,$sql);
	
	while($row = mysqli_fetch_array($result)):?>
		<tr>
			<td><?php echo ++$i;?></td>
			<td><?php echo $row['medicine_name'];?></td>
			<td><?php echo $category[$row['category_id']];?></td>
			<td><?php echo $row['requested_quantity'];?></td>
			<td><?php echo DhsHelper::formatDate($row['requested_date']);?></td>
			<td><a class="btn btn-small btn-danger" target="_blank" href="index.php?view=process_stock_request&menu=requests&inventory_id=<?php echo $row['inventory_id'];?>&store_key=<?php echo $store_key;?>">Done</a></td>
		</tr>
		
	<?php endwhile;}?>
	</tbody>
</table>

</body>
</html>