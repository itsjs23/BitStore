<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<fieldset>
	<legend>List of Returned Stock</legend>
	
	<table class="table table-stripped">
		<thead>
			<tr>
				<th>S. No.</th>
				<th>Medicine Name</th>
				<th>Returned Quantity</th>
				<th>Purchased Price</th>
				<th>Returned Amount</th>
				<th>Loss</th>
				<th>Return Date</th>
				<th>Returned By</th>
			</tr>
		</thead>
		
		<tbody>
			<?php 
				$store_key  = $_SESSION['mystoreid'];
				$result 	= mysqli_query($con,"select r.*, m.medicine_name from `return_stock` as r join `medicine` as m on (r.medicine_id = m.medicine_id and r.store_key = '$store_key' and m.store_key = '$store_key' and r.status <> 0)");
				$index 		= 0;
				$records	= array();
				$medicines 	= array();
				$users 		= array();
				$distributors = array();
				
				while($row = mysqli_fetch_array($result)){
					$records[] 		= $row;
					$medicines[] 	= $row['medicine_id'];
					$users[] 		= $row['returned_by'];
					$distributors[] = $row['distributor_id'];
				}
				
				$users_list 		= DhsHelper::getUsersList($users);
				$medicines_list 	= DhsHelper::getMedicinesList($medicines);
				$distributor_list 	= DhsHelper::getDistributorsList($distributors);
				
				foreach ($records as $record):
			?>
			<tr>
				<td><?php echo ++$index;?></td>
				<td><?php echo isset($medicines_list[$record['medicine_id']]) ? $medicines_list[$record['medicine_id']] : 'N/A';?></td>
				<td><?php echo $record['quantity'];?></td>
				<td><?php echo DhsHelper::formatPrice($record['purchased_price']);?></td>
				<td><?php echo DhsHelper::formatPrice($record['returning_total']);?></td>
				<td><?php echo DhsHelper::formatPrice($record['loss']);?></td>
				<td><?php echo $record['return_date'];?></td>
				<td><?php echo $users_list[$record['returned_by']];?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</fieldset>
<?php
