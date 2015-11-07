<?php session_start(); ?>
<?php
include("../../config.php");
$store_key = $_SESSION['mystoreid'];

$flag=0; // status flag 

if(isset($_POST['query'])){
  
    parse_str($_POST['query'], $data);
    $action		=	urldecode($data['action']);
    $medicine_id=	urldecode($data['medicine_id']);
    $dist_id	=	urldecode($data['dist_id']);
    $quantity	=	urldecode($data['quantity']);
    $bill_no    =   urldecode($data['bill_number']);
    $buy_cost	=	urldecode($data['buy_cost']);
    $cost		=	urldecode($data['cost']);
    $batch_code	=	urldecode($data['batch_code']);
    $payment_date=	urldecode($data['payment_date'])=="" ? date('Y-m-d'): urldecode($data['payment_date']);  
     $now 		= date('Y-m-d');
    
    // get the qunatity if exist
    $sql 	= "select quantity from `new_inventory` where `batch_code` = '$batch_code'";
    $result = mysqli_query($con,$sql);
    $count 	=  $result->num_rows;
    if($count > 0){
        $data=mysqli_fetch_row($result);
        $QunatityNew=$quantity+$data[0];
        $update_query="UPDATE `new_inventory` SET `quantity`='$QunatityNew',`unit_cost`='$cost',`buy_unit_cost`='$buy_cost'   where `batch_code` = '$batch_code'";
        $result_query=mysqli_query($con,$update_query);
        if(!$result_query){
        $flag++;
        }  
        
    } //update qunatity 
    
    // INSERT PRODUCT INTO STOCK  
    else
    {
        $sql="INSERT INTO `new_inventory`( `distributor_id`, `medicine_id`, `quantity`, `unit_cost`, `buy_unit_cost`, `expiry_date`, `store_key`, `barcode`, `batch_code`, `date`) 
				values ('$dist_id','$medicine_id','$quantity','$cost','$buy_cost','$payment_date', '$store_key', '0', '$batch_code','$now')";
		$result_query=mysqli_query($con,$sql);
        if(!$result_query){
            $flag++;
        }  
    }  // insert product 
    
    
    //UPDATE into vendor_payment  -- IF Bill No , Ven Id and Date Match
    $bill_no_count="SELECT `Amount`,`BillDetails` FROM `vendor_payment` where `BillNo`='$bill_no' AND `ven_id`='$dist_id' AND `date`='$now'";
    $bill_result = mysqli_query($con,$bill_no_count);
    
    if($bill_result  && $bill_result->num_rows > 0){
        $old_data=mysqli_fetch_row($bill_result);
        $newAmount=$old_data[0] +($quantity * $buy_cost );
        $billDetails=$old_data[1].",".$_POST['productName']."_"."$quantity"."_"."$buy_cost";
        $update_query=" UPDATE `vendor_payment`  SET `Amount`='$newAmount',`BillDetails`='$billDetails' WHERE `BillNo`='$bill_no' AND `ven_id`='$dist_id' AND `date`='$now'"  ;
        if(!mysqli_query($con,$update_query)){
            $flag++;
        }
    } // INSERT INTO VENDOR PAYMENT FOR NEW PRODUCT 
    else
    {
        $amount=$quantity * $buy_cost ;
        $billDetail=$_POST['productName']."_"."$quantity"."_"."$buy_cost";
        $insert_vendor_payment="INSERT INTO `vendor_payment`(`ven_id`,`BillNo`,`BillDetails`, `Amount`, `PendiangAmount`, `paymentDate`, `date`)
             VALUES ('$dist_id','$bill_no','$billDetail','$amount',0,'$payment_date','$now')";
        if(!mysqli_query($con,$insert_vendor_payment)){
        $flag++;
        }
    }
  
}
else{
$flag++;
}

if($flag==0){
$arr['status']='success';
}else{
    $arr['status']='fail';
}
echo json_encode($arr);    
exit;
    
    

?>