<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<div class="row-fluid">
    <fieldset class="span9 offset1">
        <legend>Salary Details</legend>

        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>User Name</th>
                    <th>Salary</th>
                    <th>Nofiy Day</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                $store_key = $_SESSION['mystoreid'];
                $result = mysqli_query($con,"select users.username as username, salary.* from `salary` join `users` on (salary.user_id = users.user_id and users.`store_key` = '$store_key')");
                $index = 0;
                while($record = mysqli_fetch_array($result)):
                ?>
                <tr class="row<?php echo $record['salary_id'];?>">
                    <td><?php echo ++$index;?></td>
                    <td><?php echo $record['username'];?></td>
                    <td><?php echo $record['salary'];?></td>
                    <td><?php echo $record['notify_day'];?></td>
                    <td>
                        <button type="button" value="<?php echo $record['salary_id'];?>" class="update-salary"><i class="icon-edit"></i></button>
                    </td>
                </tr>
                <?php endwhile;?>
            </tbody>
        </table>
    </fieldset>
    <div class="span2">&nbsp;</div>

</div>


<!--edit modal-->
<div id="salary-detail-update" class="modal hide fade" tabindex="-1" data-width="760">
    <div class=" btn btn-warning salary-modal-header" style="background-color: #0480be; margin-left: 40%;">
    </div>
    <div class="salary-modal-body">
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn  btn-primary" onclick="window.location.reload(true);">Close</button>
        <button type="button" class="btn  btn-warning salary-product-details">Update</button>
    </div>
</div>


<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {

            //////====  Edit Salaray =====/////

            $('.update-salary').click(function () {

                var userId = $(this).val();
                var row = "row" + userId;
                var arr = ['salary','NotifyDate'];
                var inc = 0;
                var htm = '<div class="table-responsive"><table class="table table-bordered table-striped table-condensed salary-details-update"><tbody>';
                var obj = $("table ." + row).find("td");
                obj.each(function () {
                    if (inc == 2|| inc == 3) {
                        htm += '<tr><td>' + arr[inc - 2] + '</td><td><input type="text" value="' + $(this).text() + '" id="edit' + arr[inc - 1] + '" style="height:30px;"/></td></tr>';
                    }
                    inc++;
                });
                htm += '</tbody></table></div>';
                $('.salary-modal-body').html(htm);
                $('.salary-modal-header').html('<b>Edit Salary</b>');
                $('.salary-product-details').val(userId);
                $('#salary-detail-update').modal('show');

            }); // salray show in Model END 

            // update Salary 

            $('.salary-product-details').click(function () {
                var id = $(this).val();
                var data = [];
                data.push(id); // user id
                var flag = 0;
                var inc = 0;
                var msg = "";
                $('.salary-details-update').find('input').each(function () {
                    if (inc == 0) {
                        var amount = parseFloat($(this).val()) > 0 ? $(this).val() : 0;
                        if (amount == 0) {
                            flag++;
                            msg += "Enter Valid Salary !! ";
                        }

                    } else {
                        var amount = parseFloat($(this).val()) > 0 ? $(this).val() : 0;
                        if (!(amount >= 1 && amount <= 31)) {
                            flag++;
                            msg += "Enter Nofication date b/w 1-31 !!";
                        }
                    }
                    inc++;
                    data.push($(this).val());
                });
                if (data.length != 0 && flag ==0) {
                    $.ajax({
                        type: 'POST',
                        url: 'admin/db/manage_salary.php',
                        data: {
                            query: data,
                            action: 'update_salary'
                        },
                        success: function (html) {
                            var result = JSON.parse(html);
                            if (result['status'] == 'success') {

                                alert('Updated Success fully !!');
                            }
                            else {
                                alert('Updation Failed !!');
                            }
                        }
                    });


                }// if end 
                else {

                    alert(msg);
                }

            });





        }); // document ENd
    })(jQuery);
</script>


<?php
