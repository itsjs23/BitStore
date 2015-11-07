<?php
session_start();
include("../../config.php");

$store_id=$_SESSION['mystoreid'];

parse_str($_POST['data'],$data);

$purpose = $data['particular'];
$amount = $data['amount'];
$created_date = date('Y-m-d');
$added_by = $_SESSION['myuserid'];
$paymode=$data['paymode'];
if($paymode=='cheque'){
    $cheque_num=$data['cheque-num'];
}else{
    $cheque_num="";
}

$remark=$data['remark'];

$sql='INSERT INTO `expenditure`(`purpose`, `amount`, `paymode`, `chequeNum`, `added_by`, `created_date`, `store_key`, `remark`) 
        VALUES ("'.$purpose.'","'.$amount.'","'.$paymode.'","'.$cheque_num.'","'.$added_by.'","'.$created_date.'","'.$store_id.'","'.$remark.'")';
$result=mysqli_query($con,$sql);
if($result){
        $arr['status']='success';
    }else{
    $arr['status']='fail';
}
echo json_encode($arr);
exit;


?>

