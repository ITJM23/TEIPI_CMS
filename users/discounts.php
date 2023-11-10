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

    <title>Canteen Management System |Discounts</title>

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

    <link href="../assets/css/toastr.min.css" rel="stylesheet">

    <!-- Custom Style-->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>
    
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
                                <h4>Transaction Discounts</h4>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-3">
                                        <p><b>Discount</b></p>
                                        <div class="d-flex align-items-center">
                                            <select class="form-control" name="discount_dd" id="discount_dd"></select>
                                        </div>
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
                                        <p style="color:transparent;">Action</p>
                                        <button type="button" class="btn btn-light" onclick="printPDF()">Print PDF</button>
                                    </div>

                                </div><br><br><br>

                                <div class="row">

                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-light border-info" onclick="cutOffFil('')">All</button>
                                        <button type="button" class="btn btn-light border-info" onclick="cutOffFil('1st')">1st cutoff</button>
                                        <button type="button" class="btn btn-light border-info" onclick="cutOffFil('2nd')">2nd cutoff</button>
                                    </div>

                                    <div class="col-lg-4 text-center">
                                        <p>employee discounts</p>
                                        <h5><b id="trans_date">as of <?php echo date('M d, Y', strtotime("now")); ?></b></h5>
                                    </div>

                                </div><br>

                                <div class="row" id="disc_cards">

                                    <!-- <div class="col-lg-4">

                                        <div class="card border border-success">

                                            <div class="card-body text-success">
                                                <h4 class="mb-0 font-weight-bold"><span id="total_transc">0</span><span class="float-right"><i class="fa fa-shopping-cart"></i></span></h4><br>
                                                <p class="mb-0 small-font">Total transactions<span class="float-right text-success" style="font-weight:bold"></span></p>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="card border border-info">

                                            <div class="card-body text-info">
                                                <h4 class="mb-0 font-weight-bold"><span id="total_disc1">P0.00</span><span class="float-right"><i class="fa-solid fa-percent"></i></span></h4><br>
                                                <p class="mb-0 small-font">Total Free Rice <span class="float-right text-success" style="font-weight:bold"></span></p>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="card border border-info">

                                            <div class="card-body text-info">
                                                <h4 class="mb-0 font-weight-bold"><span id="total_disc2">P0.00</span><span class="float-right"><i class="fa-solid fa-percent"></i></span></h4><br>
                                                <p class="mb-0 small-font">Total 10 Pesos Discount <span class="float-right text-success" style="font-weight:bold"></span></p>
                                            </div>

                                        </div>

                                    </div> -->

                                </div>

                                <table class="table table-hover" id="emp_disc_tbl" style="width:100%;">

                                    <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th>Date Added</th>
                                            <th>Transaction ID</th>
                                            <th>Employee</th>
                                            <th>Discount</th>
                                            <th>Amount</th>
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

    <script src="../assets/js/toastr.min.js"></script>

 
    <!-- sidebar-menu js -->
    <script src="../assets/js/sidebar-menu.js"></script>

    <!-- loader scripts -->
    <script src="../assets/js/jquery.loading-indicator.js"></script>

    <!-- Custom scripts -->
    <script src="../assets/js/app-script.js"></script>

    <script src="../assets/js/functions.js"></script>

    <script>
        
        $(document).ready(function(){

            discountDD('discount_dd')

            // totalTrans('total_transc', '', '')
            // totalDisc('total_disc1', 2,  '', '')
            // totalDisc('total_disc2', 1,  '', '')

            discCards('disc_cards', '', '')

            discountsTbl('emp_disc_tbl', '', '')

            $('#discount_dd').on('change', function(){

                var disc_val    = $('#discount_dd').val()
                var date_fil1   = $('#date_fil1').val()
                var date_fil2   = $('#date_fil2').val()

                $('#emp_disc_tbl').DataTable().destroy()

                discountsTbl('emp_disc_tbl', disc_val, date_fil1, date_fil2)

            })

        })

        

        function discountsTbl(id, disc_Id, date_fil1, date_fil2){

            var dataTable = $('#'+id).DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,
                "bSort": false,
                "bInfo":false,
                "searching": false,
                "order" : [],
                "ajax" : {
                    url:"datatables/trans_disc_tbl.php",
                    type: "POST",
                    data:{
                        discid:disc_Id,
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



        function discountDD(id){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    action:"discount_dd"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#'+id).html(response)
                }
            })
        }

        

        function dateFilter(){

            var disc_val = $('#discount_dd').val()

            var date_fil1 = $('#date_fil1').val()
            var date_fil2 = $('#date_fil2').val()

            if(date_fil1 != '' && date_fil2 != ''){

                // totalTrans('total_transc', date_fil1, date_fil2)
                // totalDisc('total_disc1', 2,  date_fil1, date_fil2)
                // totalDisc('total_disc2', 1,  date_fil1, date_fil2)

                discCards('disc_cards', date_fil1, date_fil2)

                $('#emp_disc_tbl').DataTable().destroy()

                discountsTbl('emp_disc_tbl', disc_val, date_fil1, date_fil2)

                $('#trans_date').html("From " + formatDate(date_fil1) + " to " + formatDate(date_fil2))
            }

        }

        

        function totalDisc(id, disc_Id, date_fil1, date_fil2){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    discid:disc_Id,
                    datefil1:date_fil1,
                    datefil2:date_fil2,
                    action:"total_disc"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#'+id).html("P"+response)
                }
            })
        }



        function totalTrans(id, date_fil1, date_fil2){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    datefil1:date_fil1,
                    datefil2:date_fil2,
                    action:"count_trans"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#'+id).html(response)

                }
            })
        }



        function printPDF(){

            var discount_dd = $('#discount_dd').val()
            var date_fil1   = $('#date_fil1').val()
            var date_fil2   = $('#date_fil2').val()

            location.href='print_discounts.php?discid='+discount_dd+"&datefil1="+date_fil1+"&datefil2="+date_fil2;
        }



        function cutOffFil(co_val){

            var disc_val = $('#discount_dd').val()

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

                    $('#emp_disc_tbl').DataTable().destroy()

                    // totalTrans('total_transc', response.FirstDate, response.LastDate)
                    // totalDisc('total_disc1', 2, response.FirstDate, response.LastDate)
                    // totalDisc('total_disc2', 1, response.FirstDate, response.LastDate)

                    discCards('disc_cards',  response.FirstDate, response.LastDate)

                    discountsTbl('emp_disc_tbl', disc_val, response.FirstDate, response.LastDate)

                    $('#trans_date').html("From " + formatDate(response.FirstDate) + " to " + formatDate(response.LastDate))
                }
            })

            // empTrans('emp_trans_tbl', emp_id, date_fil1, date_fil2)
        }



        function discCards(id, date_fil1, date_fil2){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    datefil1:date_fil1,
                    datefil2:date_fil2,
                    action:"discount_cards"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#'+id).html(response)
                }
            })
        }

        

    </script>

    
  </body>

</html>
