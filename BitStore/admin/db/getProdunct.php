<?php
session_start();
include("../../config.php");
//parse_str($_POST['catId'], $set);

$store_id=$_SESSION['mystoreid'];
$get_data = "select medicine_id,medicine_name from `medicine` where `store_key` = '".$store_id."' and `status` <> 0 AND category_id='".$_POST['catId']."' ";
$result= mysqli_query($con,$get_data);


if($result){
    $num_of_rows=$result->num_rows;
    if($num_of_rows > 0){
        $product_name=' <option value=""> Select Product</option>';
        while($medicine=mysqli_fetch_row($result)){
            $product_name .= '<option value="'.$medicine[0].'">'.$medicine[1].'</option>';
        }
        $arr['status']='success';
    }
    else{
        $arr['status']='fail';
        $product_name=' <option value=""> No Product Found </option>';
    }
 
}

else{
$arr['status']='fail';
}


$arr['product_name']=$product_name;
echo json_encode($arr);
exit;





?>


