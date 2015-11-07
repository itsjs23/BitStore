<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php
include("config.php");

$store_key = $_SESSION['mystoreid'];

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
$action=$_REQUEST['action']; }
 else{ $action='';}
}

switch($action)
{
	
case "insert_distributor":
	$username	= urldecode($data['username']);
	$password	= urldecode($data['passsword']);
	$name		= urldecode($data['name']);
	$shopname	= urldecode($data['shopname']);
	$email		= urldecode($data['email'])=="" ? null : urldecode($data['email']);
	$mobile		= urldecode($data['mobile'])=="" ? null : urldecode($data['mobile']);
	$address	= urldecode($data['address'])=="" ? null : urldecode($data['address']);
	$city		= urldecode($data['city'])=="" ? null : urldecode($data['city']);
	$state		= urldecode($data['state'])=="" ? null : urldecode($data['state']);
	$country	= urldecode($data['country'])=="" ? null : urldecode($data['country']);
	$now 		= date('Y-m-d');
	
	$sql="insert into `users` (`username`, `password`, `type`, `Enable`, `register_date`, `status`, `store_key`) 
			values ('$username','$password',303,1, '$now', 1, '$store_key')";
	if(!$rs = mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}


	$result = mysqli_query($con,"select LAST_INSERT_ID() as user_id");
	$user_id = mysqli_fetch_row($result);
	$user_id=$user_id[0];
	$sql="INSERT INTO `distributors` (`user_id`, `name`, `email`, `mobile`, `address`, `city`, `state`, `country`, `shop_name`, `status`, `store_key`) 
			VALUES ($user_id,'$name','$email','$mobile','$address','$city','$state','$country','$shopname', 1, '$store_key')";
	
	if(!mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}

break;

case "update_distributor":

	$name 		= urldecode($data['name']);
	$shopname	= urldecode($data['shopname']);
	$email		= urldecode($data['email']) == "" ? null : urldecode($data['email']);
	$mobile		= urldecode($data['mobile']) == "" ? null : urldecode($data['mobile']);
	$address=urldecode($data['address']) == "" ? null : urldecode($data['address']);
	$city=urldecode($data['city']) == "" ? null : urldecode($data['city']);
	$state=urldecode($data['state']) == "" ? null : urldecode($data['state']);
	$country=urldecode($data['country']) == "" ? null : urldecode($data['country']);
	$id=urldecode($data['dist_id']);


$sql="update distributors set name='$name', email='$email', mobile='$mobile', 
 address='$address', city='$city',state='$state',country='$country',shop_name='$shopname' where distributor_id=$id ";
 
if(!mysqli_query($con,$sql)){
	die('Error'.mysql_error());
}

break;
case "delete_distributor":
$id=$_REQUEST['id'];
$sql="update distributors set status=0 where distributor_id=$id";
if(!mysqli_query($con,$sql))
{
die('Error'.mysql_error());
}
echo "<script>";
echo "window.location='index.php?view=distributor_details'";
echo "</script>";
break;


case "block_user":
$id=$_REQUEST['id'];
$sal=mysqli_query($con,"select Enable from users where user_id=$id");
$enable_row=mysqli_fetch_array($sal);
$enable=$enable_row['Enable'];
if($enable==0)
$enable=1;
else
$enable=0;
$sql="update users set Enable=$enable where user_id=$id";
if(!mysqli_query($con,$sql))
{
die('Error'.mysql_error());
}
echo "<script>";
echo "window.location='index.php?view=user_details'";
echo "</script>";
break;


case "insert_users":

$type=urldecode($data['user_type']);
$username=urldecode($data['username']);
$password=urldecode($data['passsword']);

$sql="insert into `users` (`username`, `password`, `type`, `Enable`, `status`, `store_key`) values 
	('$username','$password',$type,1, 1, '$store_key')";
if(!mysqli_query($con,$sql)){
	die('Error'.mysql_error());
}

break;


case "delete_user":
$id=$_REQUEST['id'];
$sql="update `users` set status=0 where `user_id` = $id";
if(!mysqli_query($con,$sql)){
	die('Error'.mysql_error());
}
break;


case "verify_user":
	$username = $_POST['username'];
	$result = mysqli_query($con,"select count(`user_id`) as user_id from `users` where `store_key` = '$store_key' and `username` = '$username'");
	$record = mysqli_fetch_array($result);
	echo '####'.$record['user_id'].'@@@@';
	die();
break; 


case "verify_distributor":
	$username = $_POST['username'];
	$sql = "select count(`distributor_id`) as user_id from `distributors` where `username` = '$username'";
	$result = mysqli_query($con,$sql);
	$record = mysqli_fetch_array($result);
	echo '####'.$record['user_id'].'@@@@';
	die();
break; 

case "distributor_details":
	$distributor_id = $_POST['distributor_id'];
	$sql = "select * from `distributors` where `distributor_id` = '$distributor_id'";
	$result = mysqli_query($con,$sql);
	$record = mysqli_fetch_array($result);
	echo '####'.json_encode($record).'@@@@';
	die();
break; 

case "insert_distributor_mapping":
	$distributor_id = $_POST['distributor_id'];
	$sql = "select count(`map_id`) from `store_distributor_mapping` where `distributor_id` = '$distributor_id'";
	$result = mysqli_query($con,$sql);
	$count = mysqli_fetch_row($result);
	$count = $count[0];
	
	if($count < 1){
		$sql = "insert into `store_distributor_mapping` (`store_key`, `distributor_id`) values ('$store_key', $distributor_id)";
		if(!mysqli_query($con,$sql)){
			die('Error'.mysql_error());
		}
	}
	
	echo '####'.json_encode($record).'@@@@';
	die();
break;

}
?>