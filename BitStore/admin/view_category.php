<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php $store_key = $_SESSION['mystoreid'];?>
  <table class="table table-striped">
        
        <tr><th>No</th><th>Category</th><th>Edit&nbsp;|&nbsp;Delete</th></tr>

<?php
include("config.php");
$sql= "Select * from category where `store_key` = '$store_key' and `status` <> 0";
$result=mysqli_query($con,$sql);
$n=0;
while($row=mysqli_fetch_array($result))
{
$n++;
?>
<tr class="row<?php echo $row['category_id'];?>"><td><?php echo $n;?></td><td><?php echo $row['name'];?></td>
<td><!--<a href="index.php?view=add_category&menu=medicine&id=<?php //echo $row['category_id'];?>"><i class="icon-edit"></i></a>-->
    <button type="button" class="cat_edit" value="<?php echo $row['category_id'].'_'.$row['name']; ?>"><i class="icon-edit"></i></button> 

<button type="button" class="dist_delete" data-source-id="<?php echo $row['category_id']; ?>" href="#"  onclick="javascript:void(0)"> <i class="icon-remove"></i></button>
</td>
</tr>
<?php
}
?>    </table>


 <!--edit modal-->
<div id="cat-detail-update" class="modal hide fade" tabindex="-1" data-width="760">
        <div class=" btn btn-warning cat-modal-header" style="background-color: #0480be;margin-left:40%;">
           <b>EDIT ACTEGORY </b>
        </div>
        <div class="cat-modal-body" >
        </div>
        <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn  btn-primary" onclick="window.location.reload(true);"> Close</button>
            <button type="button" class="btn  btn-warning update-cat-details" >Update</button>
        </div>
    </div>

<script type="text/javascript">
(function($){
	$(document).ready(function(){
		$(".dist_delete").click(function() {
			var didConfirm = confirm("Deleting Category Also Delete Product Inside of It !!");
			  if (didConfirm == true) {
				  var id = $(this).attr('data-source-id');
				  $.ajax({
						type: 'POST',
						url: 'admin/db/manage_category.php',
						data: {
						    id: id,
						    action: 'delete_category'
							
						},
						success: function (details) {
						    var result = JSON.parse(details);
						    if (result['status'] == 'success') {
						        var row = '.row' + id;
						        $(row).hide();
						    }
						    else {
						        alert("Error Occur !!");
						    }
							
						}
					});
			  }
		});
	});
})(jQuery);


    // show modal and cat- value in it 
$('.cat_edit').click(function () {
    var str = $(this).val().split('_');
    var htm = '<div class="table-responsive" style="magin-top:15px;"><table class="table table-bordered table-striped table-condensed"><tbody>';
    htm += '<tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td> Category Name </td><td><input type="text" id="update-cat-name" value="' + str[1] + '" style="height:30px;"/></td></tr>';
    htm += '<tr><td>&nbsp;</td><td id="cat-update-status">&nbsp;</td></tr></tbody></table>';
            htm += '</div>';

    $('.cat-modal-body').html(htm);
    $('.update-cat-details').val(str[0]);
    $('#cat-detail-update').modal('show');
});


    // update cat value 
$('.update-cat-details').click(function () {

    var cat_id = $(this).val();
    var cat_name = $('#update-cat-name').val();
    if(cat_name != ""){
        $.ajax({
            type: 'POST',
            url: 'admin/db/manage_category.php',
            data: {
                cat_id: cat_id,
                catName:cat_name,
                action: 'update_category'

            },
            success: function (details) {
                var result = JSON.parse(details);
                if (result['status'] == 'success') {
                    $('#cat-update-status').html('<p class="text-success">Updated SuccessFully !!</p>');
                }
                else {
                    $('#cat-update-status').html('<p class="text-error">Updated Failed !!</p>');
                  }
             }
        });

    }

    else {
        $('#cat-update-status').html('<p class="text-error">Type Category Name !!</p>');
    }



});













</script>

