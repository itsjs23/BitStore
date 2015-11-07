<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<style type="text/css">
select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
    margin-bottom:0px;   
}

@media (max-width: 480px){
	.prescribed-by{
		text-align:center;
	}
}

@media (min-width: 768px) {
	.prescribed-by{
		text-align:left;
	}
 }

</style>

<div id="setbody"></div>
<form class="dhs-medical-form form-vertical" id="myform" name="myform">

    <fieldset>
    	<legend>Local Billing Info</legend>
    	
	    <div id="dhs-billing-form">
	    	
		    <div style="padding:10px;">
		    
		      <input type="text" name="medicine[0][barcode]" placeholder="Barcode" required="" id="barcode0" class="input-small data-barcode numeric-txt" />
		      <input type="hidden" class="medicines-select input-small" id="name0" name="medicine[0][name]" />
		      <div class="input-append" style="margin-bottom:0px;">
		      	<input type="text" class="medicines-select input-small" id="medicine_name0" name="medicine[0][medicine_name]" placeholder="Product Name" />
		      	<input type="button" class="btn" id="remaining0" value="0" />
		      </div>
		      <input type="text" name="medicine[0][quantity]" placeholder="Quantity" required="" id="quantity0" class="input-small data-quantity numeric-txt data-medi0" />
		      <input type="text" name="medicine[0][cost]" placeholder="Unit Cost" required="" id="cost0" data-source="0" class="input-small bill-data data-medi0" />
		      <input type="text" name="medicine[0][subtotal]" placeholder="Subtotal" id="subtotal0" data-source="0" class="input-small bill-data" readonly="readonly" />
		      <input type="text" name="medicine[0][tax]" placeholder="Tax" id="tax0"  data-source="0" value="" class="input-small bill-data data-medi0" />
		      <input type="text" name="medicine[0][discount]" placeholder="Discount" id="discount0" data-source="0" value="" class="input-small bill-data data-medi0" />
		      <input type="text" name="medicine[0][total]" placeholder="Total" id="total0" data-source="0"  class="input-small bill-data data-total" readonly="readonly" />
		      <input type="hidden" name="medicine[0][mfg_date]" placeholder="Manufactured Date" id="mfg_date0" required="" class="input-small" />
		      <input type="hidden" name="medicine[0][expiry_date]" placeholder="Expiry Date" id="expiry_date0" required="" class="input-small" />
		    </div>
	    </div>
    </fieldset>
 	
 	 
    <input type="hidden" name="action" id="action"  value="insert_billing" />
 	<button type="button" class="dhs-bill-add btn btn-primary"><i class="icon-plus icon-white"></i></button>
    
<br /><br />
		<div style="text-align: center;">
			<button class="btn btn-primary" id="proceed" type="button">Proceed</button>
		</div>

		<div class="row-fluid" id="calculate_total">
			<div class="span5 offset3 well">
				<div class="row-fluid" style="padding-bottom:20px;">
	            	<div class="span4"><label class="control-label" for="bill_total">Total:</label></div>
		            <div class="span8 input-append">
			            <input type="text" id="bill_total" class="input-medium" name="bill_total" readonly="readonly">
			            <button id="refresh" type="button" class="btn" style="padding:6.5px"><i class="icon-refresh"></i></button>
		            </div>
	            </div>
	           
	            <div class="row-fluid" style="padding-bottom:20px;">
	            	<div class="span4"><label class="control-label" for="grand_tax">Tax:</label></div>
		            <div class="span8">
	            		<div class="btn-group" data-toggle="buttons-radio">
						  <button type="button" class="btn active tax_type" id="fixed">Rs.</button>
						  <button type="button" class="btn tax_type" id="percentage">%</button>
						</div>
						<input type="text" id="grand_tax" class="input-small" required="" value="0.00" />
						<input type="hidden" id="grand_tax_value" name="grand_tax" value="0.00" />
		            </div>
	            </div>
	            
	            <div class="row-fluid" style="padding-bottom:20px;">
	            	<div class="span4"><label class="control-label" for="grand_discount">Discount:</label></div>
		            <div class="span8">
	            		<div class="btn-group" data-toggle="buttons-radio">
							<button type="button" class="btn active discount_type" id="fixed">Rs.</button>
							<button type="button" class="btn discount_type" id="percentage">%</button>
						</div>
	            		
	            		<input type="text" id="grand_discount" class="input-small" required="" value="0.00" />
	            		<input type="hidden" id="grand_discount_value" name="grand_discount" value="0.00" />
		            </div>
	            </div>
	                        
	            <div class="row-fluid" style="padding-bottom:10px;">
	            	<div class="span4"><label class="control-label" for="grand_total">Grand Total:</label></div>
		            <div class="span8">
		            	<input type="text" id="grand_total" name="grand_total" readonly="readonly">
		            </div>
	            </div>
	            
	            <input type="hidden" id="doctor_name" value="" name="doctor_name" />
	            <input type="hidden" id="doctor_no" name="doctor_no" value="" />
	            <input type="hidden" id="customer_name" name="customer_name" value="Local Bills" />
	            <input type="hidden" id="customer_no" name="customer_no" value="">
	            <input type="hidden" name="payment_mode" value="Cash">
	            <input type="hidden" id="cheque_no" name="cheque_no" value="0">
	            <input type="hidden" name="bank_name" value="0">
	            <input type="hidden" name="branch_name" value="0">
	            
	            
	            <div class="row-fluid">
	            	<div class="span4">&nbsp;</div>
		            <div class="span8">
						<input type="button" name="btn_save" class="btn btn-primary" value="Print" id="btn_save" />
					</div>
	            </div>
	            
	    	</div>
	    	<div class="span4">&nbsp;</div>      
		</div>
		
