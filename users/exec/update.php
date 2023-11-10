<?php
    
    include "../includes/db.php";
    include "../includes/functions.php";

    if(isset($_POST['action'])){


        if($_POST['action'] == 'plus_qty'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query  ="UPDATE trans_details SET Quantity = Quantity + 1 WHERE Trans_det_Id = '$trans_Id' ";
                $update = mysqli_query($con, $query);

                if($update){

                    echo json_encode('1');
                }

                else{

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }

        

        else if($_POST['action'] == 'minus_qty'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query  ="UPDATE trans_details SET Quantity = Quantity - 1 WHERE Trans_det_Id = '$trans_Id' ";
                $update = mysqli_query($con, $query);

                if($update){

                    echo json_encode('1');
                }

                else{

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }

        

        else if($_POST['action'] == 'void_trans'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query  = "UPDATE transactions SET Status = 3 WHERE Trans_Id = '$trans_Id' ";
                $update = mysqli_query($con, $query);
                
                if($update){

                    $query2     = "DELETE FROM trans_disc WHERE Trans_Id = '$trans_Id' ";
                    $remove2    = mysqli_query($con, $query2);

                    if($remove2){

                        echo json_encode('1');
                    }

                    else{

                        echo json_encode('2');
                    }
                }

                else{

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'pay_cash'){

            if(isset($_POST['transid']) && isset($_POST['gtotal']) && isset($_POST['p_amount_val']) && isset($_POST['p_change_val'])){

                $trans_Id = $_POST['transid'];
                $g_total  = $_POST['gtotal'];
                $amount   = $_POST['p_amount_val'];
                $p_change = $_POST['p_change_val'];

                $query = "UPDATE transactions SET Grand_Total = '$g_total', Pay_amount = '$amount', ";
                $query .="Pay_Method = 'Cash', Trans_change = '$p_change', Status = 1 ";
                $query .="WHERE Trans_Id = '$trans_Id' ";

                $update = mysqli_query($con, $query);

                if($update){

                    // ====================== Clear unfinished transactions ==================
                        $query2 = "UPDATE transactions SET `Status` = 3 ";
                        $query2 .="WHERE Date_added = curdate() AND `Status` = 2 ";

                        $update2 = mysqli_query($con, $query2);

                        if($update2){

                            echo json_encode('1');

                        }
                    // ====================== Clear unfinished transactions END ==============

                }

                else{

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'edit_item'){

            if( isset($_POST['e_item_id']) && 
                isset($_POST['e_cat_dd']) && 
                isset($_POST['e_item_name']) && 
                isset($_POST['e_item_amount']) &&
                // isset($_POST['e_item_arr']) &&
                isset($_POST['e_item_barcode']) ){

                $item_Id    = $_POST['e_item_id'];
                $cat_Id     = $_POST['e_cat_dd'];
                $itemname   = $_POST['e_item_name'];
                $amount     = $_POST['e_item_amount'];
                // $item_arr   = $_POST['e_item_arr'];
                $barcode    = $_POST['e_item_barcode'];

                $query = "UPDATE items SET Item_name = '$itemname', Cat_Id = '$cat_Id', Price = '$amount', ";
                $query .="Barcode_val = '$barcode', Date_added = curdate(), Time_added = curtime() ";
                $query .="WHERE Item_Id = '$item_Id' ";

                $update = mysqli_query($con, $query);

                if($update){

                    echo json_encode('1');
                }

                else{

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'pay_credit'){

            if(isset($_POST['empid']) && isset($_POST['transid']) && isset($_POST['gtotal'])){

                $emp_Id   = $_POST['empid'];
                $trans_Id = $_POST['transid'];
                $g_total  = $_POST['gtotal'];

                if($g_total < 0){

                    $g_total = 0;
                }

                // ====================== Fetching employee ID ==========================
                    $query0 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_Id' ";
                    $fetch0 = mysqli_query($con2, $query0);

                    if($fetch0){

                        $row0 = mysqli_fetch_assoc($fetch0);

                        $emp_Id = $row0['Emp_Id'];
                    }
                // ====================== Fetching employee ID END ======================

                // ====================== Verify if allowed ======================
                    $query1 = "SELECT Credit_Id, `Status` FROM emp_credits WHERE Emp_Id = '$emp_Id' ";
                    $fetch1 = mysqli_query($con, $query1);

                    $count = mysqli_num_rows($fetch1);

                    if($fetch1){

                        if($count > 0){

                            $row1 = mysqli_fetch_assoc($fetch1);

                            $credit_stat = $row1['Status'];

                            if($credit_stat != 0){

                                $query = "UPDATE transactions SET Grand_Total = '$g_total', Pay_Method = 'Credit', Status = 1 ";
                                $query .="WHERE Trans_Id = '$trans_Id' ";

                                $update = mysqli_query($con, $query);

                                if($update){

                                    echo json_encode('1');
                                }

                                else{

                                    echo json_encode('2');
                                }
                            }

                            else{

                                echo json_encode('4');
                            }

                        }

                        else{

                            echo json_encode('4');
                        }
                    }                    
                // ====================== Verify if allowed END ==================

                // ====================== Clear unfinished transactions ==================
                    $query2 = "UPDATE transactions SET `Status` = 3 ";
                    $query2 .="WHERE Date_added = curdate() AND `Status` = 2 ";

                    $update2 = mysqli_query($con, $query2);

                    // if($update2){


                    // }
                // ====================== Clear unfinished transactions END ==============

            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'edit_usr_acc'){

            if( isset($_POST['e_usr_id']) &&
                isset($_POST['e_fname']) &&
                isset($_POST['e_lname']) &&
                isset($_POST['e_usr_name']) &&
                isset($_POST['e_usr_level']) ){
                
                $usr_Id = $_POST['e_usr_id'];
                $fname  = $_POST['e_fname'];
                $lname  = $_POST['e_lname'];
                $usrname= $_POST['e_usr_name'];
                $usrlvl = $_POST['e_usr_level'];
                // $oldpass= $_POST['e_old_pass'];

                $query = "UPDATE users SET Lname = '$lname', Fname = '$fname', Username = '$usrname', User_lvl_Id = '$usrlvl' ";
                $query .="WHERE User_Id = '$usr_Id' ";

                $update = mysqli_query($con, $query);

                if($update){

                    if($_POST['e_usr_pass'] != ''){

                        $usr_pass = $_POST['e_usr_pass'];

                        $new_password = password_hash($usr_pass, PASSWORD_BCRYPT, array('cost' => 12));

                        $query2     = "UPDATE users SET `Password` = '$new_password' WHERE User_Id = '$usr_Id' ";
                        $update2    = mysqli_query($con, $query2);

                        if($update2){

                            echo json_encode('1');
                        }

                        else{

                            echo json_encode('2');
                        }
                    }

                    else{

                        echo json_encode('1');
                    }
                }

                else{

                    echo json_encode('2');
                }
            }
        }



        else if($_POST['action'] == 'edit_disc_sett'){

            if(isset($_POST['e_disc_id']) && isset($_POST['e_disc_name']) && isset($_POST['e_disc_amount']) && isset($_POST['e_disc_freq']) ){

                $disc_Id    = $_POST['e_disc_id'];
                $disc_name  = $_POST['e_disc_name'];
                $disc_amount= $_POST['e_disc_amount'];
                $disc_freq  = $_POST['e_disc_freq'];

                $query  ="UPDATE discounts SET Disc_name = '$disc_name', Disc_amount = '$disc_amount', Date_added = curdate(), Time_added = curtime() ";
                $query .="WHERE Disc_Id = '$disc_Id' ";

                $update = mysqli_query($con, $query);
                
                if($update){

                    $query2     = "UPDATE disc_settings SET Quantity = '$disc_freq' WHERE Disc_Id = '$disc_Id' ";
                    $update2    = mysqli_query($con, $query2);

                    if($update2){

                        echo json_encode('1');
                    }

                    else{

                        echo json_encode('2');
                    }
                }

                else{

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'edit_cat'){

            if(isset($_POST['e_cat_id']) && isset($_POST['e_cat_name']) && isset($_POST['e_cat_arrngmnt'])){

                $cat_Id   = $_POST['e_cat_id'];
                $cat_name = $_POST['e_cat_name'];
                $arrngmnt = $_POST['e_cat_arrngmnt'];

                $query = "UPDATE categories SET Arrangement = '$arrngmnt', Cat_name = '$cat_name' WHERE Cat_Id = '$cat_Id' ";
                $fetch = mysqli_query($con, $query);

                if($fetch){

                    echo json_encode('1');
                }

                else{

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'allow_item'){

            if(isset($_POST['allowstat'])){

                $allow_stat = $_POST['allowstat'];

                $query  = "UPDATE settings SET Sett_val = '$allow_stat' WHERE Sett_name = 'Allow_items' ";
                $update = mysqli_query($con, $query);

                if($update){

                    echo json_encode('1');
                }

                else{

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }

    }

?>