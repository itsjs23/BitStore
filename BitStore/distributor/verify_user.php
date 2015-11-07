<?php
session_start();
require_once '../config.php';
// username and password sent from form
$myusername = isset($_POST['admin_email']) ? $_POST['admin_email'] : null ;
$mypassword = isset($_POST['admin_password']) ? $_POST['admin_password'] : null;

if(empty($myusername) || empty($mypassword)){
	$_SESSION["type"] = 'invalid_credentials';
	echo"<script>";
	echo"window.location='distributor/index.php'";
	echo"</script>";
	
	return true;
}

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$sql	= "SELECT * FROM `distributors` WHERE username='$myusername' and password='$mypassword' and status = 1";
$result	= mysqli_query($con,$sql);
$row	= mysqli_fetch_array($result);
//echo $sql; die();
// Mysql_num_row is counting table row
$count	= mysqli_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count == 1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
//session_register("myusername");
//session_register("mypassword");

$_SESSION['myuserid'] = $row['distributor_id'];
$_SESSION['myusername'] = $row['username'];
$_SESSION['fullname'] = $row['fullname'];

echo"<script>";
echo"window.location='index.php?view=stores_list'";
echo"</script>";
exit();
}

$_SESSION["type"] = 'invalid_credentials';
header("Location: index.php");
exit;
?>