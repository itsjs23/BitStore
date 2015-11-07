<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-th-list"></span></a>
        <div class="nav-collapse collapse">
            <ul class="nav nav-pills pull-right">
                
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'medicine' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Products <b class="caret"></b></a>
		            <ul class="dropdown-menu">
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=medicine_registration&menu=medicine">Add Product</a></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=medicine_details&menu=medicine">View Product</a></li>
		                <li class="divider"></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=add_category&menu=medicine">Add Category</a></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=view_category&menu=medicine">View Category</a></li>
		            </ul>
		        </li>
		        
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'stock' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Stock <b class="caret"></b></a>
		            <ul class="dropdown-menu">
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=inventory_registration&menu=stock">Add Stock</a></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=inventory_details&menu=stock">View Stock</a></li>
		                <li class="divider"></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=out_of_stock&menu=stock">Finished Stock <span class="badge badge-important"><?php echo DhsHelper::getFinishedStock($con);?></span></a></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=arrived_stock&menu=stock">Arrived Stock <span class="badge badge-info"><?php echo DhsHelper::getArrivedStock($con);?></span></a></li>
		            </ul>
		        </li>
		        
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'billing' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Billing <b class="caret"></b></a>
		            <ul class="dropdown-menu">
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=billing&menu=billing">Create Bills</a></li>
		                <li class="divider"></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=customer_bills&menu=billing">Customer Bills</a></li>
		               <!-- <li class="divider"></li>
		                <li><a href="<?php //echo DHS_ROOT;?>index.php?view=local_bills&menu=billing">Create Local Bills</a></li>-->
		            </ul>
		        </li>
		        
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'account' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Accounting <b class="caret"></b></a>
		            <ul class="dropdown-menu">
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=expense_registration&menu=account">Add Expenses</a></li>
		            </ul>
		        </li>
		        
		        <li class="pull-right <?php echo isset($_GET['menu']) && $_GET['menu'] == 'changepassword' ? 'active': '';?>"><a href="<?php echo DHS_ROOT;?>index.php?view=change_password&menu=changepassword">Change Password</a></li>
		        
		        <li class="pull-right"><a href="logout.php">Logout</a></li>
            </ul>
            </div>
        </div>
    </div>
</div>

    <div style="clear:both"></div>

<?php if(!empty($view)):?>
	<?php include_once "hospital/$view.php"; ?>
  <?php endif;?>
  <?php if($view=="index" || empty($view)){?>
  	<?php include_once "hospital/billing.php"; ?>
<?php }?>