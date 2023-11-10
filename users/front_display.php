<!DOCTYPE html>

<html lang="en">

  <head>
    
    <meta charset="utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <meta name="description" content=""/>

    <meta name="author" content=""/>

    <title>Canteen Management System | Front Display</title>

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

  <body class="bg-theme bg-theme6"><br><br>

    <div class="row">

        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">
                    <h4>Order List</h4>
                </div>

                <div class="card-body">

                    <table class="table table-hover">

                        <thead class="bg-light text-uppercase">
                            <tr>
                                <td><b>No.</b></td>
                                <td><b>Item Name</b></td>
                                <td><b>Price</b></td>
                                <td><b>Quantity</b></td>
                                <td><b>Total</b></td>
                            </tr>
                        </thead>

                        <tbody class="table-bordered" id="orders_tbl"></tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg">

            <div class="card">

                <div class="card-header">
                    <h5>Receipt</h5>
                    <input type="hidden" name="trans_id" id="trans_id">
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-lg-8">
                            <h5><b id="emp_name">---</b></h5>
                            <input type="hidden" name="emp_id" id="emp_id">
                        </div>

                        <div class="col-lg d-flex align-items-center justify-between">
                            <h5 class="mr-3"><b>Credit</b></h5>
                            <span class="fa fa-check p-2"id="credit_stat"></span>
                        </div>

                    </div>

                    <br><br>

                    <table class="table">

                        <thead class="bg-light">
                            <tr>
                                <th>Discount</th>
                                <th>Qty</th>
                            </tr>
                        </thead>

                        <tbody class="table-bordered" id="disc_tbl"></tbody>

                    </table>

                    <br><br>

                    <div class="row">

                        <div class="col-lg-6">
                            <h3><b>Grand Total</b></h3>
                        </div>
                        <div class="col-lg-6">
                            <h1><b class="text-info" id="grand_total">0.00</b></h1>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
      
    <!-- simplebar js -->
    <script src="../assets/plugins/simplebar/js/simplebar.js"></script>

    <script src="../assets/js/datatables.min.js"></script>

    <script src="../assets/js/dataTables.bootstrap4.js"></script>

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
            
            activeTransc()

            setInterval(function(){

                activeTransc()

            }, 1000)
        })



        function activeTransc(){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    action:"active_transc"
                },
                dataType: "JSON",
                success: function (response) {

                    var emp_name = response.Fname + " " + response.Lname
                    
                    $('#emp_id').val(response.EmpId)
                    $('#trans_id').val(response.TransId)
                    $('#emp_name').html(emp_name)

                    creditChckr(response.EmpId)

                    getTotal('grand_total', response.TransId)

                    discountTbl('disc_tbl', response.TransId)

                    ordersTbl('orders_tbl', response.TransId)
                }
            })
        }

        

        function creditChckr(emp_Id){

            // var emp_Id = $('#emp_id').val()

            $.ajax({
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
                        $('#credit_stat').attr('class', 'fa fa-check p-2')
                    }

                    else if(response == '0'){

                        $('#credit_stat').attr('style', 'background:red; color:white; border-radius: 20px;')
                        $('#credit_stat').attr('class', 'fa fa-close p-2')
                    }

                    else if(response == ''){

                        $('#credit_stat').attr('style', 'background:red; color:white; border-radius: 20px;')
                    }
                }
            })
        }



        function getTotal(id, trans_Id){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    transid:trans_Id,
                    action:"get_cart_total"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#'+id).html(response)

                }
            })
        }



        function discountTbl(id, trans_Id){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    transid:trans_Id,
                    action:"discount_tbl"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#'+id).html(response)
                }
            })
        }



        function ordersTbl(id, trans_Id){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    transid:trans_Id,
                    action:"orders_tbl"
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
