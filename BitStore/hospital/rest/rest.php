<?php

require_once dirname(dirname(dirname(__FILE__))) . '/defines.php';
require_once dirname(dirname(dirname(__FILE__))) . '/config.php';
require_once dirname(dirname(dirname(__FILE__))) . '/helper.php';

class Rest_controller{
	
	public function __construct($api_key)
	{
		if($api_key !== '3dxYZ_dhs5248_$41@3@4'){
			$this->authenticate = false;
		}else{
			$this->authenticate = true;
		}
	}
	
	public function isAuthorized()
	{
		return $this->authenticate;
	}
	
	public function login($request)
	{
		$response = array('success_code' => '404', 'result' => array('user_id' => "Error"));
		$values = array('storeid', 'username', 'password');
		$data	= array();
		
		foreach($values as $value){
			if(isset($request[$value]) && !empty($request[$value])){
				$data[$value] = stripslashes($request[$value]);
			}else {
				return $response;
			}
		}
		
		$sql	= "SELECT * FROM `users` WHERE `store_key` = '".$data['storeid'];
		$sql   .= "' and `username`='".$data['username']."' and `password`='".$data['password'];
		$sql   .= "' and `Enable` = 1 and `status` = 1";
		
		$result	= mysqli_query($con,$sql);
		$count	= mysqli_num_rows($result);
		$user	= mysqli_fetch_array($result);
		
		// If result matched $myusername and $mypassword, table row must be 1 row
		if($count == 1){
			$record = array('user_id' => $user['user_id']);
			$record = json_encode($record);
			$response = array('success_code' => '200', 'result' => array(array('user_id' => $user['user_id'])));
		}
		
		return $response;
	}
	
