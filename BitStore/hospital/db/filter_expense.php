<?php
session_start();
include("../../config.php");
$store_id=$_SESSION['mystoreid'];
parse_str($_POST['fields'],$filters);

$sql="SELECT  `purpose`, `amount`, `paymode`, `chequeNum`, `created_date`, `remark` FROM `expenditure` AS EE WHERE EE.`store_key`='".$store_id."' ";
    
    if($filters['start_date'] &&  $filters['end_date']){ // from date and to date 
        $sql .=" AND EE.`created_date` BETWEEN '".$filters['start_date']."' AND '".$filters['end_date']."' ";
    }
    if($filters['paymode'] ){
        if($filters['paymode'] =='cheque'){
            $sql .=" AND EE.`paymode`='cheque' AND EE.`chequeNum`='".$filters['chequenum']."' ";
        }else{
            $sql .=" AND EE.`paymode`='cash' ";
        }
    }
    if($filters['type'] !="default"){ // purpose
        $sql .=" AND  EE.`purpose`='".$filters['type']."' ";
    }
    $result=mysqli_query($con,$sql);
    $data="";
    
    $total_amount=0;
    
    if($result && $result -> num_rows > 0){
    $n=0;
        while($row=mysqli_fetch_assoc($result)){
          $n++;
          $total_amount += $row['amount'] ;
            $data .='<tr><td>'.$n.'<td>';
            $data .='<td>'.$row['purpose'].'<td>';
            $data .='<td>'.$row['amount'].'<td>';
            $data .= '<td>'.$row['paymode'].'<td>';
            $data .= '<td>'.$row['chequeNum'].'<td>';
            $data .= '<td>'.$row['created_date'].'<td>';
            $data .= '<td>'.$row['remark'].'<td>';
            $data .= '</tr>';
        }
        $arr['status']='success';
        $arr['data']=$data;
        $arr['total_amount']=$total_amount;
        echo json_encode($arr);
        exit;
        
    }
    
    else{
        $arr['status']='fail';
        $arr['total_amount']=$total_amount;
        echo json_encode($arr);
        exit;
    }
        







?>

