<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Inventory Management</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.ui.dialog.js"></script>
    <link rel="stylesheet" href="css/chosen.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.ui.dialog.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.ui.theme.css" type="text/css" />
    <!-- <link rel="stylesheet" href="css/style.css" type="text/css" />-->
    <link rel="stylesheet" href="css/screen.css" type="text/css" />

    <link href="img/dl.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

    <style>
        .control-group.required .control-label:after {
            content: "*";
            color: red;
        }
    </style>


    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript" src="js/livequery.js"></script>
    <script type="text/javascript" src="js/chosen.jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>

    <script type="text/javascript" src="js/bootstrap_tab.js"></script>

    <script type="text/javascript">
        $(function () {

            // IMP:- bug fix for dropdown menu in mobile device.
            $('.dropdown-toggle').click(function (e) {
                e.preventDefault();
                setTimeout($.proxy(function () {
                    if ('ontouchstart' in document.documentElement) {
                        $(this).siblings('.dropdown-backdrop').off().remove();
                    }
                }, this), 0);
            });

            $('.dhs-datetimepicker').datetimepicker({
                pickTime: false
            });

            $(".numeric-txt").keydown(function (event) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(event.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (event.keyCode >= 35 && event.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                else {
                    // Ensure that it is a number and stop the keypress
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                        event.preventDefault();
                    }
                }
            });
        });
    </script>

    <link href="css/menu.css" rel="stylesheet" type="text/css" />
    <script src="js/script.js"></script>

    <style>
        html, body {
            height: 93.5%;
        }

        #mystoreid, #myusername, #mypassword {
            height: 16px;
            font-size: 13px;
            border-radius: 2px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
        }

        #login-btn {
            line-height: 16px;
        }
    </style>
</head>

<?php session_start();
$user = isset($_SESSION["type"]) ? $_SESSION["type"] : '';
?>

