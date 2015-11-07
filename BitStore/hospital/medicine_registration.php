<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>

<?php $store_key = $_SESSION['mystoreid'];?>
<?php // $file = dirname(dirname(__FILE__)).'\js\medicines.json'; ?>
<?php //$manu = dirname(dirname(__FILE__)).'\js\manufacturer.json'; ?>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            //    var data = {};
            //  data.source = <?php //echo file_get_contents($file);?>
           // $("#name").typeahead(data);
		
//            var manufacturer = {};
  //          manufacturer.source = <?php //echo file_get_contents($manu);?>
            //        $("#manufacturer").typeahead(manufacturer);

            $("#success_msg").hide();
            $("#category_validation").hide();
            $("#medicine_validation").hide();

            $("#category_id").change(function () {
                $("#category_validation").fadeOut();
                $("#success_msg").fadeOut();
            });

            $("#name").keypress(function () {
                $("#medicine_validation").fadeOut();
                $("#success_msg").fadeOut();
            });

            $("#btn_save").click(function () {
                var category = document.myform.category_id.value;
                var medicine = document.myform.name.value;
                if (category == "") {
                    $('#category_id').focus();
                    $("#category_validation").fadeIn();
                }

                if (medicine == "") {
                    $('#name').focus();
                    $("#medicine_validation").fadeIn();
                }

                if (category == "" | medicine == "")
                    return false;

                var querystring = $("#myform").serialize();
                //$("#myform").validate();
                $.ajax({
                    type: 'POST',
                    url: 'admin/db/manage_medicine.php',
                    data: {
                        query: querystring,
                        action: 'insert_medicine'
                    },

                    success: function (html) {
                        var act = document.myform.action.value;
                        $("#success_msg").fadeIn();
                        if (act == 'update_medicine')
                            window.location.replace("index.php?view=medicine_details&menu=medicine");
                        else
                            document.myform.reset();
                        $("#success_msg").fadeIn();
                    }
                });
            });
        });
    })(jQuery);

</script>
	
<fieldset class="span8 offset2">
<legend>Product Form</legend>
<form class="form-horizontal dhs-medical-form " name="myform" id="myform">

<?php 
if(isset($_REQUEST['medicine_id']) && !empty($_REQUEST['medicine_id'])){
	$med_res = mysqli_query($con,'select * from `medicine` where `store_key` = '."'".$store_key."'");
    //$med_res = mysqli_query($con,'select * from `medicine` where `store_key` = '."'".$store_key."'".' and `medicine_id` = '.$_REQUEST['medicine_id']);
	$medcine = mysqli_fetch_array($med_res);
    
}
?>
	  <div class="control-group">
	    <label class="control-label" for="name">products Category:</label>
	    <div class="controls">
	     <select name="category_id" id="category_id">
	     	<option value="">Select Category</option>
			    <?php
				include("config.php");
				$result=mysqli_query($con,"select * from category where `store_key` = '$store_key' and `status` <> 0");
				while($row=mysqli_fetch_array($result)){?>
			        <?php if(isset($_REQUEST['medicine_id']) && !empty($_REQUEST['medicine_id'])){?>
			        	<option value="<?php echo $row['category_id'];?>" <?php echo ($medcine['category_id'] == $row['category_id']) ? 'selected=selected' : '';?>><?php echo $row['name'];?></option>
					<?php }else{?>
						<option value="<?php echo $row['category_id'];?>"><?php echo $row['name'];?></option>
					<?php }?>
			        <?php
				}
				?>
	     </select>
	    <!-- <div id="category_validation" style="color:#F00; font-family:Georgia, 'Times New Roman', Times, serif;" class="error_msg">*Please Select products Category</div>-->
	    </div>
	  </div>
  
   <div class="control-group">
    <label class="control-label" for="name">Product Name</label>
    <div class="controls">
      <input type="text" id="name" name="name" placeholder="Product Name" required="" value="<?php  echo isset($medcine['medicine_name']) ? $medcine['medicine_name'] : ''; ?>" />
         </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="ingrediants">Details:</label>
    <div class="controls">
      <input type="text" id="ingrediants" name="ingrediants" placeholder="Ingrediants" value="<?php echo isset($medcine['ingrediants']) ? $medcine['ingrediants'] : ''; ?>" />
    </div>
  </div>
  
  

  
   <div class="control-group">
    <label class="control-label" for="manufacturer">Manufacturer:</label>
    <div class="controls">
    	<?php 
		if(isset($_REQUEST['medicine_id']) && !empty($_REQUEST['medicine_id'])):?>
      		<input type="hidden" name="action" value="update_medicine" />
      		<input type="hidden" name="medicine_id" value="<?php echo $_REQUEST['medicine_id'];?>" />
      	<?php else:?>
      		<input type="hidden" name="action" value="manage_medicine" />
      	<?php endif;?>	
      <input type="text" id="manufacturer" name="manufacturer" placeholder="Manufacturer" required="" value="<?php echo isset($medcine['manufacturer']) ? $medcine['manufacturer'] : ''; ?>" />
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="min_limit">Min Quantity :</label>
    <div class="controls">
           		<input type="number" name="min_limit" id="min_limit" value="" placeholder="Enter Min Quantity " required="" />
        </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      
      <button type="button" class="btn btn-primary dhs-medical-btn" name="btn_save" id="btn_save">Save</button>
    
    </div>
  </div>
   <div align="center" id="success_msg" style="display:none;">
     <div style="width:400px; height:70px; font-family:Georgia, 'Times New Roman', Times, serif; font-size:18px; color:#0C3;">*product Successfully Saved.</div>
    </div> 
</form>	</fieldset>
