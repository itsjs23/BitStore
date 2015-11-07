<?php session_start(); ?>
<?php
include("../../config.php");
$store_key = $_SESSION['mystoreid'];

if(isset($_POST['action'])){

    
    switch($_POST['action'])
    {
        case "insert_medicine":
            parse_str( $_POST['query'],$data);
            $medicine	= urldecode($data['name']);
            $inge		= urldecode($data['ingrediants']);
            $generic	= 1;
            $mfgr		= urldecode($data['manufacturer']);
            $cat_id		= urldecode($data['category_id']);
            $min_limit=($data['min_limit']=='')? 0 : $data['min_limit'];
           // $barcode = $_POST['barcode'];
           // $current = date("Y-m-d");
           // $after	= date("Y-m-d", mktime(0,0,0,date('m'), date('d')+7, date('Y')));
            $batchCode=urldecode(substr($medicine,0,2).''.rand(1111,9999));
            
            $sql="insert into `medicine` (`medicine_name`, `category_id`, `ingrediants`, `is_generic`, `manufacturer`, `status`, `store_key`,batchCode,minLimit) 
		        values ('$medicine',$cat_id,'$inge',$generic,'$mfgr', 1, '$store_key','$batchCode','$min_limit')";
            $result=mysqli_query($con,$sql);
            if($result){
                $arr['status']='success';
            }
            else{
                $arr['status']='fail';
                $arr['msg']='Insert Query Failed';
            }
            break;
        
        case "update_medicine":
            $data=$_POST['query'];
            $medicine	= urldecode($data[1]); // name 
            $inge		= urldecode($data[3]); // ingredient
            $generic	= 1; // is genric yes
            $mfgr		= urldecode($data[5]);
            //$cat_id		= $_POST['$cat_id']
            
           // $min_limit=($data['min_limit']=='')? 0 : $data['min_limit'];
           // $barcode = $_POST['barcode'];
           // $current = date("Y-m-d");
          //  $after	= date("Y-m-d", mktime(0,0,0,date('m'), date('d')+7, date('Y')));
           // $batchCode=substr($medicine,0,2).''.rand(1111,9999);
            
            $medicine_id = $data[0];
               // $sql = "update `medicine` set `medicine_name`= '$medicine', `category_id`= $cat_id, `ingrediants` = '$inge',
            $sql = "update `medicine` set `medicine_name`= '$medicine',`ingrediants` = '$inge',
                `is_generic` = $generic, `manufacturer` = '$mfgr' where `medicine_id` = $medicine_id";
                $result=mysqli_query($con,$sql);
                if($result){
                    $arr['status']='success';
                }
                else{
                    $arr['status']='fail';
                    $arr['msg']='Insert Query Failed';
                }
            break;
            
        case "delete_medicine":
            $id	= $_REQUEST['medicine_id'];

            if(!empty($id)){
                $sql="update `medicine` set status=0 where medicine_id=$id";
                $result=mysqli_query($con,$sql);
                if($result){
                    $arr['status']='success';
                }
                else{
                    $arr['status']='fail';
                    $arr['msg']='Delete Query Failed';
                }
            }
            break;  
            
            
            
        
    }  //switch end 
    
} //action chk if end 
else{
$arr['status']='fail';
$arr['msg']='Parameter Expected';
}

echo json_encode($arr);
exit;









//switch($action)
//{
//case "insert_medicine":



//case "select_medicine":
//    $sql  = 'select m.medicine_name, invt.* from medicine as m inner join (select * from `inventory` ';
//    $sql .= 'where `store_key` = '."'".$store_key."'".' and `status` = '.DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED;
//    $sql .= " and `barcode` = $barcode ) as invt on (m.medicine_id = invt.medicine_id)";

//    $result = mysqli_query($con,$sql);
//    $record = mysqli_fetch_array($result);

//    $record['unit_cost'] 	= DhsHelper::formatPrice($record['unit_cost']);
//    $record['subtotal']		= DhsHelper::formatPrice($record['subtotal']);
//    $record['total']		= DhsHelper::formatPrice($record['total']);

//    $record['mfg_date'] = DhsHelper::formatDate($record['mfg_date'], 'Y-m-d');
//    $record['expiry_date'] = DhsHelper::formatDate($record['expiry_date'], 'Y-m-d');

//    //$sold_rs = mysqli_query($con,'select sum(quantity) as sold from `cust_inventory` group by `barcode` where ');

//    echo '####'.json_encode($record).'@@@@';
//    die();

//    break;

//case "barcode_medicine":
//    $records = DhsHelper::getBarcodeDetails($barcode, $store_key);

//    echo '####'.json_encode($records).'@@@@';
//    die();

//    break;



//echo "<script>";
//echo "window.location='index.php?view=medicine_details&menu=medicine'";
//echo "</script>";

//break;

//case "return_medicine":
//    $id	= $_REQUEST['medicine_id'];

//    if(!empty($id)){
//        $sql="update `medicine` set status=0 where medicine_id=$id";
//        if(!$rs = mysqli_query($con,$sql)){
//            die('Error'.mysql_error());
//        }
//    }

//echo "<script>";
//echo "window.location='index.php?view=medicine_details&menu=medicine'";
//echo "</script>";

//break;
//}

?>


