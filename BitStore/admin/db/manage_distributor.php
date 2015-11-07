<?php  
session_start();
include("../../config.php");
$store_key = $_SESSION['mystoreid'];

if(isset($_POST['query']) && isset($_POST['action'])){
    

    switch($_POST['action'])
    {
        
        case "insert_vendor":
            parse_str($_POST['query'], $data);  // parse form Fileds 
            $name = urldecode($data['vendor_name']);
            $shopname	= urldecode($data['shopname']);
            $email		= urldecode($data['email'])=="" ? null : urldecode($data['email']);
            $mobile		= urldecode($data['mobile'])=="" ? null : urldecode($data['mobile']);
            $address	= urldecode($data['address'])=="" ? null : urldecode($data['address']);
            $city		= urldecode($data['city'])=="" ? null : urldecode($data['city']);
            $state		= urldecode($data['state'])=="" ? null : urldecode($data['state']);
            $country	= urldecode($data['country'])=="" ? null : urldecode($data['country']);
            $now 		= date('Y-m-d');
            $sql="INSERT INTO `vendors`( `Name`, `ShopName`, `Email`, `Mobile`, `Address`, `City`, `State`, `Country`, `RegDate`, `Status`,`store_key`)
            VALUES ('$name','$shopname','$email','$mobile','$address','$city','$state','$country','$now', 1, '$store_key')";
            $result=mysqli_query($con,$sql);
            if($result){
                $arr['status']='success';
            }
            else{
                $arr['status']='fail';
                $arr['msg']='Add vendor fail';
            }
            break;
        case "update_vendor":
            $data=$_POST['query'];
            $sql="UPDATE `vendors` SET 
            `Name`='".mysqli_real_escape_string($con,$data[1])."',
            `ShopName`='".mysqli_real_escape_string($con,$data[2])."',
            `Email`='".mysqli_real_escape_string($con,$data[3])."',
            `Mobile`='".mysqli_real_escape_string($con,$data[4])."',
            `City`='".mysqli_real_escape_string($con,$data[5])."',
            `State`='".mysqli_real_escape_string($con,$data[6])."',
            `Country`='".mysqli_real_escape_string($con,$data[7])."'
            WHERE `Id`='".mysqli_real_escape_string($con,$data[0])."'
            ";
            $result=mysqli_query($con,$sql);
            if($result){
                $arr['status']='success';
            }
            else{
                $arr['status']='fail';
                $arr['msg']='Update Details  fail';
            }
            break;
            
        case "Insert":
            
            break;
        
    } // switch end 
} //parameter chk if end 
else{
    $arr['status']='fail';
    $arr['msg']='parameter left empty ';
}

echo json_encode($arr);
exit();


?>
