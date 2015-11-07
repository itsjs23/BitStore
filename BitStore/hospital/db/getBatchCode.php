<?php
session_start();
include("../../config.php");

$store_id=$_SESSION['mystoreid'];
$sql = "select batchCode from `medicine` where `store_key` = '".$store_id."' and `status` <> 0 AND medicine_id='".$_POST['productId']."' ";
$result = mysqli_query($con,$sql);

if($result){
    $num_rows=$result->num_rows;
    if($num_rows > 0){
        $arr['batchCode']=mysqli_fetch_row($result)[0];
        $arr['status']='success';
    }

    
}else{
    $arr['status']='fail';
    $arr['batchCode']='';
}
echo json_encode($arr);
exit;


?>

