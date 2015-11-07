<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php require_once 'Barcode39.php';?>

<?php $store_key = $_SESSION['mystoreid'];?>
<?php
	
	$data = $_POST;
	$medicine_name 	= $data['medicine_name'];
	$batch_code 	= $data['batch_code'];
	$mfg_date		= $data['mfg_date'];
	$expiry_date 	= $data['expiry_date'];
	$mrp 			= $data['mrp'];
	$action			= $data['action']; 
	
	if(empty($medicine_name) || empty($batch_code) || empty($mfg_date) || empty($expiry_date) || empty($mrp)){
		return true;
	}
	
	switch($action){
		case "insert_barcodes":
			
			$barcode = DhsHelper::getUniqueBarcode();
			
			$bc = new Barcode39($barcode);
			// set text size 
			$bc->barcode_text_size = 5; 
			
			// set barcode bar thickness (thick bars) 
			$bc->barcode_bar_thick = 4; 
			
			// set barcode bar thickness (thin bars) 
			$bc->barcode_bar_thin = 2; 
			
			// save barcode GIF file 
			$bc->draw("admin/barcodes/$barcode.gif");
			
			$sql = "insert into `barcodes` (`barcode`, `medicine_name`, `batch_code`, `mfg_date`, `expiry_date`, `mrp`, `store_key`)
					values ($barcode, '$medicine_name', '$batch_code', '$mfg_date', '$expiry_date', $mrp, '$store_key')";
			
			if(!mysqli_query($con,$sql)){
				die('Error'.mysql_error());
			}
			
			$max_id = mysql_insert_id();

		break;
	}


?>
<script type="text/javascript">
function poponload()
{
	var popUp = window.open("admin/barcodes/print_barcode.php?barcodes_id=<?php echo $max_id;?>", "Print Barcode", "location=no,status=1,scrollbars=1,width=400,height=400,top=100,left=300");

    if (popUp == null || typeof(popUp)=='undefined') { 	
    	alert("Alert: Please disable your pop-up blocker. <br> For now, print the barcode from 'View Barcodes' section.");
    } 
    setTimeout(function () {
        window.location.href = "index.php?view=create_barcodes&menu=stock"; //will redirect to your blog page (an ex: blog.html)
     }, 2000); 
}
</script>
<body onLoad="javascript: poponload()"></body>