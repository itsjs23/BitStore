<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<?php
	//To get maximum id.............
	$sql=mysqli_query($con,"select max(bill_id) from new_cust_inventory");
	$result=mysqli_fetch_array($sql);
	$max_id=$result['max(bill_id)'];
	$max_id++;
	
	
	$data = $_POST;
	$medicine		= $data['medicine'];
	$action			= $data['action'];
	$customer_name	= $data['customer_name'] == "" ? null : $data['customer_name'];
	//$doctor_name	= $data['doctor_name'] == "" ? null : $data['doctor_name'];
	$customer_no	= $data['customer_no'] == "" ? 0 : $data['customer_no'];
	//$doctor_no		= $data['doctor_no'] == "" ? 0 : $data['doctor_no'];
       
	$payment_mode	= $data['payment_mode'] == "" ? null : $data['payment_mode'];
	$cheque_no		= $data['cheque_no'] == "" ? null : $data['cheque_no'];
	$branch			= $data['branch_name'] == "" ? null : $data['branch_name'];
	$bank			= $data['bank_name'] == "" ? null : $data['bank_name'];
	$create_date	= date("Y-m-d");
	
    //// Check for doctor details
    //if(!empty($doctor_name)){
    //    $sql = "select * from `doctors` where `store_key` = '$store_key' and `mobile` = $doctor_no";
    //    $result = mysqli_query($con,$sql);
    //    $record = mysqli_fetch_row($result);
		
    //    if(count($record) == 0 || $record == false){
    //        $sql = "insert into `doctors` (`doctor_name`, `mobile`, `status`, `store_key`) 
    //                values ('$doctor_name', $doctor_no, 1, '$store_key')";
			
    //        if(!mysqli_query($con,$sql)){
    //            die('Error'.mysql_error());
    //        }
    //    }elseif (count($record) > 0){
    //        $doctor_name = $record[1];
    //    }
    //}

	foreach($medicine as $values)
	{
        $InStock=	empty($values['inStock']) ? 'unchk':$values['inStock'] ;		
		$barcode	=	empty($values['barcode']) ? '': $values['barcode'] ;		
		$medicine_id=	empty($values['name']) ? '-1' : $values['name'];
		$quantity	=	$values['quantity'];
		$cost		=	$values['cost'];
		$subtotal	=	$values['subtotal'];
		$tax		=	empty($values['tax']) ? 0 : $values['tax'];
		$discount	=	empty($values['discount']) ? 0 : $values['discount'];
		$total		=	$values['total'];
		//$mfg_date	=	urldecode($values['mfg_date']);
		//$expiry_date=	urldecode($values['expiry_date']);
		
		
		//if(empty($barcode) || empty($medicine_id) || empty($quantity) || empty($subtotal) || empty($total) || empty($expiry_date)){
        if( empty($quantity) || empty($subtotal) || empty($total) ){
			continue;
		}
		
		switch($action){
			case "insert_billing":
				$user_id = $_SESSION['myuserid'];
				
				$sql="insert into `new_cust_inventory` (`customer_name`, `customer_mob`,  `medicine_id`, `quantity`, 
													`unit_cost`, `subtotal`, `tax`, `discount`, `total`, `created_date`, 
													 `bill_id`, `bill_created_by`, `payment_mode`, `cheque_no`, 
													`status`,`branch_name`,`bank_name`, `store_key`, `barcode`)
										 	values ('$customer_name', $customer_no,  $medicine_id, $quantity , 
													$cost, $subtotal, $tax, $discount, $total, '$create_date',
                                                    $max_id, $user_id, '$payment_mode', '$cheque_no', 
													1, '$branch', '$bank', '$store_key', '".$barcode."')";
				//die($sql);
				if(!mysqli_query($con,$sql)){
					die('Error'.mysql_error());
				}
                
                else
                {
                    if($InStock=='on')
                    {
                        // Get The Current Qunatity 
                        
                        $getQuantity="SELECT `quantity` FROM  new_inventory  where `medicine_id`='" .$medicine_id."' AND `store_key`='".$store_key."'";
                        $getresultQunatity=mysqli_fetch_row(mysqli_query($con,$getQuantity));
                        $quan=$getresultQunatity[0]-$quantity;
                        
                        // update qunatity from new_inventory table 
                        $updateQunatity="UPDATE `new_inventory` SET `quantity`='".$quan."' where `medicine_id`='".$medicine_id."' AND `store_key`='".$store_key."'";
                        $updateresultQunatity=mysqli_query($con,$updateQunatity);
                        
                    // reduce qunatity
                        
                        
                    }
                // chk InStatus In check than reduce qunatity from table 
                }
				
	
			break;
		}
	}
	
	$bill_total 	= $data['bill_total'];
	$grand_tax 		= $data['grand_tax'];
	$grand_discount = $data['grand_discount'];
	$grand_total 	= $data['grand_total'];
	
	$sql = "insert into `billing` (`bill_id`, `subtotal`, `tax`, `discount`, `total`, `store_key`, `created_date`)
			values ($max_id, $bill_total, $grand_tax, $grand_discount, $grand_total, '$store_key', '$create_date')";
	
	if(!mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}
				
?>
<script type="text/javascript">
    function poponload() {
        var popUp = window.open("admin/paid_bill_print.php?bill_id=<?php echo $max_id;?>", "Print Bill", "location=no,status=1,scrollbars=1,width=980,height=600,top=100,left=300");

    if (popUp == null || typeof (popUp) == 'undefined') {
        alert("Alert: Please disable your pop-up blocker. <br> For now, print the bill from 'Customer Bills' section.");
    }
    setTimeout(function () {
        window.location.href = "index.php?view=billing&menu=billing"; //will redirect to your blog page (an ex: blog.html)
    }, 2000);
}
</script>
<body onLoad="javascript: poponload()"></body>
