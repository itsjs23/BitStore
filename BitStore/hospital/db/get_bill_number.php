<?php
session_start();
include("../../config.php");
$store_id=$_SESSION['mystoreid'];
$get_data = "SELECT VP.`BillNo` FROM `vendor_payment`  AS VP INNER JOIN vendors AS VS ON VS.Id=VP.`ven_id` WHERE VS.store_key='".$store_id."'  AND  VS.Status<>0 ";
$value_data = mysqli_query($con,$get_data);


if(mysqli_num_rows($value_data) !=0)
{

$data="";
while($row=mysqli_fetch_row($value_data))
{
//$data .="<option value='".$row[0]."'> ".$row[0] ."</option>";
$data .='<option value="'.$row[0].'">'.$row[0].'</option>';
}

$arr['status']='Success';
$arr['billNo']=$data;
	echo json_encode($arr);
	exit;
}
else
{
    $product_name=' <option value=""> No Bill Found </option>';
$arr['status']='Failed';
$arr['batchCode']='';
echo json_encode($arr);
exit;
}






?>