	public function add_medicine($request)
	{
		$response  	= array('success_code' => '404', 'result' => 'Error');
		$compulsory = array('medicine_name', 'category_id', 'storeid');
		$values 	= array('ingrediants', 'is_generic', 'manufacturer', 'status');
		$data		= self::processRequestData($request, $compulsory, $values);
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$sql = "insert into `medicine` (`medicine_name`, `category_id`, `ingrediants`, `is_generic`, `manufacturer`, `status`, `store_key`) 
				values ("."'".$data['medicine_name']."', '".$data['category_id'].
				"' , '".$data['ingrediants']."' , '".$data['is_generic']."' , '".$data['manufacturer'].
				"', ".$data['status'].", '".$data['storeid']."')";

		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record inserted successfully.')));
	}
	
	public function add_category($request)
	{
		$compulsory = array('category_name', 'storeid');
		$data		= self::processRequestData($request, $compulsory, array());
			
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$name = $data['category_name'];
		$store = $data['storeid'];
		
		$sql = "insert into `category` (`name`, `status`, `store_key`) 
				values ('$name', 1, '$store')";
		
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record inserted successfully.')));
	}
	
	public function category_details($request)
	{
		$compulsory = array('storeid');
		$data		= self::processRequestData($request, $compulsory, array());
			
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$where = array();
		$sql = 'select * from `category` ';
		
		$where[] = '`store_key` = '."'".$data['storeid']."'";
		$where[] = '`status` <> 0';
		
		if(isset($request['category_id']) && $request['category_id'] != 0){
			$data['category_id'] = $request['category_id'];
			$where[] = '`category_id` = '.$data['category_id'];
		}
		
		$sql .= ' where '. implode(' and ', $where);
		
		$result  = mysqli_query($con,$sql);
		$records = array();

		while($record = mysqli_fetch_array($result)){
			$records[] = $record;
		}
		
		
		return array('success_code' => '200', 'result' => $records);
	}
	
	
	public function distributor_details($request)
	{
		$compulsory = array('storeid');
		$data		= self::processRequestData($request, $compulsory, array());
			
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$store_key = $data['storeid'];
		$result = mysqli_query($con,"select group_concat(`distributor_id`) as distributor_ids from `store_distributor_mapping` where `store_key` = '$store_key'");
		$distributor_ids = mysqli_fetch_row($result);
		$distributor_ids = empty($distributor_ids) ? null : $distributor_ids[0];
		
		$where = array();
		$sql = 'select `distributor_id`, `fullname` as name, `email`, `mobile`, `address`, `city`, `state`, `country`, `shop_name`, `status` from `distributors` ';
		$where[] = '`status` <> 0';
		
		if(isset($request['distributor_id']) && $request['distributor_id'] != 0){
			$data['distributor_id'] = $request['distributor_id'];
			$where[] = '`distributor_id` = '.$data['distributor_id'];
		}
		elseif (!empty($distributor_ids)){
			$where[] = "distributor_id IN ($distributor_ids)";
		}
		
		$sql .= ' where '. implode(' and ', $where);
		$result  = mysqli_query($con,$sql);
		$records = array();

		while($record = mysqli_fetch_array($result)){
			$records[] = $record;
		}
		
		return array('success_code' => '200', 'result' => $records);
	}
	
	public function barcode_details($request)
	{
		$compulsory = array('barcode','storeid');
		$data		= self::processRequestData($request, $compulsory, array());
			
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$details = DhsHelper::getBarcodeDetails($data['barcode'], $data['storeid']);
		return array('success_code' => '200', 'result' => array($details));
	}
	
	public function customer_bills($request)
	{
		$compulsory = array('storeid');
		$values 	= array('customer_name', 'start_date', 'end_date'); 
		$data		= self::processRequestData($request, $compulsory, $values);
			
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$sql = 'SELECT `customer_name`,`customer_mob`,`bill_id`, 
					sum(`quantity`) as quantity, sum(`total`) as total,
					`created_date` as paid_date FROM `cust_inventory` ';
					
					
		$where = array();
		$where[] = "`store_key` = '".$data['storeid']."'";
		
		if(trim($data['customer_name']) != '0'){
			$where[] = '`customer_name` like '."'%".$data['customer_name']."%'";
		}
		
		if(trim($data['start_date']) != '0'){
			$where[] = 'created_date >= '."'".$data['start_date']."'";
		}
		
		if(trim($data['end_date']) != '0'){
			$where[] = 'created_date <= '."'".$data['end_date']."'";
		}
		
		$where[] = 'status <> 0';
		
		$sql .= ' where '. implode(' and ', $where);
		$sql .= ' group by `bill_id` order by `bill_id` DESC ';
		
		$result  = mysqli_query($con,$sql);
		$records = array();

		while($record = mysqli_fetch_array($result)){
			$records[] = $record;
		}
		
		return array('success_code' => '200', 'result' => $records);
	}
	
	public function create_bill($request)
	{
		$bills 	 = $request['billlist'];
		$bills	 = json_decode($bills, true);
		$records = $bills['result'];
		
		$customer_name 	= $bills['customerName'];
		$customer_mob 	= $bills['customerMobile'];
		$doctor_mobile 	= $bills['doctorMobile'];
		$doctor_name 	= $bills['doctorName'];
		$payment_mode 	= $bills['cashMode'];
		$branch_name 	= $bills['branchName'];
		$bank_name 		= $bills['bankName'];
		$cheque_no 		= $bills['chequeNo'];
		
		$sql 	= mysqli_query($con,"select max(bill_id) from cust_inventory");
		$result = mysqli_fetch_array($sql);
		$max_id = $result['max(bill_id)'];
		$max_id++;
		
		
		$action 		= 'insert_billing';
		$medicine		= $bills['result'];
		$customer_name	= empty($bills['customerName']) ? 'Local Bills' : $bills['customerName'];
		$doctor_name	= empty($bills['doctorName']) ? null : $bills['doctorName'];
		$customer_no	= empty($bills['customerMobile']) ? 0 : $bills['customerMobile'];
		$doctor_no		= empty($bills['doctorMobile']) ? 0 : $bills['doctorMobile'];
	       
		$payment_mode	= empty($bills['cashMode']) ? 'Cash' : $bills['cashMode'];
		$cheque_no		= empty($bills['chequeNo']) ? null : $bills['chequeNo'];
		$branch			= empty($bills['branchName']) ? null : $bills['branchName'];
		$bank			= empty($bills['bankName']) ? null : $bills['bankName'];
		$store_key 		= $request['storeid'];
		$bill_total		= 0;
		
		// Check for doctor details
		if(!empty($doctor_name)){
			$sql = "select * from `doctors` where `store_key` = '$store_key' and `mobile` = $doctor_no";
			$result = mysqli_query($con,$sql);
			$record = mysqli_fetch_row($result);
			
			if(count($record) == 0 || $record == false){
				$sql = "insert into `doctors` (`doctor_name`, `mobile`, `status`, `store_key`) 
						values ('$doctor_name', $doctor_no, 1, '$store_key')";
				
				if(!mysqli_query($con,$sql)){
					die('Error'.mysql_error());
				}
			}elseif (count($record) > 0){
				$doctor_name = $record[1];
			}
		}
	
		foreach($medicine as $values)
		{
			$barcode	=	$values['barCodeNo'];		
			$medicine_id=	$values['medicine_id'];
			$quantity	=	$values['quantity'];
			$cost		=	$values['unitCost'];
			$subtotal	=	$values['subTotal'];
			$tax		=	$values['tax'];
			$discount	=	$values['discount'];
			$total		=	$values['total'];
			$mfg_date	=	urldecode($values['mfg_date']);
			$expiry_date=	urldecode($values['exp_date']);
			$create_date=	date("Y-m-d");
			
			if(empty($barcode) || empty($medicine_id) || empty($quantity) || empty($subtotal) || empty($total) || empty($expiry_date)){
				continue;
			}
			
			switch($action){
				case "insert_billing":
					$bill_total += $total;
					$user_id = $request['login_user_id'];
					
					$sql="insert into `cust_inventory` (`customer_name`, `customer_mob`, `doctor_name`, `doctor_mob`, `medicine_id`, `quantity`, 
														`unit_cost`, `subtotal`, `tax`, `discount`, `total`, `created_date`, `mfg_date`, 
														`expiry_date`, `bill_id`, `bill_created_by`, `payment_mode`, `cheque_no`, 
														`status`,`branch_name`,`bank_name`, `store_key`, `barcode`)
											 	values ('$customer_name', $customer_no, '$doctor_name', $doctor_no, $medicine_id, $quantity , 
														$cost, $subtotal, $tax, $discount, $total, '$create_date', '$mfg_date', 
														'$expiry_date',$max_id, $user_id, '$payment_mode', '$cheque_no', 
														1, '$branch', '$bank', '$store_key', $barcode)";
					//die($sql);
					if(!mysqli_query($con,$sql)){
						return array('success_code' => '404', 'result' => mysql_error());
					}
				break;
			}
		}
		
		$grand_tax 		= $bills['grandTax'];
		$grand_discount = $bills['grandDiscount'];
		$grand_total 	= $bills['grandTotal'];
		
		$sql = "insert into `billing` (`bill_id`, `subtotal`, `tax`, `discount`, `total`, `store_key`, `created_date`)
				values ($max_id, $bill_total, $grand_tax, $grand_discount, $grand_total, '$store_key', '$create_date')";
		
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		$st_rs = mysqli_query($con,"select * from `store` where `store_key` = '$store_key'");
		$stores = mysqli_fetch_array($st_rs);
		$stores['bill_id'] = $max_id;
		
		return array('success_code' => '200', 'result' => $stores);
		
	}
	
