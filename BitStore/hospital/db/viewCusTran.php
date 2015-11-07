<?php
session_start();
include("../../config.php");
$store_id=$_SESSION['mystoreid']; 
$htm="";

$sql ="SELECT   MD.medicine_name, CI.`quantity`, CI.`total`, CI.`created_date` FROM `new_cust_inventory` AS CI 
            INNER JOIN medicine AS MD ON MD.medicine_id=CI.medicine_id where 
             CI.`store_key`='".$store_id."' ";

        $data=explode('_',$_POST['data']);
     if(count($data) > 1){
     // filter by cus Name and date
         $sql .=" AND  `customer_name`='".$data[0]."' AND `created_date`='".$data[1]."'  ";
     }else{
         $sql .="  AND  bill_id='".$data[0]."' ";
     }
 $result =  mysqli_query($con,$sql);
    $i=1;
    if( $result && $result -> num_rows > 0  ){
          $htm .="<table class='table table-stripped'>
                      <tr>
                         <th>S.No.</th>
                         <th>Item Name</th>
                         <th>Qunatity </th>
                         <th>Total Cost</th>
                         <th>Date </th>
                         </tr>";
                      
            while($row = mysqli_fetch_row($result)){ 
                         $htm .= "<tr ><td>".$i++ ."</td>";
                         $htm .="<td>".$row[0]."</td>";
                         $htm .="<td>".$row[1]."</td>";
                         $htm .="<td>".$row[2]."</td>";
                         $htm .="<td>".$row[3]."</td></tr>";
                      
                    }              
        $htm .="</table>";
        $arr['status']='Success';
        $arr['trans']=$htm;
	echo json_encode($arr);
	exit;
    }
    
    else
    {
        $arr['status']='Failed';
        $arr['trans']=' <option value=""> No transaction Found </option>';
        echo json_encode($arr);
        exit;
    }






?>


