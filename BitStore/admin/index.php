<?php $store_key = $_SESSION['mystoreid'];?>
<div class="navbar span11">
    <div class="navbar-inner">
        <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-th-list"></span></a>
        <div class="nav-collapse collapse">
            <ul class="nav nav-pills">
                
                <li class="<?php echo isset($_GET['menu']) ? '': 'active';?>"><a href="<?php echo DHS_ROOT;?>index.php?view=index">Dashboard</a></li>
                
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'distributor' ? 'active': '';?>">
		        	<a href="#" data-toggle="dropdown" class="dropdown-toggle">Vendors <b class="caret"></b></a>
		        	<ul class="dropdown-menu">
		                <li><a class="enabled" href="<?php echo DHS_ROOT;?>index.php?view=distributor_registration&menu=distributor">Add Vendor</a></li>
		                <li><a class="enabled" href="<?php echo DHS_ROOT;?>index.php?view=distributor_details&menu=distributor">View Vendor</a></li>
		           <li><a class="enabled" href="<?php echo DHS_ROOT;?>index.php?view=paid_bills&menu=distributor">Vendor Bills</a></li>
                   </ul>
		        </li>
		        
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'medicine' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Product <b class="caret"></b></a>
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
		                <li class="divider"></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=return_stock&menu=stock">Return Stock</a></li>
                         <li><a href="<?php echo DHS_ROOT;?>index.php?view=returned_stock&menu=stock">Returned Stock</a></li>
                        <!--<li class="divider"></li>
		                <li><a href="<?php //echo DHS_ROOT;?>index.php?view=create_barcodes&menu=stock">Create Barcodes</a></li>
		                <li><a href="<?php //echo DHS_ROOT;?>index.php?view=view_barcodes&menu=stock">View Barcodes</a></li>-->
		            </ul>
		        </li>
		        
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'billing' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Billing <b class="caret"></b></a>
		            <ul class="dropdown-menu">
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=billing&menu=billing">Create Bills</a></li>
		                <li class="divider"></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=customer_bills&menu=billing">Customer Bills</a></li>
		             <!--   <li class="divider"></li>
		                <li><a href="<?php //echo DHS_ROOT;?>index.php?view=local_bills&menu=billing">Create Local Bills</a></li>-->
                       
		            </ul>
		        </li>
		        
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'account' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Accounting <b class="caret"></b></a>
		            <ul class="dropdown-menu">
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=expense_registration&menu=account">Add Expenses</a></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=expense_list&menu=account">Expenditure Statement</a></li>
		                <li class="divider"></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=account_statement&menu=account">Complete Statement</a></li>
		            </ul>
		        </li>
		        
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'payroll' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Payroll <b class="caret"></b></a>
		            <ul class="dropdown-menu">
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=add_salary&menu=payroll">Add Salary</a></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=view_salary&menu=payroll">View Salary</a></li>
		                <li class="divider"></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=due_salary&menu=payroll">Due Salary</a></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=paid_salary&menu=payroll">Paid Salary</a></li>
		            </ul>
		        </li>
		        
		        <li class="dropdown <?php echo isset($_GET['menu']) && $_GET['menu'] == 'user' ? 'active': '';?>">
		            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Users <b class="caret"></b></a>
		            <ul class="dropdown-menu">
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=user_registration&menu=user">Add User</a></li>
		                <li><a href="<?php echo DHS_ROOT;?>index.php?view=user_details&menu=user">View Users</a></li>
		              <!--  <li class="divider"></li>
		                <li><a href="<?php //echo DHS_ROOT;?>index.php?view=doctor_registration&menu=user">Add Doctor</a></li>
		                <li><a href="<?php //echo DHS_ROOT;?>index.php?view=doctors_list&menu=user">View Doctors</a></li>
		                <li class="divider"></li>
		                <li><a href="<?php //echo DHS_ROOT;?>index.php?view=change_password&menu=user">Change Password</a></li>-->
		            </ul>
		        </li>
		        
		        <li class="pull-right"><a href="logout.php">Logout</a></li>
            </ul>
            </div>
        </div>
    </div>
</div>

    <div style="clear:both"></div>

