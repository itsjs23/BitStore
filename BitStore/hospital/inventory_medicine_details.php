<?php

session_start();
if(!isset($_SESSION["type"]) || empty($_SESSION["type"])){
	die('Session is expired. Please do login again.');
}

if(!isset($_GET['medicine_id']) || empty($_GET['medicine_id'])){
	die('Request format to access contents is not proper. Select the record properly.');
}

$medicine_id = $_GET['medicine_id'];
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
    
    $store_key = $_SESSION['mystoreid'];
    
    $records = array();
	$result	 = mysqli_query($con,"select medicine.medicine_name, inventory.* from `medicine` inner join
				(select * from inventory where `store_key` = '$store_key' and status = 30 and medicine_id = $medicine_id) as inventory 
				on (medicine.`medicine_id` = inventory.`medicine_id`)");
	?>
	
	
        <table class="table table-striped">
        	<thead>
        		<tr>
		            <th>No</th>
		            <th>Medicine</th>
		            <th>Barcode</th>
		            <th>Quantity</th>
		            <th>UnitCost</th>
		            <th>Subtotal</th>
		            <th>Mfg. Date</th>
		            <th>Exp. Date</th>
		            <th>Total</th>
		            <th>Return Stock</th>
		          </tr>
        	</thead>
        	
        	<tbody>
				<?php while($row = mysqli_fetch_array($result)){ $i = 0;?>
				<?php 
					$barcode = $row['barcode'];
					
					if(empty($barcode)){
						$a = 0;
					}
					else{
						$sql  = 'SELECT '; 
						$sql .= '( ';
						$sql .= "(select COALESCE(`quantity`, 0) from `inventory` where `barcode` = $barcode and status = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED.") ";
						$sql .= " - ";
						$sql .= "(select COALESCE(sum(`quantity`), 0) as quantity from `cust_inventory` where `barcode` = $barcode and status <> 0) "; 
					    $sql .= ' - ';
					    $sql .= "(select COALESCE(sum(`quantity`), 0) as quantity from `return_stock` where `barcode` = $barcode and status <> 0) ";
					    $sql .= ') as remaining';
						
						$res	= mysqli_query($con,$sql);
						$rem	= mysqli_fetch_array($res);
						$a		= $rem['remaining'];
					}
				?>
              <tr>
	              <td><?php echo ++$i;?></td>
	              <td><?php echo 	$row['medicine_name'];?></td>
	              <td><?php echo 	$row['barcode'];?></td>
	              <td><?php echo 	$a;?></td>
	              <td><?php echo 	DhsHelper::formatPrice($row['unit_cost']);?></td>
	              <td><?php echo 	DhsHelper::formatPrice($row['subtotal']);?></td>
	              <td><?php echo 	DhsHelper::formatDate($row['mfg_date']);?></td>
	              <td><?php echo 	DhsHelper::formatDate($row['expiry_date']);?></td>
	              <td><?php echo 	DhsHelper::formatPrice($row['total']);?></td>
	              <td>
	              	<?php if($a > 0):?>
	              	<a href="<?php echo DHS_ROOT;?>index.php?view=return_stock&menu=medicine&medicine_id=<?php echo $row['medicine_id'];?>&inventory_id=<?php echo $row['inventory_id'];?>" target="_blank" onclick="javascript:void(0)">
						<i class="icon-retweet"></i>
					</a>
					<?php endif;?>
	              </td>
              	</tr>
              
              <?php
		  }
		  ?>
    	</tbody>
	</table>       
	
</body>
</html>