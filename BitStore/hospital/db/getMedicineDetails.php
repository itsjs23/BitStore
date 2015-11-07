<?php
session_start();
$store_key = $_SESSION['mystoreid']; // store Id 
include("../../config.php");

// get bar code  details 
$batchCode=$_POST['batchCode'];
$action=$_POST['action']; 

// Get Details from 
$query="";

switch($action)
{
    case "batch_code":
        $query .="SELECT MD.medicine_id,MD.medicine_name,NI.`quantity`,NI.`unit_cost`  FROM `new_inventory` AS NI  
    INNER JOIN medicine AS MD ON MD.medicine_id=NI.medicine_id
    WHERE NI.`batch_code`='".$batchCode."'  AND NI.`store_key`='".$store_key."'   limit 1 ";
        break;

        case "med_id":
            $query .="SELECT MD.medicine_id,NI.batch_code,NI.`quantity`,NI.`unit_cost`  FROM `new_inventory` AS NI  
                    INNER JOIN medicine AS MD ON MD.medicine_id=NI.medicine_id
                    WHERE MD.`medicine_name`='".$batchCode."'  AND NI.`store_key`='".$store_key."'   limit 1 ";
            break;
        
}


$result=mysqli_query($con,$query);

if($result)
{
    $row=mysqli_fetch_assoc($result);
    $arr['data']=$row;
    $arr['status']='Success';
    //$arr['msg']="Success";
    echo json_encode($arr);
	exit;

}

else
{

    $arr['status']='fail';
    echo json_encode($arr);
	exit;

}

                                            













