<?php
session_start();
include("../../config.php");
$store_id=$_SESSION['mystoreid'];
$get_data = "SELECT VP.BillDetails,ven_id FROM `vendor_payment`  AS VP INNER JOIN vendors AS VS ON VS.Id=VP.`ven_id` WHERE  VP.`BillNo`='".$_POST['bill_num']."'  AND  VS.store_key='".$store_id."'  ";
$result = mysqli_query($con,$get_data);


if(mysqli_num_rows($result) > 0)
{

$data="";
while($row=mysqli_fetch_row($result))
{
    $get_data=explode('_',$row[0]);
    $data .="<tr class='active'><td><b>ProductName</b></td><td><input type='text' name='product_name' value='".$get_data[0]."' readonly/></td></tr>";
    $data .="<tr class='success'><td><b>Return Quantity</b></td><td><input type='number' name='returnQunatity' value='".$get_data[1]."'/></td></tr>";
    $data .="<tr class='warning'><td><b>UnitCost</b></td><td><input type='number' name='unit_price' value='".$get_data[2]."' readonly/></td></tr>";
    $data .="<tr class='info'><td><b>Remark</b></td><td><input type='text' name='return_product_remark' plcaeholder='Enter Remark' /></td></tr>";
    $data .="<tr class='danger'><td>&nbsp;</td><td><button type='button' class='btn btn-info' name='returnStock' id='returnStock' onclick='returnProduct(this)' value='".$row[1]."'> Return Stock </button></td></tr>";   
}
$arr['status']='Success';
$arr['billDetails']=$data;
	echo json_encode($arr);
	exit;
}
else
{
    $product_name=' <p> No Bill Found </option>';
$arr['status']='Failed';
$arr['batchCode']='';
echo json_encode($arr);
exit;
}






?>

