<?php session_start(); ?>
<?php

include("../../config.php");
$store_key = $_SESSION['mystoreid'];

if(isset($_POST['action'])){
switch($_POST['action']){
    case "verify_user":
        $userName=mysqli_real_escape_string($con,$_POST['username']);
        $sql="SELECT US.user_id FROM users AS US WHERE US.username='".$userName."'";
        $result=mysqli_query($con,$sql);
        if($result && $result-> num_rows > 0){
        $arr['status']='success';
        }else{
        $arr['status']='fail';
        }
        break;
        
    case "add_user":
        parse_str($_POST['query'],$data);
        $userStatus=$enable='1';
        
        $sql="INSERT INTO `users`(`username`, `password`, `type`, `Enable`, `register_date`, `status`, `store_key`, `Name`, `Mobile`, `Address`) 
      VALUES(
      '".mysqli_real_escape_string($con,$data['username'])."',
      '".mysqli_real_escape_string($con,$data['passsword'])."', 
      '".mysqli_real_escape_string($con,$data['user_type'])."',
      '".$enable."',
      '".date('Y-m-d')."',
      '".$userStatus."',
      '".$store_key."' ,
      '".mysqli_real_escape_string($con,$data['user_name'])."',
      '".mysqli_real_escape_string($con,$data['mobile'])."',
      '".mysqli_real_escape_string($con,$data['user_address'])."'
      )";
        $result=mysqli_query($con,$sql);
        if($result){
            $arr['status']='success';
        }else{
            $arr['status']='fail';
        }
        break;
        
      case "update_user":
          $data=$_POST['query'];
          $status='1';
          if($data[4] !='active'){
          $status='0';
          }
          
          $sql="UPDATE `users` SET `Enable`='".$status."' ,
          `Name`= '".mysqli_real_escape_string($con,$data[1])."', 
          `Mobile`='".mysqli_real_escape_string($con,$data[2])."'
          ";
          if($data[3] !='12345'&& $data[3] !="" ){
              $pwd=$data[3];
              $sql .="`password`='".mysqli_real_escape_string($con,$pwd)."' ";
          }
            $sql .= "  WHERE `user_id`='".mysqli_real_escape_string($con,$data[0])."'";
          
            $result=mysqli_query($con,$sql);
            if($result){
            $arr['status']='success';
            }else{
                $arr['status']='fail';
            }
            
          break;
        
        case "delete_user":
            $userId=mysqli_real_escape_string($con,$_POST['query']);
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