	public function add_stock($request)
	{
		$compulsory = array('storeid', 'distributor_id', 'barcode', 'medicine_id', 'quantity', 'buy_unit_cost', 'unit_cost', 'subtotal', 'total', 'mfg_date', 'expiry_date', 'batch_code');
		$values = array('tax', 'discount');
		$data		= self::processRequestData($request, $compulsory, $values);

		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$data['status'] = DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED;
		$data['verified_date'] = date('Y-m-d');
		$data['store_key'] = $data['storeid'];
		unset($data['storeid']);
		
		$coulmns = array_keys($data);
		$coulmns = '`'.implode('`, `', $coulmns).'`';
		
		$values = "'".implode("', '", $data)."'";
		
		$sql = "insert into `inventory` ($coulmns) values ($values)";
		
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record inserted successfully.')));
	}
	
	public function medicine_details($request)
	{
		$compulsory = array('storeid');
		$data		= self::processRequestData($request, $compulsory, array());
			
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$where = array();
		$sql = 'select medicine.*, category.name as category_name from `medicine` join `category` on (medicine.category_id = category.category_id) ';
		
		$where[] = 'medicine.`store_key` = '."'".$data['storeid']."'";
		$where[] = 'medicine.`status` <> 0';
		
		if(isset($request['medicine_id']) && $request['medicine_id'] != 0){
			$data['medicine_id'] = $request['medicine_id'];
			$where[] = '`medicine_id` = '.$data['medicine_id'];
		}
		
		$sql .= ' where '. implode(' and ', $where);
		
		$result  = mysqli_query($con,$sql);
		$records = array();

		while($record = mysqli_fetch_array($result)){
			$records[] = $record;
		}
		
		return array('success_code' => '200', 'result' => $records);
	}
	
