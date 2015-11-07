<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $("#username_validation").hide();
            $("#password_validation").hide();
            $("#type_validation").hide();
            $("#success_msg").hide();

            $("#username").keypress(function () {
                $("#success_msg").fadeOut();
                $("#username_validation").fadeOut();
            });

            $("#passsword").keypress(function () {
                $("#success_msg").fadeOut();
                $("#password_validation").fadeOut();
            });

            $("#user_type").change(function () {
                $("#success_msg").fadeOut();
                $("#type_validation").fadeOut();
            });


            $("#user_validation").click(function () {
                var user = $("#username").val();

                if (user == "") {
                    $("#username_validation").show();
                    $("#username_validation").html('Username field cannot be empty.');
                    $("#btn_save").attr('disabled', 'disabled');
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: 'admin/db/manage_user.php',
                        data: {
                            username: user,
                            action: 'verify_user'
                        },
                        success: function (details) {
                            var count = JSON.parse(details);
                            if (count['status'] == 'success') {
                                $("#username_validation").show();
                                $("#username_validation").html('Username already exists');
                                $("#username_validation").css('color', 'red');
                                $("#btn_save").attr('disabled', 'disabled');
                            } else {
                                $("#username_validation").show();
                                $("#username_validation").html('Congratulations, you can use this username');
                                $("#username_validation").css('color', 'green');
                                $("#btn_save").removeAttr('disabled');
                            }
                        }
                    });
                }
            });  // verify user END 

            // Insert User 
             $("#btn_save").click(function () {
                var username = document.myform.username.value;
                var password = document.myform.passsword.value;
                var type = document.myform.user_type.value;
                var counter = 0;
                if (username == "") {
                    counter++;
                    if (counter == 1)
                        $('#username').focus();
                    $("#username_validation").fadeIn();

                }
                if (password == "") {
                    $("#password_validation").fadeIn();
                    if (counter == 0) {
                        counter++;
                        $('#passsword').focus();
                    }
                }

                if (type == "") {
                    $("#type_validation").fadeIn();
                    if (counter == 0) {
                        counter++;
                        $('#type').focus();
                    }
                }

                if (username == "" | password == "" | type == "")
                    return false;

                var querystring = $("#myform").serialize();

                $.ajax({
                    type: 'POST',
                    url: 'admin/db/manage_user.php',
                    data: {
                        query: querystring,
                        action: 'add_user'

                    },

                    success: function (html) {
                        var result = JSON.parse(html);
                        if (result['status'] == 'success') {
                            var msg = '<div style="width: 400px; height: 70px; font-family: Georgia, \'Times New Roman\', Times, serif; font-size: 18px; color: #0C3;">*User Successfully Saved.</div>';
                            $("#success_msg").html(msg);
                            $("#success_msg").fadeIn();
                            document.myform.reset();
                        } else {
                            var msg = '<div style="width: 400px; height: 70px; font-family: Georgia, \'Times New Roman\', Times, serif; font-size: 18px; color: #F00;">*User Registration failed .</div>';
                            $("#success_msg").html(msg);
                            $("#success_msg").fadeIn();
                            document.myform.reset();
                        }
                        //$("#setbody").html(html);
                    }
                });
               }); // add Use END
        });
    })(jQuery);
</script>

<fieldset class="span8 offset2">
    <legend>User Form</legend>
    <?php $id='';$username='';?>
    <form class="form-horizontal dhs-medical-form " id="myform" name="myform">
        <div class="control-group required">
            <label class="control-label" for="username">Username:</label>
            <div class="controls">
                <input type="text" id="username"  required="" <?php echo ($id != '' ? 'readonly="readonly"' : '');?>  name="username" placeholder="Username" value="<?php echo  $username;?>" style="width:141px">
                <?php if($id == ''):?>
                <button type="button" class="btn" id="user_validation">Verify</button><?php endif;?>
                <div id="username_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Username</div>

            </div>
        </div>

        <div class="control-group required">
            <label class="control-label" for="passsword">Password:</label>
            <div class="controls">
                <input type="password" id="passsword" name="passsword" placeholder="Password" required="">
                <div id="password_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Password</div>

            </div>
        </div>


        <div class="control-group required">
            <label class="control-label" for="Type">User Type:</label>
            <div class="controls">

                <select name="user_type" id="user_type">
                    <option value="">Select User</option>
                    <option value="301">Admin</option>
                    <option value="302">Staff</option>
                </select>
                <div id="type_validation" style="color: #F00; font-family: Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Select User Type</div>

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="user_name">Name:</label>
            <div class="controls">
                <input type="text" id="user_name" name="user_name" placeholder="User Name" required="">
                <!-- <div id="password_validation" style="color:#F00; font-family:Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Password</div>-->

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="mobile">Mobile:</label>
            <div class="controls">
                <input type="number" id="mobile" name="mobile" placeholder="mobile" required="">
                <!-- <div id="password_validation" style="color:#F00; font-family:Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Mobile</div>-->

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="user_address">Address:</label>
            <div class="controls">
                <input type="text" id="user_address" name="user_address" placeholder="user address" required="">
                <!--<div id="password_validation" style="color:#F00; font-family:Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Enter Password</div>-->

            </div>
        </div>


        <div class="control-group">
            <div class="controls">
                <input type="hidden" name="action" id="action" value="insert_users" />
                <button type="button" class="btn btn-primary"   id="btn_save">Create</button>
                <!--<button type="reset" class="btn btn-primary offset1" id="">Reset</button>-->

            </div>
        </div>
        <div align="center" id="success_msg">
          
         </div>
    </form>
</fieldset>

