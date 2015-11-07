<?php
require_once 'config.php';

class DhsHelper 
{
    
	public static function getDistInventoryData($inventory_id)
	{
		$store_key = $_SESSION['mystoreid'];
		
		$sql = 'select invt.*,date(invt.`mfg_date`) as mfg_date, date(invt.`expiry_date`) as expiry_date, date(invt.`verified_date`) as verified_date, dst.name as distributor_name, md.medicine_name from `inventory` as invt ';
		$sql .= 'left join `distributors` as dst on (invt.distributor_id = dst.distributor_id) ';
		$sql .= 'left join `medicine` as md on (invt.medicine_id = md.medicine_id) ';
		$sql .= 'where invt.inventory_id = '.$inventory_id;
		
		$result = mysqli_query($dbConn,$sql);
		while($row = mysqli_fetch_array($result)){
			return $row;
		}
	}
    
    
	public static function getMedicinesList($con,$medicine_ids = array())
	{
		if(empty($medicine_ids)){
			return array();
		}
		
		$sql = 'select medicine_id, medicine_name from `medicine` where `medicine_id` IN ('.implode(',', $medicine_ids).')';
		$medicine_list = array();
		$result = mysqli_query($con,$sql);
		
		while($row = mysqli_fetch_array($result)){
			$medicine_list[$row['medicine_id']] = $row['medicine_name'];
		}
		
		return $medicine_list;
	}
	
	public static function getMedicineCategories($medicine_ids = array())
	{
		if(empty($medicine_ids)){
			return array();
		}
		
		$sql = 'select m.medicine_id, c.name from `medicine` as m inner join `category` as c on (m.category_id = c.category_id and m.medicine_id IN ('.implode(',', $medicine_ids).'))';
		$category_list = array();
		$result = mysqli_query($dbConn,$sql);
		
		while($row = mysqli_fetch_array($result)){
			$category_list[$row['medicine_id']] = $row['name'];
		}
		
		return $category_list;
	}
	
	public static function getCategories($con)
	{
		$store_key 	= $_SESSION['mystoreid'];
		$result 	= mysqli_query($con,"select * from `category` where `store_key` = '$store_key'");
		$categories = array();
		
		while($record = mysqli_fetch_array($result)){
			$categories[$record['category_id']] = $record['name'];
		}
		
		return $categories;
	}
	
	public static function getDistributorsList($con,$distributor_ids = array())
	{
		if(empty($distributor_ids)){
			return array();
		}
		
		$sql = 'select distributor_id, fullname from `distributors` where distributor_id IN ('.implode(',', $distributor_ids).')';
		$distributor_list = array();
		$result = mysqli_query($con,$sql);
		
		while($row = mysqli_fetch_array($result)){
            $distributor_list[$row['distributor_id']] = $row['fullname'];
		}
		
		return $distributor_list;
	}
	
	public static function getUsersList($user_ids = array())
	{
		if(empty($user_ids)){
			return array();
		}
		
		$store_key = $_SESSION['mystoreid'];
		
		$sql = 'select user_id, username from `users` where user_id IN ('.implode(',', $user_ids).')';
		$user_list = array();
		$result = mysqli_query($dbConn,$sql);
		
		while($row = mysqli_fetch_array($result)){
			$user_list[$row['user_id']] = $row['username'];
		}
		
		return $user_list;
	}
	
	public static function getFinishedStock($con)
	{
		$store_key = $_SESSION['mystoreid'];
		
		static $_finish_stock = 0;
		$count_out_of_stock="SELECT COUNT(NI.`inventory_id`) FROM `new_inventory` AS NI INNER JOIN `medicine` AS MD ON MD.`medicine_id`=NI.`medicine_id` WHERE  MD.store_key='$store_key' AND  NI.`quantity` < MD.minLimit";
        $result=mysqli_query($con,$count_out_of_stock);
        if($result  &&  $result->num_rows > 0)
        {
            $count=mysqli_fetch_row($result);
            return $count[0];
        }
        else
        {
            return $_finish_stock;
        }
        
        
        
		// Retrive all medicines list
        //$result = mysqli_query($dbConn,'select * from `medicine` where `store_key` = '."'".$store_key."'".' and `status` <> 0');
        //while($row = mysqli_fetch_array($result))
        //{
        //    $id 	= $row['medicine_id'];
        
        //    $result2	= mysqli_query($dbConn,"select sum(quantity) from inventory where `store_key` = '$store_key' and `medicine_id` = $id and status = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED);
        //    $purchased	= mysqli_fetch_array($result2);
        //    $total_purchased = $purchased['sum(quantity)'];
        
        //    $result1 = mysqli_query($dbConn,"select sum(quantity) from cust_inventory where `store_key` = '$store_key' and medicine_id=$id");
        //    $sold	= mysqli_fetch_array($result1);
        //    $total_sold = $sold['sum(quantity)'];
        
        //    $remaining=intval($total_purchased)-$total_sold;
        //    if($remaining <= 10){
        //        ++$_finish_stock;
        //    }
        //}
		//return $_finish_stock;
	}
	
