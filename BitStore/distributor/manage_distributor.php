<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php
$store_key = $_SESSION['mystoreid'];

if(!isset($_SESSION['myuserid']) || empty($_SESSION['myuserid'])){
	die('You are not authorize to access this content.');
}
$user_id = $_SESSION['myuserid'];

if(!isset($_POST['distributor_id'])){
	die('You are not authorize to access this content.');
}

$distributor_id 	= $_POST['distributor_id'];
$distributor_name 	= isset($_POST['name']) ? $_POST['name'] : null;
$shop_name 			= isset($_POST['shopname']) ? $_POST['shopname'] : null;
$email 				= isset($_POST['email']) ? $_POST['email'] : null;
$mobile 			= isset($_POST['mobile']) ? $_POST['mobile'] : null;
$address 			= isset($_POST['address']) ? $_POST['address'] : null;
$city 				= isset($_POST['city']) ? $_POST['city'] : null;
$state 				= isset($_POST['state']) ? $_POST['state'] : null;
$country 			= isset($_POST['country']) ? $_POST['country'] : null;


$sql = "UPDATE `distributors` SET `fullname`='$distributor_name',`email`='$email',`mobile`=$mobile,`address`='$address',`city`='$city',`state`='$state',`country`='$country',`shop_name`='$shop_name' WHERE `distributor_id` = $distributor_id";
if(!mysqli_query($con,$sql)){
	die('Error'.mysql_error());
}
?>
<div class="alert alert-info">Your profile updated successfully.<a class="pull-right" href="index.php?view=distributor_registration">View Profile</a>
</div>