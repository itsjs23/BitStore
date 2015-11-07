<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php $store_key = $_SESSION['mystoreid'];?>

<style type="text/css">
    input, textarea, .uneditable-input {
    width:120px;
    }
    select {
        width:120px;
    }
</style>



<!--<form id="filter" action="index.php?view=account_statement&menu=account" method="post">-->
<form id="filter" action="#" method="post">
	<div class="well">
	From : 
	  <div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
	    <input data-format="yyyy-MM-dd" type="text" name="start_date" required=""/>
	    <span class="add-on">
	      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
	      </i>
	    </span>
	  </div>
	  To: 
	  <div class="input-append dhs-datetimepicker" style="margin-bottom: 0;">
	    <input data-format="yyyy-MM-dd" type="text" name="end_date" required=""/>
	    <span class="add-on">
	      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
	      </i>
	    </span>
	  </div>
         
        <div class="input-append" style="margin-bottom: 0; "> Mode
	    <select name="paymode" id="paymode">
	    	<option value="cash">cash</option>
	    	<option value="cheque">cheque</option>
	    </select>
	  </div>
	  
             <div class="input-append cheque-block" style="margin-bottom: 0; display:none;" >
<input type="text" id="chequenum" class="input-append" name="chequenum" placeholder="Cheque Number" required="" value="" />
                 </div>
	  <div class="input-append pull-left" style="margin-bottom: 0;">Type
	    <select name="type">
            <option value="default">select one</option>
	    	<?php
            $sql="SELECT  DISTINCT purpose FROM `expenditure` ";
            $result=mysqli_query($con,$sql);
            if($result && $result->num_rows > 0){
                while($row=mysqli_fetch_row($result)){
                ?>
             <option value="<?php  echo $row[0]; ?>"><?php  echo $row[0]; ?></option>'
            <?php
                }
            }
            
            ?>
	    </select>
	  </div>
	  <button class="btn btn-primary" type="button" id="filter_expenses" >Filter</button>
	  
	</div>
</form>

		<?php  
        echo '<table class="table table-stripped"><thead>';
		echo '<tr><th>S. No.</th><th>&nbsp;</th><th>Particulars</th>';
		echo '<th>&nbsp;</th><th>Amount</th><th>&nbsp;</th><th>payMode</th>';
        echo '<th>&nbsp;</th><th>chequeNo</th>';
		echo '<th>&nbsp;</th><th>Date</th>';
        echo '<th>&nbsp;</th><th>Remark</th></tr></thead><tbody id="expense_data">';
        $total=0;
        $que="SELECT  `purpose`, `amount`, `paymode`, `chequeNum`, `created_date`, `remark` FROM `expenditure` WHERE created_date='".date('Y-m-d')."'";
        $res=mysqli_query($con,$que);
        if($res && $res -> num_rows > 0){
            $n=0;
            
        while($row=mysqli_fetch_assoc($res)){
            $n++;
            $total +=$row['amount'];
            echo '<tr><td>'.$n.'<td>';
            echo '<td>'.$row['purpose'].'<td>';
            echo '<td>'.$row['amount'].'<td>';
            echo '<td>'.$row['paymode'].'<td>';
            echo '<td>'.$row['chequeNum'].'<td>';
            echo '<td>'.$row['created_date'].'<td>';
            echo '<td>'.$row['remark'].'<td>';
            echo '</tr>';
        }
        }
        else{
            echo '<tr>';
            echo str_repeat('<td>&nbsp;</td>',6);
            echo '<td style="color:#f00;"> NO DATA !! </td>';
            echo str_repeat('<td>&nbsp;</td>',6);
            echo '</tr>';
            
        }
           
        echo '</tbody></table>';	
        echo ' <div class="well" id="total_expenses">';
        echo "<strong>Total Expenses : Rs.".$total."</strong>";
        echo '</div> </tbody>	</table>';
        
        
        
        
      ?>
        
<script type="text/javascript">
    $('#paymode').change(function () {
        var mode_type = $('#paymode').val();
        if (mode_type == 'cheque') {
            $('.cheque-block').css("display", "block");
        } else {
            $('.cheque-block').css("display", "none");
        }
    });


    $('#filter_expenses').click(function () {

        var fields= $('#filter').serialize();
        $.ajax({
            type: 'POST',
            datatype: 'json',
            url: 'admin/db/filter_expense.php',
            data: {
                fields: fields
            },
            success: function (e) {
                var result = JSON.parse(e);
                if (result['status'] == 'success') {
                    var str = "<strong>Total Expenses : Rs." + result['total_amount'] + "</strong>";
                    $('#expense_data').html(result['data']);
                    $('#total_expenses').html(str);
                } else {
                    var str = "<strong>Total Expenses : Rs. 0  </strong>";
                    $('#total_expenses').html(str);
                }

               


            }
        });

    });

</script>

