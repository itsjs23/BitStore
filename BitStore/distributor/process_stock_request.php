<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php

if(!isset($_GET['inventory_id']) || empty($_GET['inventory_id'])){
	die('Request format to access contents is not proper. Select the record properly.');
}

if(!isset($_GET['store_key']) || empty($_GET['store_key'])){
	die('Request format to access contents is not proper. Select the record properly.');
}

$store_key = $_GET['store_key'];

if(isset($_POST['action']) && $_POST['action'] == 'process_request'){
	$id 		= $_GET['inventory_id'];
	$quantity 	= $_POST['quantity'];
	$cost 		= $_POST['unit_cost'];
	$subtotal 	= $quantity * $cost;
	$status 	= DHS_DISTRIBUTOR_INVENTORY_STATUS_COMPLETED;
	$now 		= date('Y-m-d');
	$m_date 	= strtotime($_POST['mfg_date']);
	$e_date 	= strtotime($_POST['expiry_date']);
	
	$mfg_date 	= $_POST['mfg_date'];
	$exp_date 	= $_POST['expiry_date'];
	$barcode 	= $_POST['barcode'];
	
	if($m_date < $e_date){
		$sql = "UPDATE `inventory` SET `quantity`=$quantity,`buy_unit_cost`=$cost,`subtotal`=$subtotal,`total`=$subtotal,`status`=$status, `completed_date`='$now',`mfg_date`='$mfg_date',`expiry_date`='$exp_date', `barcode`=$barcode  WHERE `inventory_id` = $id";
		if(!mysqli_query($con,$sql)){
			die('Error : '.mysql_error());
		}
		echo "<script>";
		echo "window.location='index.php?view=inventory_request&menu=requests'";
		echo "</script>";
	}
	else{?>
		<div class="alert alert-error">Manufacturing date cannot be greater than expiry date.</div>		
<?php }
	}
	

$result = mysqli_query($con,"select m.`medicine_id`, m.`medicine_name`, inv.* from medicine as m join (select * from `inventory` where `store_key` = '$store_key' and inventory_id = ".$_GET['inventory_id'].') as inv on (m.medicine_id = inv.medicine_id)');
$record = mysqli_fetch_array($result);
?>

<fieldset class="span8 offset2" >
<legend>Process Stock Request Form</legend>
<form class="form-horizontal dhs-medical-form " id="myform" name="myform" method="post" action="index.php?view=process_stock_request&menu=requests&inventory_id=<?php echo $_REQUEST['inventory_id'];?>">
  
   <div class="control-group">
    <label class="control-label" for="name">Medicine Name:</label>
    <div class="controls">
    	<input type="text" id="medicine_name" name="medicine_name" placeholder="medicine_name" readonly="readonly" value="<?php echo $record['medicine_name'];?>">
        <input type="hidden" name="medicine_id" value="<?php echo $record['medicine_id'];?>" />
    </div>
  </div>
  
  <div class="control-group">
	    <label class="control-label" for="name">Medicine Barcode:</label>
	    <div class="controls">
	    	<input type="text" id="barcode" name="barcode" placeholder="Barcode" class="numeric-txt" required="" />
	    	<div id="barcode_validation" style="color:#F00; font-family:Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Barcode.</div>
	    </div>
	</div>
  
  <div class="control-group">
    <label class="control-label" for="req_quantity">Requested Qunatity:</label>
    <div class="controls">
      <input type="text" id="req_quantity" name="req_quantity" placeholder="Requested Qunatity" readonly="readonly" value="<?php echo $record['requested_quantity'];?>" />
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="quantity">Available Qunatity:</label>
    <div class="controls">
      <input type="text" id="quantity" name="quantity" placeholder="Qunatity" value="" required="" />
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="unit_cost">Unit Cost:</label>
    <div class="controls">
      <input type="text" id="unit_cost" name="unit_cost" placeholder="Unit Cost" value="" required="" />Rs.
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="subtotal">Total:</label>
    <div class="controls">
	    <input type="text" id="subtotal" name="subtotal" placeholder="Total" value="" readonly="readonly" />Rs.
	  </div>
	</div>
  
  <div class="control-group">
    <label class="control-label" for="mfg_date">Manufactured Date:</label>
    <div class="controls">
      <div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
	    <input data-format="yyyy-MM-dd" type="text" name="mfg_date" id="mfg_date" required="" value=""></input>
	    <span class="add-on">
	      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
	      </i>
	    </span>
	  </div>
  	</div>
  </div>
  
        
  <div class="control-group">
    <label class="control-label" for="expiry_date">Expiry Date:</label>
    <div class="controls">
      <div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
	    <input data-format="yyyy-MM-dd" type="text" name="expiry_date" id="expiry_date" required="" value=""></input>
	    <span class="add-on">
	      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
	      </i>
	    </span>
	  </div>
  </div></div>
  
  <div class="control-group">
    <div class="controls">
      <input type="hidden" name="inventory_id" value="<?php echo $_REQUEST['inventory_id'];?>" />
      <input type="hidden" name="action" value="process_request" id="action" />
      <button type="submit" class="btn btn-primary" id="btn_save" >Send Consignment</button>

    </div>
  </div>
  </form>
</fieldset>

<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$("#barcode_validation").hide();
			$("#unit_cost").focusout(function(){
				var quantity = $("#quantity").val();
				var unit = $(this).val();
				$("#subtotal").val(quantity * unit);
			});

			$('#barcode').focusout(function(){
				var barcode = $(this).val();
				$.ajax({
					type: 'POST',
					url: 'index.php?view=manage_inventory',
					data: {
						data:'data',
						action:'verify_barcode',
						barcode: barcode
					},
				
					success:function(details){
						var details		= details.substring(details.lastIndexOf("####")+4,details.lastIndexOf("@@@@"));

						if(details.trim() == 'Exists'){
							$('#btn_save').attr('disabled', 'disabled');
							$('#barcode_validation').fadeIn();
							$('#barcode_validation').html('Barcode details already exists.');
						}
						else{
							$('#btn_save').removeAttr('disabled', 'disabled');
						}
					}
				});
			});
		});
	})(jQuery);
</script>