<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<script type="text/javascript">
(function($){
	$(document).ready(function() {
		$(".chosen-select").chosen();
		
		$(".send_request").click(function(){
			var medicine_id = $(this).attr('id');
			var distributor_id = '.distributor'+medicine_id;
			var quantity_id = '.quantity'+medicine_id;
	
			var distributor = $(distributor_id).val();
			var quantity = $(quantity_id).val();
			quantity = parseInt(quantity);

			if(quantity > 0){
				$.ajax({
					type: 'POST',
					url: 'index.php?view=manage_inventory',
					data: {
						querystring:'data',
						medicine: medicine_id,
						distributor: distributor,
						quantity: quantity,
						action: 'request_inventory'
					},
					success:function(html){
						var request_btn = "#request_button" + medicine_id;
						$(request_btn).html('<button class="btn btn-success">Request Sent</button>');
						$(quantity_id).attr('readonly', 'readonly');
					}
				});
			}
		});
	});
})(jQuery);
</script>

Stock Below 10.
<table class="table table-stripped">
	<tr>
		<th>S. No.</th>
		<th>Product Name</th>
		<th>Avaiable Quantity</th>
		<th>Prchage Amount</th>
		<th>Vendor Name</th>
		<!--<th>&nbsp;</th>-->
	</tr>
	<?php 
	
	// Retrive all distributors list
	$distributors = array();
    $i=0;
    $out_of_stock="SELECT MD.medicine_name, NI.`quantity`,NI.`buy_unit_cost`,VD.Name FROM `new_inventory` AS NI INNER JOIN `medicine` AS MD ON MD.`medicine_id`=NI.`medicine_id` 
       INNER JOIN vendors AS VD ON VD.Id=NI.`distributor_id` WHERE  MD.status <>0 AND MD.`store_key`='$store_key' AND  NI.`quantity` < MD.minLimit ";
 $result_stock=mysqli_query($con,$out_of_stock);
    if(mysqli_num_rows($result_stock) >0)
    {
        while($data = mysqli_fetch_row($result_stock)){
       ?>
            <tr>
				<td><?php echo ++$i;?></td>
				<td><?php echo $data[0];?></td>
                <td><?php echo $data[1];?></td>
                <td><?php echo round($data[2],2);?></td>
                <td><?php echo $data[3];?></td>
                
				
			</tr>
		<?php	
		
        }
        
    
    }
        		
	?>
</table>
