<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<table class="table table-striped">
	<tr>
		<th>S.No.</th>
		<th>Product Name</th>
		<th>Available Quantity </th>
		<th>Unit Cost</th>
        <th>Sell Price</th>
        <th>Amount</th>
        <th>EDIT</th>
		
	</tr>
<?php
	
    $n=0;
    $stock_details="SELECT  MD.medicine_name, NI.`quantity`, NI.`unit_cost`, NI.`buy_unit_cost` , (NI.quantity * NI.`buy_unit_cost`) AS Amount ,NI.inventory_id FROM `new_inventory` AS NI INNER JOIN medicine AS MD ON MD.medicine_id=NI.medicine_id 
   where  NI.`store_key` = '$store_key' and MD.`status` <> 0";
 $stock_result=mysqli_query($con,$stock_details);
 if( $stock_result && $stock_result-> num_rows > 0)
 {
 while($data = mysqli_fetch_row($stock_result))
	{
		$n++;
       ?>
    	<tr class="stock_row_<?php echo $n;?>">
			<td><?php echo ' '.$n;?></td>
            <td><?php echo $data[0] ;?> </td>
            <td><?php echo $data[1] ;?> </td>
            <td><?php echo round($data[3],2) ;?> </td>
            <td><?php echo round($data[2],2) ;?> </td>
            <td><?php echo round($data[4],2) ;?> </td>
            <td><button type="button" class="show-stock_data" value="<?php echo $n.'_'.$data[5];?>"> <i class="icon-edit"></i></button>
		</tr>
<?php
}}
?>
</table>


 <!--edit modal-->
<div id="stock-detail-update" class="modal hide fade" tabindex="-1" data-width="760">
        <div class=" btn btn-warning stock-modal-header" style="background-color: #0480be;margin-left:40%;">
           
        </div>
        <div class="stock-modal-body" >
        </div>
        <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn  btn-primary" onclick="window.location.reload(true);"> Close</button>
            <button type="button" class="btn  btn-warning update-stock-details"  >Update</button>
        </div>
    </div>



<script type="text/javascript">
    // view Stock Details In Modal 
    $('.show-stock_data').click(function () {
        var str = $(this).val().split('_');
        var SrNo = "stock_row_" + str[0].trim();
        var arr = ['','','','Unit Cost','Sell Price'];
        var inc = 0;
        var htm = '<div class="table-responsive"><table class="table table-bordered table-striped table-condensed stock-details-update"><tbody>';
        var obj = $("table ." + SrNo).find("td");
        //var len = obj.length;
        obj.each(function () {
            if (inc == 3 || inc == 4) {
                htm += '<tr><td>' + arr[inc] + '</td><td><input type="text" value="' + $(this).text() + '" id="edit' + arr[inc] + '" style="height:30px;"/></td></tr>';
            }
            inc++;
        });

        htm += '<tr><td>&nbsp;</td><td class="stock-update-status"> </td></tbody></table></div>';
        $('.stock-modal-body').html(htm);
        $('.stock-modal-header').html('<b>Edit Details</b>');
        $('.update-stock-details').val(str[1]);
        $('#stock-detail-update').modal('show');


    });

    //update  unit cost and sell cost 

    $('.update-stock-details').click(function () {

        var id = $(this).val();
        var flag = 0;
        var data = [];
        data.push(id); // store id
        $('.stock-details-update').find('input').each(function () {
            data.push($(this).val());
            if (!parseFloat($(this).val()) > 0) {
                flag++;
            }
        });
        if (data.length != 0 && flag ==0) {
            $.ajax({
                type: 'POST',
                url: 'admin/db/edit_stock_items.php',
                data: {
                    query: data
                 },
                success: function (html) {
                    var result = JSON.parse(html);
                    if (result['status'] == 'success') {
                        $('.stock-update-status').html('<p class="text-success  text-center" style="font-size:18px;" > Details Updated SuccessFully !! </p>');
                    }
                    else {
                        $('.stock-update-status').html('<p class="text-danger text-center" style="font-size:18px;" > ' + result['msg'] + '');
                    }
                }
            });


        }// if end 


    });







</script>
