<?php
    session_start();
    include "includes/sessions.php";
?>

<!DOCTYPE html>

<html lang="en">

  <head>
    
    <meta charset="utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <meta name="description" content=""/>

    <meta name="author" content=""/>

    <title>Canteen Management System | POS</title>

    <!-- loader-->
    <link href="../assets/css/pace.min.css" rel="stylesheet"/>
    
    <script src="../assets/js/pace.min.js"></script>

    <!--favicon-->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

    <!-- Vector CSS -->
    <link href="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>

    <!-- simplebar CSS-->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>

    <!-- Bootstrap core CSS-->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- animate CSS-->
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>

    <!-- Icons CSS-->
    <!-- <link href="../assets/css/icons.css" rel="stylesheet" type="text/css"/> -->
    <link href="../assets/icons/fontawesome-free-6.0.0-web/css/all.css" rel="stylesheet" type="text/css"/>

    <!-- Sidebar CSS-->
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>

    <link href="../assets/css/toastr.min.css" rel="stylesheet">

    <link href="../assets/css/select2.min.css" rel="stylesheet">

    <!-- Custom Style-->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>

    <style>

        /* .select2-search input { background-color: #00f; } */

        .select2-results { color:#000; }

    </style>
    
  </head>

  <body class="bg-theme bg-theme6">

    <?php 
        date_default_timezone_set("Asia/Manila");
        // echo date('G', strtotime("now")); 
    ?>
  


    <!-- Start wrapper-->
      <div id="wrapper">
      
        <?php include "layout/sidebar.php"; ?>

        <?php include "layout/topbar.php"; ?>

        <div class="clearfix"></div>
        
        <div class="content-wrapper">

          <div class="container-fluid">

            <div class="row">

                

                <!-- ====================== Item Cards ======================= -->
                    <div class="col-lg">

                        <div class="card">

                            <div class="card-body" style="max-width: 1000px; overflow-auto;">

                                <div class="d-flex align-items-center">

                                    <input type="text" class="form-control" name="barcode_val" id="barcode_val" placeholder="Input barcode here" style="display:none;" disabled>
                                    <input type="text" class="form-control" name="i_search_val" id="i_search_val" placeholder="Input item name here" disabled>

                                    <button type="button" class="btn btn-light" onclick="$('#i_search_val').hide(); $('#barcode_val').show();"><span class="fa fa-barcode"></span></button>
                                    <button type="button" class="btn btn-light" onclick="$('#barcode_val').hide(); $('#i_search_val').show();"><span class="fa fa-search"></span></button>

                                </div>

                                <hr>

                                <ul class="nav nav-tabs" id="cat_tab" style="display:none;"></ul>

                                <br>

                                <div class="row" id="item_list" style="max-height:800px; overflow-y:auto;"></div>

                            </div>
                            
                        </div>

                    </div>
                <!-- ====================== Item Cards END =================== -->



                <!-- ======================= Numpad ========================== -->
                    <div class="col-lg-3">

                        <div class="card">

                            <div class="card-body" style="max-width: 1000px; overflow-auto;">

                                <p> <b>Selected discounts</b> <span class="text-muted">(click to remove)</p>
                                <div id="selected_disc"></div>

                            </div>

                        </div>

                    </div>
                 <!-- ======================= Numpad END ====================== -->

                

                <!-- ======================= Cart Section ======================== -->
                    <div class="col-lg-3">

                        <div class="card">

                            <div class="card-header">
                                <input type="hidden" name="trans_Id" id="trans_Id">
                                <h5>Order List <span id="trans_Id2" class="text-info"></span></h5>
                            </div>

                            <div class="card-body">

                                <span class="fa fa-user mr-3"></span>
                                <a href="" id="cust_name">Add Customer</a> 
                                <span class="p-2"id="credit_stat"></span>
                            
                                <br><br>

                                <div class="d-flex align-items-center">

                                    <input type="text" class="form-control" name="qr_code_val" id="qr_code_val" placeholder="Scan QR code" autocomplete="off">

                                    <!-- ================== Manual Searching of Employee ===================== -->
                                    
                                    <button type="button" class="btn btn-light" onclick="searchEmp()" id="searchBtn"><span class="fa fa-user"></span></button>  
                                    <button type="button" class="btn btn-light" onclick="searchEmp()" id="searchBtn" disabled><span class="fa fa-user"></span></button>
                                    
                                    <!-- ================== Manual Searching of Employee END ================= -->

                                </div>

                                <hr>

                                <div style="height:300px; max-height:300px; overflow-y:auto;">

                                    <div id="cstm_list"></div>

                                    <div id="order_list"></div>

                                </div>

                                <?php

                                    if(date('l', strtotime("now")) != 'Saturday' && date('l', strtotime("now")) != 'Sunday'){
                                    // if(date('l', strtotime("now")) != 'Sunday'){

                                    ?> 

                                    <table>

                                        <tbody>

                                            <tr>
                                                <td>Discount</td>   
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td id="discount_list"></td>
                                            </tr>
                                            
                                        </tbody>

                                    </table>

                                    <?php

                                    }
                                ?>

                                <table class="table" style="width:100%;">
                                    
                                    <tbody>
                                        <tr>
                                            <td>Total</td>
                                            <td><h4 id="grand_total">0.00</h4></td>
                                            <input type="hidden" name="g_total_val" id="g_total_val">
                                        </tr>
                                    </tbody>

                                </table>

                                <div class="card-footer" id="cart_action" style="display:none;">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-primary" onclick="voidTrans()">Void</button>
                                        </div>
                                        <div class="col-lg text-right">
                                            <button type="button" class="btn btn-outline-success" id="payCashBtn" data-toggle="modal" data-target="#payCashMod"> <span class="fa fa-money-bill"></span> CASH</button>
                                            <br><br>
                                            <button type="button" class="btn btn-success" id="payCreditBtn" onclick="payCredit()"> <span class="fa fa-receipt"></span> CREDIT</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                <!-- ======================= Cart Section END ==================== -->

                

                <!-- ======================== Employee Modal ======================== -->
                    <div class="modal" id="srchEmpMod">

                        <div class="modal-dialog">

                            <div class="modal-content bg-dark">

                                <div class="modal-header">
                                    <h4 class="modal-title">Search an employee</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                   <div class="form-group">
                                       <p><b>Employee</b></p>
                                       <select class="form-control" name="emp_dd" id="emp_dd" style="width:100%;"></select>
                                   </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" onclick="empFetch()">Submit</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                </div>

                            </div>

                        </div>

                    </div>
                <!-- ======================== Employee Modal END ==================== -->

                

                <!-- ======================== Pay Cash Modal ======================== -->
                    <div class="modal" id="payCashMod">

                        <form method="POST" id="payCashForm">

                            <div class="modal-dialog">

                                <div class="modal-content bg-dark">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Pay Cash</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="form-group">
                                            <p><b>Amount</b></p>
                                            <div class="d-flex align-items-center">
                                                <input type="number" class="form-control" name="p_amount_val" id="p_amount_val" placeholder="Input payment amount here" required>
                                                <button type="button" class="btn btn-light" onclick="clearBtn('p_amount_val')"><span class="fa fa-delete-left"></span></button>
                                            </div>
                                        </div>

                                        <!-- =============== Numpad ================= -->
                                            <div class="card">

                                                <div class="card-body" style="max-width: 1000px; overflow-auto;">

                                                    <div class="row">

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('7')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>7</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('8')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>8</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('9')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>9</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('4')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>4</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('5')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>5</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('6')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>6</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('1')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>1</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('2')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>2</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('3')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>3</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="clearBtn()">
                                                                <!-- <div class="card-body bg-light text-center bg-light">
                                                                    <h6>Clear</h6>
                                                                </div> -->
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="payCashInpt('0')">
                                                                <div class="card-body bg-light text-center">
                                                                    <h4>0</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="card cursor-pointer" onclick="submitCust()">
                                                                <!-- <div class="card-body text-center bg-success">
                                                                    <h6>ENTER</h6>
                                                                </div> -->
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        <!-- =============== Numpad END ============= -->

                                        <hr>

                                        <div class="row">

                                            <div class="col-lg-6 text-right">
                                                <p>Grand Total</p>
                                                <h4 id="g_total">0.00</h4>
                                            </div>

                                            <div class="col-lg-6 text-right">
                                                <p>Change</p>
                                                <h4 id="p_change">0.00</h4>
                                                <input type="hidden" name="p_change_val" id="p_change_val">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>
                <!-- ======================== Pay Cash Modal END ==================== -->



            </div>
          
            <!--start overlay-->
              <div class="overlay toggle-menu"></div>
            <!--end overlay-->
            
          
          </div>
          <!-- End container-fluid-->
          
        </div><!--End content-wrapper-->

        <!--Start Back To Top Button-->
          <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->
        
        <?php include "layout/footer.php"; ?>
        
        <?php include "layout/color_switcher.php"; ?>
        
      </div>
    <!--End wrapper-->



    <!-- Bootstrap core JavaScript-->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
      
    <!-- simplebar js -->
    <script src="../assets/plugins/simplebar/js/simplebar.js"></script>

    <!-- sidebar-menu js -->
    <script src="../assets/js/sidebar-menu.js"></script>

    <!-- loader scripts -->
    <script src="../assets/js/jquery.loading-indicator.js"></script>

    <script src="../assets/js/toastr.min.js"></script>

    <script src="../assets/js/select2.min.js"></script>

    <!-- Custom scripts -->
    <script src="../assets/js/app-script.js"></script>

    <script src="../assets/js/functions.js"></script>

    <script>

        $(document).ready(function(){

            

            getTranscID()
            
            $('#qr_code_val').focus()

            empDD('emp_dd')

            $('#emp_dd').select2()

            $('#qr_code_val').focus()

            getCartOrders('order_list')

            catTabs('cat_tab')

            setInterval(Disable30Disc, 1000); //jm
            //document.addEventListener('click', Disable30Disc());
            //setInterval(FrontDisplayCookies, 1000);



        



            $('#qr_code_val').on('keyup', function(e){

                if(e.keyCode == 13) {

                    var emp_dd = $('#qr_code_val').val()

                    $.ajax({
                        type: "POST",
                        url: "exec/fetch.php",
                        data: {
                            emphash:emp_dd,
                            action:"emp_info"
                        },
                        dataType: "JSON",
                        success: function (response) {
                            
                            if(response.EmpCount > 0){

                                itemList('item_list', '', '')

                                $('#cat_tab').show()

                                $('#barcode_val').prop('disabled', false)
                                $('#i_search_val').prop('disabled', false)

                                $('#cust_name').html(response.FullName) 
                                creditChckr(response.EmpId)

                                newTransc()
                            }

                            // else{

                            //     $('#item_list').html('')
                            //     $('#cat_tab').html('')

                            //     toastr.error('This QR Code is invalid', 'Please reactivate QR', { "progressBar": true });
                            // }
                        }
                    })

                }

            })

            $('#p_amount_val').on('keyup', function(){

                var p_amount    = parseInt($('#p_amount_val').val())
                var grand_total = parseInt($('#g_total_val').val())

                var change      = p_amount - grand_total

                if(change <= 0){

                    change = 0
                }

                $('#p_change').html(parseFloat(change))
                $('#p_change_val').val(change)
            })

            $('#payCashForm').on('submit', function(){

                var trans_Id    = $('#trans_Id').val()
                var g_total     = $('#g_total').html()
                var data        = $('#payCashForm').serializeArray()
                //
                // if(g_total < 0){

                //     g_total = 0
                // }

                data.push(
                    {name: 'gtotal', value: g_total},
                    {name: 'transid', value: trans_Id},
                    {name: 'action', value: 'pay_cash'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){

                            setTimeout(function(){
                                clearCookies();
                                location.href='pos.php'

                            }, 1000)
                        }

                        else if(response == '2'){

                            toastr.error('Something went wrong', 'Please contact your developer ', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Item has been missing', 'Please contact your developer ', { "progressBar": true });
                        }
                    }
                })
            })

            $('#i_search_val').on('keyup', function(){

                var search_val = $('#i_search_val').val()

                itemList('item_list', '', search_val)
            })

        })



        async function itemList(id, cat_id, search_val){ //jm

            var output=''

            await $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    catid:cat_id,
                    searchval:search_val,
                    action:"item_list"
                },
                dataType: "JSON",
                success: function (response) {

                    if(response.length > 0){

                        $.each(response, function(key, value){
    
                            output+='<div class="col-lg-3" style="padding-right:0;padding-left:0;">'
                            output+='<div class="card" style="margin:0; border:1px solid gray;" onclick="addToCart(`' + value.Item_Id + '`)">'
                            output+='<div class="card-body text-center">'
                            output+='<h5 class="truncate">'+ value.Item_name +'</h5>'
                            output+='<p><b class="text-muted">'+ value.Item_price +'</b></p>'
                            output+='</div>'
                            output+='</div>'
                            output+='</div>'
                        })
                    }

                    else{

                        output+='<div class="col-lg-12 text-center">';
                        output+='<h5>No Results</h5>';
                        output+='</div>'
                    }

                    $('#'+id).html(output)
                    
                }
            })

            
        }





        function searchEmp(){

            $('#srchEmpMod').modal('show')
        }



        function empFetch(){

            var emp_dd = $('#emp_dd').val()

            $('#srchEmpMod').modal('hide')

            $('#qr_code_val').val(emp_dd)

            // getDiscounts('discount_list')

            itemList('item_list', '', '')

            $('#cat_tab').show()

            $('#barcode_val').prop('disabled', false)
            $('#i_search_val').prop('disabled', false)

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    emphash:emp_dd,
                    action:"emp_info"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#cust_name').html(response.FullName)
                    creditChckr(response.EmpId)
                    setCookie('CUST_NAME', response.FullName, 30);

                   


                    newTransc()
                }
            })


        }

        function setCookie(cookieName, cookieValue, expirationDays) {
            var d = new Date();
            d.setTime(d.getTime() + (expirationDays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
        }

        


        function getTranscID(){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    action:"gnrt_trans_Id"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#trans_Id').val(response.TransId)
                    $('#trans_Id2').html("("+ response.TransId2 +")")

                    setCookie('TRANS_ID', response.TransId2, 30);

                }
            })
        }

        

        
        //let disableButtonFlag = false; // Flag to check if we need to disable the button
        // ================== Cart Functions =======================
      async function getCartOrders(id) {
    var output = '';
    var ITEM_NAME = [];
    var ITEM_ID = [];
    var ITEM_QTY = [];
    var ITEM_PRICE = [];

    var trans_Id = $('#trans_Id').val();

    await $.ajax({
        type: "POST",
        url: "exec/fetch.php",
        data: {
            transid: trans_Id,
            action: "get_cart_orders"
        },
        dataType: "JSON",
        success: function (response) {
            if (response.length > 0) {
                $.each(response, function (key, value) {
                    output += '<div class="d-flex align-items-center" style="justify-content: space-between;">';
                    output += '<div>';
                    output += '<h5>' + value.Item_name + '</h5>';
                    output += '<p><b>P' + value.Item_price + '</b></p>';
                    if (value.Cat_Id == 44) {
                        output += '<p>Disc available</p>';
                    }
                    output += '</div>';
                    output += '<div class="d-flex align-items-center">'; // Corrected typo here
                    output += '<span class="fa fa-minus ml-2 p-2" style="border-radius: 100%; border: 2px solid #fff;" onclick="minusQty(`' + value.Trans_Id + '`)"></span>';
                    output += '<h4 class="mr-3 ml-3">' + value.Item_qty + '</h4>';
                    output += '<span class="fa fa-plus mr-2 p-2" style="border-radius: 100%; border: 2px solid #fff;" onclick="plusQty(`' + value.Trans_Id + '`)"></span>';
                    output += '</div>';
                    output += '</div><hr>';

                    ITEM_NAME.push(value.Item_name);
                    ITEM_ID.push(value.Item_Id);
                    ITEM_QTY.push(value.Item_qty);
                    ITEM_PRICE.push(value.Item_price);
                });
            } else {
                output += '<div class="text-center">';
                output += '<h5>No Results</h5>';
                output += '</div>';
            }

            setCookie('ITEM_NAME', ITEM_NAME, 30);
            setCookie('ITEM_ID', ITEM_ID, 30);
            setCookie('ITEM_QTY', ITEM_QTY, 30);
            setCookie('ITEM_PRICE', ITEM_PRICE, 30);

            $('#' + id).html(output);
        }
    });
}






            //========================================================
           

            //========================================================



            async function addToCart(item_id){ //jm

                var trans_Id = $('#trans_Id').val()
                var emp_dd   = $('#qr_code_val').val()

                await $.ajax({
                    type: "POST",
                    url: "exec/insert.php",
                    data: {
                        emphash:emp_dd,
                        transid:trans_Id,
                        itemid:item_id,
                        action:"add_to_cart"
                    },
                    dataType: "JSON",
                    success: function (response) {

                        if(response == '1'){

                            $('#searchBtn').prop('disabled', true)

                            $('#qr_code_val').prop('disabled', true)

                            getCartOrders('order_list').then( () => {

                                getDiscounts('discount_list')
                            })
                            .then( () => {

                                getTotal('grand_total')
                            })
                            .then( () => {

                                $('#cart_action').show()
                            })

                            // toastr.success('Successfully Added', 'You added a new item to cart', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Something went wrong', 'Please contact your developer ', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Item has been missing', 'Please contact your developer ', { "progressBar": true });
                        }
                    }
                })

            
            }



            async function plusQty(trans_Id){

                $('#payCreditBtn').prop('disabled', true)

                await $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: {
                        transid:trans_Id,
                        action:"plus_qty"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){

                            getCartOrders('order_list').then( () => {

                                getTotal('grand_total')

                            }).then( () => {

                                $('#payCreditBtn').prop('disabled', false)
                            })

                        }
                    }
                })
            }

            

            async function minusQty(trans_Id){

                $('#payCreditBtn').prop('disabled', true)

                await $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: {
                        transid:trans_Id,
                        action:"minus_qty"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){

                            removeZero().then( () => {

                                getCartOrders('order_list')
                            })
                            .then( () => {

                                getTotal('grand_total')
                            })
                            .then( () => {

                                $('#payCreditBtn').prop('disabled', false)
                            })

                        }
                    }
                })
            }



            async function removeZero(){

                await $.ajax({
                    type: "POST",
                    url: "exec/delete.php",
                    data: {
                        action:"remove_zero_qty"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){

                            console.log('Executed')
                        }

                        else if(response == '2'){

                            console.log('Error')
                        }
                    }
                })
            }



            function voidTrans(){
                
                var trans_Id = $('#trans_Id').val()

                $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: {
                        transid:trans_Id,
                        action:"void_trans"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){
                            clearCookies();
                            location.href='pos.php'

                        }

                        else if(response == '2'){

                            toastr.error('Something went wrong', 'Please contact your developer ', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Item has been missing', 'Please contact your developer ', { "progressBar": true });
                        }
                    }
                })
            }



            async function getTotal(id){

                var trans_Id = $('#trans_Id').val()

                await $.ajax({
                    type: "POST",
                    url: "exec/fetch.php",
                    data: {
                        transid:trans_Id,
                        action:"get_cart_total"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        $('#'+id).html(response)
                        $('#g_total').html(response)
                        $('#g_total_val').val(response)

                        setCookie('Grand_Total', response, 30);


                        if(response == 0 || response == ''){

                            $('#discount_list').html('')
                        }
                    }
                })
            }
        // ================== Cart Functions END ===================

            
        // ======================= Discounts =========================
            async function useDisc(disc_Id){

                var trans_Id    = $('#trans_Id').val()
                var emp_dd      = $('#qr_code_val').val()

                await $.ajax({
                    type: "POST",
                    url: "exec/insert.php",
                    data: {
                        transid:trans_Id,
                        emphash:emp_dd,
                        discid:disc_Id,
                        action:"use_discount"
                    },
                    dataType: "JSON",
                    success: function (response) {

                        if(response == '1'){

                            // $('#payCreditBtn').prop('disabled', true)
                            // $('.dics_btn').prop('disabled', true)

                            $('#payCreditBtn').hide()
                            $('#payCashBtn').hide()
                            $('.dics_btn').hide()

                            selectedDisc('selected_disc').then( () => {

                                getTotal('grand_total')
                            })
                            .then( () => {

                                getDiscounts('discount_list')
                            })
                            .then( () => {

                                setTimeout(function(){
    
                                    // $('#payCreditBtn').prop('disabled', false)
                                    // $('.dics_btn').prop('disabled', false)

                                    $('#payCreditBtn').show()
                                    $('#payCashBtn').show()
                                    $('.dics_btn').show()
    
                                }, 1000)
                            })

                        }

                        else if(response == '2'){

                            toastr.error('Something went wrong', 'Please contact your developer ', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Item has been missing', 'Please contact your developer ', { "progressBar": true });
                        }

                        else if(response == '4'){

                            toastr.error('Cannot use discount', 'Allowable limit reached', { "progressBar": true });
                        }

                        else if(response == '5'){

                            toastr.error('Discount is not applicable for orders', 'Item not applicable', { "progressBar": true });
                        }
                    }
                })
            }

            function Disable30Disc() { // jm
                const orderListDiv = document.getElementById('order_list');
                const button = document.getElementById('disc_1');

                if (orderListDiv && orderListDiv.textContent.includes('Disc available')) {
                    // Enable the button
                    button.disabled = false;
                } else {
                    button.disabled = true;
                }
            }



                
           


    async function getDiscounts(id){ 
    var output = ''
    var emp_dd = $('#qr_code_val').val()

    await $.ajax({
        type: "POST",
        url: "exec/fetch.php",
        data: {
            emphash: emp_dd,
            action: "get_discounts"
        },
        dataType: "JSON",
        success: function (response) {
            $.each(response, function(key, value){
                // Check if Disc_Id is 1 jm
                if (value.Disc_Id == 1) {
                    output += '<button type="button" id="disc_' + value.Disc_Id + '" class="btn btn-light p-3 dics_btn" onclick="useDisc(`'+ value.Disc_Id +'`)" disabled>' + value.Disc_name + ' (' + value.Avail_disc + ')</button>';
                } else {
                    output += '<button type="button" id="disc_' + value.Disc_Id + '" class="btn btn-light p-3 dics_btn" onclick="useDisc(`'+ value.Disc_Id +'`)">' + value.Disc_name + ' (' + value.Avail_disc + ')</button>';
                }


            })
            
            $('#'+id).html(output)
        }
    })
}


            

            

            async function selectedDisc(id){

                var output=''

                var trans_Id = $('#trans_Id').val()
                var arrdiscounts = [];
                var arrDisc_amount = [];

                $.ajax({
                    type: "POST",
                    url: "exec/fetch.php",
                    data: {
                        transid:trans_Id,
                        action:"selected_disc"
                    },
                    dataType: "JSON",
                    success: function (response) {

                        $.each(response, function(key, value){

                            output+='<button type="button" class="btn bg-dark btn-outline-danger" onclick="deleteDisc(`'+ value.Trans_D_Id +'`)">'+ value.Disc_name +'</button> '
                            arrdiscounts.push(value.Disc_name);
                            arrDisc_amount.push(value.Disc_amount);

                        })

                        setCookie('DISCOUNTS', arrdiscounts, 30);
                        setCookie('Disc_amount', arrDisc_amount, 30);


                        $('#'+id).html(output)
                    }   
                })
            }



            async function deleteDisc(transd_Id){     

                await $.ajax({
                    type: "POST",
                    url: "exec/delete.php",
                    data: {
                        transdid:transd_Id,
                        action:"delete_disc"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){

                            getDiscounts('discount_list').then( () => {

                                selectedDisc('selected_disc')
                            })
                            .then( () => {

                                getTotal('grand_total')
                            })
                        }
                    }
                })
            }
        // ======================= Discounts END =====================



        // ======================= Pay Cash ============================
            function payCashInpt(num){

                $('#p_amount_val').val($('#p_amount_val').val() + num)

                var p_amount    = parseInt($('#p_amount_val').val())
                var grand_total = parseInt($('#g_total_val').val())

                var change      = p_amount - grand_total

                if(change <= 0){

                    change = 0
                }

                $('#p_change').html(parseFloat(change))
                $('#p_change_val').val(change)

            }
        // ======================= Pay Cash END ========================

        

        // ======================= Pay Credit ===========================
            function payCredit(){

                var trans_Id = $('#trans_Id').val()
                var g_total  = $('#g_total').html()
                var emp_dd   = $('#qr_code_val').val()

                setTimeout(function(){

                    if(g_total < 0){

                        // g_total = 0;

                        toastr.error('Please use discount with the right amount', 'Discount number exceed', { "progressBar": true });
                    }

                    else{

                        $.ajax({
                            type: "POST",
                            url: "exec/update.php",
                            data: {
                                empid:emp_dd,
                                transid:trans_Id,
                                gtotal:g_total,
                                action:"pay_credit"
                            },
                            dataType: "JSON",
                            success: function (response) {
                                
                                if(response == '1'){

                                    setTimeout(function(){
                                        clearCookies();
                                        location.href='pos.php'
                                        
                                    }, 1000)

                                }

                                else if(response == '2'){

                                    toastr.error('Something went wrong', 'Please contact your developer ', { "progressBar": true });
                                }

                                else if(response == '3'){

                                    toastr.info('Item has been missing', 'Please contact your developer ', { "progressBar": true });
                                }

                                else if(response == '4'){

                                    toastr.info('Not Allowed for credits', 'Please activate cashless feature', { "progressBar": true });
                                }
                            }
                        })

                    }

                }, 500)
            }
        // ======================= Pay Credit END =======================



        async function catTabs(id){ //jm

            var output =''

            await $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    action:"category_tabs"
                },
                dataType: "JSON",
                success: function (response) {

                    output+='<li class="nav-item" onclick="tabContents(``)">';
                    output+='<a class="nav-link active" data-toggle="tab" href="#">All</a>';
                    output+='</li>';

                    $.each(response, function(key, value){

                        output+='<li class="nav-item" onclick="tabContents(`'+ value.Cat_Id +'`)">'
                        output+='<a class="nav-link" data-toggle="tab" href="#">'+ value.Cat_name +'</a>'
                        output+='</li>'
                    })

                    
                    $('#'+id).html(output)
                }
            })
        }



        function tabContents(cat_id){

            itemList('item_list', cat_id, '')
        }



        async function creditChckr(emp_Id){

            // var emp_Id = $('#emp_id').val()

            await $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    empid:emp_Id,
                    action:"credit_chckr"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    if(response == '1'){

                        $('#credit_stat').attr('style', 'background:green; color:white; border-radius: 20px;')
                        $('#credit_stat').attr('class', 'fa fa-check p-1')

                        // $('#payCashBtn').prop('disabled', true)
                    }

                    else if(response == '0'){

                        $('#credit_stat').attr('style', 'background:red; color:white; border-radius: 20px;')
                        $('#credit_stat').attr('class', 'fa fa-close p-1')
                    }

                    else if(response == ''){

                        $('#credit_stat').attr('style', 'background:red; color:white; border-radius: 20px;')
                    }
                }
            })
        }



        function newTransc(){   

            var trans_Id = $('#trans_Id').val()
            var emp_dd   = $('#qr_code_val').val()

            $.ajax({
                type: "POST",
                url: "exec/insert.php",
                data: {
                    transid:trans_Id,
                    emphash:emp_dd,
                    action:'new_transaction'
                },
                dataType: "JSON",
                success: function (response) {
                    
                    if(response == '1'){

                        console.log('Added Successfully')
                    }
                }
            })
        }

        function clearCookies() {
            setCookie('CUST_NAME', '', -1);
            setCookie('TRANS_ID', '', -1);
            setCookie('Grand_Total', '', -1);
            setCookie('DISCOUNTS', '', -1);
            setCookie('ITEM_NAME', '', -1);
            setCookie('ITEM_ID', '', -1);
            setCookie('ITEM_QTY', '', -1);
            setCookie('ITEM_PRICE', '', -1);
            
        }




    </script>

    
  </body>

</html>
