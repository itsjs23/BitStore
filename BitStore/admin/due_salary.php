<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php
$store_key = $_SESSION['mystoreid'];
$current = date('Y-m-d');
$day 	 = date('d');
$month 	 = date('m');
$year	 = date('Y');

$dues 	 = array();
$users 	 = array();
$user_ids = array();

$user_rslt = mysqli_query($con,"select u.*, sal.salary, sal.notify_day from `users` as u join `salary` as sal 
						on (sal.user_id = u.user_id and sal.store_key = '$store_key' and u.store_key = '$store_key') 
						where u.status <> 0 and u.Enable = 1 and (u.type = 301 or u.type = 302)");
while($user = mysqli_fetch_array($user_rslt)){
	$users[$user['user_id']] = $user;
	$user_ids[] = $user['user_id'];
}

if(!empty($user_ids)){
	foreach ($user_ids as $id){
		$result = mysqli_query($con,"select count(paid_salary_id) from `paid_salary` where `store_key` = '$store_key' and `user_id` = $id");
		$count = mysqli_fetch_row($result);
		if($count[0] == 0){
			$dues[] = array('username' => $users[$id]['username'],
								'salary' => $users[$id]['salary'],
								'user_id' => $id,
								'due_date' => $users[$id]['notify_day'].'-'.date('M').'-'.date('Y'));
		}
		else{
			$sql = 'select user_id, month, year, date(paid_on_date) as paid_on_date from `paid_salary` where user_id = '.$id;
			$sql .= ' order by paid_salary_id DESC limit 0,1';
			
			$result = mysqli_query($con,$sql);
			$paid = mysqli_fetch_row($result);
			
			if(($paid[1] < $month) && ($paid[2] <= $year) && $paid[3] < $current){
				$dues[] = array('username' => $users[$id]['username'],
								'salary' => $users[$id]['salary'],
								'user_id' => $id,
								'due_date' => $users[$id]['notify_day'].'-'.date('M').'-'.date('Y'));
			}
		}
	}
	
	?>
	<table class="table table-stripped">
	  <thead>
		  <tr>
		    <th>S.No.</th>
		    <th>Username</th>
		    <th>Salary</th>
		    <th>Due Date</th>
		    <th>Do Payment</th>
		  </tr>
	  </thead>
	  
	  <tbody>
	  	<?php 
	  	$index = 0;
	  	foreach ($dues as $due):
	  	?>
	  	  <tr>
	  	  	<td><?php echo ++$index;?></td>
		    <td><?php echo $due['username'];?></td>
		    <td><?php echo $due['salary'];?></td>
		    <td><?php echo $due['due_date'];?></td>
		    <td>
		    	<a href="index.php?view=pay_due_salary&menu=payroll&user_id=<?php echo $due['user_id'];?>" class="pay_salary">
                	<i class="icon-check"></i>
                </a>
            </td>
		  </tr>
		<?php endforeach;?>
	  </tbody>
	  
	</table>

<?php 	
}
else{
	echo '<div class="alert alert-info">Currently, there are no employees registered with your organization.</div>';
}