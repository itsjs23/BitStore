<?php

	//$a = $_POST;
	//$a = serialize($a);
	//$file = __DIR__. '\test.txt';
	//file_put_contents($file, $a, FILE_APPEND);

	//$data = file_get_contents($file);
 	//$data = unserialize($data);
	// var_dump($data);

	// result array success_code => 200, 301, 404,  
	// result => array()

	
	
	$request = $_POST;

	if(!isset($request['api_key']) || empty($request['api_key'])){
		$api = false;
	}else{
		$api = $request['api_key'];
	}
	
	if(!isset($request['action']) || empty($request['action'])){
		$action = false;
	}else{
		$action = $request['action'];
	}
	
	$result = array('success_code' => 404, 'result' => array('data' => false));
	
	require_once 'rest.php';
	$rest = new Rest_controller($api);
	if($rest->isAuthorized() && method_exists($rest, $action)){
		$result = call_user_func_array(array($rest, $action), array($request));
	}
	
	$result = json_encode($result);
	echo $result;
	die();
	
	
