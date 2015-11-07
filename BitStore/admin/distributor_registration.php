<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<script type="text/javascript">

    $().ready(function () {
        $("#vendor_successMsg").css("display", "none");
        $("#myform").validate({
            rules: {
                vendor_name: "required",
                shopname: "required",
                // mobile: "required",
                mobile: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                }

                // address: "required"
                //city: "required",
                //state: "required",
                //country: "required",
                //email: {
                //    required: true,
                //    email: true
                //},

            },
            messages: {
                vendor_name: "Please enter Vendor Name",
                shopname: "Please enter Shop Name",
                mobile: "Enter Valid 10-digit Mobile number "
                //city: "Please enter city Name ",
                //state: "Please enter state Name ",
                //country: "Please enter country Name",
                //email: "Please enter a valid email address"
            },
            submitHandler: function (form) {
                var querystring = $("#myform").serialize();
                $.ajax({
                    type: 'POST',
                    url: 'admin/db/manage_distributor.php',
                    data: {
                        query: querystring,
                        action: 'insert_vendor'
                    },
                    success: function (html) {
                        var result = JSON.parse(html);
                        if (result['status'] == 'success') {
                            $('.modal-body').html('<p class="text-success  text-center" style="font-size:18px;" > Vendor Added SuccessFully !! </p>');
                            //clear fileds
                            $('#myform').find('input').each(function () {
                                $(this).val('');
                            });
                            $('#address').val('');
                            $('.btn_vendor').val('Submit');  // give btn name Submit 
                        }
                        else {
                            $('.modal-body').html('<p class="text-danger text-center" style="font-size:18px;" > ' + result['msg'] + '');
                        }
                        $('.modal-header').html('<b>VENDOR</b>');
                        $('#myModal').modal('show');
                       }
                });

            }

        });
    });

</script>


<fieldset class="span8 offset2" id="setbody">
    <legend>Vendor Form</legend>
    <form class="form-horizontal bitstore-form-control" name="myform" id="myform">

        <div class="control-group required">
            <label class="control-label" for="vendor_name">Vendor Name:</label>
            <div class="controls">
                <input type="text" id="vendor_name" name="vendor_name" required="" placeholder="Vendor Name" value="">
            </div>
        </div>


        <div class="control-group required">
            <label class="control-label" for="shopname">Shop Name:</label>
            <div class="controls">
                <input type="text" id="shopname" name="shopname" required="" placeholder="Shop Name" value="">
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="email">Email:</label>
            <div class="controls">
                <input type="email" id="email" name="email" placeholder="Email" value="">
            </div>
        </div>

        <div class="control-group required">
            <label class="control-label" for="mobile">Mobile No:</label>
            <div class="controls">
                <input type="text" id="mobile" name="mobile" maxlength="10" placeholder="Mobile" value="" required="">
            </div>
        </div>


        <div class="control-group">
            <label class="control-label " for="address">Address:</label>
            <div class="controls">
                <textarea name="address" id="address"></textarea>
            </div>
        </div>



        <div class="control-group">
            <label class="control-label" for="city">City:</label>
            <div class="controls">
                <input type="text" id="city" name="city" placeholder="City" value="">
            </div>
        </div>



        <div class="control-group">
            <label class="control-label" for="state">State:</label>
            <div class="controls">
                <input type="text" id="state" name="state" placeholder="state" value="">
            </div>
        </div>



        <div class="control-group">
            <label class="control-label" for="country">Country:</label>
            <div class="controls">
                <input type="text" id="country" name="country" placeholder="country" value="">
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <input type="submit" value="Submit" class="btn btn-primary btn_vendor" />
            </div>
        </div>
       </form>
</fieldset>
