<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php 
$store_key = $_SESSION['mystoreid'];
if(isset($_REQUEST['medicine_id']) && !empty($_REQUEST['medicine_id']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'return_stock'){
	$medicine_id = $_REQUEST['medicine_id'];
	$quantity = $_POST['quantity'];
	$distributor_id = $_POST['distributor_id'];
	$unit_cost = $_POST['unit_cost'];
	$purchased_price = $_POST['purchased_price'];
	$return_toal = $_POST['returning_total'];;
	$loss = $_POST['loss'];
	$return_date = $_POST['return_date'];
	$barcode = $_POST['barcode'];
	$created_date = date('Y-m-d');
	$returned_by = $_SESSION['myuserid'];
	
	$sql = "insert into `return_stock` (`medicine_id`, `quantity`, `distributor_id`, `unit_cost`, `purchased_price`, `returning_total`, `loss`, `return_date`, `created_date`, `status`, `returned_by`, `store_key`, `barcode`) 
			values ($medicine_id, $quantity, $distributor_id, $unit_cost, $purchased_price, $return_toal, $loss, '$return_date', '$created_date', 1, $returned_by, '$store_key', $barcode)";
	if(!mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}
	echo "<script>";
	echo "window.location='index.php?view=inventory_details&menu=stock'";
	echo "</script>";
	exit;
}


if(isset($_REQUEST['inventory_id']) && !empty($_REQUEST['inventory_id']))
{
	$inventory_id = $_REQUEST['inventory_id'];
	
	$result	 = mysqli_query($con,"select medicine.medicine_name, inventory.* from `medicine` inner join
				(select * from inventory where `store_key` = '$store_key' and status = 30 and `inventory_id` = $inventory_id) as inventory 
				on (medicine.`medicine_id` = inventory.`medicine_id`)");
	
	$record 		= mysqli_fetch_row($result);
	$unit_cost 		= $record[5];
	$distributor_id = $record[2];
	$barcode		= $record[22];
	
	$sql  = 'SELECT '; 
	$sql .= '( ';
	$sql .= "(select COALESCE(`quantity`, 0) from `inventory` where `barcode` = $barcode and status = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED.") ";
	$sql .= " - ";
	$sql .= "(select COALESCE(sum(`quantity`), 0) as quantity from `cust_inventory` where `barcode` = $barcode) "; 
    $sql .= ' - ';
    $sql .= "(select COALESCE(sum(`quantity`), 0) as quantity from `return_stock` where `barcode` = $barcode and status <> 0) ";
    $sql .= ') as remaining';
	
	$result	= mysqli_query($con,$sql);
	$row	= mysqli_fetch_array($result);
	$a		= $row['remaining'];
}
?>

<fieldset>
	<legend>Stock to Return</legend>
	
	<form class="form-horizontal" method="post" action="index.php?view=return_stock&menu=stock&medicine_id=<?php echo $record[3];?>">
	  <div class="control-group">
	    <label class="control-label" for="medicine_name">Medicine Name</label>
	    <div class="controls">
	      <input type="text" id="medicine_name" readonly="readonly" value="<?php echo $record[0];?>" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="barcode">Medicine Barcode</label>
	    <div class="controls">
	      <input type="text" id="barcode" name="barcode" readonly="readonly" value="<?php echo $record[22];?>" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="available">Available Quantity</label>
	    <div class="controls">
	      <input type="text" id="available" readonly="readonly" value="<?php echo $a;?>" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="unit_cost">Unit Cost</label>
	    <div class="controls">
	      <input type="text" id="unit_cost" name="unit_cost" readonly="readonly" value="<?php echo DhsHelper::formatPrice($unit_cost);?>" />
	    </div>
	  </div>	  
	  
	  <div class="control-group">
	    <label class="control-label" for="quantity">Quantity to Return</label>
	    <div class="controls">
	      <select id="quantity" name="quantity">
	      		<option>Select Quantity</option>
	      		<?php for($i = $a; $i > 0; $i--):?>
	      			<option><?php echo $i;?></option>
	      		<?php endfor;?>
	      </select>
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="purchased_price">Purchased Price</label>
	    <div class="controls">
	      <input type="text" id="purchased_price" name="purchased_price" readonly="readonly" value="" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="returning_total">Returning Amount</label>
	    <div class="controls">
	      <input type="text" id="returning_total" name="returning_total" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="loss">Total Loss</label>
	    <div class="controls">
	      <input type="text" id="loss" name="loss" value="" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="return_date">Return Date:</label>
	    <div class="controls">
	    	<div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
			    <input data-format="yyyy-MM-dd" type="text" name="return_date" id="return_date" required="" value="<?php echo isset($record['return_date']) ? $record['return_date'] : ''; ?>" />
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
			      </i>
			    </span>
			  </div>
	      <span class="muted">(DD-MM-YYYY)</span>
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <div class="controls">
	    	<input type="hidden" name="distributor_id" value="<?php echo $distributor_id;?>" />
	    	<input type="hidden" name="action" value="return_stock" />
	      <button type="submit" class="btn">Submit</button>
	    </div>
	  </div>
	</form>
</fieldset>

<script type="text/javascript">
(function($){
	$(document).ready(function(){
		$("#quantity").change(function(){
			var unit = parseFloat($("#unit_cost").val());
			var quantity = $(this).val();
			$("#purchased_price").val(parseFloat(unit * quantity));
		});
		
		$("#returning_total").change(function(){
			var price = parseFloat($("#purchased_price").val());
			var ret	  = parseFloat($(this).val());
			$("#loss").val(price - ret);
		});
	});
})(jQuery);
</script>
<?php