	public static function getArrivedStock($con)
	{
		$store_key = $_SESSION['mystoreid'];
        $arrived_stock="SELECT COUNT(VP.`ven_pay_id`) AS count FROM `vendor_payment` AS VP INNER JOIN vendors AS VD ON VD.Id=VP.`ven_id`  
                WHERE VP.date='".date('Y-m-d')."' AND VD.store_key='".$store_key."' ";
        $result = mysqli_query($con,$arrived_stock);
        if($result && $result->num_rows > 0 ){
            $record = mysqli_fetch_array($result);
            return $record['count'];
        }else{ 
            return '0' ;
        }
        
	}
	
	public static function formatPrice($con,$price, $decimal = 2)
	{
		return number_format($price, $decimal, '.', '');
	}
	
	public static function formatDate($date, $format = 'd-m-Y')
	{   
        $date = new DateTime($date);
		return $date->format($format);
	}
	
	public static function getInventoryDetails($medicine_id = 0, $page_id = null, $store_key = null)
	{
		$store_key 	= ($store_key == null) ? $_SESSION['mystoreid'] : $store_key;
		$sql 		= 'select * from medicine';
		
		$where		= array();
		$where[]	= "`store_key` = '$store_key'";
		$where[]	= '`status` <> 0';
		if(!empty($medicine_id) && !is_array($medicine_id)){
			$where[] = '`medicine_id` = '.$medicine_id;
		}
		
		if(!empty($medicine_id) && is_array($medicine_id)){
			$where[] = '`medicine_id` IN ('.implode(",", $medicine_id).')';
		}
		
		$sql   .= ' where '.implode(' and ', $where);
		
		if($page_id !== null){
			$pageLimit = PAGE_PER_NO * $page_id;
			$sql .= " limit $pageLimit,".PAGE_PER_NO;
		}
		
		$result = mysqli_query($dbConn,$sql);
		
		$records 	= array();
		$medicines 	= array();
		
		while ($row = mysqli_fetch_array($result)){
			$records[] 	= $row;
			$medicines[]= $row['medicine_id'];
		}
        
		if(empty($medicines)){
			return array(array(), array(), array(), array());
		}
		
		// calculate purchased units
		$sql = 'select `medicine_id`, sum(`quantity`) as quantity, sum(`total`) as total, max(`mfg_date`) as mfg_date, max(`expiry_date`) as expiry_date from `inventory` ';
		$sql .= 'where `medicine_id` IN ('.implode(',', $medicines).') ';
		$sql .= 'group by `medicine_id`';
		
		$result = mysqli_query($dbConn,$sql);
		$purchased = array();
		
		while($row = mysqli_fetch_array($result)){
			$purchased[$row['medicine_id']]['quantity'] = $row['quantity'];
			$purchased[$row['medicine_id']]['total'] = $row['total'];
			$purchased[$row['medicine_id']]['mfg_date'] = $row['mfg_date'];
			$purchased[$row['medicine_id']]['expiry_date'] = $row['expiry_date']; 
		}
		
		// calculate sold units
		$sql = 'select `medicine_id`, sum(`quantity`) as quantity, billing.`total` as total from `cust_inventory` join `billing`';
		$sql .= 'on (`cust_inventory`.bill_id = `billing`.`bill_id`) where `medicine_id` IN ('.implode(',', $medicines).') ';
		$sql .= 'group by `medicine_id`';
		
		$result = mysqli_query($dbConn,$sql);
		$sold = array();
		$bill_ids = array();
		while($row = mysqli_fetch_array($result)){
			$sold[$row['medicine_id']]['quantity'] = $row['quantity'];
			$sold[$row['medicine_id']]['total'] = $row['total']; 
		}
		
		$sql = 'select `medicine_id`, sum(`quantity`) as quantity, sum(`returning_total`) as total from `return_stock` ';
		$sql .= 'where `medicine_id` IN ('.implode(',', $medicines).') ';
		$sql .= 'group by `medicine_id`';
		
		$result = mysqli_query($dbConn,$sql);
		$return = array();
		
		while($row = mysqli_fetch_array($result)){
			$return[$row['medicine_id']]['quantity'] = $row['quantity'];
			$return[$row['medicine_id']]['total'] = $row['total']; 
		}
		
		return array($records, $purchased, $sold, $return);
	}
	
