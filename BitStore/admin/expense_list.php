<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<div class="row-fluid">
	<div class="span9 offset1">
	
<table class="table table-stripped">
	<thead>
		<tr>
			<th>S.No.</th>
			<th>Particular</th>
			<th>Amount</th>
			<!--<th>Expenditure Date</th>-->
            <th>Date</th>
			<!--<th>Action</th>-->
		</tr>
	</thead>
	
	<tbody>
		<?php 
		$store_key = $_SESSION['mystoreid'];
			$index = 0;
			$total = 0;
			$result = mysqli_query($con,"select * from `expenditure` where `store_key` = '$store_key' order by `expenditure_id` DESC");
            if($result && $result -> num_rows > 0 ){
			while($row = mysqli_fetch_assoc($result)):
	?>
			<?php $total += $row['amount'];?>
			<tr><td><?php echo ++$index;?></td>
			<td><?php echo $row['purpose'];?></td>
			<td>Rs. <?php echo DhsHelper::formatPrice($con,$row['amount']);?></td>
            
            <td><?php  echo DhsHelper::formatDate($row['created_date']);?>
			<!--<td>
				<a href="index.php?view=expense_registration&menu=accounting&action=update_expense&expense_id=<?php //echo $row['expenditure_id'];?>">
					<i class="icon-edit"></i>
				</a>
				<a href="#" class="expense_delete" data-source-id="<?php //echo $row['expenditure_id'];?>">
                        <i class="icon-remove"></i>
                	</a>
                	
			</td>-->
		</tr>
		<?php endwhile;
            }
            
              ?>
		
	<!--	
		<?php 
			//	$result = mysqli_query($con,"select users.username as username, actual_payment, paid_on_date from `paid_salary` join `users` on (paid_salary.user_id = users.user_id and users.`store_key` = '$store_key')");
				//while($row = mysqli_fetch_array($result)):
				//$total += $row['actual_payment'];
			?>
			<tr>
				<td><?php  //echo ++$index;?></td>
				<td>
					<strong>Salary Paid To: </strong> <?php //echo ucfirst($row['username']); ?><br>
				</td>
				<td>Rs. <?php //echo DhsHelper::formatPrice($con,$row['actual_payment']);?></td>
				<td><?php //echo DhsHelper::formatDate($row['paid_on_date']);?></td>
				<td>&nbsp;</td>
			</tr>
			<?php //endwhile; ?>
	-->
	
	</tbody>

</table>

<div class="well">
	<strong>Total Expenses: </strong><?php echo DhsHelper::formatPrice($con,$total);?>
</div>
</div>
	<div class="span2">&nbsp;</div>
</div>




<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$(".expense_delete").click(function(){
				var id = $(this).attr('data-source-id');
				var didConfirm = confirm("Are you sure?");
				  if (didConfirm == true) {
					  var id = $(this).attr('data-source-id');
					  $.ajax({
							type: 'POST',
							url: 'index.php?view=manage_expense',
							data: {
								action: 'delete_expense',
								expense_id: id
							},
							success:function(details){
								var row = '.row'+id;
								$(row).hide();
							}
						});
				  }
			});
		});
	})(jQuery);
</script>

<?php