	public function stock_details($request)
	{
		$compulsory = array('storeid');
		$data		= self::processRequestData($request, $compulsory, array());
			
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$key = 0;
		$records = array();
		list($medicines, $purchased, $sold, $return) = DhsHelper::getInventoryDetails(0 , null, $data['storeid']);
		
		foreach ($medicines as $medicine){
			$medicine_id = $medicine['medicine_id'];
			
			$purchase = isset($purchased[$medicine_id]) ? $purchased[$medicine_id]['quantity'] : 0;
			$sell = isset($sold[$medicine_id]) ? $sold[$medicine_id]['quantity'] : 0;
			$rturn = isset($return[$medicine_id]) ? $return[$medicine_id]['quantity'] : 0;
			
			$records[$key]['medicine_id'] 	= $medicine_id;
			$records[$key]['available_quantity']	  	= $purchase - $sell - $rturn;
			$records[$key]['medicine_name'] = $medicine['medicine_name'];
			
			$key++;
		}
		
		return array('success_code' => '200', 'result' => $records);
	}
	
	public static function arrived_stock($request)
	{
		$compulsory = array('storeid');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$store_key 	= $data['storeid'];
		$result 	= mysqli_query($con,"select * from `inventory` where `store_key` = '$store_key' and status = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_COMPLETED);
		
		$index = 0;
		$inventory	= array();
		$medicines	= array();
		$distributor= array();
		$records	= array();
		
		while($record = mysqli_fetch_array($result)){
			$records[]		= $record;
			$medicines[] 	= $record['medicine_id'];
			$distributor[] 	= $record['distributor_id'];
		}
		
		$medicine_details = DhsHelper::getMedicinesList($medicines);
		$distributors = DhsHelper::getDistributorsList($distributor);
		
		foreach ($records as $record){
			$inventory_id = $record['inventory_id'];
			$i = array();
			
			$i['inventory_id'] 		= $inventory_id;
			$i['medicine_name'] 	= $medicine_details[$record['medicine_id']];
			$i['requested_quantity']= $record['requested_quantity'];
			$i['arrived_quantity'] 	= $record['quantity'];
			$i['sent_on'] 			= $record['completed_date'];
			$i['distributor_name']	= $distributors[$record['distributor_id']];
			$i['barcode']			= $record['barcode'];
			$i['requested_quantity']= $record['requested_quantity'];
			$i['arrived_quantity']	= $record['quantity'];
			$i['unit_cost']			= $record['buy_unit_cost'];
			$i['subtotal']			= $record['subtotal'];
			$i['tax']				= $record['tax'];
			$i['discount']			= $record['discount'];
			$i['total']				= $record['total'];
			$i['mfg_date']			= $record['mfg_date'];
			$i['exp_date']			= $record['expiry_date'];
			
			$inventory[] = $i;
		}
		
		return array('success_code' => '200', 'result' => $inventory);
	}
	
	public static function verify_arrived_stock($request)
	{
		$compulsory = array('storeid', 'inventory_id', 'login_user_id', 'marginal_unit_cost');
		$values		= array('verified', 'cancellation_reason');
		
		$data		= self::processRequestData($request, $compulsory, $values);
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$now 		= date('Y-m-d');
		$id 		= $data['inventory_id'];
		$user 		= $data['login_user_id'];
		$verify 	= $data['verified'];
		$unit_cost 	= $data['marginal_unit_cost'];
		$message 	= empty($data['cancellation_reason']) ? null : $data['cancellation_reason'] ;
		$status 	= ($verify == 1) ? DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED : DHS_DISTRIBUTOR_INVENTORY_STATUS_CANCEL;
		
		$sql = "UPDATE `inventory` SET `verified_date`='$now', `message` = '$message', `unit_cost` = $unit_cost, `verified_by`=$user, `status` = $status WHERE `inventory_id` = $id";
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => array(array('message' => 'Error: '.mysql_error())));
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record updated successfully.')));
	}
	
