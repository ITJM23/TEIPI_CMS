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

    <title>Canteen Management System | Discount Settings</title>

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
                                <h4>Discounts</h4>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg">

                                        <div class="form-group col-6">
                                            <div class="icheck-material-white">
                                                <input type="checkbox" id="allow_checkbox" />
                                                <label for="allow_checkbox">Allow Applicable items only</label>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group d-flex align-items-center">
                                            <input type="checkbox"> &nbsp
                                            <p><b>Enable restrictions</b></p>
                                        </div> -->
                                    </div>

                                </div>

                                <table class="table table-hover" id="disc_tbl" style="width:100%;">

                                    <thead class="text-uppercase bg-light">
                                        <tr>
                                            <th>Discount Name</th>
                                            <th>Amount</th>
                                            <th>Frequency</th>
                                            <th>Date Modified</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody class="table-bordered"></tbody>

                                </table>

                            </div>

                        </div>

                    </div>



                    <!-- =============================== Add New Discount Form ========================== -->
                        <div class="col-lg" id="newForm">

                            <form method="POST" id="newDiscForm">

                                <div class="card">

                                    <div class="card-header">
                                        <h5>Add New Discount</h5>
                                    </div>

                                    <div class="card-body">

                                        <div class="form-group">
                                            <p><b>Discount Name</b></p>
                                            <input type="text" class="form-control" name="disc_name" id="disc_name" placeholder="Input discount name here">
                                        </div>

                                        <div class="form-group">
                                            <p><b>Amount</b></p>
                                            <input type="number" class="form-control" name="disc_amount" id="disc_amount" placeholder="Input amount here">
                                        </div>

                                        <div class="form-group">
                                            <p><b>Frequency</b></p>
                                            <input type="number" class="form-control" name="disc_freq" id="disc_freq" placeholder="Input frequency here">
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
                    <!-- =============================== Add New Item Form END ===================== -->



                     <!-- ============================== Edit an Item Form ========================== -->
                        <div class="col-lg" id="editForm" style="display:none;">

                            <form method="POST" id="editDiscForm">

                                <div class="card">

                                    <div class="card-header">
                                        <h5>Edit Discount</h5>
                                    </div>

                                    <div class="card-body">

                                        <input type="hidden" name="e_disc_id" id="e_disc_id">

                                        <div class="form-group">
                                            <p><b>Discount Name</b></p>
                                            <input type="text" class="form-control" name="e_disc_name" id="e_disc_name" placeholder="Input discount name here">
                                        </div>

                                        <div class="form-group">
                                            <p><b>Amount</b></p>
                                            <input type="number" class="form-control" name="e_disc_amount" id="e_disc_amount" placeholder="Input amount here">
                                        </div>

                                        <div class="form-group">
                                            <p><b>Frequency</b></p>
                                            <input type="number" class="form-control" name="e_disc_freq" id="e_disc_freq" placeholder="Input frequency here">
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary"> <span class="fa fa-check"></span> Save</button>
                                            <button type="button" class="btn btn-light" onclick="closeBtn()">Close</button>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </div>
                     <!-- ============================== Edit an Item Form END ====================== -->



                </div>

                <hr>

                <div class="row" id="applcble_items" style="display:none">

                    <div class="col-lg-8">
                        
                        <div class="card">

                            <div class="card-header">
                                <h5>Applicable Items <span class="text-info" id="disc_name_txt">(discount here)</span></h5>
                            </div>

                            <div class="card-body">

                                <table class="table table-bordered table-hover table-striped" id="appl_items_tbl">

                                    <thead class="bg-light">
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Date Added</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg">

                        <form method="POST" id="newItemForm">

                            <div class="card">

                                <div class="card-header">
                                    <h5>Add Item</h5>
                                </div>

                                <div class="card-body">

                                    <!-- <input type="text" name="appl_disc_id" id="appl_disc_id"> -->
                                    
                                    <div class="form-group">
                                        <p><b>Item</b></p>
                                        <select class="form-control" name="item_dd" id="item_dd" style="width:100%;"></select>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>

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

    <script src="../assets/js/datatables.min.js"></script>

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

            allowRestric()

            discountsTbl('disc_tbl')

            itemDD('item_dd')

            $('#item_dd').select2()

            $('#newDiscForm').on("submit", function(aa){

                aa.preventDefault()

                var data = $('#newDiscForm').serializeArray()

                data.push(
                    { name: 'action', value: 'new_discount'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/insert.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#newDiscForm')[0].reset()

                            $('#disc_tbl').DataTable().ajax.reload()

                            toastr.success('You added a new discount', 'Successfully Added', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                        }

                        else if(response == '4'){

                            toastr.info('discount already exist', 'Already Exist', { "progressBar": true });
                        }
                    }
                })
            })

            $('#editDiscForm').on("submit", function(ab){

                ab.preventDefault()

                var data = $('#editDiscForm').serializeArray()

                data.push(
                    {name:'action', value:'edit_disc_sett'}
                )

                $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#disc_tbl').DataTable().ajax.reload()

                            $('#editForm').hide()
                            $('#newForm').show()

                            toastr.success('You updated a discount', 'Successfully Updated', { "progressBar": true });
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

            $('#newItemForm').on("submit", function(ac){

                ac.preventDefault()

                var e_disc_Id   = $('#e_disc_id').val()
                var item_dd     = $('#item_dd').val()

                $.ajax({
                    type: "POST",
                    url: "exec/insert.php",
                    data: {
                        discid:e_disc_Id,
                        itemdd:item_dd,
                        action:"new_appl_item"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#appl_items_tbl').DataTable().destroy()

                             applItemsTbl('appl_items_tbl', e_disc_Id)

                            toastr.success('You added a new item', 'Successfully Added', { "progressBar": true });
                        }

                        else if(response == '2'){

                            toastr.error('Please contact your developer', 'Something went wrong', { "progressBar": true });
                        }

                        else if(response == '3'){

                            toastr.info('Please contact your developer', 'Item has been missing', { "progressBar": true });
                        }

                        else if(response == '4'){

                            toastr.info('Please try other item', 'Already Exist', { "progressBar": true });
                        }
                    }
                })
            })

            $('#allow_checkbox').change(function() {

                var allow_stat

                if(this.checked) {

                    allow_stat = 1
                }

                else{

                    allow_stat = 0
                }

                $.ajax({
                    type: "POST",
                    url: "exec/update.php",
                    data: {
                        allowstat:allow_stat,
                        action:"allow_item"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){

                            console.log('You changed restrictions')
                        }
                    }
                })

            })
            
        })



        function discountsTbl(id){

            var dataTable = $('#'+id).DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,
                "bSort": false,
                "bInfo":false,
                "order" : [],
                "ajax" : {
                    url:"datatables/disc_sett_tbl.php",
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

        

        function editDisc(disc_id){

            $('#newForm').hide()
            $('#editForm').show()

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    discid:disc_id,
                    action:"edit_disc"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    $('#e_disc_id').val(disc_id)
                    $('#e_disc_name').val(response.DiscName)
                    $('#e_disc_amount').val(response.DiscAmount)
                    $('#e_disc_freq').val(response.DiscQty)

                    $('#applcble_items').show()

                    $('#disc_name_txt').html("("+response.DiscName+")")

                    $('#appl_items_tbl').DataTable().destroy()

                    applItemsTbl('appl_items_tbl', disc_id)
                }
            })
        }



        function deleteDisc(disc_id){

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
                            discid:disc_id,
                            action:"delete_disc_sett"
                        },
                        dataType: "JSON",
                        success: function (response) {
                            
                            if(response == '1'){  

                                $('#disc_tbl').DataTable().ajax.reload()

                                toastr.success('You removed a discount', 'Successfully Removed', { "progressBar": true });
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



        // ================== Applicable Items ==================
            function applItemsTbl(id, disc_id){

                var dataTable = $('#'+id).DataTable({

                    "responsive": true,
                    "processing": true,
                    "serverSide": true,
                    "bSort": false,
                    "bInfo":false,
                    "order" : [],
                    "ajax" : {
                        url:"datatables/appl_items_tbl.php",
                        type: "POST",
                        data:{
                            discid:disc_id
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



            function itemDD(id){

                $.ajax({
                    type: "POST",
                    url: "exec/fetch.php",
                    data: {
                        action:"item_dd"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        $('#'+id).html(response)
                    }
                })
            }



            function deleteApplItem(appl_item_Id){

                $.ajax({
                    type: "POST",
                    url: "exec/delete.php",
                    data: {
                        applitemid:appl_item_Id,
                        action:"del_appl_item"
                    },
                    dataType: "JSON",
                    success: function (response) {
                        
                        if(response == '1'){  

                            $('#appl_items_tbl').DataTable().ajax.reload()

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
        // ================== Applicable Items END ==============



        function closeBtn(){

            $('#editForm').hide()

            $('#applcble_items').hide()

            $('#newForm').show()
        }



        function allowRestric(){

            $.ajax({
                type: "POST",
                url: "exec/fetch.php",
                data: {
                    action:"check_restrictions"
                },
                dataType: "JSON",
                success: function (response) {
                    
                    if(response == '1'){

                        $('#allow_checkbox').prop('checked', true)
                    }
                    
                    else{

                        $('#allow_checkbox').prop('checked', false)
                    }
                }
            })
        }


        
    </script>

    
  </body>

</html>
