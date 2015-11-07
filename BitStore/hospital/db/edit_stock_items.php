<?php session_start(); ?>

<?php

include("../../config.php");
$store_key = $_SESSION['mystoreid'];

if(isset($_POST['query'])){
    $data=$_POST['query'];
    
    // update unit price and selling price 
    
    $sql="UPDATE `new_inventory` SET `unit_cost`='".$data[2]."' ,  `buy_unit_cost`='".$data[1]."'
        WHERE `inventory_id`='".$data[0]."'";
    $result=mysqli_query($con,$sql);
    
    if($result){
    $arr['status']='success';
    }else{
        $arr['status']='fail';
        $arr['msg']='Update Qauery Fail !';
    }
}else{
    $arr['status']='fail';
    $arr['msg']='Parameter Required !';
}

echo json_encode($arr);
exit();


?>