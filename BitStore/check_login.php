<?php
session_start();
include("config.php");

// username and password sent from form
//$mystoreid  = isset($_POST['mystoreid']) ? $_POST['mystoreid'] : null;  //-- comment for later use for mulitple store 
$mystoreid  = 'dhs_KSb';
$myusername = isset($_POST['myusername']) ? $_POST['myusername'] : null ;
$mypassword = isset($_POST['mypassword']) ? $_POST['mypassword'] : null;

// if fileds  are  empty return to index page 
if(empty($mystoreid) || empty($myusername) || empty($mypassword)){
	$_SESSION["type"] = 'invalid_credentials';
	echo"<script>";
    echo"window.location='index.php'";
    echo"</script>";
	
	return true;
}

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$mystoreid = stripslashes($mystoreid);
$mystoreid = mysqli_real_escape_string($con,$mystoreid);
$myusername = mysqli_real_escape_string($con,$myusername);
$mypassword = mysqli_real_escape_string($con,$mypassword);

$sql	= "SELECT `user_id`,`type`  FROM `users` WHERE `store_key` = '$mystoreid' and `username`='$myusername' and `password`='$mypassword' and `Enable` = 1 and `status` = 1";

$result	= mysqli_query($con,$sql);

if($result)
{
    $count	= $result -> num_rows ;  // Get the Num Of Rows 
    if($count == 1){
        $row	= mysqli_fetch_assoc($result);
        // Register $myusername, $mypassword and redirect to file "login_success.php"
        //session_register("myusername");
        //session_register("mypassword");

        $_SESSION['mystoreid'] = $mystoreid;     //$row['store_key'];
        $_SESSION['myuserid'] = $row['user_id'];
        $_SESSION['myusername'] = $myusername;  //$row['username'];
        $_SESSION["type"] = $row['type'];

        echo"<script>";
        echo"window.location='index.php'";
        echo"</script>";
        return true;
    }
}

$_SESSION["type"] = 'invalid_credentials';
header("Location: index.php");
exit;
?>