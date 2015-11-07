<?php session_start(); ?>
<?php

include("../../config.php");
$store_key = $_SESSION['mystoreid'];

if(isset($_POST['action'])){
switch($_POST['action']){
    case "verify_user":
        $userName=$_POST['username'];
        $sql="SELECT US.user_id FROM users AS US WHERE US.username='".$userName."'";
        $result=mysqli_query($con,$sql);
        if($result && $result-> num_rows > 0){
        $arr['status']='success';
        }else{
        $arr['status']='fail';
        }
        break;
        
    case "add_salary":
        parse_str($_POST['query'],$data);
        $purpose 		= $data['user_id'];
        $amount 		= $data['salary'];
        $expense_date 	= $data['notify_day'];
	$status 		= 1;
	$created_date 	= date('Y-m-d');
	
	$query = mysqli_query($con,"select user_id from `salary` where store_key = '$store_key' and status <> 0 and user_id = ".$purpose);
	if($query && $query->num_rows > 0){
    $arr['status']='salrayExist';
    }
    else{
        $sql = "insert into `salary` (`user_id`, `salary`, `status`, `notify_day`, `created_date`, `store_key`) 
            values ($purpose, $amount, $status, $expense_date, '$created_date', '$store_key')";
        $result=mysqli_query($con,$sql);
        if($result){
            $arr['status']='success';
        }else{
            $arr['status']='fail';
        }
    } // else End 
      break;
        
    case "update_salary":
          $data=$_POST['query'];
        
          $sql="UPDATE `salary` SET `salary`='".$data[1]."' , `notify_day`='".$data[2]."' WHERE   `salary_id`='".$data[0]."' AND `store_key`='".$store_key."' ";
            $result=mysqli_query($con,$sql);
            if($result){
            $arr['status']='success';
            }else{
                $arr['status']='fail';
            }
            
          break;
        
        case "delete_user":
            $userId=$_POST['query'];
            $sql="UPDATE `users` SET `status`='0' WHERE `user_id`='".$userId."' ";
            $result=mysqli_query($con,$sql);
            if($result){
                $arr['status']='success';
            }else{
                $arr['status']='fail';
            }
            break;
          
        
    }
}else{
$arr['status']='fail';
}
    echo json_encode($arr);
        exit;

?>
