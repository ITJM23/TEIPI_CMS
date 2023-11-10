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

    <title>Canteen Management System | Cashless</title>

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

    <link href="../assets/css/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />

    <link href="../assets/css/toastr.min.css" rel="stylesheet"/>

    <link href="../assets/css/select2.min.css" rel="stylesheet">

    <!-- Sidebar CSS-->
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>

    <!-- Custom Style-->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>

    <style>

        .select2-results { color:#000; }

    </style>
    
  </head>

  <body class="bg-theme bg-theme6">
  
    <?php

        if($_COOKIE["CMS_usrlevel"] != 1){

            echo "<script>location.href='index.php';</script>";
        }

    ?>

    <!-- Start wrapper-->
      <div id="wrapper">
      
        <?php include "layout/sidebar.php"; ?>

        <?php include "layout/topbar.php"; ?>

        <div class="clearfix"></div>
        
        <div class="content-wrapper">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8">

                        <div class="card">

                            <div class="card-header">
                                <h4>Cashless Feature</h4>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    
                                    <div class="col-lg-4">
                                        <p><b>Employee</b></p>
                                        <select class="form-control" name="emp_dd2" id="emp_dd2"></select>
                                    </div>

                                </div>

                                <br>

                                <table class="table table-hover table-striped" id="cashless_tbl" style="width:100%;">

                                    <thead class="bg-light text-uppercase">
                                        <tr>
                                            <th>ID Number</th>
                                            <th>Name</th>
                                            <th>Date Added</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody class="table-bordered"></tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg">

                        <form method="POST" id="cashlessForm">

                            <div class="card">

                                <div class="card-header">
                                    <h5>Add an employee</h5>
                                </div>

                                <div class="card-body">

                                    <div class="form-group">
                                        <p><b>Employee</b></p>
                                        <select class="form-control" name="emp_dd" id="emp_dd" style="width:100%;"></select>
                                    </div>

                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Submit</button>
                                    <button type="button" class="btn btn-light">Clear</button>
                                </div>

                            </div>

                        </form>

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

    <!-- sidebar-menu js -->
    <script src="../assets/js/sidebar-menu.js"></script>

    <!-- loader scripts -->
    <script src="../assets/js/jquery.loading-indicator.js"></script>

    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/dataTables.responsive.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="../assets/js/toastr.min.js"></script>

    <script src="../assets/js/select2.min.js"></script>

    <!-- Custom scripts -->
    <script src="../assets/js/app-script.js"></script>

    <script src="../assets/js/functions.js"></script>

    <script>
        
        $(document).ready(function(){

            empDD('emp_dd')
            $('#emp_dd').select2()

            empDD('emp_dd2')
            $('#emp_dd2').select2()

            cashlessTbl('cashless_tbl', '')

            $('#cashlessForm').on('submit', function(aa){

                aa.preventDefault()

                var data = $('#cashlessForm').serializeArray()

                data.push(
                    {name: 'action', value: 'new_cashless'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/insert.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#cashless_tbl').DataTable().ajax.reload()

                            empDD('emp_dd')

                            $('#emp_dd').select2()

                            toastr.success('You activated cashless feature', 'Successfully Added', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                        }

                        else if(response == '4'){

                            toastr.info('Employee record already exist', 'Already Exist', { "progressBar": true });
                        }
                    }
                })
            })

            $('#emp_dd2').on('change', function(){

                var emp_dd = $('#emp_dd2').val()

                $('#cashless_tbl').DataTable().destroy()

                cashlessTbl('cashless_tbl', emp_dd)
            })
        })



        function cashlessTbl(id, emp_id){

            var dataTable = $('#'+id).DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,
                "bSort": false,
                "searching": false,
                "bInfo":false,
                "searching":false,
                "order" : [],
                "ajax" : {
                    url:"datatables/cashless_tbl.php",
                    type: "POST",
                    data:{
                        emphash:emp_id
                    }
                },
                dom: 'Bfrtip',
                //     buttons: [
                    //         { extend: 'copyHtml5', className: 'btn btn-outline-primary' },
                    //         { extend: 'csvHtml5', className: 'btn btn-outline-primary' },
                    //         { extend: 'excelHtml5', className: 'btn btn-outline-primary' },
                    //         { extend: 'pdfHtml5', className: 'btn btn-outline-primary' }
                    
                    //     ],
                    // "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            })
        }

        

        function setInactive(credit_id){    

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {

                if (willDelete) {

                    $.ajax({
                        type: "POST",
                        url: "exec/delete.php",
                        data: {
                            creditid:credit_id,
                            action:"inactive_cashless"
                        },
                        dataType: "JSON",
                        success: function (response) {
                            
                            if(response == '1'){  

                                $('#cashless_tbl').DataTable().ajax.reload()

                                swal("Successfully Removed", {
                                    icon: "success",
                                })
                            }

                            else if(response == '2'){

                                toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                            }

                            else if(response == '3'){

                                toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                            }
                        }
                    })
                } 
            
                // else {
                //     swal("Your imaginary file is safe!");
                // }
            })

        }

    </script>

    
  </body>

</html>
