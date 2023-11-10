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

    <title>Canteen Management System | Items</title>

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
                                <h4>Items</h4>
                            </div>

                            <div class="card-body">

                                <table class="table table-hover" id="items_tbl" style="width:100%;">

                                    <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Amount</th>
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



                    <!-- =============================== Add New Item Form ========================== -->
                        <div class="col-lg" id="newForm">

                            <form method="POST" id="newItemForm">

                                <div class="card">

                                    <div class="card-header">
                                        <h5>Add New Item</h5>
                                    </div>

                                    <div class="card-body">

                                        <div class="form-group">
                                            <p><b>Item Name</b></p>
                                            <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Input item name here" required>
                                        </div>

                                        <div class="form-group">
                                            <p><b>Category</b></p>
                                            <select class="form-control" name="cat_dd" id="cat_dd" style="width:100%;"></select>
                                        </div>

                                        <div class="form-group">
                                            <p><b>Amount</b></p>
                                            <input type="number" class="form-control" name="item_amount" id="item_amount" placeholder="Input amount here" required>
                                        </div>

                                        <!-- <div class="form-group">
                                            <p><b>Arrangement</b></p>
                                            <input type="number" class="form-control" name="item_arr" id="item_arr" placeholder="Input number here" required>
                                        </div> -->

                                        <div class="form-group">
                                            <p><b>Barcode <span class="text-muted">(optional)</span></b></p>
                                            <input type="text" class="form-control" name="item_barcode" id="item_barcode" placeholder="Input barcode here">
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
                    <!-- ============================== Add New Item Form END ===================== -->



                     <!-- ============================== Edit an Item Form ========================== -->
                        <div class="col-lg" id="editForm" style="display:none;">

                            <form method="POST" id="editItemForm">

                                <div class="card">

                                    <div class="card-header">
                                        <h5>Edit Item</h5>
                                    </div>

                                    <div class="card-body">

                                        <input type="hidden" name="e_item_id" id="e_item_id">

                                        <div class="form-group">
                                            <p><b>Item Name</b></p>
                                            <input type="text" class="form-control" name="e_item_name" id="e_item_name" placeholder="Input item name here" required>
                                        </div>

                                        <div class="form-group">
                                            <p><b>Category</b></p>
                                            <select class="form-control" name="e_cat_dd" id="e_cat_dd" style="width:100%;"></select>
                                        </div>

                                        <div class="form-group">
                                            <p><b>Amount</b></p>
                                            <input type="number" class="form-control" name="e_item_amount" id="e_item_amount" placeholder="Input amount here" required>
                                        </div>

                                        <!-- <div class="form-group">
                                            <p><b>Arrangement</b></p>
                                            <input type="number" class="form-control" name="e_item_arr" id="e_item_arr" placeholder="Input number here" required>
                                        </div> -->

                                        <div class="form-group">
                                            <p><b>Barcode <span class="text-muted">(optional)</span></b></p>
                                            <input type="text" class="form-control" name="e_item_barcode" id="e_item_barcode" placeholder="Input barcode here">
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary"> <span class="fa fa-check"></span> Save</button>
                                            <button type="button" class="btn btn-light" onclick="newItem()">Close</button>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </div>
                     <!-- ============================== Edit an Item Form END ====================== -->



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

            catDD('cat_dd')

            $('#cat_dd').select2()

            catDD('e_cat_dd')

            $('#e_cat_dd').select2()

            itemsTbl('items_tbl')

            $('#newItemForm').on("submit", function(aa){

                aa.preventDefault()

                var data = $('#newItemForm').serializeArray()

                data.push(
                    { name: 'action', value: 'new_item'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/insert.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#newItemForm')[0].reset()

                            $('#items_tbl').DataTable().ajax.reload()

                            $('#item_name').focus()

                            toastr.success('You added a new item', 'Successfully Added', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                        }

                        else if(response == '4'){

                            toastr.info('Item already exist', 'Already Exist', { "progressBar": true });
                        }
                    }
                })
            })

            $('#editItemForm').on("submit", function(ab){

                ab.preventDefault()

                var data = $('#editItemForm').serializeArray()

                data.push(
                    {name:'action', value:'edit_item'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#editItemForm')[0].reset()

                            $('#items_tbl').DataTable().ajax.reload()

                            $('#editForm').hide()
                            $('#newForm').show()

                            toastr.success('You updated an item', 'Successfully Updated', { "progressBar": true });
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



        function itemsTbl(id){

            var dataTable = $('#'+id).DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,
                "bSort": false,
                "bInfo":false,
                "order" : [],
                "ajax" : {
                    url:"datatables/items_tbl.php",
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

        

        function editItem(item_id){

            $('#newForm').hide()
            $('#editForm').show()

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    itemid:item_id,
                    action:"edit_item"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    // $("#e_cat_dd").select2("val", response.CatId)
                    $("#e_cat_dd").val(response.CatId).trigger('change');
                    
                    $('#e_item_id').val(item_id)
                    $('#e_item_name').val(response.ItemName)
                    // $('#e_cat_dd').val(response.CatId)
                    $('#e_item_amount').val(response.ItemPrice)
                    // $('#e_item_arr').val(response.Arrngemnt)
                    $('#e_item_barcode').val(response.Barcode)
                }
            })
        }

        

        function newItem(){

            $('#editForm').hide()
            $('#newForm').show()
        }



        function deleteItem(item_id){

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
                            itemid:item_id,
                            action:"delete_item"
                        },
                        dataType: "JSON",
                        success: function (response) {
                            
                            if(response == '1'){  

                                $('#items_tbl').DataTable().ajax.reload()

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
