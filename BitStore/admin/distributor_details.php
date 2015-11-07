<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<h4>Vendor List</h4>
<table class="table table-striped">
    <tr>
        <th>No</th>
        <th>Vendor Name</th>
        <th>Shop Name</th>
        <th>Email</th>
        <th>Mobile No</th>
        <th>City</th>
        <th>State</th>
        <th>Country</th>
        <th>EDIT</th>
    </tr>

    <?php
    $count = 0;
	$sql= "select * from vendors where  `status` <> 0 order by Id DESC";
	
	// ***** Pagination Work Start ******
	$pageSql = $sql;
	$pageResult = mysqli_query($con,$pageSql);
	$count = $pageResult->num_rows;
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
	$n=0;
	while($row = mysqli_fetch_array($result))
    {
        $n++;
    ?>
    <tr  class="vendorSrNo_<?php  echo $n; ?>">
        <td><?php echo $n;?></td>
        <td><?php echo $row['Name'];?></td>
        <td><?php echo $row['ShopName'];?></td>
        <td><?php echo $row['Email'];?></td>
        <td><?php echo $row['Mobile'];?></td>
        <td><?php echo $row['City'];?></td>
        <td><?php echo $row['State'];?></td>
        <td><?php echo $row['Country'];?></td>
        <td>
            <button type="button" class="edit-vendor-details" value="<?php echo $n.'_'.$row['Id'];?>"><i class="icon-edit"></i></button>
        </td>

    </tr>
    <?php
	}
    //}
    ?>
</table>

<?php if($count > 0):?>
<div class="pagination text-center">
    <ul>
        <?php 
          for($i = 0; $i < $paginationCount; $i++):?>
        <li class="<?php echo ($page_id == $i) ? 'active' : 'disabled';?>">
            <a  href="<?php echo DHS_ROOT;?>index.php?view=distributor_details&menu=distributor&page_id=<?php echo $i;?>">
                <?php echo $i + 1;?>
            </a>
        </li>
        <?php endfor;?>
    </ul>
</div>



 <!--edit modal-->
<div id="vendor-detail-update" class="modal hide fade" tabindex="-1" data-width="760">
        <div class=" btn btn-warning vendor-modal-header" style="background-color: #0480be;margin-left:40%;">
           
        </div>
        <div class="vendor-modal-body" >
        </div>
        <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn  btn-primary" onclick="window.location.reload(true);"> Close</button>
            <button type="button" class="btn  btn-warning update-vendor-details"  >Update</button>
        </div>
    </div>


<?php endif;?>

<script type="text/javascript">
    $('.edit-vendor-details').click(function () {
        var str = $(this).val().split('_');
        var SrNo = "vendorSrNo_" + str[0].trim();
        var arr = ['vendor Name', 'shop Name', 'Email', 'Mobile No', 'city', 'state', 'country'];
        var inc=0;
        var htm = '<div class="table-responsive"><table class="table table-bordered table-striped table-condensed vendor-details-update"><tbody>';
        var obj = $("table ." + SrNo).find("td");
        var len = obj.length;
        obj.each(function () {
            if (inc != 0 && inc != len-1) {
            htm += '<tr><td>' + arr[inc-1] + '</td><td><input type="text" value="' + $(this).text() + '" id="edit' + arr[inc-1] + '" style="height:30px;"/></td></tr>';
        }
            inc++;
        });

        htm += '</tbody></table></div>';
        $('.vendor-modal-body').html(htm);
        $('.vendor-modal-header').html('<b>Edit Details</b>');
        $('.update-vendor-details').val(str[1]);
        $('#vendor-detail-update').modal('show');

    });


    $('.update-vendor-details').click(function () {
        var id = $(this).val();
        var data = [];
        data.push(id); // store id
        $('.vendor-details-update').find('input').each(function () {
            data.push($(this).val());
        });

        if(data.length !=0)
        {
           $.ajax({
                type: 'POST',
                url: 'admin/db/manage_distributor.php',
                data: {
                    query: data,
                    action: 'update_vendor'
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


