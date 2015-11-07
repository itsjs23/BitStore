<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php 
$sql = "select * from `distributors` where `distributor_id` = ".$_SESSION['myuserid'];
$result = mysqli_query($con,$sql);
$record = mysqli_fetch_array($result);

if(empty($record)){
	$distributor_id		= 0;
	$distributor_name 	= '';
	$shop_name 			= '';
	$email 				= '';
	$mobile 			= '';
	$address 			= '';
	$city 				= '';
	$state 				= '';
	$country 			= '';
}else{
	$distributor_id 	= $record['distributor_id'];
	$distributor_name 	= $record['fullname'];
	$shop_name 			= $record['shop_name'];
	$email 				= $record['email'];
	$mobile 			= $record['mobile'];
	$address 			= $record['address'];
	$city 				= $record['city'];
	$state 				= $record['state'];
	$country 			= $record['country'];
}

?>

<fieldset class="span8 offset2" >
<legend>Distributor Form</legend>
<form class="form-horizontal dhs-medical-form" method="post" action="index.php?view=manage_distributor">
  
   <div class="control-group">
    <label class="control-label" for="name">Username:</label>
    <div class="controls">
      <input type="text" id="username"  required="" name="username" placeholder="Username" value="<?php echo $_SESSION['myusername'];?>">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="name">Distributor Name:</label>
    <div class="controls">
      <input type="text" id="name"  required="" name="name" placeholder="Name" value="<?php echo $distributor_name;?>">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="shopname">Shop Name:</label>
    <div class="controls">
      <input type="text" id="shopname" name="shopname" required="" placeholder="Shop Name" value="<?php echo $shop_name;?>">
    </div>
  </div>
  
  
  <div class="control-group">
    <label class="control-label" for="email">Email:</label>
    <div class="controls">
      <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $email;?>">
    </div>
  </div>
  
   <div class="control-group">
    <label class="control-label" for="mobile">Mobile No:</label>
    <div class="controls">
      <input type="text" id="mobile" name="mobile" required=""  minlength="10"  placeholder="Mobile" value="<?php echo $mobile;?>">
    </div>
  </div>
  
  
  <div class="control-group">
    <label class="control-label" for="address">Address:</label>
    <div class="controls">
		<textarea name="address" id="address"><?php echo $address;?></textarea>
	</div>
  </div>
  
  
   
  <div class="control-group">
    <label class="control-label" for="city" >City:</label>
    <div class="controls">
      <input type="text" id="city" name="city" placeholder="City" required="" value="<?php echo $city;?>">
  </div></div>
  
  
    
  <div class="control-group">
    <label class="control-label" for="state" >State:</label>
    <div class="controls">
      <input type="text" id="state" name="state" placeholder="state" required="" value="<?php echo $state;?>">
  </div></div>
  
  
    
  <div class="control-group">
    <label class="control-label" for="country">Country:</label>
    <div class="controls">
      <input type="text" id="country" name="country" placeholder="country" required="" value="<?php echo $country;?>">
  </div></div>
  
  
  <div class="control-group">
    <div class="controls">
      <input type="hidden" name="distributor_id" value="<?php echo $distributor_id;?>" />
      <button type="submit" class="btn btn-primary">Update Details</button>
    </div>
  </div>
</form>	</fieldset>