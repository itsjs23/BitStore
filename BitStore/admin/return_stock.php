<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<fieldset>
	<legend>List of Returned Stock</legend>
	
	<table class="table table-stripped">
		<thead>
			<tr>
				<th>S. No.</th>
				<th>Product Name</th>
				<th>Return Quantity</th>
				<th>Unit Price</th>
				<th>Vendor Name</th>
                <th>Remark</th>
                <th>Date</th>
			</tr>
		</thead>
		
		<tbody>
			<?php 
			    $sql="SELECT MD.medicine_name,RS.Qunatity,RS.unit_price,VN.Name,RS.Reamrk,RS.date FROM returnstock AS RS 
                                INNER JOIN medicine AS MD ON MD.medicine_id=RS.ProductId 
                                INNER JOIN vendors AS VN ON VN.Id=RS.ven_id WHERE RS.`store_key`='$store_key'";
                $result=mysqli_query($con,$sql);
                $index 	= 0;
				if($result && $result->num_rows > 0 )
                {
                    while($data = mysqli_fetch_row($result)){
              ?>
				
			<tr>
				<td><?php echo ++$index;?></td>
				<td><?php echo $data[0];?></td>
                <td><?php echo $data[1];?></td>
                <td><?php echo $data[2];?></td>
                <td><?php echo $data[3];?></td>
                <td><?php echo $data[4];?></td>
                <td><?php echo $data[5];?></td>
                
			</tr>
            
			<?php 
                }
                }
            ?>
		</tbody>
	</table>
</fieldset>




<?php
