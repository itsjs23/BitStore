<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php
$store_key = $_SESSION['mystoreid'];
 
if(isset($_POST['query'])){
	$query = explode("&", $_POST['query']);
	$data = array();
	foreach($query as $values){
		$value = explode("=", $values);
		$data[$value[0]] = $value[1];	
	}
	
	$action		= urldecode($data['action']);
	$medicine	= urldecode($data['name']);
	$inge		= urldecode($data['ingrediants']);
	$generic	= urldecode($data['generic']);
	$mfgr		= urldecode($data['manufacturer']);
	$cat_id		= $data['category_id'];
}else
{
if(isset($_REQUEST['action'])){
$action=$_REQUEST['action']; }
else{ $action='';}
}

if(isset($_POST['data'])){
	$action  = $_POST['action'];
	$barcode = $_POST['barcode'];
}

$current = date("Y-m-d");
$after	 = date("Y-m-d", mktime(0,0,0,date('m'), date('d')+7, date('Y')));

switch($action)
{
case "manage_medicine":
$sql="insert into `medicine` (`medicine_name`, `category_id`, `ingrediants`, `is_generic`, `manufacturer`, `status`, `store_key`) 
		values ('$medicine',$cat_id,'$inge',$generic,'$mfgr', 1, '$store_key')";

if(!mysqli_query($con,$sql)){
	die('Error'.mysql_error());
}

break;

case "update_medicine":
	$medicine_id = $data['medicine_id'];
	$sql = "update `medicine` set `medicine_name`= '$medicine', `category_id`= $cat_id, `ingrediants` = '$inge', `is_generic` = $generic, `manufacturer` = '$mfgr' where `medicine_id` = $medicine_id";
	if(!mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}
	
	break;

case "select_medicine":
	$sql  = 'select m.medicine_name, invt.* from medicine as m inner join (select * from `inventory` ';
	$sql .= 'where `store_key` = '."'".$store_key."'".' and `status` = '.DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED;
	$sql .= " and `barcode` = $barcode ) as invt on (m.medicine_id = invt.medicine_id)";
	
	$result = mysqli_query($con,$sql);
	$record = mysqli_fetch_array($result);
	
	$record['unit_cost'] 	= DhsHelper::formatPrice($record['unit_cost']);
	$record['subtotal']		= DhsHelper::formatPrice($record['subtotal']);
	$record['total']		= DhsHelper::formatPrice($record['total']);
	
	$record['mfg_date'] = DhsHelper::formatDate($record['mfg_date'], 'Y-m-d');
	$record['expiry_date'] = DhsHelper::formatDate($record['expiry_date'], 'Y-m-d');
	
	//$sold_rs = mysqli_query($con,'select sum(quantity) as sold from `cust_inventory` group by `barcode` where ');
	
	echo '####'.json_encode($record).'@@@@';
	die();
	
	break;
	
case "barcode_medicine":
	$records = DhsHelper::getBarcodeDetails($barcode, $store_key);
	
	echo '####'.json_encode($records).'@@@@';
	die();
	
	break;
	
case "delete_medicine":
	$id	= $_REQUEST['medicine_id'];
	
	if(!empty($id)){
		$sql="update `medicine` set status=0 where medicine_id=$id";
		if(!$rs = mysqli_query($con,$sql)){
			die('Error'.mysql_error());
		}
	}
	
echo "<script>";
echo "window.location='index.php?view=medicine_details&menu=medicine'";
echo "</script>";

break;

case "return_medicine":
	$id	= $_REQUEST['medicine_id'];
	
	if(!empty($id)){
		$sql="update `medicine` set status=0 where medicine_id=$id";
		if(!$rs = mysqli_query($con,$sql)){
			die('Error'.mysql_error());
		}
	}
	
echo "<script>";
echo "window.location='index.php?view=medicine_details&menu=medicine'";
echo "</script>";

break;
}


