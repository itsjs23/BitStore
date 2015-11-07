<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<table class="table table-striped">
	<tr>
		<th>S.No.</th>
		<th>Doctor Name</th>
		<th>Mobile Number</th>
		<th>Income</th>
		<th>Edit&nbsp;|&nbsp;Delete</th>
	</tr>
	
	<?php 
	include("config.php");
	$sql	= "select * from `doctors` where `store_key` = '$store_key' and `status` <> 0";
	$result = mysqli_query($con,$sql);
	$n=0;
	while($row=mysqli_fetch_array($result)):
		$n++;
	?>
	
	<tr>
		<td><?php echo $n;?></td>
		<td><?php echo $row['doctor_name'];?></td>
		<td><?php echo $row['mobile'];?></td>
		
		<td>
			<?php 
				$sql = "select sum(`total`) as income, `doctor_name`, `store_key` from `cust_inventory` group by `doctor_name` having `store_key` = '$store_key' and `doctor_name` = "."'".$row['doctor_name']."'";
				//echo $sql;
				$inc = mysqli_query($con,$sql);
				$income = mysqli_fetch_array($inc);
				echo DhsHelper::formatPrice($income['income']);
			?>
		</td>
		<td>
			<a href="index.php?view=doctor_registration&menu=user&doctor_id=<?php echo $row['doctor_id'];?>">
				<i class="icon-edit"></i>
			</a>
			<a href="index.php?view=manage_doctor&action=delete_doctor&doctor_id=<?php echo $row['doctor_id'];?>"  onclick="javascript:void(0)"> 
				<i class="icon-remove"></i>
			</a>
		</td>
	</tr>
		
	<?php endwhile;?>
</table>