
//==== Get Product Name For category =====//
$('#category_id').on('change', function () {
    event.preventDefault();
    //  product names
    var catId = document.myform.category_id.value;
    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: 'admin/db/getProdunct.php',
        data: {
            catId: catId
          },
        success: function (e) {
            var str = JSON.parse(e);
            if (str['status'] == 'Success') {
                $('#medicine_id').html(str['product_name']);
            }
            else
            {
                $('#medicine_id').html(str['product_name']);
            }
        }
    });


});


//get Product Batch Code 

$('#medicine_id').on('change', function () {
    event.preventDefault();
    //  product names
    var productId = $('#medicine_id').val();
    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: 'admin/db/getBatchCode.php',
        data: {
            productId: productId
        },
        success: function (e) {
            var str = JSON.parse(e);
            if (str['status'] == 'success') {
                $('#batch_code').val(str['batchCode']);
            }
            else {
                alert('No Batch Code Found ');
            }
        }
    });


});
//item_type on change function

$('#item_type').on('change', function () {
    if ($('#item_type').val() == 'box') {
        var htm = '<div class="control-group"><label class="control-label" for="quantity1">Qunatity :</label><div class="controls">';
        htm += '<input type="text" id="quantity1" name="quantity1" placeholder="Qunatity" class="numeric-txt" required="" value="" >';
        htm += '<select  class="item_type" name="item_type_2" id="item_type_2"><option value="quantity">Qunatity</option><option value="box">Box</option><option value="packets">Packets</option> ';
        htm += '<option value="pouches">pouches</option><option value="kg">Kg</option> <option value="gram">gram</option> <option value="liter">Liter</option><option value="ml">MilliLiter</option> ';
        htm += '</select> </div> </div> ';

        $('#item_select_type').append(htm);
    }


});


////get bill info 

//$('.get_bill_info').on('click', function () {
    
//    var vendorId=$(this).val();
//    $.ajax({
//        type: 'POST',
//        datatype: 'json',
//        url: 'admin/db/get_bill_number.php',
//        data: {
//            vendorId: vendorId
//        },
//        success: function (e) {
//            var str = JSON.parse(e);
//            if (str['status'] == 'Success') {
//                var htm = '<form class="form-control" name="returnForm" id="returnForm">';
//                htm += '<div class="table-responsive retrn_stock_table" ><table class="table table-bordered table-striped table-condensed"><tbody>';
//                htm += '<tr><td><b>Bill Number</b></td><td><select   name="Get_bill_No_dateils"  onchange="Get_bill_details()" id="Get_bill_No_dateils"><option value="default"> select One</option>' + str['billNo']; + '</select></td></tr>';
//                htm += '<tr><td><b>Bill Details</b> </td><td><table class="table table-bordered table-striped table-condensed retrn_bill_data "></table></td></tr></tbody></table></div>';
//                htm += '<div class="stocK_retrn_msg"></div></form>';             
                   
//                showModal('Return Stock', htm);
//            }

//            else {
//                var htm = '<form class="form-control" name="returnForm" id="returnForm">';
//                htm += '<div class="table-responsive"><table class="table table-bordered table-striped table-condensed"><tbody>';
//                htm += '<tr><td>Bill Number</td><td><select   name="Get_bill_No_dateils"  onchange="Get_bill_details()" id="Get_bill_No_dateils"><option value="default"> select One</option>' + str['billNo']; + '</select></td></tr></tbody></table>';
//                htm += '</div><div class="table-responsive"><table class="table table-bordered table-striped table-condensed retrn_bill_data "></table></div></form>';
//                showModal('Return Stock', htm);
//            }
//        }
//    });

//});


//get Bill Details 

function Get_bill_details()
{
    $('.stocK_retrn_msg').html('');
    var bill_num = $('#Get_bill_No_dateils').val();
    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: 'admin/db/get_bill_Details.php',
        data: {
            bill_num: bill_num
        },
        success: function (e) {
            var str = JSON.parse(e);
            if (str['status'] == 'Success') {
                $('.retrn_bill_data').html(str['billDetails']);
            }
            else {
                $('.retrn_bill_data').html(str['billDetails']);
            }
        }
});

}


//return products 
function returnProduct() {
    var ven_id = arguments[0].value;
    var querystring = $("#returnForm").serialize();
   
    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: 'admin/db/ReturnStockInsert.php',
        data: {
            querystring: querystring,
            ven_id: ven_id
        },
        success: function (e) {
            var str = JSON.parse(e);
            if (str['status'] == 'Success') {
                var htm = '<p class="text-success">' + str['msg'] + '<p>'
            }
            else {
                var htm = '<p class="text-danger">' + str['msg'] + '<p>'
            }

            $('#Get_bill_No_dateils').val('default'); //set to default 
            $('.stocK_retrn_msg').html(htm);
            $('.retrn_bill_data').html('');

        }
    });

}





// view Recent Cus Transaction 

$('.view_cus_tran').on('click', function () {
    event.preventDefault();
    var data = $(this).val(); //cus Mobile
    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: 'admin/db/viewCusTran.php',
        data: {
            data: data
        },
        success: function (e) {
            var str = JSON.parse(e);
            if (str['status'] == 'Success') {
                showModal('Transaction', str['trans']);
            }
            else {
               
            }
        }
    });

   


});


// modal show 

function showModal()
{

    if(arguments.length>0)
    {
        $('.modal-header').html(arguments[0]);
        $('.modal-body').html(arguments[1]);
        $('#myModal').modal('show');

    }


}












