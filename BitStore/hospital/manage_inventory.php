<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<?php
	
	if(isset($_POST['query'])){
		$query = explode("&", $_POST['query']);
		$data = array();
		
		foreach($query as $values){
			$value = explode("=", $values);
			$data[$value[0]] = $value[1];	
		}
		
		$action		=	urldecode($data['action']);
		$medicine_id=	urldecode($data['medicine_id']);
		$barcode	=	urldecode($data['barcode']);
		$dist_id	=	urldecode($data['dist_id']);
		$quantity	=	urldecode($data['quantity']);
		$buy_cost	=	urldecode($data['buy_cost']);
		$cost		=	urldecode($data['cost']);
		$subtotal	=	urldecode($data['subtotal']);
		$tax		=	urldecode($data['tax']);
		$discount	=	urldecode($data['discount']);
		$total		=	urldecode($data['total']);
		$batch_code	=	urldecode($data['batch_code']);
		$mfg_date	=	urldecode($data['mfg_date']);
		$expiry_date=	urldecode($data['expiry_date']);
	}
	
	if(isset($_POST['querystring'])){
		$action = $_POST['action'];
		$medicine = $_POST['medicine'];
		$distributor = $_POST['distributor'];
		$quantity = $_POST['quantity'];
	}
	
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
				$bar_res = mysqli_query($con,"select * from `barcodes` where `barcode` = $barcode");
				$bar_det = mysqli_fetch_array($bar_res);
				if(!empty($bar_det)){
					echo '####'.json_encode($bar_det).'@@@@';
					exit();
				}
				echo '####Not@@@@';
				exit();
			}
			
			break;
			
		case "insert_inventory":
		$sql="INSERT INTO `inventory` (`distributor_id`, `medicine_id`, `quantity`, `unit_cost`, `buy_unit_cost`, `subtotal`, `tax`, `discount`, `total`, `status`,`mfg_date`,`expiry_date`, `store_key`, `barcode`, `batch_code`) 
				values ('$dist_id','$medicine_id','$quantity','$cost','$buy_cost','$subtotal','$tax','$discount','$total','30','$mfg_date','$expiry_date', '$store_key', '$barcode', '$batch_code')";
		if(!mysqli_query($con,$sql)){
			die('Error'.mysql_error());
		}

        break;
         
		case "request_inventory":
			$now = date('Y-m-d');
			$user = $_SESSION['myuserid'];
			$status = DHS_DISTRIBUTOR_INVENTORY_STATUS_PENDING;
			$sql="INSERT INTO `inventory` (`distributor_id`, `medicine_id`, `requested_quantity`, `status`, `requested_date`, `requested_by`, `store_key`) values 
			($distributor, $medicine, $quantity, $status, '$now', $user, '$store_key')";
			
			if(!mysqli_query($con,$sql)){
				die('Error'.mysql_error());
			}
			
			break;
}