<?php
session_start();
include("../../config.php");
$store_id=$_SESSION['mystoreid'];
$get_data = "SELECT NI.inventory_id,NI.medicine_id,MD.medicine_name,NI.quantity,NI.unit_cost,NI.batch_code FROM new_inventory AS NI INNER JOIN medicine AS MD ON MD.medicine_id=NI.medicine_id WHERE NI.store_key='".$store_id."' ";
$result = mysqli_query($con,$get_data);

$data=array();
$arr=array();
$i=0;

if($result && $result->num_rows > 0)
{
    while($row=mysqli_fetch_assoc($result))
    {
        $data['inventory_id']=$row['inventory_id'];
        $data['medicine_id']=$row['medicine_id'];
        $data['batch_code']=$row['batch_code'];
        $data['medicine_name']=$row['medicine_name'];
        $data['quantity']=$row['quantity'];
        $data['unit_cost']=$row['unit_cost'];
    $i++;
    
    $arr[]=$data;
    }

    $arr['status']='Success';
    echo json_encode($arr);
	exit;
}
else
{
    $arr['status']='fail';
    echo json_encode($arr);
    exit;
}