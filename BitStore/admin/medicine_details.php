<?php if ( !defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>

<table class="table table-striped">
    <tr>
        <th>No</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Ingrediants</th>
        <th>Is Generic</th>
        <th>Manufacturer</th>
        <th>EDIT &nbsp;|&nbsp;DELETE</th>
    </tr>

    <?php
	$sql	= "select * from medicine where `store_key` = '$store_key' and `status` <> 0";
	
	// ***** Pagination Work Start ******
	$pageSql 	= $sql;
	$pageResult = mysqli_query($con,$pageSql);
	$count 		= mysqli_num_rows($pageResult);
	if($count > 0){
        $paginationCount = DhsHelper::getPagination($count);
	}
	// ***** Pagination Work End ******
	
	if(isset($_GET['page_id']) && !empty($_GET['page_id'])){
        $page_id = $_GET['page_id'];
	}else{
        $page_id = '0';
	}
	
	$pageLimit = PAGE_PER_NO * $page_id;
	$sql .= " limit $pageLimit,".PAGE_PER_NO;

	$result = mysqli_query($con,$sql);
	
	$n = 0;
	$categories = DhsHelper::getCategories($con);
	
	while($row=mysqli_fetch_array($result)){
		$n++;?>
    <tr class="row<?php echo $row['medicine_id']; ?>">
        <td><?php echo $n;?></td>
        <td><?php echo $row['medicine_name'];?></td>
        <td><?php echo $categories[$row['category_id']];?></td>
        <td><?php echo $row['ingrediants'];?></td>
        <td><?php echo ($row['is_generic'] == 1) ? 'Yes' : 'No';?></td>
        <td><?php echo $row['manufacturer'];?></td>
        <td>
            <button type="button" class="show-product-details" value="<?php echo $row['medicine_id'];?>">
                <i class="icon-edit"></i>
            </button>
            <!--<a href="index.php?view=medicine_registration&menu=medicine&medicine_id=<?php //echo $row['medicine_id'];?>">
					<i class="icon-edit"></i>
				</a>
				-->
            <button type="button" class="dist_delete" data-source-id="<?php echo $row['medicine_id']; ?>" href="#"  onclick="javascript:void(0)"><i class="icon-remove"></i></button>
        </td>
    </tr>
    <?php
	}
    ?>
</table>

<?php if($count > 0):?>
<div class="pagination text-center">
    <ul>
        <?php 
          for($i = 0; $i < $paginationCount; $i++):?>
        <li class="<?php echo ($page_id == $i) ? 'active' : 'disabled';?>">
            <a  href="<?php echo DHS_ROOT;?>index.php?view=medicine_details&menu=medicine&page_id=<?php echo $i;?>">
                <?php echo $i + 1;?>
            </a>
        </li>
        <?php endfor;?>
    </ul>
</div>

<!--edit modal-->
<div id="product-detail-update" class="modal hide fade" tabindex="-1" data-width="760">
    <div class=" btn btn-warning product-modal-header" style="background-color: #0480be; margin-left: 40%;">
    </div>
    <div class="product-modal-body">
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn  btn-primary" onclick="window.location.reload(true);">Close</button>
        <button type="button" class="btn  btn-warning update-product-details">Update</button>
    </div>
</div>



<?php endif;?>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $(".dist_delete").click(function () {
                var didConfirm = confirm("Are you sure?");
                if (didConfirm == true) {
                    var id = $(this).attr('data-source-id');
                    $.ajax({
                        type: 'POST',
                        url: 'admin/db/manage_medicine.php',
                        data: {
                            action: 'delete_medicine',
                            medicine_id: id
                        },
                        success: function (details) {
                            var row = '.row' + id;
                            $(row).hide();
                        }
                    });
                }
            });
        });
    })(jQuery);

    // show Product Details  in modal
    $('.show-product-details').click(function () {
        var mId = $(this).val();
        var className = "row" + mId.trim();
        var arr = ['Product Name', 'Category', 'Ingrediants', 'Is Generic', 'Manufacturer', 'state', 'country'];
        var inc = 0;
        var htm = '<div class="table-responsive"><table class="table table-bordered table-striped table-condensed product-details-update"><tbody>';
        var obj = $("table ." + className).find("td");
        var len = obj.length;
        obj.each(function () {
            if (inc != 0 && inc != len - 1) {
                htm += '<tr><td>' + arr[inc - 1] + '</td><td><input type="text" value="' + $(this).text() + '" id="edit' + arr[inc - 1] + '" style="height:30px;"/></td></tr>';
            }
            inc++;
        });

        htm += '</tbody></table></div>';
        $('.product-modal-body').html(htm);
        $('.product-modal-header').html('<b>Edit Details</b>');
        $('.update-product-details').val(mId);
        $('#product-detail-update').modal('show');
    });

    // update product details 
    $('.update-product-details').click(function () {
        var id = $(this).val();
        var data = [];
        data.push(id); // store id
        $('.product-details-update').find('input').each(function () {
            data.push($(this).val());
        });

        if (data.length != 0) {
            $.ajax({
                type: 'POST',
                url: 'admin/db/manage_medicine.php',
                data: {
                    query: data,
                    action: 'update_medicine'
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
                    $('.modal-header').html('<b>VENDOR</b>');
                    $('#myModal').modal('show');
                }
            });


        }// if end 

    });









</script>
