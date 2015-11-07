<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php $file = dirname(dirname(__FILE__)).'\js\medicines.json'; ?>
<script type="text/javascript">
(function($){	
	$(document).ready(function() {
		var data = {};
		data.source = <?php echo file_get_contents($file);?>;
		$("#medicine_name").typeahead(data);
	});
})(jQuery);
</script>
<?php //require_once 'Barcode39.php';?>
<?php 
/*
 * 
 
$barcode = DhsHelper::getUniqueBarcode();

$bc = new Barcode39($barcode);
// set text size 
$bc->barcode_text_size = 4; 

// set barcode bar thickness (thick bars) 
$bc->barcode_bar_thick = 2; 

// set barcode bar thickness (thin bars) 
$bc->barcode_bar_thin = 1; 

// save barcode GIF file 
$bc->draw("admin/barcodes/$barcode.gif");

*/
?>

<form class="dhs-medical-form form-horizontal" id="myform" name="myform" action="index.php?view=manage_barcodes" method="post">
	<fieldset class="span8">
		<legend>Create Barcode</legend>
		
		<div class="control-group">
		    <label class="control-label" for="medicine_name">Medicine Name</label>
		    <div class="controls">
		      <input type="text" id="medicine_name" name="medicine_name" required="" />
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="batch_code">Batch Code</label>
		    <div class="controls">
		      <input type="text" id="batch_code" name="batch_code" required="" />
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="mrp">M.R.P</label>
		    <div class="controls">
		      <input type="text" id="mrp" name="mrp" required="" class="numeric-txt" />
		    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="mfg_date">Manufactured Date:</label>
		    <div class="controls">
		    	<div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
			    	<input data-format="yyyy-MM-dd" type="text" name="mfg_date" id="mfg_date" required=""></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
			    </div>
		  </div></div>
		  
		        
		  <div class="control-group">
		    <label class="control-label" for="expiry_date">Expiry Date:</label>
		    <div class="controls">
		      <div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
			    	<input data-format="yyyy-MM-dd" type="text" name="expiry_date" id="expiry_date" required=""></input>
				    <span class="add-on">
				      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      </i>
				    </span>
			    </div>
		  </div></div>
		
		<div class="control-group">
		    <div class="controls">
		      <input type="hidden" name="action" value="insert_barcodes" id="action" />
		      <button type="submit" class="btn btn-primary" id="btn_save">Create</button>
		    </div>
		  </div>
  
	</fieldset>
</form>
	

<?php
