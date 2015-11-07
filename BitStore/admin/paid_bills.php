<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>
<!--<fieldset>
	<legend style="margin-bottom:10px;"><font size="+2">Bills Paid to Distributors</font></legend>
    <font class="muted" size="-2">
  	Get the list of all bills paid to the distributors. Get the process how these bills are generated :-
        <ol>
        	<li>Admin/Staff will create request to send consignment of medicines.</li>
            <li>Distributors will get list of requests. In request they will get the quantity of medicines they need to send.</li>
            <li>Once distributors do confirm and dispatch the consignment. Admin/Staff will cross-check the consignment and mark it as Verified.</li>
            <li>After verification the entry of consignment comes here.</li>
        </ol>    
    
    </font>
</fieldset>-->

<table class="table table-stripped" style="margin-top:30px;">
	<tr>
		<th>S. No.</th>
		<th>Distributor Name</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Unit Cost</th>
        <th>Subtotal</th>
        <th>Tax</th>
        <th>Discount</th>
        <th>Total</th>
		<th>Paid Date</th>
        <th>&nbsp;</th>
	</tr>
	
	<?php
	//	$sql= "select * from `new_inventory` where `store_key` = '$store_key' and `status` = ".DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED;
    $sql= "select * from `new_inventory` where `store_key` = '$store_key' ";
		// ***** Pagination Work Start ******
		$pageSql = $sql;
		$pageResult = mysqli_query($con,$pageSql);
		
		$count = $pageResult->num_rows;
		if($count > 0){
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
		
		$result=mysqli_query($con,$sql);
		
		$records 		= array();
		$medicines 		= array();
		$distributors 	= array();
		
		while($row=mysqli_fetch_assoc($result)){	
			$records[] 		= $row;
			$medicines[] 	= $row['medicine_id'];
			$distributors[] = $row['distributor_id'];
		}
		
		// remove duplicate entries
		$medicines 		= array_unique($medicines);
		$distributors 	= array_unique($distributors);
		
		// get names of medicine and distributors
		$medicine_list 		= DhsHelper::getMedicinesList($con,$medicines);
		$distributor_list 	= DhsHelper::getDistributorsList($con,$distributors);
		
		
		$n = 0;
		foreach($records as $record)
		{
			$n++;
	?>

            <tr>
               <!-- <td><?php //echo '#'.$n;?></td>
                <td><?php //echo isset($distributor_list[$record['distributor_id']]) ? $distributor_list[$record['distributor_id']] : 'N/A';?></td>
                <td><?php //echo isset($medicine_list[$record['medicine_id']]) ? $medicine_list[$record['medicine_id']] : 'N/A';?></td>
                <td><?php //echo $record['quantity']; ?></td>
                <td><?php //echo DhsHelper::formatPrice($con,$record['unit_cost']);?></td>
               --><!-- <td><?php //echo DhsHelper::formatPrice($con,$record['subtotal']);?></td>
                <td><?php //echo DhsHelper::formatPrice($con,$record['tax']);?></td>
                <td><?php //echo DhsHelper::formatPrice($con,$record['discount']);?></td>
                <td><?php //echo DhsHelper::formatPrice($con,$record['total']);?></td>
                <td><?php //echo DhsHelper::formatDate($con,$record['verified_date']);?></td>-->
                <!--<td>
                	<a href="index.php?view=edit_distributor_bills&task=edit&id=<?php //echo $record['inventory_id'];?>">
                        <i class="icon-edit"></i>
                	</a>
                	
                	<a href="admin/paid_bill_print.php" onclick="javascript:void window.open('admin/paid_bill_print.php', '', 'width=700, height=500, toolbar=0, menubar=0, location=0, status=1, scrollbars=1, resizable=1, left=0, top=0'); return false;">
                        <i class="icon-remove"></i>
                	</a>
                </td>-->
            </tr>
	<?php }?>
</table>
<?php if($count > 0):?>
 <div class="pagination text-center">
	<ul>
	    <?php 
	    for($i = 0; $i < $paginationCount; $i++):?>
	        <li class="<?php echo ($page_id == $i) ? 'active' : 'disabled';?>">
	          <a  href="<?php echo DHS_ROOT;?>index.php?view=paid_bills&menu=billing&page_id=<?php echo $i;?>">
	              <?php echo $i + 1;?>
	          </a>
	    </li>
	    <?php endfor;?>
	</ul>
</div>

<?php endif;?>