<body class="container set_text" style="margin:0; width:99.9%;<?php echo empty($user) ? "background-image:url('img/ecg.png'); background-repeat:repeat repeat;" : ''; ?>">
    <div class="row-fluid" style="height: auto; min-height: 100%; overflow: hidden;">

        <?php require_once 'config.php';?>
        <?php require_once 'defines.php';?>
        <?php require_once 'helper.php';?>

        <?php define('DHS_DEFINES', 'development');?>

        <?php $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'index'; ?>

        <?php if($user == 301):?>
        <div class="row-fluid">
            <div class="" style="background: #21b6f4; color: #FFF; padding: 10px 0 0 0; margin-bottom: 0px; height: 80px; box-shadow: 0px 0px 5px rgba(0,0,0,56);">
                <h2 class="set_text" style="color: #fff; padding: 0px 0 0 20px; text-shadow: 1px 1px #000;">Welcome <?php echo ucfirst($_SESSION['myusername']);?></h2>
            </div>
            <div class="span1">&nbsp;</div>
            <div class="span10" style="min-height: 200px;">
                <?php include_once("admin/index.php");?>
            </div>
            <div class="span1">&nbsp;</div>
        </div>


        <?php elseif($user == 302): ?>
        <div class="row-fluid">
            <div class="hospital-header">
                <h2 class="set_text" style="color: #fff; padding: 25px; text-shadow: 1px 1px #000;">Welcome <?php echo ucfirst($_SESSION['myusername']);?></h2>
            </div>

            <div class="span10 offset1" style="min-height: 200px;">
                <?php include_once("hospital/index.php"); ?>
            </div>
            <div class="span1">&nbsp;</div>
        </div>



        <?php else : ?>
        <div class="row-fluid check_it">
            <div class="span1 hidden-phone"></div>
            <div class="span3 dhs_logo">
                <p style="font-style:italic;font-size:30px;font-family:Arial;color:#fff; ">BitStore</p>
                <!--<img src="img/dhs_logo.png" />-->
            </div>
            <div class="span7">
                <div class="hidden-phone">
                    <form method="post" action="check_login.php" style="margin-top: 1px; padding: 10px;" name="myform" class="form-inline dhs-medical-form pull-right">
                        <!-- <div><input type="text" id="mystoreid" name="mystoreid" placeholder="Store Id" required="" style="width:263px;" /></div>-->
                        <div style="margin-top: 5px;">
                            <input type="text" id="myusername" name="myusername" placeholder="Enter UserName" required="" class="input-small" />
                            <input type="password" id="mypassword" name="mypassword" placeholder="Password" required="" class="input-small" />
                            <input type="submit" class="btn btn-success" id="login-btn" value="Login" />
                        </div>

                    </form>
                </div>
            </div>
            <div class="span1 hidden-phone">
                &nbsp;
            </div>
        </div>

    <!--    <div class="visible-phone" style="margin-top: 40px; text-align: center;">
            <!--<form method="post" action="check_login.php" name="myform" class="form-horizontal dhs-medical-form">
                <div class="control-group">
                    <div class="controls">
                        <input type="text" class="input-large" style="padding: 20px;" id="mystoreid" name="mystoreid" placeholder="Store Id" required="" />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="text" class="input-large" style="padding: 20px;" id="myusername" name="myusername" placeholder="Username" required="" />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="password" class="input-large" style="padding: 20px;" id="mypassword" name="mypassword" placeholder="Password" required="" />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-info btn-large pull-right" type="button">Login</button>
                    </div>
                </div>
            </form>-->

        </div>-->

        <?php if($user == 'invalid_credentials'):?>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $(".remove-msz").click(function () {
                        $(".invalid-msz").hide();
                    });
                });

            })(jQuery);
        </script>
        <div class="row-fluid invalid-msz">
            <div class="span3">&nbsp;</div>
            <div class="span6 alert alert-error"><span>The store-id, username or password is incorrect.</span> <span class="pull-right"><a href="#" class="remove-msz"><i class="icon-remove"></i></a></span></div>
            <div class="span3">&nbsp;</div>
        </div>
        <?php endif;?>

    <!--    <div class="row-fluid hidden-phone">
        <div class="span3">&nbsp;</div>
            <div class="check_tt span6" style="margin-top: 50px; max-width: 670px; border-radius: 129px; background-image: url('img/capsule.png');">

                <div style="margin: 0px 5px; padding: 10px;" name="myform" class="row-fluid">
                    <div class="span1">&nbsp;</div>
                    <div class="search-query span10" style="margin-top: 91px;">
                        <input class="span1" id="store_id" placeholder="Store Id" name="store_id" style="width: 20%; max-width: 150px; padding: 20px;" type="text" />
                        <input class="span1" id="search" placeholder="Type your search query here" name="search" style="width: 70%; max-width: 380px; padding: 20px;" type="text" />
                    </div>

                    <div class="span1">&nbsp;</div>

                </div>
            </div>
            <div class="span3">&nbsp;</div>
        </div>-->

        <div style="margin-top: 50px; margin-left: 340px; width: 680px;">
            <div id="search_results">
            </div>
        </div>


        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $("#search").keypress(function (e) {
                        do_search();
                    });
                });
            })(jQuery);

            function do_search() {

                var search = $("#search").val();
                var store_id = $("#store_id").val();
                $.ajax({
                    type: 'POST',
                    url: 'search_results.php',
                    data: {
                        search: search,
                        store_id: store_id
                    },
                    success: function (details) {
                        $("#search_results").addClass('well');
                        $("#search_results").html(details);
                    }
                });

            }
        </script>

        <?php endif; ?>

    </div>

    <div class="row-fluid text-center hidden-phone" style="bottom: 0; background: #21b6f4; color: #FFF; box-shadow: 0px 0px 5px rgba(0,0,0,56);">
        <address style="line-height: 17px; margin-top: 8px;">
           BITBLUE TECHNOLOGY
                <br />
                G1 Ostwal Nagari , Building No. 2A,<br />
                opp Muthoot Finance,Next to Central Park,<br/>
                Nallasopara(East),Palghar,Maharashtra -401209<br />
                <abbr title="Phone">Tel:</abbr>
                +91 250-3297961  
        </address>

    </div>

    <div class="row-fluid text-center visible-phone" style="margin-top: -10px; bottom: 0; z-index: 1; background: #21b6f4; color: #FFF; padding: 5px 0; margin-bottom: 0px; height: 95px; box-shadow: 0px 0px 5px rgba(0,0,0,56);">
        <footer>
            <address>
                BITBLUE TECHNOLOGY
                <br />
                G1 Ostwal Nagari , Building No. 2A,<br />
                opp Muthoot Finance,Next to Central Park,<br/>
                Nallasopara(East),Palghar,Maharashtra -401209<br />
                <abbr title="Phone">Tel:</abbr>
                +91 250-3297961  
            </address>

        </footer>
    </div>

    <?php include_once 'myModal.php'?>

    <!--  <input type="hidden" id="hidden_store_key " value="<?php echo $store_key?>" />-->
    <script src="js/admin_script.js" type="text/javascript"></script>

</body>


</html>

