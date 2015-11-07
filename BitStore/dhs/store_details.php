<?php
if(!isset($_SESSION['myuserid'])) { die('Session is expired. Please do login again.'); }
?>

<table class="table table-stripped">
	<thead>
		<tr>
			<th>S. No.</th>
			<th>Store Key</th>
			<th>Store Name</th>
			<th>Contact Name</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Address</th>
			<th>Created By</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
			$result = mysqli_query($con,"select * from `store`");
			$index = 0;
			while ($row = mysqli_fetch_array($result)):
		?>
		<tr>
			<td><?php echo ++$index;?></td>
			<td><?php echo $row['store_key'];?></td>
			<td><?php echo $row['store_name'];?></td>
			<td><?php echo $row['person_name'];?></td>
			<td><?php echo $row['mobile'];?></td>
			<td><?php echo $row['email'];?></td>
			<td>
				<?php echo $row['address'];?>
				<br>
				<?php echo $row['city'].','.$row['state'].'('.$row['country'].')';?>
			</td>
			<td><?php echo $row['created_by'];?></td>
		</tr>
		<?php endwhile;?>
	</tbody>
</table>