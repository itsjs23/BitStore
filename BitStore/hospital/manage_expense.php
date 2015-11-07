<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php

if(isset($_POST['query'])){
	$query = explode("&", $_POST['query']);
	$data = array();
	
	foreach($query as $values){
			$value = explode("=", $values);
			$data[$value[0]] = $value[1];	
	}
	
	$action			= $data['action'];
	$particular		= urldecode($data['particular']);
	$amount			= urldecode($data['amount']);
	$expense_date	= urldecode($data['expense_date']);
}
else
{
if(isset($_REQUEST['action'])){
	$action=$_REQUEST['action']; }
else{ $action='';}
}

switch($action)
{
	
case "delete_expense":
	$id = $_REQUEST['expense_id'];
	
	$sql="update `expenditure` set status=0 where `expenditure_id` = $id";
	if(!$rs = mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}


break;


}
?>
