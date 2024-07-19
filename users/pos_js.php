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
            empDD('emp_dd')
            $('#emp_dd').select2()
            $('#qr_code_val').focus()
            getCartOrders('order_list')
            catTabs('cat_tab')
            searchEmp()


           

            function getTranscID(){

            $.ajax({
                type: "POST",
                url: "exec/fetch_js.php",
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

           

            

          
            

        });

        function searchEmp(){

        $('#srchEmpMod').modal('show')
        //console.log('test');
        }


    </script>

    
  </body>

</html>
