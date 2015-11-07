<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<fieldset>
	<legend>List of Stores</legend>

<table class="table table-stripped">
	<thead>
		<tr>
			<th>S. No.</th>
			<th>Store Name</th>
			<th>Store Key</th>
			<th>Pending requests</th>
			<th>Verified Stock</th>
			<th>View Stock</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		$index = 0;
		$distributor_id = $_SESSION['myuserid'];
		$result = mysqli_query($con,"select * from `store` where `store_key` IN (select `store_key` from `store_distributor_mapping` where distributor_id = $distributor_id)");
		
		while($row = mysqli_fetch_array($result)):
		?>
		<tr>
			<td><?php echo ++$index;?></td>
			<td><?php echo $row['store_name'];?></td>
			<td><?php echo $store_key = $row['store_key'];?></td>
			<td>
				<?php 
				$sql = "select count(inventory_id) from `inventory` where `store_key` = '$store_key' and `distributor_id` = $distributor_id";
				$sql .= ' and `status` = '.DHS_DISTRIBUTOR_INVENTORY_STATUS_PENDING;
				$res = mysqli_query($con,$sql);
				$count = mysqli_fetch_row($res);
				?>
				<a class="stores" data-href="inventory_request.php" data-store="<?php echo $store_key; ?>">View (<?php echo $count[0];?>)</a>
			</td>
			<td><a class="stores" data-href="verified_stock.php" data-store="<?php echo $store_key; ?>">View</a></td>
			<td><a class="stores" data-href="inventory_details.php" data-store="<?php echo $store_key; ?>">View</a></td>
		</tr>
		<?php endwhile;?>
	</tbody>
</table>

</fieldset>
<div id="somediv" title="Store Details" style="display:none;">
    <iframe id="thedialog" width="960" height="300" frameborder='0' style="overflow-x: hidden; overflow-y: scroll;"></iframe>
</div>

<script type="text/javascript">
	(function($){
		$(document).ready(function () {
		    $(".stores").click(function () {
			    var store_key = $(this).attr("data-store");
			    var href = $(this).attr("data-href");
			    href = href + '?&store_key='+store_key;

			    
		        $("#thedialog").attr('src', href);
		        $("#somediv").dialog({
		            width: 1000,
		            height: 400,
		            modal: true,
		            close: function () {
		                $("#thedialog").attr('src', "about:blank");
		            }
		        });
		        return false;
		    });
		});
	})(jQuery);
</script>