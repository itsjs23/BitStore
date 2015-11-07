<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php 
$store_key = $_SESSION['mystoreid'];

?>

<fieldset class="span8 offset2">
    <legend>Add Expense Details</legend>

    <form class="form-horizontal dhs-medical-form " id="myform" name="myform" action="index.php?view=expense_registration&menu=account" method="post">
        <div class="control-group">
            <label class="control-label" for="particular">Particular:</label>
            <div class="controls">
                <input type="text" id="particular" name="particular" placeholder="Purpose of Expense" required="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="amount">Amount:</label>
            <div class="controls">
                <input type="text" id="amount" name="amount" placeholder="Amount" required="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="pay-mode">Paymode:</label>
            <div class="controls">
                <select id="paymode" name="paymode">
                    <option value="default">select One </option>
                    <option value="cash">By Cash</option>
                    <option value="cheque">By Cheque</option>
                </select>


            </div>
        </div>
        <div class="control-group cheque-block" style="display: none;">
            <label class="control-label" for="cheque-num">Cheque Number:</label>
            <div class="controls">
                <input type="text" id="cheque-num" name="cheque-num" placeholder="Cheque Number" required="" value="" />
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="remark">Remark:</label>
            <div class="controls">
                <input type="text" id="remark" name="remark" placeholder="Remark" required="" />
            </div>
        </div>


        <div class="control-group">
            <div class="controls">
                <button type="button" class="btn btn-primary" id="btn_save">Save</button>
            </div>
        </div>

    </form>
</fieldset>

<script type="text/javascript">
    $('#paymode').change(function () {
        var mode_type = $('#paymode').val();
        if (mode_type == 'cheque') {
            $('.cheque-block').css("display", "block");
        } else {
            $('.cheque-block').css("display", "none");
        }
    });

    $('#btn_save').click(function () {
        var data = $('#myform').serialize();
        $.ajax({
            type: 'POST',
            url: 'admin/db/manage_expenses.php',
            data: {
                data: data
            },
            success: function (html) {
                var data = JSON.parse(html);
                if (data['status'] == 'success') {
                    //clear fileds 
                    //$('input').each(function () { $(this).val(''); })
                    //$("#dropdown option:selected").text('select One ');

                    alert('Added SuccessFully !!');
                    window.location.reload(true);
                }
                else {
                    alert('Problem Occur !!');
                    window.location.reload(true);
                }

            }
        });

    });

</script>
