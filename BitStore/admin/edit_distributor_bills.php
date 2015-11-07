<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php
$store_key = $_SESSION['mystoreid'];
$is_update = isset($_REQUEST['update_details']) ? $_REQUEST['update_details'] : null;

	if(!empty($is_update)){
		$invt_id	= $_REQUEST['inventory_id'];
		$quantity 	= $_REQUEST['quantity'];
		$unit_cost 	= $_REQUEST['unit_cost'];
		$tax		= $_REQUEST['tax'];
		$subtotal 	= $quantity * $unit_cost;
		$discount	= $_REQUEST['discount'];
		$total		= $subtotal + $tax - $discount;
		$mfg_date	= $_REQUEST['mfg_date'];
		$exp_date	= $_REQUEST['expiry_date'];
		
		$sql = "update `inventory` set `quantity`=$quantity, `unit_cost`=$unit_cost, `subtotal`=$subtotal, ";
		$sql .= "`tax`=$tax, `discount`=$discount, `total`=$total, `mfg_date`='$mfg_date', `expiry_date`='$exp_date' ";
		$sql .= "where `inventory_id` = $invt_id";
		
		
		
		if(!mysqli_query($con,$sql)):?>
			<div class="alert alert-danger">Record was not updated. Please try again.</div>
		<?php else: ?>
			<div class="alert alert-success">Record updated successfully.</div>
		<?php endif;
	}


$task = $_REQUEST['task'];
$id   = $_REQUEST['id'];

if(empty($task) || empty($id)){
	echo "You are not authorized to access this content.";
	return true;
}

$inventory = DhsHelper::getDistInventoryData($id);
?>

<fieldset class="span8 offset2">
	<legend>Edit Distributor Bill Details</legend>

	<form class="form-horizontal" method="post">
		<input type="hidden" name="inventory_id" value="<?php echo $inventory['inventory_id'];?>" />
		
		<div class="control-group">
		    <label class="control-label" for="medicine_name">Medicine Name:</label>
		    <div class="controls">
		      <input type="text" name="medicine_name" readonly="readonly" value="<?php echo $inventory['medicine_name'];?>">
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="distributor_name">Distributor Name:</label>
		    <div class="controls">
		      <input type="text" name="distributor_name" readonly="readonly" value="<?php echo $inventory['distributor_name'];?>">
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="quantity">Quantity:</label>
		    <div class="controls">
		      <input type="text" name="quantity" required="" value="<?php echo $inventory['quantity'];?>">
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="unit_cost">Unit Cost:</label>
		    <div class="controls">
		      <input type="text" name="unit_cost" required="" value="<?php echo DhsHelper::formatPrice($inventory['unit_cost']);?>">
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="subtotal">Subtotal:</label>
		    <div class="controls">
		      <input type="text" name="subtotal" required="" readonly="readonly" value="<?php echo DhsHelper::formatPrice($inventory['subtotal']);?>">
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="tax">Tax:</label>
		    <div class="controls">
		      <input type="text" name="tax" required="" value="<?php echo DhsHelper::formatPrice($inventory['tax']);?>">
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="discount">Discount:</label>
		    <div class="controls">
		      <input type="text" name="discount" required="" value="<?php echo DhsHelper::formatPrice($inventory['discount']);?>">
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="total">Total:</label>
		    <div class="controls">
		      <input type="text" name="total" required="" value="<?php echo DhsHelper::formatPrice($inventory['total']);?>" readonly="readonly">
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="mfg_date">Manufacturing Date:</label>
		    <div class="controls">
		    	<div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
			    	<input data-format="yyyy-MM-dd" type="text" name="mfg_date" id="mfg_date" required="" value="<?php echo $inventory['mfg_date'];?>"></input>
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
			    	<input data-format="yyyy-MM-dd" type="text" name="expiry_date" id="expiry_date" required="" value="<?php echo $inventory['expiry_date'];?>"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
			    </div>
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="verified_date">Paid Date:</label>
		    <div class="controls">
		    	<div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
			    	<input data-format="yyyy-MM-dd" type="text" name="verified_date" id="verified_date" required="" value="<?php echo $inventory['verified_date'];?>"></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
			    </div>
		    </div>
		</div>
		
		<input type="hidden" name="update_details" value="1" />
		
		<div class="control-group">
		    <div class="controls">
		      <button type="submit" class="btn btn-primary">Update</button>
		    </div>
		</div>
		
		
	</form>
</fieldset>



