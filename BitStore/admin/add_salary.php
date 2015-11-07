<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php 
$store_key = $_SESSION['mystoreid'];
$record = array();
if(isset($_POST['action']) && $_POST['action'] == 'insert_salary'){
	$purpose 		= $_POST['user_id'];
	$amount 		= $_POST['salary'];
	$expense_date 	= $_POST['notify_day'];
	$status 		= 1;
	$created_date 	= date('Y-m-d');
	
	$result = mysqli_query($con,"select count(*) from `salary` where store_key = '$store_key' and status <> 0 and user_id = ".$purpose);
	$count = mysqli_fetch_row($result);
	
	if($count[0] > 0){?>
		<div class="alert alert-error">Duplicate entry for salary details is not allowed.</div>
	<?php }
	else{
		$sql = "insert into `salary` (`user_id`, `salary`, `status`, `notify_day`, `created_date`, `store_key`) values ($purpose, $amount, $status, $expense_date, '$created_date', '$store_key')";
		if(!mysqli_query($con,$sql)){
			?>
			<div class="alert alert-error">Some error occured while saving salary data.</div>
			<?php 
			die('Error : '.mysql_error());
		}
	
		unset($_POST);
		?>
		<div class="alert alert-info">Salary Recorded Successfully.</div>
	<?php 
	}
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_salary' && !empty($_REQUEST['salary_id'])){
	$result = mysqli_query($con,'select * from `salary` where `salary_id` = '.$_REQUEST['salary_id']);
	$record = mysqli_fetch_array($result);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_update_salary' && !empty($_REQUEST['salary_id'])){

	$amount 		= $_POST['salary'];
	$expense_date 	= $_POST['notify_day'];
		
	$sql = "update `salary` SET `salary` = $amount, `notify_day` = $expense_date where `salary_id` = ".$_REQUEST['salary_id'];
	
	if(!mysqli_query($con,$sql)){
		?>
		<div class="alert alert-error">Some error occured while saving salary data.</div>
		<?php 
		die('Error : '.mysql_error());
	}
	?>
	<div class="alert alert-info">Salary Updated Successfully.</div>
	<?php 
}

?>

<fieldset class="span8 offset2">
	<legend>Add Salary Details</legend>

	<form class="form-horizontal dhs-medical-form " id="myform" name="myform" action="#" method="post">
  		<div class="control-group">
    		<label class="control-label" for="user_id">Select User:</label>
		    <div class="controls">
		      <select name="user_id" id="user_id">
		      		<option value="default">Select User</option>
		      		<?php 
		      		$user_rslt = mysqli_query($con,"select * from `users` where store_key = '$store_key' and status <> 0 and Enable = 1 and (type = 301 or type = 302)");
		      		while($user = mysqli_fetch_array($user_rslt)):
		      		?>
		      		<option value="<?php echo $user['user_id'];?>" <?php echo (isset($record['user_id']) && $record['user_id'] == $user['user_id']) ? 'selected=selected' : ''; ?>><?php echo $user['username'];?></option>
		      		<?php endwhile;?>
		      </select>
		      
		    </div>
		</div>
  
	  <div class="control-group">
	    <label class="control-label" for="salary">Per Month Salary:</label>
	    <div class="controls">
	      <input type="text" id="salary" class="numeric-txt" name="salary" required="" value="<?php echo isset($record['salary']) ? $record['salary'] : ''; ?>" />
	    </div>
	  </div>
	  
	  
	  
	  <div class="control-group">
	    <label class="control-label" for="notify_day">Notify Day:</label>
	    <div class="controls">
	    	<select name="notify_day">
	    		<?php for($day = 1; $day <= 31; $day++):?>
	    		<option value="<?php echo $day?>" <?php echo (isset($record['notify_day']) && $record['notify_day'] == $day) ? 'selected=selected' : ''; ?>><?php echo $day;?></option>
	    		<?php endfor;?>
	    	</select>
	    </div>
	  </div>
   
	  <div class="control-group">
	    <div class="controls">
	    	<input type="hidden" name="salary_id" id="salary_id"  value="<?php echo isset($record['salary_id']) ? $record['salary_id'] : 0;?>" />
	      	<input type="hidden" name="action" id="action"  value="<?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_salary') ? 'do_update_salary' : 'insert_salary';?>" />
	      	<button type="button" class="btn btn-primary" id="btn_save">Save</button>
	    </div>
	  </div>
	  
	</form>	
</fieldset>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {

            //////====  Add Salaray =====/////

            $('#btn_save').click(function () {
            var userId = $('#user_id').val();
            var salaryAmount = parseFloat($('#salary').val()) > 0 ? $('#salary').val() : '0';

        var querystring = $("#myform").serialize();
        if (userId != 'default' && salaryAmount != '0') {
            $.ajax({
                type: 'POST',
                url: 'admin/db/manage_salary.php',
                data: {
                    query: querystring,
                    action: 'add_salary'

                },

                success: function (html) {
                    var result = JSON.parse(html);
                    if (result['status'] == 'success') {
                        alert('Added Success Fully !!');
                    } else {
                        if (result['status'] == 'salrayExist') {
                            alert('Salary  Alreay Added For User !!');
                        } else {
                            alert('Failed To add Salray');
                        }
                    }
                    document.myform.reset();
                }
            }); // ajax end 

        } else {
        alert('Please Fill All the details');
        }




    });

        }); // document add
    })(jQuery); 
</script>