	public static function finished_stock($request)
	{
		$compulsory = array('storeid');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$store_key 	= $data['storeid'];
		$result 	= mysqli_query($con,"select * from `medicine` where `store_key` = '$store_key' and `status` = 1");
		$finished	= array();
		
		while($record = mysqli_fetch_array($result)){
			$id 		 = $record['medicine_id'];
			$pending_res = mysqli_query($con,"select count(`inventory_id`) as invt, `requested_quantity`, `distributor_id` from `inventory` where `store_key` = '$store_key' and `medicine_id` = $id and `status` = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_PENDING);
			$pending 	 = mysqli_fetch_array($pending_res);
			$finish 	 = array();
			
			if($pending['invt'] == 1){
				$finish['medicine_id'] 			= $id;
				$finish['medicine_name'] 		= $record['medicine_name'];
				$finish['available_quantity'] 	= 0;
				$finish['requested_quantity'] 	= $pending['requested_quantity'];
				$finish['distributor_id'] 		= $pending['distributor_id'];
				$finished[] = $finish;
				continue;
			}
			
			$result2	= mysqli_query($con,"select sum(quantity) from `inventory` where `store_key` = '$store_key' and `medicine_id` = $id and `status` = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED);
			$purchased	= mysqli_fetch_array($result2);
			$total_purchased = $purchased['sum(quantity)'];
			
			$result1 = mysqli_query($con,"select sum(quantity) from `cust_inventory` where `store_key` = '$store_key' and medicine_id=$id");
			$sold	= mysqli_fetch_array($result1);
			$total_sold = $sold['sum(quantity)'];
			
			$result3 = mysqli_query($con,"select sum(quantity) from `return_stock` where `store_key` = '$store_key' and medicine_id=$id");
			$return	= mysqli_fetch_array($result3);
			$total_return = $sold['sum(quantity)'];
			
			$remaining = intval($total_purchased) - $total_sold - $total_return;
			
			if($remaining < 10){
				$finish['medicine_id'] 			= $id;
				$finish['medicine_name'] 		= $record['medicine_name'];
				$finish['available_quantity'] 	= $remaining;
				$finish['requested_quantity'] 	= 0;
				$finish['distributor_id'] 		= 0;
				$finished[] = $finish;
			}
		}
		
		return array('success_code' => '200', 'result' => $finished);
	}
	
	public function inventory_details($request)
	{
		$compulsory = array('storeid', 'medicine_id');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$store_key 	= $data['storeid'];
		$medicine_id = $data['medicine_id'];
		$result	 = mysqli_query($con,"select medicine.medicine_name, inventory.* from `medicine` inner join
				(select * from inventory where `store_key` = '$store_key' and status = 30 and medicine_id = $medicine_id) as inventory 
				on (medicine.`medicine_id` = inventory.`medicine_id`)");
		
		$inventory = array();
		
		while($row = mysqli_fetch_array($result)){ 
			$barcode = $row['barcode'];
			$sql  = 'SELECT '; 
			$sql .= '( ';
			$sql .= "(select COALESCE(`quantity`, 0) from `inventory` where `barcode` = $barcode and status = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED.") ";
			$sql .= " - ";
			$sql .= "(select COALESCE(sum(`quantity`), 0) as quantity from `cust_inventory` where `barcode` = $barcode) "; 
		    $sql .= ' - ';
		    $sql .= "(select COALESCE(sum(`quantity`), 0) as quantity from `return_stock` where `barcode` = $barcode and status <> 0) ";
		    $sql .= ') as remaining';
			
			$res	= mysqli_query($con,$sql);
			$rem	= mysqli_fetch_array($res);
			
			$i['available_quantity'] = $rem['remaining']; 
			$i['medicine_name'] = $row['medicine_name'];
			$i['barcode'] 		= $row['barcode'];
			$i['unit_cost'] 	= DhsHelper::formatPrice($row['unit_cost']);
			$i['subtotal'] 		= DhsHelper::formatPrice($row['subtotal']);
			$i['mfg_date'] 		= DhsHelper::formatDate($row['mfg_date']);
			$i['expiry_date'] 	= DhsHelper::formatDate($row['expiry_date']);
			$i['total'] 		= DhsHelper::formatPrice($row['total']);
			$i['medicine_id']	= $row['medicine_id'];
			$i['distributor_id']= $row['distributor_id'];
			$i['inventory_id']	= $row['inventory_id'];
			
			$inventory[] = $i;
		}
					
		return array('success_code' => '200', 'result' => $inventory);
	}
	
	public static function request_finish_stock($request)
	{
		$compulsory = array('storeid', 'distributor_id', 'requested_quantity', 'medicine_id', 'login_user_id');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$store_key 	= $data['storeid'];
		$now 		= date('Y-m-d');
		$user 		= $data['login_user_id'];
		$status 	= DHS_DISTRIBUTOR_INVENTORY_STATUS_PENDING;
		$distributor = $data['distributor_id'];
		$medicine	= $data['medicine_id'];
		$quantity 	= $data['requested_quantity'];
		
		$sql = "INSERT INTO `inventory` (`distributor_id`, `medicine_id`, `requested_quantity`, `status`, `requested_date`, `requested_by`, `store_key`) values 
				($distributor, $medicine, $quantity, $status, '$now', $user, '$store_key')";
		
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record inserted successfully.')));
	}
	
	public function update_medicine($request)
	{
		$compulsory = array('medicine_id', 'medicine_name', 'category_id');
		$values 	= array('ingrediants', 'is_generic', 'manufacturer');
		$data		= self::processRequestData($request, $compulsory, $values);
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$medicine_id = $data['medicine_id'];
		$medicine 	 = $data['medicine_name'];
		$cat_id 	 = $data['category_id'] ;
		$inge 		 = $data['ingrediants'];
		$generic 	 = $data['is_generic'];
		$mfgr 		 = $data['manufacturer'];
		
		$sql = "update `medicine` set `medicine_name`= '$medicine', `category_id`= $cat_id, `ingrediants` = '$inge', `is_generic` = $generic, `manufacturer` = '$mfgr' where `medicine_id` = $medicine_id";
		
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record updated successfully.')));
	}
	
	public static function delete_medicine($request)
	{
		$compulsory = array('medicine_id');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$id	 = $data['medicine_id'];
		$sql = "update `medicine` set status=0 where medicine_id=$id";
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record deleted successfully.')));
	}
	
	public function update_category($request)
	{
		$compulsory = array('category_id', 'name');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$cat_id = $data['category_id'];
		$name 	= $data['name'];
		
		$sql = "update `category` set `name`= '$name' where `category_id` = $cat_id";
		
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record updated successfully.')));
	}
	
	public static function delete_category($request)
	{
		$compulsory = array('category_id');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$id	 = $data['category_id'];
		$sql = "update `category` set status=0 where category_id=$id";
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record deleted successfully.')));
	}
	
	public static function add_expense($request)
	{
		$compulsory = array('storeid', 'particular', 'amount', 'expense_date', 'login_user_id');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$store_key  = $data['storeid'];
		$purpose 	= $data['particular'];
		$amount 	= $data['amount'];
		$expense_date = $data['expense_date'];
		$status 	= 1;
		$created_date = date('Y-m-d');
		$added_by 	= $data['login_user_id'];
		
		$sql = "insert into `expenditure` (`purpose`, `amount`, `expense_date`, `status`, `created_date`, `added_by`, `store_key`) 
				values ('$purpose', $amount, '$expense_date', $status, '$created_date', $added_by, '$store_key')";
		
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record inserted successfully.')));
	}	

	public static function do_return_stock($request)
	{
		$compulsory = array('storeid', 'medicine_id', 'quantity', 'distributor_id', 'unit_cost',
							'purchased_price', 'returning_total', 'loss', 'barcode',
							'login_user_id', 'return_date', 'inventory_id');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$store_key  	= $data['storeid'];
		$medicine_id 	= $data['medicine_id'];
		$quantity 		= $data['quantity'];
		$distributor_id = $data['distributor_id'];
		$unit_cost 		= $data['unit_cost'];
		$purchased_price= $data['purchased_price'];
		$return_toal 	= $data['returning_total'];;
		$loss 			= $data['loss'];
		$return_date 	= $data['return_date'];
		$barcode 		= $data['barcode'];
		$created_date 	= date('Y-m-d');
		$returned_by 	= $data['login_user_id'];
		
		$sql = "insert into `return_stock` (`medicine_id`, `quantity`, `distributor_id`, `unit_cost`, `purchased_price`, `returning_total`, `loss`, `return_date`, `created_date`, `status`, `returned_by`, `store_key`, `barcode`) 
				values ($medicine_id, $quantity, $distributor_id, $unit_cost, $purchased_price, $return_toal, $loss, '$return_date', '$created_date', 1, $returned_by, '$store_key', $barcode)";
		
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		//$sql = 'update `inventory` set `status` = '.DHS_DISTRIBUTOR_INVENTORY_STATUS_REVERT.' where `inventory_id` = '.$data['inventory_id'];
		//if(!mysqli_query($con,$sql)){
			//return array('success_code' => '404', 'result' => mysql_error());
		//}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record returned successfully.')));
	}
	
	public static function change_password($request)
	{
		$compulsory = array('storeid', 'login_user_id', 'old_password', 'new_password');
		$data		= self::processRequestData($request, $compulsory, array());
		
		if(!is_array($data)){
			return array('success_code' => '404', 'result' => $data);
		}
		
		$store_key	= $data['storeid'];
		$user_id	= $data['login_user_id'];
		$old_passwd	= $data['old_password'];
		$new_passwd = $data['new_password'];
		
		$sql = "update `users` set `password` = '$new_passwd' where `user_id` = '$user_id' and `store_key` = '$store_key' and `password` = '$old_passwd'";
		if(!mysqli_query($con,$sql)){
			return array('success_code' => '404', 'result' => mysql_error());
		}
		
		return array('success_code' => '200', 'result' => array(array('message' => 'Record updated successfully.')));
	}
	
	public static function processRequestData($request, $compulsory, $non_compulsory)
	{
		$data = array();
		foreach($compulsory as $value){
			if(isset($request[$value]) && !empty($request[$value])){
				$key = $request[$value];
				$key = stripslashes($key);
				$key = mysql_real_escape_string($key);
				$data[$value] = $key;
			}else {
				return ucfirst($value).' cannot be blank.';
			}
		}
		
		foreach($non_compulsory as $value){
			if(isset($request[$value]) && !empty($request[$value])){
				$key = $request[$value];
				$key = stripslashes($key);
				$key = mysql_real_escape_string($key);
				$data[$value] = $key;
			}else {
				$data[$value] = 0;
			}
		}
		
		return $data;
	}
	
}