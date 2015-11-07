<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php
$store_key = $_SESSION['mystoreid'];

include("config.php");
if(isset($_POST['query'])){
	$query = explode("&", $_POST['query']);
	$data = array();
	
	foreach($query as $values){
			$value = explode("=", $values);
			$data[$value[0]] = $value[1];	
	}
	
	$action			= $data['action'];
	$doctor_name	= urldecode($data['doctor_name']);
	$mobile_no		= urldecode($data['mobile_no']);
}
else
{
if(isset($_REQUEST['action'])){
$action=$_REQUEST['action']; }
else{ $action='';}
}

switch($action)
{
	
case "insert_doctor":

if(!empty($doctor_name) && !empty($mobile_no)){
	$sql="insert into `doctors` (`doctor_name`, `mobile`, `status`, `store_key`) 
			values ('$doctor_name', $mobile_no ,1, '$store_key')";
	if(!$rs = mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}
}

break;

case "update_doctor":
	$id	= urldecode($data['doctor_id']);
	$sql= "update `doctors` set `doctor_name`='$doctor_name', `mobile` = $mobile_no where doctor_id=$id";
	
	if(!$rs = mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}

break;

case "delete_doctor":
	$id = $_REQUEST['doctor_id'];
	if(!empty($id)){
		$sql="update `doctors` set status = 0 where `doctor_id` = $id";
		if(!$rs = mysqli_query($con,$sql)){
			die('Error'.mysql_error());
		}
	}


echo "<script>";
echo "window.location='index.php?view=doctors_list&menu=user'";
echo "</script>";

break;


}
?>
