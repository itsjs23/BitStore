<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<fieldset>
	<legend>List of Paid Salary</legend>
	
	<table class="table table-stripped"> 
		<thead>
			<tr>
				<th>S.No</th>
				<th>Username</th>
				<th>Monthly Salary</th>
				<th>Month</th>
				<th>Year</th>
				<th>Present Days</th>
				<th>Absent Days</th>
				<th>Salary Paid</th>
				
			</tr>
		</thead>
		
		<tbody>
			<?php 
			$store_key = $_SESSION['mystoreid'];
			$result = mysqli_query($con,"select users.username as username, paid_salary.* from `paid_salary` join `users` on (paid_salary.user_id = users.user_id and users.`store_key` = '$store_key')");
			//$result = mysqli_query($con,"select * from `paid_salary` where `store_key` = '$store_key'");
			$index = 0;
			while($row = mysqli_fetch_array($result)):
			?>
			<tr>
				<td><?php echo ++$index;?></td>
				<td><?php echo $row['username']?></td>
				<td><?php echo DhsHelper::formatPrice($con,$row['salary']);?></td>
				<td><?php echo $row['month']?></td>
				<td><?php echo $row['year']?></td>
				<td><?php echo $row['present_days']?></td>
				<td><?php echo $row['absent_days']?></td>
				<td><?php echo DhsHelper::formatPrice($con,$row['actual_payment']);?></td>
			</tr>
			<?php endwhile;?>
		</tbody>
	</table>
</fieldset>
<?php
