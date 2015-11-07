<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $("#category").focus();
            $("#success_msg").hide();
            $("#category_validation").hide();
            $("#category").keypress(function () {
                $("#category_validation").fadeOut();
                $("#success_msg").fadeOut();
            });

            $("#btn_save").click(function () {
                var querystring = $("#myform").serialize();
                var user = document.myform.category.value;
                if (user == "") {
                    $('#category').focus();
                    $("#success_msg").fadeOut();
                    $("#category_validation").fadeIn();
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: 'admin/db/manage_category.php',
                    data: {
                        query: querystring,
                        action: 'insert_category'
                    },
                    success: function (html) {

                        var result = JSON.parse(html);
                        if (result['status'] == 'success') {
                            document.myform.reset();
                            $('#category').focus();
                            var msg = ' <div style="width: 400px; height: 70px; font-family: Georgia,Times, serif; font-size: 18px; color: #0C3;">*Category Successfully Saved.</div>';
                            $("#success_msg").html(msg);
                            $("#success_msg").fadeIn();
                        }
                        else {
                            document.myform.reset();
                            $('#category').focus();
                            var msg = ' <div style="width: 400px; height: 70px; font-family: Georgia,Times, serif; font-size: 18px; color: #F00;">' + result['status'] + '</div>';
                            $("#success_msg").html(msg);
                            $("#success_msg").fadeIn();

                        }

                    }
                });
            });
        });
    })(jQuery);
</script>


<fieldset class="span8 offset1">
    <legend>Product Category Form</legend>
    <div class="muted">Product Category: Like Furits, Bottle,veg etc.</div>
    <br />
    <form class="form-horizontal dhs-medical-form " id="myform" name="myform">
        <div class="control-group">
            <label class="control-label" for="username">Category Name:</label>
            <div class="controls">
                <input type="text" id="category" name="category" placeholder="Category" required="" value="">
                <div id="category_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Category</div>
            </div>
        </div>



        <div class="control-group">
            <div class="controls">
                <input type="hidden" name="action" id="action" value="insert_category" />
                <button type="button" class="btn btn-primary" id="btn_save">Save</button>
            </div>
        </div>

        <div align="center" id="success_msg">
            <div style="width: 400px; height: 70px; font-family: Georgia, 'Times New Roman', Times, serif; font-size: 18px; color: #0C3;">*Category Successfully Saved.</div>
        </div>
    </form>
</fieldset>