</form>	

<script type="text/javascript">
(function($){
	$(document).ready(function(){
		$("input").on("paste",function(e){
	    	$("#test").focus();
		});

		$("#calculate_total").hide();

		$("#proceed").click(function(){
			var sum = 0;
			$('.data-total').each(function() {
		        sum += Number($(this).val());
		    });
		    
		    $("#bill_total").val(sum);
		    $("#grand_total").val(sum);
			$("#calculate_total").show();
			$(this).hide();
		});

		$("#refresh").click(function(){
			var sum = 0;
			$('.data-total').each(function() {
		        sum += Number($(this).val());
		    });
		    
		    $("#bill_total").val(sum);
		    $("#grand_total").val(sum);
		});

		$("#btn_save").click(function(){
			var tax_type 		= $(".tax_type.active").attr('id');
			var discount_type 	= $(".discount_type.active").attr('id');
			var bill_total 		= Number($("#bill_total").val());
			var tax 			= Number($("#grand_tax").val());
			var discount		= Number($("#grand_discount").val());
			
			if(tax_type == 'percentage'){
				var tax = parseFloat((bill_total * tax) / 100);
			}

			if(discount_type == 'percentage'){
				var discount = parseFloat((bill_total * discount) / 100);
			}

			var grand_total = parseFloat(bill_total) + parseFloat(tax) - parseFloat(discount);
			$("#grand_tax_value").val(tax);
			$("#grand_discount_value").val(discount);
			$("#grand_total").val(grand_total);
			$("#n_grand_total").val(grand_total);


			var querystring=$("#myform").serialize();
		    //$("#myform").validate();
			$.ajax({
				type: 'POST',
				url: 'index.php?view=manage_local_billing',
				data: {
					query:querystring
				},
			
				success:function(html){
					window.location.replace("index.php?view=local_bills&menu=billing");
				}
			});

		});

		$(".bill-data").livequery('change', function(){
			var row_id 		= $(this).attr('data-source');
			var quantity 	= $('#quantity'+row_id).val();
			var unit 		= parseFloat($('#cost'+row_id).val()).toFixed(2);
			var subtotal 	= parseFloat($('#subtotal'+row_id).val()).toFixed(2);
			var tax			= 0.00;
			if($('#tax'+row_id).val() != ''){
				tax = parseFloat($('#tax'+row_id).val()).toFixed(2);
			}

			var discount	= 0.00;
			if($('#discount'+row_id).val() != ''){
				discount = parseFloat($('#discount'+row_id).val()).toFixed(2);
			}

			
			var total 		= parseFloat($('#total'+row_id).val()).toFixed(2);

			var n_subtotal  = parseFloat(quantity * unit).toFixed(2);
			var n_total 	= parseFloat(n_subtotal) + parseFloat(tax) - parseFloat(discount);

			$('#total'+row_id).val(n_total);
			$('#subtotal'+row_id).val(n_subtotal);
			
			//parseFloat(yourString).toFixed(2)
		});
		
		var count = 1;
		$(".dhs-bill-add").click(function(){
			getNewRow(count);
			++count;
		});

		$(".data-barcode").livequery('focusout', function(){
			var barcode_id 	= $(this).attr('id');;
			var row 		= barcode_id.substr(7,1);
			var barcode 	= $('#'+barcode_id).val();

			$.ajax({
				type: 'POST',
				url: 'index.php?view=manage_medicine',
				data: {
					data: 'data',
					action:'barcode_medicine',
					barcode: barcode
				},
			
				success:function(details){
					var details1 = details;
					var details		= details.substring(details.lastIndexOf("####")+4,details.lastIndexOf("@@@@"));
					var obj 		= $.parseJSON(details);
					var medicine_id = obj.medicine_id;
					var med_name 	= obj.medicine_name;
					var remaining	= obj.remaining;

					if(med_name == false){
						$('.data-medi'+row).each(function() {
					        $(this).attr('readonly', 'readonly');
					    });
					}else{
						$('.data-medi'+row).each(function() {
					        $(this).removeAttr('readonly', 'readonly');
					    });
					}

					$('#name'+row).val(medicine_id);
					$('#medicine_name'+row).val(med_name);
					$('#remaining'+row).val(remaining);
					
					$('#quantity'+row).focus();
				} 
			});
		});

		$(".data-quantity").livequery('focusout', function(e){
			var code = e.keyCode || e.which;
			//if (code == 13 || code == 9) {
				var quantity_id = $(this).attr('id');
				var row = quantity_id.substr(8,1);
				var barcode = $('#barcode'+row).val();
				var quantity = $(this).val();
				var remaining = $('#remaining'+row).val();

				if(quantity == 0 || quantity == ""){
					return false;
				}

				if(parseInt(quantity) > parseInt(remaining)){
					alert('Value of quantity cannot be greater than available quantity.');
					$(this).focus();
				}
				else{
					$.ajax({
						type: 'POST',
						url: 'index.php?view=manage_medicine',
						data: {
							data: 'data',
							action:'select_medicine',
							barcode: barcode
						},
					
						success:function(details){
							var details1 = details;
							var details		= details.substring(details.lastIndexOf("####")+4,details.lastIndexOf("@@@@"));
							var obj 		= $.parseJSON(details);
							var cost 		= '#cost'+row;
							var subtotal 	= '#subtotal'+row;
							var total		= '#total'+row;
							var mfg_date	= '#mfg_date'+row;
							var exp_date	= '#expiry_date'+row;
							
							$(cost).val(obj.unit_cost);
							var subtotal_val = quantity * obj.unit_cost; 
							$(subtotal).val(subtotal_val);
							$(total).val(subtotal_val);
							$(mfg_date).val(obj.mfg_date);
							$(exp_date).val(obj.expiry_date);

							getNewRow(count);
							++count;
						} 
					});
				}
			//}
		});
		
	});


	function getNewRow(count){
		var html = '<div style="padding:10px;">';
		html += '<input type="text" id="barcode'+count+'" name="medicine['+count+'][barcode]" placeholder="Barcode" class="input-small data-barcode numeric-txt" style="margin-left:5px;">';
		html += '<input type="hidden" class="medicines-select input-small" id="name'+count+'" name="medicine['+count+'][name]" />';

		html += '<div class="input-append" style="margin-bottom:0px;">';
      	html += '<input type="text" class="medicines-select input-small" id="medicine_name'+count+'" name="medicine['+count+'][medicine_name]" placeholder="Medicine Name" />';
      	html += '<input type="button" class="btn" id="remaining'+count+'" value="0" />';
      	html += '</div>';
			
		html += '<input type="text" id="quantity'+count+'" name="medicine['+count+'][quantity]" placeholder="Quantity" class="input-small data-quantity numeric-txt data-medi'+count+'" style="margin-left:5px;">';
    	html += '<input type="text" id="cost'+count+'" name="medicine['+count+'][cost]" placeholder="Unit Cost" data-source="'+count+'" class="input-small bill-data data-medi'+count+'" style="margin-left:5px;">';
    	html += '<input type="text" id="subtotal'+count+'" name="medicine['+count+'][subtotal]" placeholder="Subtotal" data-source="'+count+'" class="input-small bill-data" readonly="readonly" style="margin-left:5px;">';
		html+='<input type="text" id="tax'+count+'" name="medicine['+count+'][tax]" placeholder="Tax" data-source="'+count+'" class="input-small bill-data data-medi'+count+'" value="" style="margin-left:5px;">';

		html += '<input type="text" id="discount'+count+'" name="medicine['+count+'][discount]" placeholder="Discount"  data-source="'+count+'" class="input-small bill-data data-medi'+count+'" value="" style="margin-left:5px;">';
		html += '<input type="text" id="total'+count+'" name="medicine['+count+'][total]" placeholder="Total" data-source="'+count+'"  class="input-small bill-data data-total" readonly="readonly" style="margin-left:5px;">';
		html += '<input type="hidden" id="mfg_date'+count+'" name="medicine['+count+'][mfg_date]" placeholder="Manufactured Date" class="input-small" style="margin-left:5px;">';
		html += '<input type="hidden" id="expiry_date'+count+'" name="medicine['+count+'][expiry_date]" placeholder="Expiry Date" class="input-small" style="margin-left:5px;">';
	html += '</div>';

	$("#dhs-billing-form").append(html);

	}

		
})(jQuery);
</script>
