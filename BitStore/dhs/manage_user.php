<?php if(!isset($_SESSION['myuserid'])) { die('Session is expired. Please do login again.'); }?>
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
$action=$_REQUEST['action']; }
 else{ $action='';}
}

switch($action)
{

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


case "verify_user":
	$username = $_POST['username'];
	echo $username;
	$result = mysqli_query($con,"select count(`user_id`) as user_id from `users` where `username` = '$username'");
	$record = mysqli_fetch_array($result);
	echo '####'.$record['user_id'].'@@@@';
	die();


}
?>