	public static function getRecentTransactions()
	{
		//$store_key = $_SESSION['mystoreid'];
		
        
        //$sql="SELECT `customer_name`,SUM(`total`) AS TotalAmount FROM `cust_inventory` WHERE `store_key`='".$store_key."' GROUP BY `customer_name` , `customer_mob` order by `inventory_id` LIMIT 5";
        // $result =  mysqli_query($dbConn,$sql);
        // $data=array();
        //while($row = mysqli_fetch_row($result)){
        //    $data[]
        //}
        
        
        //$sql = 'select inventory_id, customer_name, medicine_id, bill_id, store_key from `cust_inventory` where `status` <> 0 group by `bill_id` having `store_key` = '."'".$store_key."'".' order by created_date DESC, inventory_id DESC limit 0, 5';
        //$result =  mysqli_query($dbConn,$sql);
        
        //$records	= array();
        //$medicines 	= array();
        //$bills 		= array();
		
        //while($row = mysqli_fetch_array($result)){
        //    $records[] 		= $row;
        //    $medicines[] 	= $row['medicine_id'];
        //    $bills[]		= $row['bill_id'];
        //}
		
		//$list_medicines = array();
        //if(!empty($medicines)){
        //    $sql = 'select medicine_id, medicine_name from medicine where `store_key` = '."'".$store_key."'".' and `medicine_id` IN ('.implode(',', $medicines).')';
        //    $result = mysqli_query($dbConn,$sql);
        
        //    while($row = mysqli_fetch_array($result)){
        //        $list_medicines[$row['medicine_id']] = $row['medicine_name'];
        //    }
        //}
		
		//$list_bills = array();
        //if(!empty($bills)){
        //    $sql = 'select sum(`total`) as total, `bill_id` from `billing` where 
        //            `store_key` = '."'".$store_key."'".' and `bill_id` IN ('.implode(',', $bills).') group by `bill_id`';
        //    $result = mysqli_query($dbConn,$sql);
        
        //    while($row = mysqli_fetch_array($result)){
        //        $list_bills[$row['bill_id']] = $row['total'];
        //    }
        //}
		
		return array($records, $list_medicines, $list_bills);
		
	}
	
