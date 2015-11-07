<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php

if(!isset($_REQUEST['inventory_id']) || empty($_REQUEST['inventory_id'])){
	die('Request format to access contents is not proper. Select the record properly.');
}

if(isset($_POST['action']) && $_POST['action'] == 'verify_inventory'){
	$now = date('Y-m-d');
	$id = $_REQUEST['inventory_id'];
	$user = $_SESSION['myuserid'];
	$verify = $_POST['verify'];
	$unit_cost = $_POST['unit_cost'];
	$message = empty($_POST['message']) ? null : $_POST['message'] ;
	$status = ($verify == 1) ? DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED : DHS_DISTRIBUTOR_INVENTORY_STATUS_CANCEL;
	
	$sql = "UPDATE `inventory` SET `verified_date`='$now', `message` = '$message', `unit_cost` = $unit_cost, `verified_by`=$user, `status` = $status WHERE `inventory_id` = $id";
	if(!mysqli_query($con,$sql)){
		die('Error: '.mysql_error());
	}else{?>
	<script type="text/javascript">
		window.location= 'index.php?view=inventory_details&menu=stock';
	</script>
	<?php }?>
	<div class="alert alert-success">Request has been <?php echo ($verify == 1) ? 'verified' : 'cancelled';?> successfully.</div>
	
	<?php 
}

$result = mysqli_query($con,'select * from `inventory` where inventory_id = '.$_REQUEST['inventory_id']);
$record = mysqli_fetch_array($result);

?>
<fieldset class="span8 offset2" >
<legend>Arrived Stock Review Form</legend>
<form class="form-horizontal dhs-medical-form " id="myform" name="myform" method="post" action="index.php?view=process_arrived_stock&menu=stock&inventory_id=<?php echo $_REQUEST['inventory_id'];?>">
  <div class="control-group">
    <label class="control-label" for="name">Distributor Name:</label>
    <div class="controls">
    	<?php $distributor = DhsHelper::getDistributorsList(array($record['distributor_id']));?>
    	<input type="text" id="distributor_name" name="distributor_name" readonly="readonly" placeholder="distributor_name" required="" value="<?php echo $distributor[$record['distributor_id']];?>">
        <input type="hidden" name="distributor_id" value="<?php echo $record['distributor_id'];?>" />
    </div>
  </div>
  <?php 
  
	$get_data= 'SELECT * FROM `medicine` INNER JOIN `category` ON (category.category_id=medicine.category_id and medicine_id = '.$record['medicine_id'].')';
	$value_data=mysqli_query($con,$get_data);
	if(!$value_data){
		die(''.mysql_error());
	}
 ?>
   <div class="control-group">
    <label class="control-label" for="name">Medicine Name:</label>
    <div class="controls">
    	<?php $medicine = DhsHelper::getMedicinesList(array($record['medicine_id']));?>
    	<input type="text" id="medicine_name" name="medicine_name" placeholder="medicine_name" readonly="readonly" value="<?php echo $medicine[$record['medicine_id']];?>">
        <input type="hidden" name="medicine_id" value="<?php echo $record['medicine_id'];?>" />
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="name">Medicine Barcode:</label>
    <div class="controls">
    	<input type="text" id="barcode" name="barcode" placeholder="Barcode" readonly="readonly" value="<?php echo $record['barcode'];?>">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="req_quantity">Requested Qunatity:</label>
    <div class="controls">
      <input type="text" id="req_quantity" name="req_quantity" placeholder="Requested Qunatity" readonly="readonly" value="<?php echo $record['requested_quantity'];?>" />
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="quantity">Arrived Qunatity:</label>
    <div class="controls">
      <input type="text" id="quantity" name="quantity" placeholder="Qunatity" value="<?php echo $record['quantity'];?>" readonly="readonly"/>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="unit_cost">Unit Cost:</label>
    <div class="controls">
      <input type="text" id="unit_cost" name="buy_unit_cost" placeholder="Unit Cost" value="<?php echo DhsHelper::formatPrice($record['buy_unit_cost']);?>" readonly="readonly" />Rs.
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="unit_cost">Marginal Unit Cost:</label>
    <div class="controls">
      <input type="text" id="unit_cost" name="unit_cost" required="" placeholder="Marginal Unit Cost" />Rs.
    </div>
  </div>
  
   <div class="control-group">
    <label class="control-label" for="subtotal">Sub Total:</label>
    <div class="controls"> 
      <input type="text" id="subtotal" name="subtotal" placeholder="Subtotal" value="<?php echo DhsHelper::formatPrice($record['subtotal']);?>" readonly="readonly" />Rs.
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="tax">Tax:</label>
    <div class="controls">
      <input type="text" id="tax" name="tax" placeholder="Tax" value="<?php echo DhsHelper::formatPrice($record['tax']);?>" readonly="readonly" />Rs.
   </div>
  </div>
  
   
  <div class="control-group">
    <label class="control-label" for="discount">Discount:</label>
    <div class="controls">
      <input type="text" id="discount" name="discount" placeholder="Discount" value="<?php echo DhsHelper::formatPrice($record['discount']);?>"  readonly="readonly" />Rs.
  	</div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="total">Total:</label>
    <div class="controls">
	    <input type="text" id="total" name="total" placeholder="Total" value="<?php echo DhsHelper::formatPrice($record['total']);?>" readonly="readonly">Rs.
	  </div>
	</div>
  
  <div class="control-group">
    <label class="control-label" for="mfg_date">Manufactured Date:</label>
    <div class="controls">
      <input type="text" id="mfg_date" name="mfg_date" placeholder="Manufactured Date" value="<?php echo DhsHelper::formatDate($record['mfg_date']);?>" readonly="readonly" />
  	</div>
  </div>
  
        
  <div class="control-group">
    <label class="control-label" for="expiry_date">Expiry Date:</label>
    <div class="controls">
      <input type="text" id="expiry_date" name="expiry_date" placeholder="Expiry Date" value="<?php echo DhsHelper::formatDate($record['expiry_date']);?>" readonly="readonly" />
  </div></div>
  
  <div class="control-group">
    <label class="control-label" for="verify">Do Verify:</label>
    <div class="controls">
      <input type="radio" name="verify" value="1" checked="checked">Yes
      <input type="radio" name="verify" value="0" <?php echo (isset($verify) && $verify == 0) ? 'checked="checked"' : '';?>>No
  	</div>
  </div>
  
  <div class="control-group reason">
    <label class="control-label" for="message">Reason For Cancellation:</label>
    <div class="controls">
      <textarea rows="5" cols="5" name="message" id="message"></textarea>
  	</div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      <input type="hidden" name="inventory_id" value="<?php echo $_REQUEST['inventory_id'];?>" />
      <input type="hidden" name="action" value="verify_inventory" id="action" />
      <button type="submit" class="btn btn-primary" id="btn_save" >Save</button>

    </div>
  </div>
  </form>
</fieldset>

<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$(".reason").hide();

			$('input:radio[name="verify"]').change(
		    	function(){
			        if ($(this).is(':checked') && $(this).val() == 0) {
			        	$(".reason").show();
			        }else{
			        	$(".reason").hide();
			        }
		    });
		}); 
	})(jQuery);
</script>