<?php 

session_start();
if(!isset($_SESSION["type"]) || empty($_SESSION["type"])){
	die('Session is expired. Please do login again.');
}

if(!isset($_GET['bill_id']) || empty($_GET['bill_id'])){
	die('Request format to access contents is not proper. Select the record properly.');
}

$bill_id = $_GET['bill_id'];
?>
<html>
<head><title>Bill</title>

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
<body class="container" style="font-family: sans-serif;">
<?php
    require_once '../config.php';
    require_once '../helper.php';
    
    $store_key = $_SESSION['mystoreid'];
    
    $records = array();
	$result	 = mysqli_query($con,"select * from `new_cust_inventory` join `medicine` 
				on (medicine.`medicine_id` = new_cust_inventory.`medicine_id` 
				and medicine.`store_key` = '$store_key' and new_cust_inventory.`store_key` = '$store_key') where bill_id = $bill_id");
	while($row=mysqli_fetch_array($result))
	{
		$records[] 	  = $row;
		$customer_name= $row['customer_name'];
		$customer_mob = $row['customer_mob'];
		//$doctor_name  = $row['doctor_name'];
		$created_date = date('d-m-Y');  // $row['created_date'];
	}
	?>
	
	<div class="set-height">&nbsp;</div>	
	
	<div class="row-fluid">
		<div class="span6"><h1>Invoice</h1></div>
		<div class="span6">
			<?php 
				$store = mysqli_query($con,"select * from `store` where `store_key` = '$store_key'");
				$store = mysqli_fetch_row($store);
					?>
			<div class="row-fluid">
				<div class="span3">&nbsp;</div>
	            <div class="span9" style="text-align: right;">
		            <h4 style="margin: 0px;"><?php echo (empty($store)) ? 'N/A' : $store[2];?></h4><br>
		            Email - <?php echo (empty($store)) ? 'N/A' : $store[3];?><br>
		            Contact - <?php echo (empty($store)) ? 'N/A' : $store[8];?>.<br>
		            <?php echo (empty($store)) ? 'N/A' : $store[5];?>(<?php echo (empty($store)) ? 'N/A' : $store[6];?>).
	            </div>
			</div>
			
		</div>
	</div>
	
	<div class="set-height">&nbsp;</div>
	<div class="set-height">&nbsp;</div>
	
	<div class="row-fluid">
       <div class="span6">
	       	<b>Bill To</b><br />
	        <div>
		        Customer Name: <?php echo $customer_name;?><br>
		        Contact No: <?php echo $customer_mob;?>.
	        </div>
     	</div>
       
       <div class="span6" style="text-align: right;">
       		<b>Details</b><br />
	        <div>
		        Bill Id	: <?php echo $bill_id;?><br>
		        Billing Date : <?php echo DhsHelper::formatDate($created_date);?><br>
		       <!-- Doctor Name: <?php //echo $doctor_name;?><br>-->
	        </div>
       		
       </div>
      
     </div>
     
     <div class="set-height">&nbsp;</div>
     <div class="set-height">&nbsp;</div>
     
     <div>
        <table class="table table-striped">
        	<thead>
        		<tr>
		            <th>No</th>
		            <th>Medicine</th>
		            <th>Quantity</th>
		            <th>UnitCost</th>
		            <th>Subtotal</th>
		            <th>Tax</th>
		            <th>Discount</th>
		            <!--<th>Mfg. Date</th>
		            <th>Exp. Date</th>-->
		            <th>Total</th>
		          </tr>
        	</thead>
        	
        	<tbody>
          
<?php 
	$i		 	= 1;
	$sum	 	= 0;
	$subtotal	= 0;
	$tax 		= 0;
	$discount 	= 0;
	
	foreach($records as $row)
	{
		$sum 		+= $row['total'];
		$subtotal 	+= $row['subtotal'];
		$tax 		+= $row['tax'];
		$discount 	+= $row['discount'];
?>
    		
              <tr>
	              <td><?php echo $i;?></td>
	              <td><?php echo 	$row['medicine_name'];?></td>
	              <td><?php echo 	$row['quantity'];?></td>
	              <td><?php echo 	DhsHelper::formatPrice($con, $row['unit_cost']);?></td>
	              <td><?php echo 	DhsHelper::formatPrice($con,$row['subtotal']);?></td>
	              <td><?php echo 	DhsHelper::formatPrice($con,$row['tax']);?></td>
	              <td><?php echo 	DhsHelper::formatPrice($con,$row['discount']);?></td>
	              <!--<td><?php //echo 	DhsHelper::formatDate($con,$row['mfg_date']);?></td>
	              <td><?php //echo 	DhsHelper::formatDate($con,$row['expiry_date']);?></td>-->
	              <td><?php echo 	DhsHelper::formatPrice($con,$row['total']);?></td>
              	</tr>
              
              <?php
			  $i++;
		  }
		  ?>
    	</tbody>
	</table>       
</div>

<div class="set-height">&nbsp;</div>

<?php 
$result = mysqli_query($con,'select * from `billing` where `store_key` = '."'".$store_key."'".' and `bill_id` = '.$bill_id);
$billing = mysqli_fetch_row($result);
?>
<div class="row-fluid" style="font-size:1.35em;"> 
	<div class="span4 offset8">
		<div class="row-fluid">
			<div class="span8" style="text-align: right;">Total</div>
			<div class="span4" style="text-align: right;"><?php echo ' Rs.'.DhsHelper::formatPrice($con,$billing[2]);?></div>
		</div>
		
		<div class="row-fluid">
			<div class="span8" style="text-align: right;">Tax</div>
			<div class="span4" style="text-align: right;"><?php echo ' Rs.'.DhsHelper::formatPrice($con,$billing[3]);?></div>
		</div>
		
		<div class="row-fluid">
			<div class="span8" style="text-align: right;">Discount</div>
			<div class="span4" style="text-align: right;"><?php echo ' Rs.'.DhsHelper::formatPrice($con,$billing[4]);?></div>
		</div>
		
		<hr style="margin:0px; margin-bottom:10px;">
		
		<div class="row-fluid">
			<div class="span8" style="text-align: right;">Total</div>
			<div class="span4" style="text-align: right;"><?php echo ' Rs.'.DhsHelper::formatPrice($con,$billing[5]);?></div>
		</div>
	</div>
</div>

	
</body>
</html>