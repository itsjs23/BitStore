<?php
/*
$con=mysql_connect("localhost","root","");
if(!$con)
{
die('could not connect'.mysql_error());
} 

//mysql_select_db("invent109"); 
mysql_select_db("medical"); 

$result = mysqli_query($con,"select * from `bk_distributors`");
while ($row = mysqli_fetch_array($result)){
	//$res = mysqli_query($con,"select * from `users` where `user_id` = ".$row['user_id']);
	//$user = mysqli_fetch_array($res);
	
	//$s = "update `distributors` set `username` = '".$user['username']."' , `password` = '".$user['password']."' where `distributor_id` = ".$row['distributor_id'];
	//echo $s;
	//mysqli_query($con,$s);
	
	$key = $row['store_key'];
	$d_id = $row['distributor_id'];
	$q = "insert into `store_distributor_mapping` (`store_key`, `distributor_id`) values ('$key', '$d_id')";
	mysqli_query($con,$q);
	
}
*/
	/*
	$medicines = array();

	for($i = 1; $i < 68; $i++){
		$file = dirname(__FILE__)."\database\medicine$i.csv";
		$medicine = file_get_contents($file);
		$data = explode("\r\n", $medicine);
		
		foreach ($data as $value){
			$value = trim($value);
			$value = rtrim($value, ',');
			$medicines[] = $value;
		}
	}
	
	$medicines = array_unique($medicines);
	$medicines = array_filter($medicines);
	
	$medicines = "['".implode("', '", $medicines)."']";
	$file = dirname(__FILE__).'\js\medicines.json';
	file_put_contents($file, $medicines);

*/

/*
$medicines = array();
$file = dirname(__FILE__)."\database\manufacture.csv";
		$medicine = file_get_contents($file);
		$data = explode("\r\n", $medicine);
		
		foreach ($data as $value){
			$value = trim($value);
			$value = rtrim($value, ',');
			$medicines[] = $value;
		}
	
	$medicines = array_unique($medicines);
	$medicines = array_filter($medicines);
	
	$medicines = "['".implode("', '", $medicines)."']";
	$file = dirname(__FILE__).'\js\manufacturer.json';
	file_put_contents($file, $medicines);
	*/
	