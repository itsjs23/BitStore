<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>

<fieldset class="span10">
	<legend style="margin-bottom:10px;"><font size="+2">Get List of Barcodes</font></legend>
    
    <table class="table table-stripped">
    	<thead>
    		<tr>
    			<th>S. No.</th>
    			<th>Product Name</th>
    			<th>Barcode</th>
    			<th>Batch Code</th>
    			<th>Mfg Date</th>
    			<th>Expiry Date</th>
    			<th>Print</th>
    		</tr>
    	</thead>
    	
    	<tbody>
    		<?php 
    		$index = 0;
    		$result = mysqli_query($con,"select * from `barcodes` where `store_key` = '$store_key'");
    		while($row = mysqli_fetch_array($result)):
    		?>
    		<tr>
    			<td><?php echo ++$index;?></td>
    			<td><?php echo $row['medicine_name']?></td>
    			<td><?php echo $row['barcode']?></td>
    			<td><?php echo $row['batch_code'];?></td>
    			<td><?php echo $row['mfg_date']?></td>
    			<td><?php echo $row['expiry_date'];?></td>
    			<td>
    				<a href="admin/barcodes/print_barcode.php" onclick="javascript:void window.open('admin/barcodes/print_barcode.php?barcodes_id=<?php echo $row['barcodes_id'];?>', '', 'width=420, height=200, toolbar=0, menubar=0, location=0, status=1, scrollbars=1, resizable=1, left=0, top=0'); return false;">
                        <i class="icon-print"></i>
                	</a>
    			</td>
    		</tr>
    		<?php endwhile;?>
    	</tbody>
    </table>
</fieldset>
