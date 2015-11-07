<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<script type="text/javascript">
	(function($){	
		$(document).ready(function() {
			$("#success_msg").hide();

			$("#btn_save").click(function(){
				var doc = $("#doctor_name").val();
				var mob = $("#mobile_no").val();

				if(doc == '' || mob == ''){
					$("#show_msz").html('Please enter all values properly.');
				}else{
					var querystring=$("#myform").serialize();
					$.ajax({
						type: 'POST',
						url: 'index.php?view=manage_doctor',
						data: {
							query:querystring
						},
						success:function(html){
							$('html,body').animate({
		                    	scrollTop: $('#success_msg').offset().top -50
		                    }, 'slow');

							var act=document.myform.action.value;
							if(act=='update_doctor'){
								window.location.replace("index.php?view=doctors_list&menu=user");
							}
							    else{
								 	document.myform.reset();
									$("#success_msg").fadeIn();
									$('#doctor_name').focus();
									$('#doctor_name').val('');
									$('#mobile_no').val('');
							    }
						}
					});
				}
			});
		});
	})(jQuery);
</script>

<fieldset>
	<legend>Add Doctor Details</legend>
	<?php 
		if(isset($_REQUEST['doctor_id']) && !empty($_REQUEST['doctor_id'])){
			$doctor_id = $_REQUEST['doctor_id'];
			$doc_result= mysqli_query($con,"select * from `doctors` where `store_key` = '$store_key' and doctor_id = $doctor_id");
			$doctor = mysqli_fetch_array($doc_result);
		}
	?>

	<form class="form-horizontal dhs-medical-form " id="myform" name="myform">
  		<div class="control-group">
    		<label class="control-label" for="doctor_name">Name:</label>
		    <div class="controls">
		      <input type="text" id="doctor_name" name="doctor_name" placeholder="Name of Doctor" required="" value="<?php echo isset($doctor['doctor_name']) ? $doctor['doctor_name'] : ''; ?>" />
		    </div>
		</div>
  
	  <div class="control-group">
	    <label class="control-label" for="mobile_no">Mobile Number:</label>
	    <div class="controls">
	      <input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile Number" required="" value="<?php echo isset($doctor['mobile']) ? $doctor['mobile'] : ''; ?>">
	    </div>
	  </div>
	  
	  <div id="show_msz" style="color: rgb(255, 0, 0); font-family: Georgia, 'Times New Roman', Times, serif; display: block;"></div>
   
	  <div class="control-group">
	    <div class="controls">
	    <?php if(isset($_REQUEST['doctor_id']) && !empty($_REQUEST['doctor_id'])):?>
	    	<input type="hidden" name="action" id="action"  value="update_doctor" />
	    	<input type="hidden" name="doctor_id" id="doctor_id"  value="<?php echo $doctor_id;?>" />
	    <?php else:?>
	    	<input type="hidden" name="action" id="action"  value="insert_doctor" />
	    <?php endif;?>
	      
	      <button type="button" class="btn btn-primary" id="btn_save">Save</button>
	    </div>
	  </div>
	  
	  <div align="center" id="success_msg">
	     <div style="width:400px; height:70px; font-family:Georgia, 'Times New Roman', Times, serif; font-size:18px; color:#0C3;">*Doctor details added successfully.</div>
	   </div> 
	</form>	
</fieldset>

<?php if(isset($_REQUEST['doctor_id']) && !empty($_REQUEST['doctor_id'])):?>
<fieldset>
	<legend>Business From Doctor</legend>
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>Medicine Name</th>
					<th>Quantity</th>
					<th>Total Amount</th>
					<th>Transaction Date</th>
				</tr>
			</thead>
			
			<tbody>
				<?php 
				$total = 0;
				$result = mysqli_query($con,"select c.*, m.medicine_name from `cust_inventory` as c join `medicine` as m on (m.medicine_id = c.medicine_id and m.store_key = '$store_key' and c.store_key = '$store_key') where c.`doctor_name` = "."'".$doctor['doctor_name']."'");
				while($row = mysqli_fetch_array($result)):
				$total += $row['total'];
				?>
				<tr>
					<td><?php echo $row['medicine_name'];?></td>
					<td><?php echo $row['quantity'];?></td>
					<td><?php echo DhsHelper::formatPrice($row['total']);?></td>
					<td><?php echo DhsHelper::formatDate($row['created_date'], 'd-M-Y');?></td>
				</tr>
				<?php endwhile;?>
			</tbody>
		</table>
		
		<div class="well well-small">
			<strong>Total Business: Rs. <?php echo DhsHelper::formatPrice($total);?></strong>
		</div>
	
</fieldset>
<?php endif;?>