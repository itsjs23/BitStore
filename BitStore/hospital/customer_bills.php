<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<fieldset>
	<legend style="margin-bottom:10px;"><font size="+2">Bills Created for Customers</font></legend>
    <font class="muted" size="-2">
    	Get the list of all bills paid by the customers. These are the revenue of medical inventory system.    
    </font>
</fieldset>

<?php
	$filters = array('customer_name', 'payment_mode', 'start_date', 'end_date');

	foreach ($filters as $filter){
		if(isset($_POST[$filter]) && !empty($_POST[$filter])){
			$_SESSION['cb'][$filter] = $_POST[$filter];
		}elseif(!empty($_SESSION['cb'][$filter])) {
			$_SESSION['cb'][$filter] = $_SESSION['cb'][$filter];
		}else{
			$_SESSION['cb'][$filter] = null;
		}
	}
?>

<form method="post" action="index.php?view=customer_bills&menu=billing">
	<div class="well">
	Customer Name:
	  <div class="input-append" style="margin-bottom: 0;">
	  	<input type="text" name="customer_name" value="<?php echo isset($_SESSION['cb']['customer_name']) ? $_SESSION['cb']['customer_name'] : '';?>" />
	  </div>
	  
	Payment Mode:
	  <div class="input-append" style="margin-bottom: 0;">
	  	<select name="payment_mode" id="payment_mode" class="input-small">
	  		<option value="0">None</option>
	  		<option value="Cash">Cash</option>
	  		<option value="Cheque">Cheque</option>
	  	</select>
	  </div>
	  
	From : 
	  <div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
	    <input data-format="yyyy-MM-dd" type="text" name="start_date" class="input-small" value="<?php echo isset($_SESSION['cb']['start_date']) ? $_SESSION['cb']['start_date'] : '';?>" />
	    <span class="add-on">
	      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
	      </i>
	    </span>
	  </div>
	  To: 
	  <div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
	    <input data-format="yyyy-MM-dd" type="text" name="end_date" class="input-small" value="<?php echo isset($_SESSION['cb']['end_date']) ? $_SESSION['cb']['end_date'] : '';?>" />
	    <span class="add-on">
	      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
	      </i>
	    </span>
	  </div>
	  
	  <button class="btn btn-primary" type="submit">Filter</button>
	  
	  <!--<a class="btn btn-danger pull-right" href="<?php //echo DHS_ROOT;?>index.php?view=manage_customer_bills&menu=billing&action=delete_cb_filter">Remove Filter</a>-->
	</div>
</form>
	

<table class="table table-stripped" style="margin-top:30px;">
	<tr>
		<th>S. No.</th>
		<th>Customer Name</th>
		<th>Customer Mobile</th>
		<th>Quantity</th>
        <th>Total</th>
        <th>Payment Mode</th>
		<th>Paid Date</th>
        <th><font size="0.8em">Print | Delete</font></th>
	</tr>
	
	<?php
		$sql = 'SELECT `customer_name`,`customer_mob`, `billing`.`bill_id`, 
					sum(`quantity`) as quantity, `billing`.total as total, `payment_mode`,
					`billing`.`created_date` FROM `new_cust_inventory`  join `billing` on (`new_cust_inventory`.bill_id = `billing`.bill_id)';
					
					
		$where = array();
		$where[] = "`billing`.`store_key` = '$store_key'";
		
		if(!empty($_SESSION['cb']['customer_name'])){
			$where[] = '`customer_name` like '."'%".$_SESSION['cb']['customer_name']."%'";
		}
		
		if(!empty($_SESSION['cb']['payment_mode'])){
			$where[] = '`payment_mode` = '."'".$_SESSION['cb']['payment_mode']."'";
		}
		
		if(!empty($_SESSION['cb']['start_date'])){
			$where[] = 'new_cust_inventory.created_date >= '."'".$_SESSION['cb']['start_date']."'";
		}
		
		if(!empty($_SESSION['cb']['end_date'])){
			$where[] = 'new_cust_inventory.created_date <= '."'".$_SESSION['cb']['end_date']."'";
		}
		
		$where[] = 'status <> 0';
		
		$sql .= ' where '. implode(' and ', $where);
		$sql .= ' group by `bill_id` order by `bill_id` DESC ';
		
		// ***** Pagination Work Start ******
		$pageSql = $sql;
		$pageResult = mysqli_query($con,$pageSql);
		
		$count = $pageResult->num_rows;
		if($pageResult && $count > 0){
		      $paginationCount = DhsHelper::getPagination($count);
		}
		// ***** Pagination Work End ******
		
		if(isset($_GET['page_id']) && !empty($_GET['page_id'])){
		   $page_id = $_GET['page_id'];
		}else{
		   $page_id = '0';
		}
		
		$pageLimit = PAGE_PER_NO * $page_id;
		$sql .= " limit $pageLimit,".PAGE_PER_NO;
		
		$result = mysqli_query($con,$sql);
		
		$n = 0;
		$total = 0;
		while($record=mysqli_fetch_array($result)){	
			$n++; $total += $record['total'];
	?>

            <tr class="row<?php echo $record['bill_id'];?>">
                <td><?php echo '#'.$n;?></td>
                <td><?php echo $record['customer_name'];?></td>
                <td><?php echo $record['customer_mob'];?></td>
                <td><?php echo $record['quantity']; ?></td>
                <td><?php echo DhsHelper::formatPrice($con,$record['total']);?></td>
                <td><?php echo $record['payment_mode']; ?></td>
                <td><?php echo DhsHelper::formatDate($record['created_date']);?></td>
                <td>
                	
                	
                	<a href="admin/paid_bill_print.php" onclick="javascript:void window.open('admin/paid_bill_print.php?bill_id=<?php echo $record['bill_id'];?>', '', 'width=980, height=600, toolbar=0, menubar=0, location=0, status=1, scrollbars=1, resizable=1, left=0, top=0'); return false;">
                        <i class="icon-print"></i>
                	</a>
                	
                	<a href="#" class="cust_delete" data-source-id="<?php echo $record['bill_id'];?>">
                        <i class="icon-remove"></i>
                	</a>
                </td>
            </tr>
	<?php }?>
</table>
	
<div class="well well-small">
	<strong>Total Sales: Rs. <?php echo DhsHelper::formatPrice($con,$total);?></strong>
</div>	

<?php if($count > 0):?>
 <div class="pagination text-center">
	<ul>
	    <?php 
	    for($i = 0; $i < $paginationCount; $i++):?>
	        <li class="<?php echo ($page_id == $i) ? 'active' : 'disabled';?>">
	          <a  href="<?php echo DHS_ROOT;?>index.php?view=customer_bills&menu=billing&page_id=<?php echo $i;?>">
	              <?php echo $i + 1;?>
	          </a>
	    </li>
	    <?php endfor;?>
	</ul>
</div>

<?php endif;?>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $(".cust_delete").click(function () {
                var id = $(this).attr('data-source-id');
                var didConfirm = confirm("Are you sure?");
                if (didConfirm == true) {
                    var id = $(this).attr('data-source-id');
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?view=manage_customer_bills',
                        data: {
                            action: 'delete_customer_bill',
                            bill_id: id
                        },
                        success: function (details) {
                            var row = '.row' + id;
                            $(row).hide();
                        }
                    });
                }
            });
        });
    })(jQuery);
</script>
	