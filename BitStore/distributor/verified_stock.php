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
			<th>Quantity Delivered</th>
			<th>Requested Date</th>
			<th>Consignment Sent Date</th>
			<th>Message</th>
			<th>Current Status</th>
		</tr>
	</thead>
	
	<tbody>
	<?php 
	$store_key = $_GET['store_key'];
	$distributor_id = $_SESSION['myuserid'];
	
	$sql 		= "select * from `category` where `store_key` = '$store_key' and `status` <> 0";
	$result 	= mysqli_query($con,$sql);
	$category 	= array();
	
	while($row = mysqli_fetch_array($result)){
		$category[$row['category_id']] = $row['name'];
	}
	
	if(!empty($distributor_id)){
	$i = 0;
	$sql = 'select inv.inventory_id, inv.requested_quantity, inv.message, inv.quantity, inv.requested_date, inv.status, inv.completed_date, m.medicine_name, m.category_id';
	$sql .= ' from `inventory` as inv';
	$sql .= ' left join `medicine` as m on (inv.medicine_id = m.medicine_id)';
	$sql .= ' where inv.`distributor_id` = '.$distributor_id;
	$sql .= " and inv.`store_key` = '$store_key'";
	$sql .= ' and inv.`status` = '.DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED;
	$sql .= ' or inv.`status` = '.DHS_DISTRIBUTOR_INVENTORY_STATUS_CANCEL;
	
	$result = mysqli_query($con,$sql);
	
	while($row = mysqli_fetch_array($result)):?>
		<tr class="<?php echo ($row['status'] == 30) ? 'success': 'error';?>">
			<td><?php echo ++$i;?></td>
			<td><?php echo $row['medicine_name'];?></td>
			<td><?php echo isset($category[$row['category_id']]) ? $category[$row['category_id']] : 'N/A';?></td>
			<td><?php echo $row['requested_quantity'];?></td>
			<td><?php echo $row['quantity'];?></td>
			<td><?php echo DhsHelper::formatDate($row['requested_date']);?></td>
			<td><?php echo DhsHelper::formatDate($row['completed_date']);?></td>
			<td><?php echo $row['message'];?></td>
			<td>
			<?php if($row['status'] == 30): ?>
				Verifed
			<?php else: ?>	
				Cancelled
			<?php endif;?>
			</td>
		</tr>
		
	<?php endwhile;}?>
	</tbody>
</table>


</body>
</html>