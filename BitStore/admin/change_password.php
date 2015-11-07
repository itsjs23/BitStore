<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php 
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == 'update_password'){
	$store_key = $_SESSION['mystoreid'];
	$username = $_POST['username'];
	$password = $_POST['passsword'];
	$sql = "update `users` set `password` = '$password' where `username` = '$username' and `store_key` = '$store_key'";
	if(!mysqli_query($con,$sql)){
		die('Error'.mysql_error());
	}
}
?>
<fieldset>
	<legend>Change Password</legend>
	
	<form class="form-horizontal dhs-medical-form " method="post" id="myform" name="myform">
  <div class="control-group">
        <label class="control-label" for="username">Username:</label>
        <div class="controls">
          <input type="text" id="username"  required="" name="username" placeholder="Username" style="width:141px">
          <button type="button" class="btn" id="user_validation">Verify</button>
          <div id="username_validation" style="color:#F00; font-family:Georgia, 'Times New Roman', Times, serif;" class="error_msg"></div>
          <input type="hidden" id="user_id" name="user_id" value="" />
        </div>
      </div>
  
  <div class="control-group">
    <label class="control-label" for="passsword">Password:</label>
    <div class="controls">
      <input type="password" id="passsword" name="passsword" placeholder="Password" required="">

    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      <input type="hidden" name="action" id="action"  value="update_password" />
      <button type="submit" class="btn btn-primary" disabled="disabled" id="btn_save">Update Password</button>
    </div>
  </div>
  
</form>
</fieldset>


<script type="text/javascript">
(function($){
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
				url: 'index.php?view=manage_distributor',
				data: {
					username:user,
					action: 'verify_user'
				},
				success:function(details){
					var details		= details.substring(details.lastIndexOf("####")+4,details.lastIndexOf("@@@@"));
					details = parseInt(details);

					if(details == 0){
						$("#username_validation").show();
						$("#username_validation").html('Username is not correct. Please enter valid username.');
						$("#btn_save").attr('disabled', 'disabled');
					}
					else{
						$("#username_validation").show();
						$("#username_validation").html('Username is correct, change the password now.');
						$("#btn_save").removeAttr('disabled');
					}
				}
			});
		}
	});
})(jQuery);
</script>
<?php
