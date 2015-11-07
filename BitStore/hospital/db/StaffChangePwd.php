<?php
session_start();
include("../../config.php");

$store_id=$_SESSION['mystoreid'];
$userId=$_SESSION['myuserid'];
$userType=$_SESSION['type'];


$oldPwd=$_POST['oldPwd'];
$newPwd=$_POST['newPwd'];
$getOldPwd="SELECT US.password FROM users AS US WHERE  US.Enable=1 AND  US.status=1 AND  US.store_key='".$store_id."' AND  US.type='".$userType."'  AND US.user_id='".$userId."'";

$result=mysqli_query($con,$getOldPwd);

if($result && $result -> num_rows > 0){

    $userPwd=mysqli_fetch_assoc($result);
    if($oldPwd ==$userPwd['password'] ){
    $changePwd="UPDATE `users` SET `password`='".$newPwd."' WHERE `user_id`='".$userId."' AND  `store_key`='".$store_id."'  ";
    
    if(mysqli_query($con,$changePwd)){
    $arr['status']='success';
    }
    }else{
    $arr['status']='fail';
    $arr['reason']='Old Pwd are Not Correct ';
    }
    
    
}else{
    $arr['status']='fail';
    $arr['reason']='Fail to update Use Password';
}

echo json_encode($arr);
exit;





?>


