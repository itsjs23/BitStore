<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<?php
include("config.php");
if(isset($_POST['query'])){
	$query = explode("&", $_POST['query']);
	$data = array();
	
	foreach($query as $values){
		$value = explode("=", $values);
		$data[$value[0]] = $value[1];	
	}
	
	$action=$data['action'];
}
else
{
	if(isset($_REQUEST['action'])){
		$action=$_REQUEST['action']; 
	}
	else{ $action='';}
}

switch($action)
{
	
	case "update_distributor":
	
	$name		= urldecode($data['name']);
	$shopname	= urldecode($data['shopname']);
	$email		= urldecode($data['email']) == "" ? null : urldecode($data['email']);
	$mobile		= urldecode($data['mobile']) == "" ? null : urldecode($data['mobile']);
	$address	= urldecode($data['address']) == "" ? null : urldecode($data['address']);
	$city		= urldecode($data['city']) == "" ? null : urldecode($data['city']);
	$state		= urldecode($data['state']) == "" ? null : urldecode($data['state']);
	$country	= urldecode($data['country']) == "" ? null : urldecode($data['country']);
	$id			= urldecode($data['dist_id']);


	$sql="update distributors set name='$name', email='$email', mobile='$mobile', 
	 address='$address', city='$city',state='$state',country='$country',shop_name='$shopname' where distributor_id=$id ";
	 
	if(!mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}

break;






case "delete_customer_bill":
	$id	= $_REQUEST['bill_id'];
	$sql= "update `cust_inventory` set status=0 where bill_id=$id";
	
	if(!mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}

break;


case "delete_cb_filter":
	unset($_SESSION['cb']);
	echo "<script>";
	echo "window.location='index.php?view=customer_bills&menu=billing'";
	echo "</script>";

break;


}
?>