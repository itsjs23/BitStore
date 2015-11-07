<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php 
$store_key = $_SESSION['mystoreid'];
$record = array();
if(isset($_POST['action']) && $_POST['action'] == 'insert_salary'){
	$user_id 		= $_POST['user_id'];
	$salary 		= $_POST['salary'];
	$month 			= $_POST['month'];
	$year 			= $_POST['year'];
	$present 		= $_POST['present_days'];
	$absent 		= $_POST['absent_days'];
	$month_days 	= $_POST['month_days'];
	$actual 		= $_POST['actual_payment'];
	$paid_date 		= $_POST['paid_on_date'];
	$status 		= 1;
	$created_date 	= date('Y-m-d');
	
	$result = mysqli_query($con,"select count(*) from `paid_salary` where `store_key` = '$store_key' and `user_id` = $user_id and `month` = $month and `year` = $year");
	$count = mysqli_fetch_row($result);
	
	if($count[0] > 0){?>
		<div class="alert alert-error">Duplicate entry for salary details is not allowed.</div>
	<?php }
	else{
		$sql = "insert into `paid_salary` (`user_id`, `salary`, `month`, `year`, `present_days`, 
				`absent_days`, `month_days`, `actual_payment`, `paid_on_date`, `created_date`, `store_key`)
				values ($user_id, $salary, $month, $year, $present,
				$absent, $month_days, $actual, '$paid_date', '$created_date', '$store_key')";
				
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
	$result = mysqli_query($con,"select * from `salary` where `store_key` = '$store_key' and salary_id = ".$_REQUEST['salary_id']);
	$record = mysqli_fetch_array($result);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_update_salary' && !empty($_REQUEST['salary_id'])){

	$amount 		= $_POST['salary'];
	$expense_date 	= $_POST['notify_day'];
		
	$sql = "update `salary` SET `salary` = $amount, `notify_dy` = $expense_date where `salary_id` = ".$_REQUEST['salary_id'];
	
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

	<form class="form-horizontal dhs-medical-form " id="myform" name="myform" action="index.php?view=pay_due_salary&menu=payroll" method="post">
  		<div class="control-group">
    		<label class="control-label" for="user_id">User:</label>
		    <div class="controls">
		      <input type="text" id="user_id" name="user_id" readonly="readonly" value="<?php echo $_REQUEST['user_id']; ?>" />
		    </div>
		</div>
  
	  <div class="control-group">
	    <label class="control-label" for="salary">Per Month Salary:</label>
	    <div class="controls">
	    	<?php $salary = mysqli_fetch_row(mysqli_query($con,"select salary from `salary` where `store_key` = '$store_key' and `user_id` = ".$_REQUEST['user_id']));?>
	      <input type="text" id="salary" class="numeric-txt" name="salary" readonly="readonly" value="<?php echo isset($record['salary']) ? $record['salary'] : $salary[0]; ?>" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="month">Deposit Salary Month:</label>
	    <div class="controls">
	      <select name="month">
	    		<?php for($day = 1; $day <= 12; $day++):?>
	    		<option value="<?php echo $day?>"><?php echo $day;?></option>
	    		<?php endfor;?>
	    	</select>
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="year">Deposit Salary Year:</label>
	    <div class="controls">
	    	<input type="text" id="year" class="numeric-txt" name="year" required="" value="<?php echo isset($record['year']) ? $record['year'] : ''; ?>" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="month_days">Month Days:</label>
	    <div class="controls">
	    	<select id="month_days" name="month_days">
	    		<option>28</option>
	    		<option>29</option>
	    		<option>30</option>
	    		<option>31</option>
	    	</select>
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="present_days">Total Presents:</label>
	    <div class="controls">
	    	<input type="text" id="present_days" class="numeric-txt" name="present_days" required="" value="<?php echo isset($record['present_days']) ? $record['presents_days'] : ''; ?>" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="absent_days">Total Absents:</label>
	    <div class="controls">
	    	<input type="text" id="absent_days" class="numeric-txt" name="absent_days" required="" value="<?php echo isset($record['absent_days']) ? $record['absent_days'] : ''; ?>" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="actual_payment">Actual Payment:</label>
	    <div class="controls">
	    	<input type="text" id="actual_payment" class="numeric-txt" name="actual_payment" required="" value="<?php echo isset($record['actual_payment']) ? $record['actual_payment'] : ''; ?>" />
	    </div>
	  </div>
	  
	  <div class="control-group">
	    <label class="control-label" for="paid_on_date">Paid Date:</label>
	    <div class="controls">
	    	<div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
			    <input data-format="yyyy-MM-dd" type="text" name="paid_on_date" id="paid_on_date" required="" value="<?php echo isset($record['paid_on_date']) ? $record['paid_on_date'] : ''; ?>"></input>
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
	    	<input type="hidden" name="salary_id" id="salary_id"  value="<?php echo isset($record['salary_id']) ? $record['salary_id'] : 0;?>" />
	      <input type="hidden" name="action" id="action"  value="<?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_salary') ? 'do_update_salary' : 'insert_salary';?>" />
	      <button type="submit" class="btn btn-primary" id="btn_save">Save</button>
	    </div>
	  </div>
	  
	</form>	
</fieldset>

<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$("#present_days").change(function(){
				var salary = $("#salary").val();
				var month = $("#month_days").val();
				var daily = salary / month;
				var actual = daily * $(this).val();
				$("#actual_payment").val(actual);
			});
		});
	})(jQuery);
</script>