<?php if(!empty($view)):?>
	<?php include_once "admin/$view.php"; ?>
  <?php endif;?>
  <?php if($view=="index"){?>
  	 <div class="row-fluid" >
        <div class="thumbnails">
            <div class="span2" style="background-color: #669900;">
<a href="<?php echo DHS_ROOT;?>index.php?view=customer_bills&menu=billing">
                <div class="thumbnail text-center admin-dashboard-stats-box" style="height:150px; color:#fff;">
                    <div style="margin-top:5px;">
                        <strong><span style="font-size:1.25em;">Revenue</span></strong><hr/>
                        <div>&nbsp;</div>
                        <div style="font-size:1.0em;">
                        	<?php 
                            // total
                        	$revenue = DhsHelper::getRevenue($con);
                        	if($revenue < 0){
                        		echo '<div style="color:#EE0400; font-weight:bold;"> TOTAL : Rs. '.$revenue.'</div>';
                        	}else {
                        		echo 'TOTAL: Rs. '.$revenue;
                        	}
                             // today
                            $revenue = DhsHelper::getRevenue($con,'true');
                        	if($revenue < 0){
                        		echo '<div style="color:#EE0400; font-weight:bold;"> TODAY  : Rs. '.$revenue.'</div>';
                        	}else {
                        		echo ' TODAY : Rs. '.$revenue;
                        	}
                            
                            
                        	?>

						</div>
                    </div>	
                </div>
    </a>
            </div>
            
            <div class="span2" style="background-color: #E65C00;">
                <a href="<?php echo DHS_ROOT;?>index.php?view=expense_list&menu=account">
                <div class="thumbnail text-center admin-dashboard-stats-box" style="height:150px; color:#fff;">
                    <div style="margin-top:5px;">
                        <strong><span style="font-size:1.25em;">Expenses</span></strong><hr/>
                        <div>&nbsp;</div>
                        <div style="font-size:1.0em;">
                        	<?php
                            
                            $que1="SELECT SUM(amount) FROM `expenditure` ; ";
                            $que2=" SELECT SUM(amount) FROM `expenditure` WHERE created_date ='".date('Y-m-d')."' ;" ;

                            $que=$que1.$que2;
                            $arr=array();
                               /* execute multi query */
                            if (mysqli_multi_query($con, $que)) {
                                do {
                                    /* store first result set */
                                    if ($result = mysqli_store_result($con)) {
                                        while ($row = mysqli_fetch_row($result)) {
                                            $arr[]=$row[0];
                                        }
                                        mysqli_free_result($result);
                                    }
                                } while (mysqli_next_result($con));
                            }
                            echo ' TOTAL : '. DhsHelper::formatPrice($con,($arr[0]==null ? 0 : $arr[0]));
                            echo '<br/>TODAY : '. DhsHelper::formatPrice($con,($arr[1]==null ? 0 : $arr[1]));
                        	?>
                        </div>
                    </div>	
                </div>
                    </a>
            </div>
        
        <div class="span2" style="background-color: #6B00B2;">
             <a class="enabled" href="<?php echo DHS_ROOT;?>index.php?view=paid_bills&menu=distributor">
                <div class="thumbnail text-center admin-dashboard-stats-box" style="height:150px; color:#fff">
                    <div style="margin-top:5px;">
                        <strong><span style="font-size:1.25em;"> Vendor</span></strong><hr/>
                        <div style="font-size:1.0em;">
                        	<?php 
                            $query1="SELECT COUNT(Id) FROM `vendors` WHERE `Status`='1' AND `store_key`='".$store_key."' ; ";
                            $query2="SELECT SUM(`Amount` - `PendiangAmount`)  FROM `vendor_payment` ;" ;
                            $query3="SELECT SUM(`Amount` - `PendiangAmount`)  FROM `vendor_payment` WHERE date='".date('Y-m-d')."' ;";
                            $query4="SELECT SUM(`PendiangAmount`) FROM `vendor_payment` ;" ;
                            $query =$query1.$query2.$query3.$query4;
                            $arr=array();
                               /* execute multi query */
                            if (mysqli_multi_query($con, $query)) {
                                do {
                                    /* store first result set */
                                    if ($result = mysqli_store_result($con)) {
                                        while ($row = mysqli_fetch_row($result)) {
                                            $arr[]=$row[0];
                                        }
                                        mysqli_free_result($result);
                                    }
                                } while (mysqli_next_result($con));
                            }
                            echo 'COUNT : '.($arr[0]==null ? 0 : $arr[0]);
                                echo '<br/>TOTAL PAID :' .($arr[1]==null ? 0 : $arr[1]);
                                echo '<br/>TOTAL PENDING :'.($arr[3]==null ? 0 : $arr[3]);
                                echo '<br/>TODAY PAID :' .($arr[2]==null ? 0 : $arr[2]);
                            ?>
                        </div>
                    </div>	
                </div>
                 </a>
            </div>
                        <div class="span2" style="background-color: #669900;">
                              <a href="<?php echo DHS_ROOT;?>index.php?view=arrived_stock&menu=stock">
                <div class="thumbnail text-center admin-dashboard-stats-box" style="height:150px; color:#fff;">
                    <div style="margin-top:15px;">
                        <strong><span style="font-size:1.25em;">Today Purchage</span></strong><hr/>
                        <div>&nbsp;</div>
                        <div style="font-size:1.0em;">
                        	<?php 
                        	$purchage = DhsHelper::getPurchage($con);
                        	if($revenue < 0){
                        		echo '<div style="color:#EE0400; font-weight:bold;"> Rs. '.$purchage.'</div>';
                        	}else {
                        		echo 'Rs. '.$purchage;
                        	}
                        	?>

						</div>
                    </div>	
                </div>
                                  </a>
            </div>
            
            
            <div class="span2" style="background-color: #CC0000;">
                 <a href="<?php echo DHS_ROOT;?>index.php?view=out_of_stock&menu=stock">
                <div class="thumbnail text-center admin-dashboard-stats-box" style="height:150px; color:#fff;">
                    <div style="margin-top:15px;">
                        <strong><span style="font-size:1.25em;">Out of Stock</span></strong><hr/>
                        <div>&nbsp;</div>
                        <div style="font-size:1.0em;">
                        	<?php 
                        		echo 'COUNT = '. DhsHelper::getFinishedStock($con);
                                
                        	?>
                        </div>
                    </div>	
                </div>
                     </a>
            </div>
        </div>
     </div>

<br/>
<br/>  
      <div class="row-fluid">
          <div class="span4" style="border: 1px solid #ccc; box-shadow: 2px 2px #ccc; padding:3px; border-radius:4px;">
                <h3>Recent Transactions</h3>
                
                <?php 
                	//list($records, $medicines, $bills) = DhsHelper::getRecentTransactions();
					$i = 1;
    $store_key = $_SESSION['mystoreid'];
    
    
    $sql="SELECT CE.`customer_name`, SUM(CE.total),CE.bill_id,CE.`created_date` FROM `new_cust_inventory` AS CE 
        WHERE CE.`store_key`='".$store_key."'   GROUP BY CE.`customer_name`,CE.`bill_id`,CE.`created_date` ORDER BY `inventory_id` DESC LIMIT 5 " ;
    $result =  mysqli_query($con,$sql);
                ?>
                
                    <?php
                    if($result && $result->num_rows > 0){ ?>
              <table class="table table-stripped">
                      <tr>
                         <th>S.No.</th>
                         <th>Customer Name</th>
                         <th>Total Cost</th>
                          <th> &nbsp;</th>
                      </tr>
                  <?php

            while($row = mysqli_fetch_row($result)){ 
                              ?>
					   <tr>
                         <td><?php echo $i++;?>.</td>
                         <td>
                         <?php 
                         $fname=explode(' ',$row[0]);
                         echo $fname[0];?>
                         </td>
                         <td><?php echo $row[1];?></td>
                         <td><button type="button" class="view_cus_tran btn btn-primary" value="<?php if($row[2]==""){ echo ($row[0].'_'.$row[3]) ; } else{echo $row[2];}?>">View</button></td>
                       </tr>
                       <?php }
                    ?>
                    </table>
                     <?php }else{ ?>
                        <div class="alert alert-success">No Transaction  !! </div> 
                        
                   <?php }                  
                     ?>              
                
          </div>
          
          
          
           <div class="span4" style="border: 1px solid #ccc; box-shadow: 2px 2px #ccc; padding:3px; border-radius:4px;">
                <h3>Vendor Paid Histroy</h3>
                 
              
                <?php 
                $sql="SELECT VD.Name,VP.Amount,VP.date  FROM vendor_payment AS VP INNER JOIN vendors AS VD ON VD.Id=VP.ven_id  ORDER BY VP.ven_pay_id DESC  LIMIT 5  ";
                $result=mysqli_query($con,$sql);
              
                if($result && $result -> num_rows > 0){
                $i=0;
                ?>
                <table class="table table-stripped" >
                      <tr>
                         <th>S.No</th>
                         <th>Customer Name</th>
                         <th>Amount</th>
                         <th>Date</th>
                      </tr>

                     <?php 
                     while($row=mysqli_fetch_assoc($result)){
                      ?>

                 	   <tr >
                         <td><?php echo ++$i;?></td>
                         <td><?php
                         echo $row['Name'];
                         ?></td>
                         <td><?php echo $row['Amount'];?></td>
                         <td><?php echo $row['date'];?></td>
                       </tr>
                       		
                       <?php } ?>
                          
                </table> 
                <?php  }else{
               ?> 
                      <div class="alert alert-success">No payment Histroy !! </div> 

               <?php }  ?>
              
                      
               
               
          </div>

               <div class="span4" style="border: 1px solid #ccc; box-shadow: 2px 2px #ccc; padding:3px; border-radius:4px;">
                <h3>Employ Paid Histroy</h3>
                 
              
                <?php 
            $sql="SELECT US.username,PS.actual_payment,PS.created_date FROM paid_salary AS PS INNER JOIN users AS US ON US.user_id=PS.user_id order by PS.paid_salary_id DESC LIMIT 5";
                $result=mysqli_query($con,$sql);
              
                if($result && $result -> num_rows > 0){
                $i=0;
                ?>
                    <table class="table table-stripped" >
                      <tr>
                         <th>S.No</th>
                         <th>Employ Name</th>
                         <th>Amount</th>
                         <th>Date</th>
                      </tr>
                     <?php 
                     while($row=mysqli_fetch_assoc($result)){
                      ?>
                 	   <tr >
                         <td><?php echo ++$i;?></td>
                         <td><?php
                         echo $row['username'];
                         ?></td>
                         <td><?php echo $row['actual_payment'];?></td>
                         <td><?php echo $row['created_date'];?></td>
                       </tr>
                       		
                       <?php } ?>
                        </table>    
               
                <?php  }else{
               ?> 
                       <div class="alert alert-success">No payment Histroy !! </div>

               <?php }  ?>
              
                      
               
               
          </div>


        

        </div>
        <br /><br />
        
        <?php }?>
		
        