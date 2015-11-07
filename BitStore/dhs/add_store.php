<?php
if(!isset($_SESSION['myuserid'])) { die('Session is expired. Please do login again.'); }
?>
<script>
	(function($){
		$(document).ready(function(){
			$("#username_validation").hide();
			$("#user_validation").click(function() {
				var user = $("#username").val();

				if(user == ""){
					$("#username_validation").show();
					$("#username_validation").html('Username field cannot be empty.');
					$("#btn_save").attr('disabled', 'disabled');
				}
				else{
					$.ajax({
						type: 'POST',
						url: 'index.php?view=manage_user',
						data: {
							username:user,
							action: 'verify_user'
						},
						success:function(details){
							var details		= details.substring(details.lastIndexOf("####")+4,details.lastIndexOf("@@@@"));
							details = parseInt(details);

							if(details == 0){
								$("#username_validation").show();
								$("#username_validation").html('Congratulations, you can use this username');
								$("#btn_save").removeAttr('disabled');
							}
							else{
								$("#username_validation").show();
								$("#username_validation").html('Username already exists');
								$("#btn_save").attr('disabled', 'disabled');
							}
						}
					});
				}
			});
		});	
	})(jQuery);
</script>
<form class="form-horizontal" method="post" action="<?php echo DHS_ROOT;?>dhs/index.php?view=new_store_details">
	<fieldset>
		<legend>Add New Store</legend>
	
		  <div class="control-group">
		    <label class="control-label" for="store_name">Store Name</label>
		    <div class="controls">
		      <input type="text" id="store_name" name="store_name" placeholder="Store Name" required="" />
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="person_name">Contact Person</label>
		    <div class="controls">
		      <input type="text" id="person_name" name="person_name" placeholder="Person Name" required="" />
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="email">Email</label>
		    <div class="controls">
		      <input type="text" id="email" name="email" placeholder="Email" />
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="address">Address</label>
		    <div class="controls">
		      <input type="text" id="address" name="address" placeholder="Address" required="" />
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="city">City</label>
		    <div class="controls">
		      <input type="text" id="city" name="city" placeholder="City" required="" />
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="state">State</label>
		    <div class="controls">
		      <input type="text" id="state" name="state" placeholder="State" required="" />
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="country">Country</label>
		    <div class="controls">
		      <input type="text" id="country" name="country" placeholder="Country" required="" />
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <label class="control-label" for="mobile">Mobile</label>
		    <div class="controls">
		      <input type="text" id="mobile" name="mobile" placeholder="Mobile" required="" />
		    </div>
		  </div>
		  
	</fieldset>	  
		  
	<fieldset>
		<legend>Login Details</legend>
		<div class="control-group">
	        <label class="control-label" for="username">Username:</label>
	        <div class="controls">
	          <input type="text" id="username"  required=""  name="username" placeholder="Username" value="" style="width:141px">
	          <button type="button" class="btn" id="user_validation">Verify</button>
	          <div id="username_validation" style="color:#F00; font-family:Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Username</div>
	          
	        </div>
	      </div>  
		
		  <div class="control-group">
		    <label class="control-label" for="password">Password</label>
		    <div class="controls">
		      <input type="password" id="password" name="password" placeholder="Password" required="" />
		    </div>
		  </div>
		  
		  <div class="control-group">
		    <div class="controls">
		      <button type="submit" id="btn_save" class="btn btn-success">Create Store</button>
		    </div>
		  </div>
	</fieldset>
</form>