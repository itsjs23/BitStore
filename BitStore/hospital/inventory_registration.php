<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {


            $("#distributor_validation").hide();
            $("#category_validation").hide();
            $("#medicine_validation").hide();
            $("#barcode_validation").hide();
            $("#quantity_validation").hide();
            $("#unit_validation").hide();
            $("#buy_unit_validation").hide();
            $("#mfg_validation").hide();
            $("#expiry_validation").hide();
            $("#success_msg").hide();

            $("#dist_id").change(function () {
                $("#success_msg").fadeOut();
                $("#distributor_validation").fadeOut();
            });


            $("#category_id").change(function () {
                $("#success_msg").fadeOut();
                $("#category_validation").fadeOut();
            });


            $("#medicine_id").change(function () {
                $("#success_msg").fadeOut();
                $("#medicine_validation").fadeOut();
            });

            $("#quantity").keypress(function () {
                $("#success_msg").fadeOut();
                $("#quantity_validation").fadeOut();
            });

            $("#cost").keypress(function () {
                $("#success_msg").fadeOut();
                $("#unit_validation").fadeOut();
            });

            $('#dp4').datepicker()
                            .on('changeDate', function (ev) {
                                startDate = new Date(ev.date);
                                $('#payment_date').val($('#dp4').data('date'));
                                $('#dp4').datepicker('hide');
                            });



            $("#btn_save").click(function () {

                var distributor = document.myform.dist_id.value;
                var medicine = document.myform.medicine_id.value;
                var quantity = document.myform.quantity.value;
                var buy_cost = $('#buy_cost').val(); //document.myform.buy_cost.value;
                var unit_cost = document.myform.cost.value;
                var payment_dat = document.myform.payment_date.value;
                var counter = 0;

                if (medicine == "") {
                    counter++;
                    if (counter == 1)
                        $('#medicine_id').focus();
                    $("#medicine_validation").fadeIn();
                }

                if (quantity == "") {
                    counter++;
                    if (counter == 1)
                        $('#quantity').focus();
                    $("#quantity_validation").fadeIn();
                }

                if (unit_cost == "") {
                    counter++;
                    if (counter == 1)
                        $('#unit').focus();
                    $("#unit_validation").fadeIn();
                }

                //if(buy_cost=="")
                //{   counter++;
                //	if(counter==1)
                //    $('#buy_cost').focus();
                //    $("#buy_unit_validation").fadeIn();
                //}

                if (medicine == "" | quantity == "" | unit_cost == "")
                    return false;

                var productName = $('#medicine_id option:selected').text();
                var querystring = $("#myform").serialize();
                $.ajax({
                    type: 'POST',
                    url: 'admin/db/manage_inventory.php',
                    data: {
                        query: querystring,
                        productName: productName
                    },

                    success: function (html) {
                        var result = JSON.parse(html);
                        if (result['status'] == 'success') {
                            document.myform.reset();
                            $("#success_msg").fadeIn();
                        } else {
                            alert('Error Occur !!! ');
                        }
                    }
                });
            });
            $(".chosen-select").chosen();
        });
    })(jQuery);
</script>

<style type="text/css">
    .input-custom {
        width: 165px;
    }
</style>

<fieldset class="span8 offset2">
    <legend>Stock Form</legend>
    <form class="form-horizontal dhs-medical-form " id="myform" name="myform">

        <div class="control-group">
            <label class="control-label" for="name">Vendor Name:</label>
            <div class="controls">
                <select class="medicines-select" name="dist_id" id="dist_id">
                    <option value="">Select Distributor</option>
                    <?php 
                    $sql= 'SELECT `Id`, `Name` FROM `vendors`';
                    $result=mysqli_query($con,$sql);
                    while($vendor=mysqli_fetch_array($result))
                    {?><option value="<?php echo $vendor['Id'];?>"><?php echo $vendor['Name'];?></option><?php }?>
                </select>
                <div id="distributor_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Select Distributor</div>

            </div>
        </div>

        <?php 
        // get Category Name 
        $query_category_names= "SELECT `category_id`, `name`  FROM `category` WHERE `status`<> 0 AND  `store_key`='$store_key' ";
        $category_names=mysqli_query($con,$query_category_names);
        
        if(!$category_names){
            die(''.mysql_error());
        }
        ?>

        <div class="control-group">
            <label class="control-label" for="category_name">Category Name:</label>
            <div class="controls">
                <!--<select class="category-select chosen-select" name="category_id" id="category_id">-->
                <select class="category-select" name="category_id" id="category_id">
                    <option value="">Select Category</option>
                    <?php while($category=mysqli_fetch_array($category_names)){?>
                    <option value="<?php echo $category['category_id'];?>"><?php echo $category['name'];?></option><?php }?>
                </select>
                <div id="category_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Select Category.</div>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="name">Product Name:</label>
            <div class="controls">
                <select class="medicines-select " name="medicine_id" id="medicine_id">
                </select>
                <div id="medicine_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Select Product.</div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="quantity">Qunatity :</label>
            <div class="controls">
                <input type="text" id="quantity" name="quantity" placeholder="Qunatity" class="numeric-txt" required="" value="" >
                <div id="quantity_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Quantity.</div>

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="buy_cost">Unit Cost:</label>
            <div class="controls">
                <div class="input-prepend">
                    <button type="button" class="btn">Rs</button>
                    <input type="text" id="buy_cost" name="buy_cost" placeholder="Buy Unit Cost" required="" class="input-custom numeric-txt" value="" />
                </div>

                <div id="buy_unit_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">&nbsp;&nbsp;&nbsp;&nbsp;*Please Enter Unit Cost</div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="cost">Marginal Unit Cost:</label>
            <div class="controls">
                <div class="input-prepend">
                    <button type="button" class="btn">Rs</button>
                    <input type="text" id="cost" name="cost" placeholder="Sell Unit Cost" required="" value="" class="input-custom numeric-txt" >
                </div>

                <div id="unit_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">&nbsp;&nbsp;&nbsp;&nbsp;*Please Enter Unit Cost</div>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="batch_code">Batch Code:</label>
            <div class="controls">
                <input type="text" id="batch_code" name="batch_code" placeholder="Batch Code" value="" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="bill_number">Bill Number:</label>
            <div class="controls">
                <input type="text" id="bill_number" name="bill_number" placeholder="Bill Number" value="" />
            </div>
        </div>



        <div class="control-group">
            <label class="control-label" for="payment_date">Payment Date:</label>
            <div class="controls">
                <div class="input-append " style="margin-bottom: 0;">
                    <input type="text" name="payment_date" id="payment_date" required="" />
                    <span class="add-on"><i data-date="<?php echo date('Y-m-d')?>" data-date-format="yyyy-mm-dd" id="dp4" class="icon-calendar"></i></span>
                </div>
                <div id="expiry_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Expiry Date</div>
            </div>
        </div>


        <div class="control-group">
            <div class="controls">
                <input type="hidden" name="action" value="insert_inventory" id="action" />
                <button type="button" class="btn btn-primary" id="btn_save">Save</button>
                <!--<button type="reset" class="btn btn-primary offset1" >Reset</button>-->

            </div>
        </div>
        <div align="center" id="success_msg">
            <div style="width: 400px; height: 70px; font-family: Georgia, 'Times New Roman', Times, serif; font-size: 18px; color: #0C3;">*Stock Successfully Saved.</div>
        </div>
    </form>
</fieldset>

