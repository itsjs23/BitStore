<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php
    if(isset($_POST['new_password']) && isset($_POST['old_password']) && isset($_POST['submit']) ){
	$user_id = $_SESSION['myuserid'];
	$old_password = $_POST['old_password'];
	$new_password = $_POST['new_password'];
	$sql = "update `users` set `password` = '$new_password' where `user_id` = '$user_id' and `password` = '$old_password'";
	$result=mysqli_query($con,$sql);
    if($result){
        $row=$con-> affected_rows;
        if($row>0){
            $pwdChnageStatus=1; //$update_query 
         }else{
            $pwdChnageStatus=2; // old pwd wrong
        }
	}else{
        $pwdChnageStatus=0; // query fail
    }
    
    
}
?>
<fieldset>
	<legend>Change Password</legend>
	
	<form class="form-horizontal dhs-medical-form " method="post" id="myform" name="myform">
  <div class="control-group">
    <label class="control-label" for="old_password">Old Password:</label>
    <div class="controls">
      <input type="password" id="old_password" name="old_password" placeholder="Old Password" required="">

    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="new_password">New Password:</label>
    <div class="controls">
      <input type="password" id="new_password" name="new_password" placeholder="Password" required="">
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      <button type="submit"  name="submit" class="btn btn-primary">Update Password</button>
        <?php
        if(isset($pwdChnageStatus)){
            if($pwdChnageStatus==1){
                echo '<p style="color:green;font-size:18px;"text-align="right" > Password Change SuccessFully</p>';
            }
            else if($pwdChnageStatus==2){
                echo '<p style="color:red;font-size:18px;" text-align="right"> Old Pwd Wrong !! </p>';
            }
        else{
            echo '<p style="color:orange;font-size:18px;" text-align="right"> Password Change Failed !! </p>';
            }
            
        }
        
        ?>

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
