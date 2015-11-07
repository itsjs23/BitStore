<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php
$store_key = $_SESSION['mystoreid'];

include("config.php");
if(isset($_POST['query']))
{
$query = explode("&", $_POST['query']);
$data = array();

foreach($query as $values){
		$value = explode("=", $values);
		$data[$value[0]] = $value[1];	
}

$action=$data['action'];
$category=urldecode($data['category']);

}
else
{
if(isset($_REQUEST['action'])){
$action=$_REQUEST['action']; }
else{ $action='';}
}

switch($action)
{
	
case "insert_category":


$sql="insert into category(`name`,`status`,`store_key`) values('$category', 1 , '$store_key')";
if(!$rs = mysqli_query($con,$sql)){
	die('Error'.mysql_error());
}

break;

case "update_category":
$id=urldecode($data['cat_id']);
$sql="update `category` set name='$category' where category_id=$id";

if(!$rs = mysqli_query($con,$sql)){
	die('Error'.mysql_error());
}

break;

case "delete_category":
$id=$_REQUEST['id'];
$sal=mysqli_query($con,"select `status` from `category` where `category_id`=$id");
$enable_row=mysqli_fetch_array($sal);
$enable=$enable_row['status'];
if($enable==0)
$enable=1;
else
$enable=0;

$sql="update `category` set `status`=$enable where `category_id`=$id";
if(!$rs = mysqli_query($con,$sql)){
	die('Error'.mysql_error());
}
echo "<script>";
echo "window.location='index.php?view=view_category&menu=medicine'";
echo "</script>";

break;


}
?>
