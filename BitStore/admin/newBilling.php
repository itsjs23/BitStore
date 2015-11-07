<?php if ( ! defined('DHS_DEFINES')) exit('Session is expired. Please do login again.');?>
<?php $store_key = $_SESSION['mystoreid'];?>

<style type="text/css">
select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
    margin-bottom:0px;   
}

@media (max-width: 480px){
	.prescribed-by{
		text-align:center;
	}
}

@media (min-width: 768px) {
	.prescribed-by{
		text-align:left;
	}
 }

</style>

<!--Angular Start-->
<script src = "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.min.js"></script>


<script  type="text/javascript">
    var app=angular.module('app',[]);
    app.controller('Billing', function ($scope, $http) {
        $scope.getFromAPI = function () {


            //Ajax Call Start 
            $http.get('admin/db/getProductDetails.php')
            .success(function (data, status, header, config) {
                //sucess 
                console.log('success', status);
                console.log(data);
                var datas = JSON.encode(data);
                console.log(datas);

            })
            .error(function (data, status, header, config) {
                $scope.json = angular.toJson($scope.user);
                //sucess 
                console.log('error', status);
                console.log(data);
            })
        }

        


    }); // CONTROLLER  END 



</script>


<!--ANgular End -->


<form class="dhs-medical-form form-vertical" id="myform" name="myform" action="index.php?view=manage_billing" method="post">



      <fieldset >
    	<legend>Billing Info</legend>
    	
	    <div id="dhs-billing-form">
	    	
		    <div style="padding:10px;">
		     <!-- <input type="checkbox" name="medicine[0][inStock]"    class="input-small" id="inStock0"  checked />InStock-->
		      <input type="text" name="medicine[0][barcode]" placeholder="batchCode" required="" id="barcode0" class="input-small data-barcode" />
		      <input type="hidden" class="medicines-select input-small" id="name0" name="medicine[0][name]" />
		      <div class="input-append" style="margin-bottom:0px;">
		      	<input type="text" class="medicines-select input-small" id="medicine_name0" name="medicine[0][medicine_name]" placeholder="Product Name"  />
		      	<input type="button" class="btn" id="remaining0" value="0" />
		      </div>
		      <input type="text" name="medicine[0][quantity]" placeholder="Quantity" required="" id="quantity0" class="input-small data-quantity numeric-txt data-medi0" />
		      <input type="text" name="medicine[0][cost]" placeholder="Unit Cost" required="" id="cost0" data-source="0" class="input-small bill-data data-medi0" />
		      <input type="text" name="medicine[0][subtotal]" placeholder="Subtotal" id="subtotal0" data-source="0" class="input-small bill-data" readonly="readonly" />
		      <input type="text" name="medicine[0][tax]" placeholder="Tax" id="tax0"  data-source="0" value="" class="input-small bill-data data-medi0" />
		      <input type="text" name="medicine[0][discount]" placeholder="Discount" id="discount0" data-source="0" value="" class="input-small bill-data data-medi0" />
		      <input type="text" name="medicine[0][total]" placeholder="Total" id="total0" data-source="0"  class="input-small bill-data data-total data-medi" readonly="readonly" />
		      <input type="hidden" name="medicine[0][mfg_date]" placeholder="Manufactured Date" id="mfg_date0" required="" class="input-small" />
		      <input type="hidden" name="medicine[0][expiry_date]" placeholder="Expiry Date" id="expiry_date0" required="" class="input-small" />
		    </div>
	    </div>
    </fieldset>


</form>


<div data-ng-controller="Billing" data-ng-app="app" >
    <span data-ng-init="getFromAPI()"></span>
    
</div>











