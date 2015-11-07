<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<fieldset>
	<legend>List of Available Stock</legend>
	
	<table class="table table-stripped">
		<thead>
			<tr>
				<th>S. No.</th>
				<th>Product Name</th>
				<th>Available Quantity</th>
				<th>Unit Price</th>
				<th>Vendor Name</th>
                <th>&nbsp;</th>
			</tr>
		</thead>
		
		<tbody>
			<?php 
				$store_key  = $_SESSION['mystoreid'];  
                $view_stock="SELECT MD.medicine_name, NI.`quantity`,NI.`buy_unit_cost`,VD.Name ,NI.inventory_id FROM `new_inventory` AS NI INNER JOIN `medicine` AS MD 
                ON MD.`medicine_id`=NI.`medicine_id`  INNER JOIN vendors AS VD ON VD.Id=NI.`distributor_id` WHERE  MD.status <>0 AND  MD.`store_key`='$store_key'";
                $reult=mysqli_query($con,$view_stock);
                $index 		= 0;
				if(mysqli_num_rows($reult) >0)
                {
				while($data = mysqli_fetch_row($reult)){
              ?>
				
			<tr class="row<?php echo $data[4]; ?>" >
				<td><?php echo ++$index;?></td>
				<td><?php echo $data[0];?></td>
                <td><?php echo $data[1];?></td>
                <td><?php echo round($data[2],2);?></td>
                <td><?php echo $data[3];?></td>
                <td><button type="button" class="return_stock" value="<?php echo $data[4];?>">Return </button></td>
                
			</tr>
            
			<?php 
                }
                }
            ?>
		</tbody>
	</table>
</fieldset>



<!--edit modal-->
<div id="stock-detail-update" class="modal hide fade" tabindex="-1" data-width="760">
    <div class=" btn btn-warning stock-modal-header" style="background-color: #0480be; margin-left: 40%;">
    </div>
    <div class="stock-modal-body">
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn  btn-primary" onclick="window.location.reload(true);">Close</button>
        <button type="button" class="btn  btn-warning stock-product-details">Update</button>
    </div>
</div>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {

            // show user details In Modal
            $('.return_stock').click(function () {
                var productId = $(this).val();
                var row = "row" + productId;
                var arr = ['Product Name','Return Qunatity'];
                var inc = 0;
                var htm = '<div class="table-responsive"><table class="table table-bordered table-striped table-condensed stock-details-update"><tbody>';
                var obj = $("table ." + row).find("td");
                obj.each(function () {
                    if (inc == 1 ) {
                        htm += '<tr><td>' + arr[inc - 1] + '</td><td><input type="text" value="' + $(this).text() + '" id="product_name" style="height:30px;" readonly/></td></tr>';
                    }
                    if (inc == 2) {
                        productId +="_"+$(this).text(); // productid_availQunatity 
                        htm += '<tr><td>' + arr[inc - 1] + '</td><td><input type="number" value="' + $(this).text() + '" min="1" max="' + $(this).text() + '" id="Retrn_quantity" style="height:30px;"/></td></tr>';
                    }
                    inc++;
                });
                htm += '<tr><td>Remark</td><td><input type="text" value="" id="user_remark" style="height:30px;"/></td></tr>';
                htm += '</tbody></table></div>';
                $('.stock-modal-body').html(htm);
                $('.stock-modal-header').html('<b>Return Qunatity</b>');
                $('.stock-product-details').val(productId);
                $('#stock-detail-update').modal('show');

            });



            // update user details
            $('.stock-product-details').click(function () {
                var info = $(this).val();
                var ProductInfo = info.split('_');
                var retnqunatity = parseInt($('#Retrn_quantity').val()) > 0 ? parseInt($('#Retrn_quantity').val()) : 0;
                var remark = $('#user_remark').val();
                var flag = 0;
                if (!(retnqunatity >= 1 && retnqunatity <= ProductInfo[1])) {
                    flag++;
                }
                var data = [];
                data.push(ProductInfo[0]); // product id
                data.push(retnqunatity); //return qunatity
                data.push(remark); // user Remark
              if (data.length != 0 && flag==0) {
                    $.ajax({
                        type: 'POST',
                        url: 'admin/db/return_stock.php',
                        data: {
                            query: data,
                            action: 'retn_stock'
                        },
                        success: function (html) {
                            var result = JSON.parse(html);
                            if (result['status'] == 'success') {
                                $('.modal-body').html('<p class="text-success  text-center" style="font-size:18px;" > Details Updated SuccessFully !! </p>');
                                //clear fileds
                            }
                            else {
                                $('.modal-body').html('<p class="text-danger text-center" style="font-size:18px;" > ' + result['msg'] + '');
                            }
                            $('.modal-header').html('<b>RETURN STOCK </b>');
                            $('#myModal').modal('show');
                        }
                    });


              }// if end 
              else {
                  var msg =" Rteurn qaunatity => 1  and <= "+ProductInfo[1];
                  alert(msg);
              }

            });


          
        }); // document ready function end 
    })(jQuery);

</script>


<?php
