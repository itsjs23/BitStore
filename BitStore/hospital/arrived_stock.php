<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<fieldset>
	<legend>List of Consignment Sent by Distributors</legend>
	
	<table class="table table-stripped">
		<thead>
			<tr>
				<th>Sr No.</th>
				<th>Product Name</th>
				<th>Qunatity</th>
				<th>Unit Cost</th>
				<th>Bill No</th>
                <th>Vendor Name</th>
				</tr>
		</thead>
		
		<tbody>
			<?php 
			
			$today_stock="SELECT VP.`BillDetails`,VP.`BillNo`,VD.Name FROM `vendor_payment` AS VP INNER JOIN vendors AS VD ON VD.Id=VP.`ven_id` 
            WHERE VP.date='".date('Y-m-d')."' AND VD.store_key='".$store_key."' ";
            $result = mysqli_query($con,$today_stock);
			if($result && $result->num_rows > 0)
            {
            $index = 0;
            while($data=mysqli_fetch_row($result))
            {
                $products=split(',',$data[0]);
                foreach($products as $product)
                {
                    $product_data=split('_',$product);
                ?>
            <tr>
				<td><?php echo ++$index; ?></td>
                <td><?php echo $product_data[0]; ?></td>
                <td><?php echo $product_data[1]; ?></td>
                <td><?php echo $product_data[2]; ?></td>
                <td><?php echo $data[1]; ?></td>
                <td><?php echo $data[2]; ?></td>
			</tr>
                    
            <?php  
            } //foreach end 
            } // while end
            } //if stmt end
            
            ?>
		</tbody>
	</table>
</fieldset>