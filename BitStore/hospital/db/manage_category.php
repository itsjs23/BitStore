<?php session_start(); ?>
<?php //if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php
$store_key = $_SESSION['mystoreid'];

include("../../config.php");

//if(isset($_POST['query']) && isset($_POST['action'])  )
if(isset($_POST['action']))
{
    switch($_POST['action'])
    {
        case "insert_category":
            parse_str( $_POST['query'],$query);
            $category=urldecode($query['category']);
            $sql="insert into category(`name`,`status`,`store_key`) values('$category', 1 , '$store_key')";
            $result=mysqli_query($con,$sql);
            if($result){
                $arr['status']='success';
              }
            else
            {
                $arr['status']='fail';
                $arr['msg']='Insert Query Failed !';
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
