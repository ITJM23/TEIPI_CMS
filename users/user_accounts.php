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

    <title>Canteen Management System | User Accounts</title>

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

    <!-- Sidebar CSS-->
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>

    <!-- Custom Style-->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>
    
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
                                <h4>User Accounts</h4>
                            </div>

                            <div class="card-body">

                                <table class="table table-hover table-striped" id="user_acc_tbl" style="width:100%;">

                                    <thead class="bg-light text-uppercase">
                                        <tr>
                                            <th>ID Number</th>
                                            <th>Username</th>
                                            <th>User Level</th>
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

                    <div class="col-lg" id="newUsrCard" >

                        <form method="POST" id="newUserForm">

                            <div class="card">

                                <div class="card-header">
                                    <h5>Add New User</h5>
                                </div>

                                <div class="card-body">

                                    <div class="form-group">
                                        <p><b>First Name</b></p>
                                        <input type="text" class="form-control" name="fname" id="fname" placeholder="Input first name here">
                                    </div>

                                    <div class="form-group">
                                        <p><b>Last Name</b></p>
                                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Input last name here">
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <p><b>Username</b></p>
                                        <input type="text" class="form-control" name="usr_name" id="usr_name" placeholder="Input username here">
                                    </div>

                                    <div class="form-group">
                                        <p><b>Password</b></p>
                                        <input type="password" class="form-control" name="usr_pass" id="usr_pass" placeholder="Input password here">
                                    </div>
                                    
                                    <div class="form-group">
                                        <p><b>User Level</b></p>
                                        <select class="form-control" name="usr_level" id="usr_level">
                                            <option value="">Select user level here</option>
                                            <option value="1">Administrator</option>
                                            <option value="2">Staff</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Submit</button>
                                    <button type="button" class="btn btn-light">Clear</button>
                                </div>

                            </div>

                        </form>

                    </div>

                    <div class="col-lg" id="editUsrCard" style="display:none;">

                        <form method="POST" id="editUserForm">

                            <div class="card">

                                <div class="card-header">
                                    <h5>Edit User</h5>
                                </div>

                                <div class="card-body">

                                    <input type="hidden" name="e_usr_id" id="e_usr_id">

                                    <div class="form-group">
                                        <p><b>First Name</b></p>
                                        <input type="text" class="form-control" name="e_fname" id="e_fname" placeholder="Input first name here" required>
                                    </div>

                                    <div class="form-group">
                                        <p><b>Last Name</b></p>
                                        <input type="text" class="form-control" name="e_lname" id="e_lname" placeholder="Input last name here" required>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <p><b>Username</b></p>
                                        <input type="text" class="form-control" name="e_usr_name" id="e_usr_name" placeholder="Input username here" required>
                                    </div>

                                    <div class="form-group">
                                        <p><b>New Password</b></p>
                                        <input type="password" class="form-control" name="e_usr_pass" id="e_usr_pass" placeholder="Input password here">
                                    </div>
                                    
                                    <div class="form-group">
                                        <p><b>User Level</b></p>
                                        <select class="form-control" name="e_usr_level" id="e_usr_level" required>
                                            <option value="">Select user level here</option>
                                            <option value="1">Administrator</option>
                                            <option value="2">Staff</option>
                                        </select>
                                    </div>

                                    <!-- <div class="form-group">
                                        <p><b>Old Password</b> <em>(to apply changes)</em></p>
                                        <input type="password" class="form-control" name="e_old_pass" id="e_old_pass" placeholder="Input old password here" required>
                                    </div> -->

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

    <!-- Custom scripts -->
    <script src="../assets/js/app-script.js"></script>

    <script src="../assets/js/functions.js"></script>

    <script>
        
        $(document).ready(function(){

            userAccTbl('user_acc_tbl')

            $('#newUserForm').on('submit', function(aa){

                aa.preventDefault()

                var data = $('#newUserForm').serializeArray()

                data.push(
                    {name: 'action', value: 'new_user_acc'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/insert.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#newUserForm')[0].reset()

                            $('#user_acc_tbl').DataTable().ajax.reload()

                            toastr.success('You added a new account', 'Successfully Added', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                        }

                        else if(response == '4'){

                            toastr.info('User account already exist', 'Already Exist', { "progressBar": true });
                        }
                    }
                })
            })

            $('#editUserForm').on('submit', function(ab){

                ab.preventDefault()

                var data = $('#editUserForm').serializeArray()

                data.push(
                    {name:'action', value:'edit_usr_acc'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#editUsrCard').hide()
                            $('#newUsrCard').show()

                            $('#e_old_pass').val('')

                            $('#user_acc_tbl').DataTable().ajax.reload()

                            toastr.success('You updated an account', 'Successfully Updated', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                        }

                        else if(response == '4'){

                            toastr.info('Please input the correct password', 'Invalid Password', { "progressBar": true });
                        }
                    }
                })
            })

        })



        function userAccTbl(id){

            var dataTable = $('#'+id).DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,
                "bSort": false,
                "bInfo":false,
                "order" : [],
                "ajax" : {
                    url:"datatables/user_acc_tbl.php",
                    type: "POST"
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



        function editAcc(acc_Id){

            $('#newUsrCard').hide()

            $('#editUsrCard').show()

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    accid:acc_Id,
                    action:"edit_acc_info"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#e_usr_id').val(acc_Id)
                    $('#e_fname').val(response.Fname)
                    $('#e_lname').val(response.Lname)
                    $('#e_usr_name').val(response.Usrname)
                    $('#e_usr_level').val(response.Level)
                }
            })
        }



        function deleteUser(acc_Id){

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
                            accid:acc_Id,
                            action:"delete_acc"
                        },
                        dataType: "JSON",
                        success: function (response) {
                            
                            if(response == '1'){  

                                $('#user_acc_tbl').DataTable().ajax.reload()

                                toastr.success('You removed an account', 'Successfully Removed', { "progressBar": true });
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

            })
        }

    </script>

    
  </body>

</html>
