<?php require_once 'config.php';?>
<?php require_once 'helper.php';?>

<?php if(!isset($_POST['search']) || empty($_POST['search']) || !isset($_POST['store_id']) || empty($_POST['store_id'])){
	?>
	<div class="alert alert-error">Store Id or search query cannot be blank.</div>
	<?php 
} else{?>

		<?php 
		
		session_start();
		$search 	= $_POST['search'];
		$store_id 	= $_POST['store_id'];
		$search 	= stripslashes($search);
		$store_id 	= stripslashes($store_id);
		$store_id 	= mysql_real_escape_string($store_id);
		$search		= mysql_real_escape_string($search);
		
		$result 	= mysqli_query($con,"select m.`medicine_id`, m.`medicine_name`, c.`name`, m.`manufacturer` 
						from `medicine` as m join `category` as c 
						on (m.category_id = c.category_id and m.`store_key` = '$store_id' and c.`store_key` = '$store_id' and m.`medicine_name` like '%$search%')");
		
		$medicines 		= array();
		$medicine_ids 	= array();
		error_reporting(0);
		
		while($row = mysqli_fetch_array($result)){
			$medicines[$row['medicine_id']]['med_name'] = $row['medicine_name'];
			$medicines[$row['medicine_id']]['cat_name'] = $row['name'];
			$medicines[$row['medicine_id']]['mfg'] 		= $row['manufacturer'];
			$medicine_ids[] = $row['medicine_id'];
		}
		
		list($records, $purchased, $sold, $return) = DhsHelper::getInventoryDetails($medicine_ids);
		?>
			<?php if(!empty($medicines)):?>
				<div style="font-size: 1.3em; border-bottom:1px solid #ccc;"><strong>Search Results</strong></div>
				<table class="table table-stripped">
					<thead>
					<tr>
						<th>#</th>
						<th>Medicine Name</th>
						<th>Type</th>
						<th>Manufacturer</th>
						<th>Available Quantity</th>
					</tr>
					</thead>
					<?php $i = 0;?>
					<?php foreach ($medicines as $medicine_id => $medicine):?>
						<tr>
							<td><?php echo ++$i;?>.</td>
							<td><?php echo $medicine['med_name'];?></td>
							<td><?php echo $medicine['cat_name'];?></td>
							<td><?php echo $medicine['mfg'];?></td>
							<td><?php echo $purchased[$medicine_id]['quantity'] - $sold[$medicine_id]['quantity'] - $return[$medicine_id]['quantity'];?></td>
						</tr>
					<?php endforeach;?>
				</table>
				
			<?php else:?>
				<div class="alert alert-error">Medicine is not available in stock with your search query.</div>
			<?php endif;?>
<?php }?>