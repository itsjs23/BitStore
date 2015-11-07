<?php 

require_once dirname(dirname(dirname(__FILE__))).'/defines.php';
require_once dirname(dirname(dirname(__FILE__))).'/config.php';
require_once dirname(dirname(dirname(__FILE__))).'/helper.php';

session_start();
if(!isset($_SESSION["type"]) || empty($_SESSION["type"])){
	die('Session is expired. Please do login again.');
}
//
//if(!isset($_GET['barcodes_id']) || empty($_GET['barcodes_id'])){
//	die('Request format to access contents is not proper. Select the record properly.');
//}

$barcodes_id = $_GET['barcodes_id'];
?>
<html>
<head><title>Medical  Bill</title>

<script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery-ui.js"></script>
    <link rel="stylesheet"  href="../../css/bootstrap.css" type="text/css" />
    <link rel="stylesheet"   href="../../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet"    href="../../css/bootstrap-responsive.css" type="text/css" />
    <link rel="stylesheet" href="../../css/bootstrap-responsive.min.css" type="text/css" />
    <script type="text/javascript" src="../../js/bootstrap.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    
    <style type="text/css">
    	.set-height{
    		height:20px;
    	}
    </style>
</head>
<body class="container" style="font-family: sans-serif;">
<?php
    
    $store_key = $_SESSION['mystoreid'];
    
    $result = mysqli_query($con,"select store_name from store where store_key = '$store_key'");
    $store = mysqli_fetch_row($result);
    $store = $store[0];
    
    $records = array();
	$result	 = mysqli_query($con,"select * from `barcodes` where `barcodes_id` = $barcodes_id");
	
	while($row=mysqli_fetch_array($result)):?>
		<?php $code = $row['barcode'];?>
		<div style="width:380px;">
			<div style="text-align:center;"><div><?php echo $store;?></div></div>
			<img src="<?php echo DHS_ROOT."admin/barcodes/$code.gif";?>">
			<br/>
			<div class="txt-small">
				<?php echo $row['medicine_name'];?> | M.R.P <?php echo number_format($row['mrp'], 2);?> 
				| MFG Date <?php echo $row['mfg_date'];?> | Exp Date: <?php echo $row['expiry_date'];?> 
			</div>
			
		</div>
		
	
	<?php endwhile;?>
	
	

	
</body>
</html>



