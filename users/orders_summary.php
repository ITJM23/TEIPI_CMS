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

    <title>Canteen Management System | Servings Summary</title>

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

    <link href="../assets/css/dataTables.bootstrap4.css" rel="stylesheet" />
    
    <link href="../assets/css/responsive.dataTables.min.css" rel="stylesheet" />

    <!-- <link href="../assets/css/toastr.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="../assets/css/select2.min.css">

    <!-- Custom Style-->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>

    <style>

        /* .select2-search input { background-color: #00f; } */

        .select2-results { color:#000; }

    </style>
    
  </head>

  <body class="bg-theme bg-theme6">
  


    <!-- Start wrapper-->
      <div id="wrapper">
      
        <?php include "layout/sidebar.php"; ?>

        <?php include "layout/topbar.php"; ?>

        <div class="clearfix"></div>
        
        <div class="content-wrapper">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-header">
                                <h4>Orders Summary</h4>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3">
                                        <p><b>Category</b></p>
                                        <select class="form-control" name="cat_dd" id="cat_dd"></select>
                                    </div>

                                    <div class="col-lg-3">
                                        <p><b>From</b></p>
                                        <input type="date" class="form-control" name="date_fil1" id="date_fil1">
                                    </div>

                                    <div class="col-lg-3">
                                        <p><b>To</b></p>
                                        <input type="date" class="form-control" name="date_fil2" id="date_fil2">
                                    </div>

                                    <div class="col-lg-1">
                                        <p style="color:transparent;">Action</p>
                                        <button type="button" class="btn btn-info" onclick="dateFilter()">Apply</button>
                                    </div>

                                    <div class="col-lg text-right">
                                        <!-- <p style="color:transparent;">Action</p>
                                        <button type="button" class="btn btn-light" onclick="printPDF()">Print PDF</button> -->
                                    </div>

                                </div><br><br>

                                <div class="row">

                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-light border-info" onclick="cutOffFil('')">All</button>
                                        <button type="button" class="btn btn-light border-info" onclick="cutOffFil('1st')">1st cutoff</button>
                                        <button type="button" class="btn btn-light border-info" onclick="cutOffFil('2nd')">2nd cutoff</button>
                                    </div>

                                    <div class="col-lg-4 text-center">

                                        <p>order summary</p>
                                        <h5><b id="trans_date">as of <?php echo date('M d, Y', strtotime("now")); ?></b></h5>

                                    </div>

                                </div><br>

                                <table class="table table-hover" id="orders_summ_tbl" style="width:100%;">

                                    <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Orders</th>
                                            <!-- <th>Grand Total</th> -->
                                        </tr>
                                    </thead>

                                    <tbody class="table-bordered"></tbody>

                                </table>

                            </div>

                        </div>

                    </div>

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

    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/dataTables.responsive.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.js"></script>
    <script src="../assets/js/dataTables.buttons.min.js"></script>
    <script src="../assets/js/jszip.min.js"></script>
    <script src="../assets/js/buttons.html5.min.js"></script>

    <!-- <script src="../assets/js/toastr.min.js"></script> -->

    <script src="../assets/js/select2.min.js"></script>

 
    <!-- sidebar-menu js -->
    <script src="../assets/js/sidebar-menu.js"></script>

    <!-- loader scripts -->
    <script src="../assets/js/jquery.loading-indicator.js"></script>

    <!-- Custom scripts -->
    <script src="../assets/js/app-script.js"></script>

    <script src="../assets/js/functions.js"></script>

    <script>
        
        $(document).ready(function(){

            catDD('cat_dd')

            $('#cat_dd').select2()

            orderSummTbl('orders_summ_tbl', '', '', '')

            // $('#payment_dd').on('change', function(){

            //     var pay_method = $('#payment_dd').val()
            //     var date_fil1 = $('#date_fil1').val()
            //     var date_fil2 = $('#date_fil2').val()

            //     $('#credit_trans_tbl').DataTable().destroy()

            //     discountsTbl('credit_trans_tbl', pay_method, date_fil1, date_fil2)
            // })
        })

        

        function orderSummTbl(id, category, date_fil1, date_fil2){

            var dataTable = $('#'+id).DataTable({
                // "select": true,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "bSort": false,
                "bInfo":false,
                "order" : [],
                "ajax" : {
                    url:"datatables/order_summary_tbl.php",
                    type: "POST",
                    data:{
                        catid:category,
                        datefil1:date_fil1,
                        datefil2:date_fil2
                    }
                },
                dom: 'Blfrtip',
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 entries', '25 entries', '50 entries', 'All' ]
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copyHtml5', className: 'btn btn-light' },
                    { extend: 'csvHtml5', className: 'btn btn-light' },
                    { extend: 'excelHtml5', className: 'btn btn-light' },
                    { extend: 'pageLength', className: 'btn btn-dark' }
                    
                ],
            })
        }

        

        function dateFilter(){

            var cat_dd      = $('#cat_dd').val()
            var date_fil1   = $('#date_fil1').val()
            var date_fil2   = $('#date_fil2').val()

            if(date_fil1 != '' && date_fil2 != ''){

                $('#orders_summ_tbl').DataTable().destroy()

                orderSummTbl('orders_summ_tbl', cat_dd, date_fil1, date_fil2)

                $('#trans_date').html("From " + formatDate(date_fil1) + " to " + formatDate(date_fil2))

            }

        }



        // function printPDF(){

        //     var payment_dd = $('#payment_dd').val()
        //     var date_fil1  = $('#date_fil1').val()
        //     var date_fil2  = $('#date_fil2').val()

        //     location.href='print_transactions.php?pm='+payment_dd+"&datefil1="+date_fil1+"&datefil2="+date_fil2;
        // }



        function cutOffFil(co_val){

            var cat_dd = $('#cat_dd').val()

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    coval:co_val,
                    action:'get_cutoff'
                },
                dataType: "JSON",
                success: function (response) {

                    $('#date_fil1').val(response.FirstDate)
                    $('#date_fil2').val(response.LastDate)

                    $('#orders_summ_tbl').DataTable().destroy()

                    orderSummTbl('orders_summ_tbl', cat_dd, response.FirstDate, response.LastDate)

                    $('#trans_date').html("From " + formatDate(response.FirstDate) + " to " + formatDate(response.LastDate))

                    $('#trans_date').html("From " + formatDate(response.FirstDate) + " to " + formatDate(response.LastDate))
                }
            })

        // empTrans('emp_trans_tbl', emp_id, date_fil1, date_fil2)
        }




    </script>

    
  </body>

</html>
