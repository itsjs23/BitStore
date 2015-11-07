<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
  <table class="table table-striped">
        
        <tr><th>No</th><th>Username</th><th>Type</th><th>Status</th><th>Name</th><th>Mobile</th><th>EDIT</th><th>Delete</th></tr>

<?php
$store_key = $_SESSION['mystoreid'];

$sql= "select * from `users` where `store_key` = '$store_key' and `status` <> 0 and type <> 303";
$result=mysqli_query($con,$sql);
$n=0;
while($row = mysqli_fetch_assoc($result))
{
	$n++;
	if($row['type'] == 302){
		$type="Staff";
	}
	
	elseif($row['type'] == 301){
		$type="Admin";
	}
	
	else{
		$type = 'N/A';
	}
	
	
	if($row['Enable']==0)
	$show="InActive";
	else
	$show="Active";
	
?>
<tr class="row<?php echo $row['user_id']; ?>">
	<td><?php echo $n;?></td>
	<td><?php echo $row['username'];?></td>
	<td><?php echo $type;?></td>
	<!--<td><a href="index.php?view=manage_distributor&action=block_user&id=<?php //echo $row['user_id'];?>" ><?php //echo $show;?></a></td>-->
    <td><b><?php echo $show;?></b></td>
	<td><?php echo $row['Name'];?></td>
    <td><?php echo $row['Mobile'];?></td>
    <td><button type="button" class="edit-user" value="<?php echo $row['user_id']; ?>"><i class="icon-edit"></i></button>
    <td>
		<button type="button" class="user_delete"   value="<?php echo $row['user_id']; ?>" > <i class="icon-remove"></i></button>
	</td>
</tr>
<?php

	
}


?>    </table>



<!--edit modal-->
<div id="user-detail-update" class="modal hide fade" tabindex="-1" data-width="760">
    <div class=" btn btn-warning user-modal-header" style="background-color: #0480be; margin-left: 40%;">
    </div>
    <div class="user-modal-body">
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn  btn-primary" onclick="window.location.reload(true);">Close</button>
        <button type="button" class="btn  btn-warning user-product-details">Update</button>
    </div>
</div>

<script type="text/javascript">
(function($){
	$(document).ready(function(){

    // show user details In Modal
$('.edit-user').click(function () {
    var userId = $(this).val();
    var row = "row" + userId;
    var arr = ['','','Status', 'Name', 'Mobile'];
    var inc = 0;
    var htm = '<div class="table-responsive"><table class="table table-bordered table-striped table-condensed user-details-update"><tbody>';
    var obj = $("table ." + row).find("td");
    obj.each(function () {
        if(inc == 3){
             htm += '<tr><td>' + arr[inc - 1] + '</td>';
             htm += '<td><select name="user-Status" id="user-status">';
             if (arr[inc - 1] == 'InActive') {
                 htm += "<option value='active' >Active</option>";
                 htm += "<option value='inactive' selected>InActive</option> </select>";
             }
             else {
                 htm += "<option value='active' selected>Active</option>";
                 htm += "<option value='inactive' >InActive</option> </select>";
                }
             }

        if (inc == 4 || inc == 5) {
            htm += '<tr><td>' + arr[inc - 1] + '</td><td><input type="text" value="' + $(this).text() + '" id="edit' + arr[inc - 1] + '" style="height:30px;"/></td></tr>';
        }
        inc++;
    });
    htm += '<tr><td>Password</td><td><input type="password" value="12345"  id="editPassword" style="height:30px;"/></td></tr>';
    htm += '</tbody></table></div>';
    $('.user-modal-body').html(htm);
    $('.user-modal-header').html('<b>Edit Details</b>');
    $('.user-product-details').val(userId);
    $('#user-detail-update').modal('show');
    
});



// update user details
$('.user-product-details').click(function () {
    var id = $(this).val();
    var data = [];
    data.push(id); // user id
    $('.user-details-update').find('input').each(function () {
        data.push($(this).val());
    });
    data.push($('#user-status').val());

    if (data.length != 0) {
        $.ajax({
            type: 'POST',
            url: 'admin/db/manage_user.php',
            data: {
                query: data,
                action: 'update_user'
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
                $('.modal-header').html('<b>USER UPDATE</b>');
                $('#myModal').modal('show');
            }
        });


    }// if end 

});


    /// user delete 

$('.user_delete').click(function () {
    var userId = $(this).val();
    var didConfirm = confirm("Are you sure?");
        if (userId != "" && didConfirm == true) {
        $.ajax({
            type: 'POST',
            url: 'admin/db/manage_user.php',
            data: {
                query: userId,
                action: 'delete_user'
            },
            success: function (html) {
                var result = JSON.parse(html);
                if (result['status'] == 'success') {
                    $('.row' + userId).hide(); // hide deleted field
                }
                
            }
        });

    } else {
        alert('Problem Occur deleting User !!');
    }



})
	}); // document ready function end 
})(jQuery); 







</script>