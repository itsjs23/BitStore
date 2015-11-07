<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<?php
	
	if(isset($_POST['data'])){
		$action = $_POST['action'];
		$barcode = $_POST['barcode'];
	}
	
	
	switch($action){
		case "verify_barcode":
			$sql 	= "select count(`inventory_id`) from `inventory` where `barcode` = $barcode";
			$result = mysqli_query($con,$sql);
			$count 	= mysqli_fetch_row($result);
			$count	= $count[0];
			
			if($count > 0){
				echo '####Exists@@@@';
				exit();
			}else {
				echo '####Not@@@@';
				exit();
			}
			
			break;

}