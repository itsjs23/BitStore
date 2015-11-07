<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Medical Management</title>

	<script type="text/javascript" src="../js/jquery.js"></script>
    <link rel="stylesheet" href="../css/chosen.css" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap-responsive.css" type="text/css" />
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap_tab.js"></script>
    <script type="text/javascript">
	  $(function() {

		  // IMP:- bug fix for dropdown menu in mobile device.
		  $('.dropdown-toggle').click(function(e) {
			  e.preventDefault();
			  setTimeout($.proxy(function() {
			    if ('ontouchstart' in document.documentElement) {
			      $(this).siblings('.dropdown-backdrop').off().remove();
			    }
			  }, this), 0);
			});
			
	    $('.dhs-datetimepicker').datetimepicker({
	      pickTime: false
	    });

	    $(".numeric-txt").keydown(function(event) {
	        // Allow: backspace, delete, tab, escape, enter and .
	        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
	             // Allow: Ctrl+A
	            (event.keyCode == 65 && event.ctrlKey === true) || 
	             // Allow: home, end, left, right
	            (event.keyCode >= 35 && event.keyCode <= 39)) {
	                 // let it happen, don't do anything
	                 return;
	        }
	        else {
	            // Ensure that it is a number and stop the keypress
	            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	                event.preventDefault(); 
	            }   
	        }
	    });
	  });
	</script>
	
	<style type="text/css">
		@media (min-width: 980px) {
			#divElement{
			    position: absolute;
			    top: 30%;
			    left: 30%;
			    width: 530px;
			    height: 200px;
			    overflow:hidden;
			}
		}
		
		@media (min-width: 768px) and (max-width: 980px) {
			#divElement{
			    position: absolute;
			    top: 20%;
			    left: 20%;
			    width: 530px;
			    height: 200px;
			    overflow:hidden;
			}
		}
		
	</style>
    
</head>

<body class="container" style="margin:0; width:99.9%;" >
	<div class="row-fluid check_it">
            <div class="span1 hidden-phone">&nbsp;</div>
            <div class="span3 dhs_logo">            
             	<img src="../img/dhs_logo.png" />
			</div>
             <div class="span8 hidden-phone">&nbsp;</div>
       </div>
       
       
	<?php session_start();
	if(!isset($_SESSION['myuserid'])):?>
	<div class="well" id="divElement">
		<fieldset>
			<legend>DHS Admin Login</legend>
			<form class="form-horizontal" method="post" action="verify_user.php">
			  <div class="control-group">
			    <label class="control-label" for="admin_email" autocomplete="off">Username</label>
			    <div class="controls">
			      <input type="text" id="admin_email" name="admin_email" placeholder="Email" />
			    </div>
			  </div>
			  <div class="control-group">
			    <label class="control-label" for="inputPassword">Password</label>
			    <div class="controls">
			      <input type="password" id="admin_password" name="admin_password" placeholder="Password" />
			    </div>
			  </div>
			  <div class="control-group">
			    <div class="controls">
			      <button type="submit" class="btn">Sign in</button>
			    </div>
			  </div>
			</form>
		</fieldset>
	</div>
	
	<?php else:?>
	
	<?php 
	
	require_once '../config.php';
	require_once '../defines.php';
	define('DHS_STORE_SALT', 'dhs_hospital');
	?>
	
	<div class="row-fluid">
		<div class="span1 hidden-phone">&nbsp;</div>
		<div class="navbar span10">
		    <div class="navbar-inner">
		        <div class="container">
			        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			        <span class="icon-th-list"></span></a>
			        <div class="nav-collapse collapse">
			            <ul class="nav nav-pills">
			                <li class="<?php echo isset($_GET['menu']) && $_GET['menu'] == 'add' ? 'active': '';?>"><a href="<?php echo DHS_ROOT;?>dhs/index.php?view=add_store&menu=add">Add outlate</a></li>
			                <li class="<?php echo isset($_GET['menu']) ? '': 'active';?>"><a href="<?php echo DHS_ROOT;?>dhs/index.php?view=store_details">View Stores</a></li>
					        <li class="pull-right"><a href="<?php echo DHS_ROOT;?>logout.php">Logout</a></li>
			            </ul>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="span1 hidden-phone">&nbsp;</div>
	</div>
	
		<div class="row-fluid">
			<div class="span2">&nbsp;</div>
			<div class="span8">
				<?php
					$view = isset($_GET['view']) ? $_GET['view'] : null;
					if(!empty($view)){
						require_once $view.'.php';
					}
				?>
			</div>
			<div class="span2">&nbsp;</div>
		</div>
		
	<?php endif;?>
	
</body>

</html>
<?php
