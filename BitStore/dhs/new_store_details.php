<?php

$values = array('store_name', 'person_name', 'email', 'address', 'city', 'state', 'country', 'mobile');
$login = array('username', 'password');
$data = array();


foreach($values as $value){
	if($value == 'email' && isset($_POST[$value])){
		$data[$value] = $_POST[$value];
		continue;
	}
	
	if(isset($_POST[$value]) && !empty($_POST[$value])){
		$data[$value] = $_POST[$value];
	}else {
		echo"<script>";
		echo"window.location='dhs/index.php?view=add_store'";
		echo"</script>";
		
		return true;
	}
}

if(empty($data)){
	echo"<script>";
	echo"window.location='dhs/index.php?view=add_store'";
	echo"</script>";
	
	return true;
}

	$charfeed = Array(
    'a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m',
    'M','n','N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w','W','x','X','y','Y',
    'z','Z','0','1','2','3','4','5','6','7','8','9');

    function intToShort($number, $charfeed) {
        $need = count($charfeed);
        $s = '';

        do {
            $s .= $charfeed[bcmod($number, $need)];
            $number = floor($number/$need);
        } while($number > 0);

        return $s;
    }


    $data['created_date'] 	= date('Y-m-d');
    $data['created_by']		= $_SESSION['myuserid'];
    $data['status']			= 1;
    
    $sql = "insert into `store` (`".implode('`,`', array_keys($data))."`) 
		values ('".implode("','", $data)."')";

if(!mysqli_query($con,$sql)){
	die('Error: '.mysql_error());
}

$store_id 	= mysql_insert_id();
$store 		= $store_id + 9999;
$store_key 	= 'dhs_'.intToShort($store, $charfeed);

$sql = "update `store` set `store_key` = '$store_key' where `store_id` = $store_id";
if(!mysqli_query($con,$sql)){
	die('Error: '.mysql_error());
}

$username	= isset($_POST['username']) ? $_POST['username'] : null;;
$password	= isset($_POST['password']) ? $_POST['password'] : null;
$date 		= date('Y-m-d');

if(!empty($username) || !empty($password)){
	$sql = "insert into `users` (`username`, `password`, `type`, `Enable`, `register_date`, `status`, `store_key`) 
			values ('$username', '$password', 301, 1, '$date', 1, '$store_key')";
	
	if(!mysqli_query($con,$sql)){
		die('Error: '.mysql_error());
	}
}

?>

<div class="row-fluid">
	<div class="span3">&nbsp;</div>
	<div class="span6">
		<div class="alert alert-info">
			Congratulation! New store has been created successfully.<br>
			<strong>New Store Id:-</strong> <?php echo $store_key;?><br>
			<strong>Username:-</strong> <?php echo $username;?>
		</div>
		<div>
			<a class="btn btn-success" href="<?php echo DHS_ROOT?>dhs/index.php?view=add_store">Create New Store</a>
		</div>
	</div>
	<div class="span3">&nbsp;</div>
</div>
