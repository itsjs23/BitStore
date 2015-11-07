<?php
session_start();
include("../../config.php");
parse_str($_POST['querystring'], $data);
$store_id=$_SESSION['mystoreid'];

$bill_no=$data['Get_bill_No_dateils'];
$product_name=$data['product_name'];
$auantity=$data['returnQunatity'];
$unit_cost=$data['unit_price'];
$remark=$data['return_product_remark'];
$ven_id=$_POST['ven_id'];

$get_quantity="SELECT `quantity`,`inventory_id` FROM `new_inventory` AS NI INNER JOIN medicine AS MD ON MD.medicine_id=NI.`medicine_id` 
                where MD.medicine_name='".$product_name."' AND NI.`distributor_id`='".$ven_id."'";
$get_result=mysqli_query($con,$get_quantity);
if(mysqli_num_rows($get_result)>0)
{

    $data=mysqli_fetch_row($get_result);
 $reduced_qunatity=$data[0]-$auantity;
 
 $update_query=mysqli_query($con,"UPDATE `new_inventory` SET  `quantity`='".$reduced_qunatity."' where `inventory_id`='".$data[1]."'");
 if($update_query)
 {
     
     $return_query="INSERT INTO `ReturnStock`( `ven_id`, `ProductInfo`, `Qunatity`, `Amount`, `date`, `BillNumber`, `Reamrk`, `store_key`) 
      VALUES ('".$ven_id."','".$product_name."','".$auantity."', '".$unit_cost."' ,'".date('Y-m-d')."','".$bill_no."','".$remark."','".$store_id."')";
     $result=mysqli_query($con,$return_query);
if($result)
{
$arr['status']='Success';
$arr['msg']="Success";
echo json_encode($arr);
	exit;
}

else
{
$arr['status']='Failed';
$arr['msg']="Refund Stock Insert Failed ";
echo json_encode($arr);
exit;
}
}
 else
 {
     
     $arr['status']='Failed';
     $arr['msg']="Reducing  Qunatity Failed ";
     echo json_encode($arr);
     exit;
 }
 
   
}
else
{
    $arr['status']='Failed';
    $arr['msg']="Unable to Get  availabe Quantity";
    echo json_encode($arr);
    exit;

}





?>


