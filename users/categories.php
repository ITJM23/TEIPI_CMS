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

    <title>Canteen Management System | Categories</title>

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

    <link href="../assets/css/select2.min.css" rel="stylesheet">

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

                    <div class="col-lg-8">

                        <div class="card">

                            <div class="card-header">
                                <h4>Categories</h4>
                            </div>

                            <div class="card-body">

                                <table class="table table-hover" id="category_tbl" style="width:100%;">

                                    <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th>Category Name</th>
                                            <th>Arrangement</th>
                                            <th>Date Modified</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody class="table-bordered"></tbody>

                                </table>

                            </div>

                        </div>

                    </div>



                    <!-- =============================== Add New Category Form ========================== -->
                        <div class="col-lg" id="newForm">

                            <form method="POST" id="newCatForm">

                                <div class="card">

                                    <div class="card-header">
                                        <h5>Add New Category</h5>
                                    </div>

                                    <div class="card-body">

                                        <div class="form-group">
                                            <p><b>Category Name</b></p>
                                            <input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="Input category name here" required>
                                        </div>

                                        <div class="form-group">
                                            <p><b>Arrangement</b></p>
                                            <input type="text" class="form-control" name="cat_arrngmnt" id="cat_arrngmnt" placeholder="Input arrangement number here" required>
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success"> <span class="fa fa-check"></span> Submit</button>
                                            <button type="button" class="btn btn-light">Clear</button>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </div>
                    <!-- ============================== Add New Category Form END ===================== -->



                     <!-- ============================== Edit an Category Form ========================== -->
                        <div class="col-lg" id="editForm" style="display:none;">

                            <form method="POST" id="editCatForm">

                                <div class="card">

                                    <div class="card-header">
                                        <h5>Edit Category</h5>
                                    </div>

                                    <div class="card-body">

                                        <input type="hidden" name="e_cat_id" id="e_cat_id">

                                        <div class="form-group">
                                            <p><b>Category Name</b></p>
                                            <input type="text" class="form-control" name="e_cat_name" id="e_cat_name" placeholder="Input category name here" required>
                                        </div>

                                        <div class="form-group">
                                            <p><b>Arrangement</b></p>
                                            <input type="text" class="form-control" name="e_cat_arrngmnt" id="e_cat_arrngmnt" placeholder="Input arrangement number here" required>
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary"> <span class="fa fa-check"></span> Save</button>
                                            <button type="button" class="btn btn-light" onclick="newCat()">Close</button>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </div>
                     <!-- ============================== Edit an Category Form END ====================== -->



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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="../assets/js/toastr.min.js"></script>

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

            catsTbl('category_tbl')

            $('#newCatForm').on("submit", function(aa){

                aa.preventDefault()

                var data = $('#newCatForm').serializeArray()

                data.push(
                    { name: 'action', value: 'new_category'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/insert.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#newCatForm')[0].reset()

                            $('#category_tbl').DataTable().ajax.reload()

                            $('#cat_name').focus()

                            toastr.success('You added a new category', 'Successfully Added', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                        }

                        else if(response == '4'){

                            toastr.info('Category already exist', 'Already Exist', { "progressBar": true });
                        }
                    }
                })
            })

            $('#editCatForm').on("submit", function(ab){

                ab.preventDefault()

                var data = $('#editCatForm').serializeArray()

                data.push(
                    {name:'action', value:'edit_cat'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#editCatForm')[0].reset()

                            $('#category_tbl').DataTable().ajax.reload()

                            $('#editForm').hide()
                            $('#newForm').show()

                            toastr.success('You updated a category', 'Successfully Updated', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                        }
                    }
                })
            })
            
        })



        function catsTbl(id){

            var dataTable = $('#'+id).DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,
                "bSort": false,
                "bInfo":false,
                "order" : [],
                "ajax" : {
                    url:"datatables/categories_tbl.php",
                    type: "POST",
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

        

        function newCat(){

            $('#editForm').hide()
            $('#newForm').show()
        }



        function editCat(cat_id){

            $('#newForm').hide()
            $('#editForm').show()

            $('#e_cat_id').val(cat_id)

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    catid:cat_id,
                    action:"cat_info"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#e_cat_name').val(response.CatName)
                    $('#e_cat_arrngmnt').val(response.Arrngmnt)
                }
            })
        }

        

        function deleteCat(cat_id){

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
                            catid:cat_id,
                            action:"delete_cat"
                        },
                        dataType: "JSON",
                        success: function (response) {
                            
                            if(response == '1'){  

                                $('#category_tbl').DataTable().ajax.reload()

                                toastr.success('You removed an item', 'Successfully Removed', { "progressBar": true });
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