	public static function getNearExpiry()
	{
		$store_key = $_SESSION['mystoreid'];
		
		$now = date('Y-m-d');
		$current = strtotime(date('Y-m-d'));
        $next = strtotime('+15 day', $current);
        $next = date('Y-m-d', $next);
        
		$sql = "select medicine_id, date(expiry_date) as expiry_date from `inventory` where `store_key` = '$store_key' and status = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED." and date(expiry_date) >= '$now' and date(expiry_date) <= '$next' order by expiry_date ASC limit 0, 5";
		//die($sql);
		$result = mysqli_query($dbConn,$sql);
		
		$records	= array();
		$medicines 	= array();
		
		while($row = mysqli_fetch_array($result)){
			$records[$row['medicine_id']] = $row;
			$medicines[] 	= $row['medicine_id'];
		}
		
		if(empty($medicines)){
			return array();
		}
		
		$medicines = array_unique($medicines);
		
		$sql = 'select m.medicine_id, m.medicine_name, c.name from `medicine` as m join `category` as c 
				on (m.category_id = c.category_id and m.store_key = '."'".$store_key."'".' and c.store_key = '.
				"'".$store_key."'".' and m.status <> 0 and m.medicine_id IN ('.implode(',', $medicines).'))';
		
		$result = mysqli_query($dbConn,$sql);
		
		$list_medicines = array();
		while($row = mysqli_fetch_array($result)){
			$list_medicines[$row['medicine_id']]['name'] = $row['medicine_name'];
			$list_medicines[$row['medicine_id']]['expiry_date'] = $records[$row['medicine_id']]['expiry_date'];
			$list_medicines[$row['medicine_id']]['category'] = $row['name'];
		}
		
		return $list_medicines;
	}
    public static function getVendorHistory()
	{
		$store_key = $_SESSION['mystoreid'];
		
		$now = date('Y-m-d');
		$current = strtotime(date('Y-m-d'));
        $next = strtotime('+15 day', $current);
        $next = date('Y-m-d', $next);
        
		$sql = "select medicine_id, date(expiry_date) as expiry_date from `inventory` where `store_key` = '$store_key' and status = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED." and date(expiry_date) >= '$now' and date(expiry_date) <= '$next' order by expiry_date ASC limit 0, 5";
		//die($sql);
		$result = mysqli_query($dbConn,$sql);
		
		$records	= array();
		$medicines 	= array();
		
		while($row = mysqli_fetch_array($result)){
			$records[$row['medicine_id']] = $row;
			$medicines[] 	= $row['medicine_id'];
		}
		
		if(empty($medicines)){
			return array();
		}
		
		$medicines = array_unique($medicines);
		
		$sql = 'select m.medicine_id, m.medicine_name, c.name from `medicine` as m join `category` as c 
				on (m.category_id = c.category_id and m.store_key = '."'".$store_key."'".' and c.store_key = '.
				"'".$store_key."'".' and m.status <> 0 and m.medicine_id IN ('.implode(',', $medicines).'))';
		
		$result = mysqli_query($dbConn,$sql);
		
		$list_medicines = array();
		while($row = mysqli_fetch_array($result)){
			$list_medicines[$row['medicine_id']]['name'] = $row['medicine_name'];
			$list_medicines[$row['medicine_id']]['expiry_date'] = $records[$row['medicine_id']]['expiry_date'];
			$list_medicines[$row['medicine_id']]['category'] = $row['name'];
		}
		
		return $list_medicines;
	}
	
	//$charfeed = Array(
    //'a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m',
    //'M','n','N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w','W','x','X','y','Y',
    //'z','Z','0','1','2','3','4','5','6','7','8','9');

    function intToShort($number, $charfeed) {
        $need = count($charfeed);
        $s = '';

        do {
            $s .= $charfeed[bcmod($number, $need)];
            $number = floor($number/$need);
        } while($number > 0);

        return $s;
    }

    function shortToInt($string, $charfeed) {
        $num = 0;
        $need = count($charfeed);
        $length = strlen($string);

        for($x = 0; $x < $length; $x++) {
            $key = array_search($string[$x], $charfeed);
            $value = $key * bcpow($need, $x);
            $num += $value;
        }

        return $num;
    }
    
	public static function getPagination($count){
        $paginationCount= floor($count / PAGE_PER_NO);
        $paginationModCount= $count % PAGE_PER_NO;
        if(!empty($paginationModCount)){
            $paginationCount++;
        }
        return $paginationCount;
	}
	
	public static function getRevenue($con,$today="")
	{
		//$store_key = $_SESSION['mystoreid'];
	
        $que1="SELECT SUM(total) FROM `new_cust_inventory` WHERE status=1 " ;
        if($today !=""){
            $que1 .= " AND  created_date='".date('Y-m-d')."'; " ;
        }else{
            $que1 .= " ; "  ;
        }
        
        $que2="SELECT SUM(Amount- PendiangAmount) FROM vendor_payment ";
        if($today !=""){
            $que2 .= " WHERE date= '".date('Y-m-d')."';" ;
        }else{
            $que2 .= " ; "  ;
        }
        
        $que3="SELECT SUM(actual_payment) FROM paid_salary ";
        if($today !=""){
            $que3 .= " WHERE paid_on_date= '".date('Y-m-d')."';" ;
        }else{
            $que3 .= " ; "  ;
        }
        
        $que4 ="SELECT SUM(amount) FROM expenditure ";
        if($today !=""){
            $que4 .= " WHERE created_date= '".date('Y-m-d')."';" ;
        }else{
            $que4 .= " ; "  ;
        }
        
        $que =$que1.$que2.$que3.$que4;
         $arr=array();
                               /* execute multi query */
                            if (mysqli_multi_query($con, $que)) {
                                do {
                                    /* store first result set */
                                    if ($result = mysqli_store_result($con)) {
                                        while ($row = mysqli_fetch_row($result)) {
                                            $arr[]=($row[0]==null? 0 :$row[0]);
                                        }
                                        mysqli_free_result($result);
                                    }
                                } while (mysqli_next_result($con));
                            }
        
        
        $income=$arr[0];
      //  $purchases=$arr[1];
       // $salary=$arr[2];
        //$expense=$arr[3];
                         
        $revenue= $income ;//- ($purchases + $salary + $expense);
        return self::formatPrice($con,$revenue); 
	}
    
    
    //get today Purchage 
   
    public static function getPurchage($con)
    {
        //$store_key = $_SESSION['mystoreid'];
      ////  $query="SELECT SUM(`quantity`*`buy_unit_cost`) FROM `new_inventory` WHERE `date`='".date('Y-m-d')."' ";
        $query="SELECT SUM(`Amount` - `PendiangAmount`)  FROM `vendor_payment` WHERE date='".date('Y-m-d')."' ;";
        $record = mysqli_fetch_row(mysqli_query($con,$query));
        $today_amount = $record[0];
        return self::formatPrice($con,$today_amount); 
        
    }
    
    
	
	public static function getBarcodeDetails($barcode, $store_key)
	{
		if(empty($barcode)){
			return array('medicine_id' => 0, 'medicine_name' => '', 'unit_cost' => '', 'remaining' => '', 'mfg_date' => '', 'expiry_date' => '');
		}
		
		$sql  = 'select m.`medicine_id`, m.`medicine_name`, invt.`unit_cost`, invt.`mfg_date`, invt.`expiry_date` from `medicine` as m join ';
		$sql .= ' (select `medicine_id`, `unit_cost`, `expiry_date`, `mfg_date` FROM `inventory` WHERE `store_key` = '."'".$store_key."'";
		$sql .= " and `barcode` = $barcode) as invt ";
		$sql .= 'on (invt.`medicine_id` = m.`medicine_id` and m.status <> 0)';
		
		$result 	 = mysqli_query($dbConn,$sql);
		$medicine 	 = mysqli_fetch_array($result);
		
		if(empty($medicine)){
			return array('medicine_id' => 0, 'medicine_name' => '', 'unit_cost' => '', 'remaining' => '', 'mfg_date' => '', 'expiry_date' => '');
		}
		
		$sql  = 'SELECT '; 
		$sql .= '( ';
		$sql .= "(select COALESCE(`quantity`, 0) from `inventory` where `barcode` = $barcode and status = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED.") ";
		$sql .= " - ";
		$sql .= "(select COALESCE(sum(`quantity`), 0) as quantity from `cust_inventory` where `barcode` = $barcode and status <> 0) "; 
	    $sql .= ' - ';
	    $sql .= "(select COALESCE(sum(`quantity`), 0) as quantity from `return_stock` where `barcode` = $barcode and status <> 0) ";
	    $sql .= ') as remaining';
		
		$result		= mysqli_query($dbConn,$sql);
		$row		= mysqli_fetch_array($result);
		$remaining	= empty($row['remaining']) ? 0 : $row['remaining'];
		
		$records = array('medicine_id' 	=> $medicine['medicine_id'], 
						'medicine_name' => $medicine['medicine_name'], 	
						'remaining' 	=> $remaining,
						'unit_cost'		=> $medicine['unit_cost'],
						'mfg_date'		=> $medicine['mfg_date'],
						'expiry_date'	=> $medicine['expiry_date']);
		return $records;
	}
	
	public static function getUniqueBarcode()
	{
		$barcode = substr(number_format(time()*rand(9999, 999999), 0, '', ''), 0, 13);
		$sql = "select count(`barcodes_id`) from `barcodes` where `barcode` = $barcode";
		$result = mysqli_query($dbConn,$sql);
		$count = mysqli_fetch_row($result);
		$count = $count[0]; 
		
		if($count > 0){
			return self::getUniqueBarcode();
		}
		
		return $barcode;
	}
}

//$original = 101;
//$short =  intToShort($original, $charfeed);
//echo $short;
//echo '<br/>';
//$result =  shortToInt($short, $charfeed);
//echo $result;


?>
