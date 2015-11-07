<?php session_start(); ?>
<?php
$store_key = $_SESSION['mystoreid'];
include("../../config.php");

if(isset($_POST['action']))
{
    switch($_POST['action'])
    {
        case "retn_stock":
            $data=$_POST['query'];
            $inventory_id=urldecode($data[0]);
            $quantity=urldecode($data[1]);
            $reamrk=urldecode($data[2]);
            // Get Product details
            $sql="SELECT `distributor_id`, `medicine_id`, `quantity`,  `buy_unit_cost` FROM `new_inventory` WHERE `inventory_id`='".$inventory_id."'";
            $result=mysqli_query($con,$sql);
            if($result && $result -> num_rows == 1){
            $data=mysqli_fetch_row($result);
            
            //update Quantity
            $remaningQunatity=$data[2]-$quantity;
            $sql2="UPDATE `new_inventory` SET `quantity`='".$remaningQunatity."' WHERE `inventory_id`='".$inventory_id."'";
            $result2=mysqli_query($con,$sql2); 
            if($result2){
            // Insert Into Return Stock
                
                $sql3="INSERT INTO `returnstock`( `ven_id`, `ProductId`, `Qunatity`, `unit_price`, `date`, `Reamrk`, `store_key`) 
                VALUES ('".$data[0]."','".$data[1]."','".$quantity."','".$data[3]."','".date('Y-m-d')."','".$reamrk."','".$store_key."')";
            $result3=mysqli_query($con,$sql3);     
                if($result3){
                $arr['status']='success';
                }else{
                $arr['status']='fail';
                }
            }else{
                $arr['status']='fail';
            }
            }else{
            $arr['status']='fail';
            }
            break;

        case "update_category":
            
            $id=urldecode($_POST['cat_id']);
            $category=urldecode($_POST['catName']);
            $sql="update `category` set name='$category' where category_id=$id";

            $result=mysqli_query($con,$sql);
            if($result){
                $arr['status']='success';
            }
            else
            {
                $arr['status']='fail';
                $arr['msg']='update Query Failed !';
            }

            break;

        case "delete_category":
            $id=mysqli_real_escape_string($con,$_REQUEST['id']);
            $sal=mysqli_query($con,"select `status` from `category` where `category_id`=$id");
            $enable_row=mysqli_fetch_array($sal);
            $enable=$enable_row['status'];
            if($enable==0)
                $enable=1;
            else
                $enable=0;

            $sql="update `category` set `status`=$enable where `category_id`=$id";
            $result=mysqli_query($con,$sql);
            if($result){
                $arr['status']='success';
            }
            else
            {
                $arr['status']='fail';
                $arr['msg']='Delete Query Failed !';
            }

            break;
            
    } // switch end 
    
} // if end 
else
{
$arr['status']='fail';
}

echo json_encode($arr);
exit;



?>
