<?php
    
    include "../includes/db.php";
    include "../includes/functions.php";

    date_default_timezone_set("Asia/Manila");

    $current_hour = date('H', strtotime("now"));
    // $current_hour = "01";

    $cookie_Id = $_COOKIE['CMS_usr_Id'];

    if(isset($_POST['action'])){
        
        

        if($_POST['action'] == 'new_item'){

            if( isset($_POST['item_name']) &&
                isset($_POST['cat_dd']) && 
                isset($_POST['item_amount']) && 
                // isset($_POST['item_arr']) &&
                isset($_POST['item_barcode']) ){

                $item_name      = $_POST['item_name'];
                $cat_Id         = $_POST['cat_dd'];
                $item_amount    = $_POST['item_amount'];
                // $item_arr       = $_POST['item_arr'];
                $item_barcode   = $_POST['item_barcode'];

                $query = "SELECT Item_name FROM items ";
                $query .="WHERE Item_name = '$item_name' ";
                $query .="AND Price = '$item_amount' ";
                $query .="AND Cat_Id = '$cat_Id' ";
                $query .="AND `Status` = 1 ";

                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                if($fetch){

                    if($count == 0){

                        $query2 = "INSERT INTO items (Item_name, Cat_Id, Price, Barcode_val, Date_added, Time_added) ";
                        $query2 .="VALUES ('$item_name', '$cat_Id', '$item_amount', '$item_barcode', curdate(), curtime() ) ";

                        $insert2 = mysqli_query($con, $query2);

                        if($insert2){

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

                    echo json_encode('2');
                }
            }  
            
            else{

                echo json_encode('3');
            }
        
        }

        

        else if($_POST['action'] == 'new_user_acc'){

            if( isset($_POST['fname']) && 
                isset($_POST['lname']) && 
                isset($_POST['usr_name']) && 
                isset($_POST['usr_pass']) && 
                isset($_POST['usr_level']) ){

                $fname   = $_POST['fname'];
                $lname   = $_POST['lname'];
                $usrname = $_POST['usr_name'];
                $usrpass = $_POST['usr_pass'];
                $usrlevel= $_POST['usr_level'];

                $new_password = password_hash($usrpass, PASSWORD_BCRYPT, array('cost' => 12));

                $query = "SELECT User_Id FROM users WHERE Username = '$usrname' ";
                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                if($fetch){

                    if($count == 0){

                        $query2 = "INSERT INTO users (Lname, Fname, Username, `Password`, User_lvl_Id, Date_added, Time_added) ";
                        $query2 .="VALUES ('$lname', '$fname', '$usrname', '$new_password', '$usrlevel', curdate(), curtime() ) ";

                        $insert2 = mysqli_query($con, $query2);

                        if($insert2){

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

                    echo json_encode('2');
                }

            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'add_to_cart'){

            if(isset($_POST['transid']) && isset($_POST['itemid']) && isset($_POST['emphash'])){

                $emp_hash = $_POST['emphash'];
                $trans_Id = $_POST['transid'];
                $item_Id  = $_POST['itemid'];



                // ====================== Fetch Employee ID ===================
                    $query0 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                    $fetch0 = mysqli_query($con2, $query0);

                    if($fetch0){

                        $row0 = mysqli_fetch_assoc($fetch0);

                        $emp_Id = $row0['Emp_Id'];
                    }
                // ====================== Fetch Employee ID END ===============



                if($current_hour == '00' || $current_hour <= '05'){

                    $the_date = date('Y-m-d', strtotime('-1 day'));
                }

                else{

                    $the_date = date('Y-m-d', strtotime('now')); // JM DATE
                }


                $query = "SELECT Trans_det_Id, Trans_Id, COUNT(Item_Id) as Total ";
                $query .="FROM trans_details ";
                $query .="WHERE Trans_Id = '$trans_Id' AND Item_Id = '$item_Id' ";

                $fetch = mysqli_query($con, $query);

                if($fetch){
                    
                    $row = mysqli_fetch_assoc($fetch);  

                    $trans_det_Id   = $row['Trans_det_Id'];
                    $count          = $row['Total'];

                    if($count > 0){

                        $query2     = "UPDATE trans_details SET Quantity = Quantity + 1 WHERE Trans_det_Id = '$trans_det_Id' ";
                        $update2    = mysqli_query($con, $query2);

                        if($update2){

                            echo json_encode('1');
                        }

                        else{

                            echo json_encode('2');
                        }
                    }

                    else{

                        $query2 = "INSERT INTO trans_details (Trans_Id, Item_Id, Quantity) ";
                        $query2 .="VALUES ('$trans_Id', '$item_Id', 1) ";

                        $insert2 = mysqli_query($con, $query2);

                        if($insert2){

                            echo json_encode('1');
                            
                            // $query3 = "SELECT COUNT(Trans_Id) as Total FROM transactions ";
                            // $query3 .="WHERE Trans_Id = '$trans_Id' AND Emp_Id = '$emp_Id' AND Date_added = '$the_date' ";
                            
                            // $fetch3 = mysqli_query($con, $query3);

                            // if($fetch3){

                            //     $row3 = mysqli_fetch_assoc($fetch3);
                            //     $count3 = $row3['Total'];

                            //     if($count3 == 0 || $count3 == '' || $count3 == null){
                                    


                            //         $queryn = "SELECT COUNT(Trans_Id) as TotalEnt FROM transactions ";
                            //         $queryn .="WHERE Trans_Id = '$trans_Id' AND Emp_Id = '$emp_Id' AND Date_added = '$the_date' ";
                            
                            //         $fetchn = mysqli_query($con, $queryn);

                            //         if($fetchn){

                            //             $rown = mysqli_fetch_assoc($fetchn);

                            //             $total_entry = $rown['TotalEnt'];

                            //             if($total_entry == 0 || $total_entry == '' || $total_entry == null){

                            //                 $query4 = "INSERT INTO transactions (Trans_Id, Emp_Id, `Status`, Date_added, Time_added, `User_Id`) ";
                            //                 $query4 .="VALUES ('$trans_Id', '$emp_Id', 2, '$the_date', curtime(), '$cookie_Id') ";
                                            
                            //                 $insert4 = mysqli_query($con, $query4);

                            //                 if($insert4){

                            //                     echo json_encode('1');
                            //                 }

                            //                 else{

                            //                     echo json_encode('2');
                            //                 }
                            //             }
                            //         }



                            //     }

                            //     else{

                            //         echo json_encode('1');
                            //     }
                            // }

                            // else{

                            //     echo json_encode('2');
                            // }

                        }

                        else{

                            echo json_encode('2');
                        }
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

        

        else if($_POST['action'] == 'new_cust_amount'){

            if(isset($_POST['transid']) && isset($_POST['customval']) && isset($_POST['empid'])){

                $trans_Id       = $_POST['transid'];
                $cust_amount    = $_POST['customval'];
                $emp_hash       = $_POST['empid'];

                // ====================== Fetch Employee ID ===================
                    $query0 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                    $fetch0 = mysqli_query($con2, $query0);

                    if($fetch0){

                        $row0 = mysqli_fetch_assoc($fetch0);

                        $emp_Id = $row0['Emp_Id'];
                    }
                // ====================== Fetch Employee ID END ===============

                if($current_hour == '00' || $current_hour <= '05'){

                    $the_date = date('Y-m-d', strtotime('-1 day'));
                }

                else{

                    $the_date = date('Y-m-d', strtotime('now'));
                }

                $query  = "INSERT INTO trans_custom (Trans_Id, Amount) VALUES ('$trans_Id', '$cust_amount') ";
                $insert = mysqli_query($con, $query);
                
                if($insert){

                    $query2 = "SELECT Trans_Id FROM transactions WHERE Trans_Id = '$trans_Id' AND Emp_Id = '$emp_Id' ";
                    $fetch2 = mysqli_query($con, $query2);

                    $count2 = mysqli_num_rows($fetch2);

                    if($fetch2){

                        if($count2 == 0){

                            $query3 = "INSERT INTO transactions (Trans_Id, Emp_Id, Date_added, Time_added, `User_Id`, `Status`) ";
                            $query3 .="VALUES ('$trans_Id', '$emp_Id', '$the_date', curtime(), '$cookie_Id', 2) ";

                            $insert3 = mysqli_query($con, $query3);

                            if($insert3){

                                echo json_encode('1');
                            }
                        }

                        else{

                            echo json_encode('1');
                        }
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



        else if($_POST['action'] == 'use_discount'){

            if(isset($_POST['transid']) && isset($_POST['emphash']) && isset($_POST['discid'])){

                $trans_Id = $_POST['transid'];
                $emp_hash = $_POST['emphash'];
                $disc_Id  = $_POST['discid'];

                // ==================== Getting employee ID ====================
                    $query = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                    $fetch = mysqli_query($con2, $query);

                    if($fetch){

                        $row = mysqli_fetch_assoc($fetch);

                        $emp_Id = $row['Emp_Id'];
                    }
                // ==================== Getting employee ID END ================

                
                // ==================== Discount Information =====================
                    $query0 = "SELECT Quantity FROM disc_settings WHERE Disc_Id = '$disc_Id' ";
                    $fetch0 = mysqli_query($con, $query0);

                    $row0 = mysqli_fetch_assoc($fetch0);

                    $disc_qty = $row0['Quantity'];
                // ==================== Discount Information END =================


                if($current_hour == '00' || $current_hour <= '05'){

                    $the_date = date('Y-m-d', strtotime('-1 day'));
                }

                else{

                    $the_date = date('Y-m-d', strtotime('now'));
                }

                // ==================== Employee Transactions ======================
                    $query1 = "SELECT COUNT(transactions.Trans_Id) as Total, trans_disc.Disc_Id, disc_settings.Quantity ";
                    $query1 .="FROM transactions ";
                    $query1 .="LEFT JOIN trans_disc ";
                    $query1 .="ON transactions.Trans_Id = trans_disc.Trans_Id ";
                    $query1 .="LEFT JOIN disc_settings ";
                    $query1 .="ON trans_disc.Disc_Id = disc_settings.Disc_Id ";
                    $query1 .="WHERE transactions.Emp_Id = '$emp_Id' AND trans_disc.Disc_Id = '$disc_Id' ";
                    $query1 .="AND transactions.Date_added = '$the_date' AND NOT transactions.Status = 3 ";

                    $fetch1 = mysqli_query($con, $query1);

                    if($fetch1){

                        $row1 = mysqli_fetch_assoc($fetch1);

                        $count1 = $row1['Total'];

                        if($count1 < $disc_qty){

                            $query_check0 = "SELECT Sett_val FROM settings WHERE Sett_name = 'Allow_items' ";
                            $fetch_check0 = mysqli_query($con, $query_check0);
        
                            if($fetch_check0){
        
                                $fetch_row0 = mysqli_fetch_assoc($fetch_check0);
        
                                $sett_val = $fetch_row0['Sett_val'];
        
                                if($sett_val == 1){
                                    
                                    // ================== Check if items purchased is applicable for discount ==================
        
                                        $purchased_items = array();
        
                                        $query_check1 = "SELECT Item_Id FROM trans_details WHERE Trans_Id = '$trans_Id' ";
                                        $fetch_check1 = mysqli_query($con, $query_check1);
        
                                        if($fetch_check1){
        
                                            while($fetch_row = mysqli_fetch_assoc($fetch_check1)){
        
                                                $ord_item_Id = $fetch_row['Item_Id'];
        
                                                $query_check2 = "SELECT Discted_Item_Id FROM discted_items ";
                                                $query_check2 .="WHERE Item_Id = '$ord_item_Id' AND Disc_Id = '$disc_Id' ";
        
                                                $fetch_check2 = mysqli_query($con, $query_check2);
        
                                                $count_check2 = mysqli_num_rows($fetch_check2);
        
                                                if($count_check2 == 0){
        
                                                    array_push($purchased_items, 0);
                                                }
        
                                                else{
        
                                                    array_push($purchased_items, 1);
                                                }
                                            }
                                        }
        
                                    // ================== Check if items purchased is applicable for discount END ==============
        
                                    if(in_array(1, $purchased_items)){
        
                                        $query2     ="INSERT INTO trans_disc (Disc_Id, Trans_Id) VALUES ('$disc_Id', '$trans_Id') ";
                                        $insert2    = mysqli_query($con, $query2);
        
                                        if($insert2){
        
                                            echo json_encode('1');
        
                                        }
        
                                        else{
        
                                            echo json_encode('2');
                                        }
        
                                    }
                                    
                                    else{
                                        
                                        echo json_encode('5');
        
                                    }
                                }
        
                                else{



                                    $queryz = "SELECT COUNT(transactions.Trans_Id) as Totalz, trans_disc.Disc_Id, disc_settings.Quantity ";
                                    $queryz .="FROM transactions ";
                                    $queryz .="LEFT JOIN trans_disc ";
                                    $queryz .="ON transactions.Trans_Id = trans_disc.Trans_Id ";
                                    $queryz .="LEFT JOIN disc_settings ";
                                    $queryz .="ON trans_disc.Disc_Id = disc_settings.Disc_Id ";
                                    $queryz .="WHERE transactions.Emp_Id = '$emp_Id' AND trans_disc.Disc_Id = '$disc_Id' ";
                                    $queryz .="AND transactions.Date_added = '$the_date' AND NOT transactions.Status = 3 ";

                                    $fetchz = mysqli_query($con, $queryz);

                                    if($fetchz){

                                        $rowz = mysqli_fetch_assoc($fetchz);

                                        $countz = $rowz['Totalz'];

                                        if($countz < $disc_qty){

                                            $query2     ="INSERT INTO trans_disc (Disc_Id, Trans_Id) VALUES ('$disc_Id', '$trans_Id') ";
                                            $insert2    = mysqli_query($con, $query2);
                
                                            if($insert2){
                
                                                echo json_encode('1');
                
                                            }
                                            
                                            else{
                                                
                                                echo json_encode('5');
                
                                            }
                                        }
                                    }

        
                                }
                            }
        
                        }
        
                        else{
        
                            echo json_encode('4');
                        }
                    }
                // ==================== Employee Transactions END ==================


            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'new_cashless'){

            if(isset($_POST['emp_dd'])){

                $emp_Id = $_POST['emp_dd'];

                $query = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_Id' ";
                $fetch = mysqli_query($con2, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $emp_Id = $row['Emp_Id'];

                    $query1 = "SELECT Emp_Id FROM emp_credits WHERE Emp_Id = '$emp_Id' ";
                    $fetch1 = mysqli_query($con, $query1);

                    $count1 = mysqli_num_rows($fetch1);

                    if($fetch1){

                        if($count1 == 0){

                            $query2 = "INSERT INTO emp_credits (Emp_Id, Date_added, Time_added) ";
                            $query2 .="VALUES ('$emp_Id', curdate(), curtime() ) ";

                            $insert2 = mysqli_query($con, $query2);

                            if($insert2){

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



        else if($_POST['action'] == 'new_discount'){

            if(isset($_POST['disc_name']) && isset($_POST['disc_amount']) && isset($_POST['disc_freq'])){

                $disc_name      = $_POST['disc_name'];
                $disc_amount    = $_POST['disc_amount'];
                $disc_freq      = $_POST['disc_freq'];

                $query = "SELECT Disc_Id FROM discounts WHERE Disc_name = '$disc_name' AND `Status` = 1 ";
                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                if($fetch){

                    if($count == 0){

                        $query2 = "INSERT INTO discounts (Disc_name, Disc_amount, Date_added, Time_added) ";
                        $query2 .="VALUES ('$disc_name', '$disc_amount', curdate(), curtime() ) ";

                        $insert2 = mysqli_query($con, $query2);

                        $last_Id = mysqli_insert_id($con);

                        if($insert2){

                            $query3 = "INSERT INTO disc_settings (Disc_Id, Quantity) ";
                            $query3 .="VALUES ('$last_Id', '$disc_freq') ";

                            $insert3 = mysqli_query($con, $query3);

                            if($insert3){
                                
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

                        echo json_encode('4');
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



        else if($_POST['action'] == 'new_category'){

            if(isset($_POST['cat_name']) && isset($_POST['cat_arrngmnt'])){

                $cat_name = $_POST['cat_name'];
                $arrngmnt = $_POST['cat_arrngmnt'];

                $query = "SELECT Cat_Id FROM categories WHERE Cat_name = '$cat_name' AND `Status` = 1 ";
                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                if($fetch){

                    if($count == 0){

                        $query2 = "INSERT INTO categories (Cat_name, Arrangement, Date_added, Time_added) ";
                        $query2 .="VALUES ('$cat_name', '$arrngmnt', curdate(), curtime() ) ";

                        $insert2 = mysqli_query($con, $query2);

                        if($insert2){

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
            }

            else{

                echo json_encode('3');
            }
        }



        else if($_POST['action'] == 'new_appl_item'){

            if(isset($_POST['discid']) && isset($_POST['itemdd'])){

                $disc_Id = $_POST['discid'];
                $item_Id = $_POST['itemdd'];

                $query = "SELECT Discted_Item_Id FROM discted_items WHERE Disc_Id = '$disc_Id' AND Item_Id = '$item_Id' ";
                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                if($fetch){

                    if($count == 0){

                        $query2 = "INSERT INTO discted_items (Disc_Id, Item_Id, Date_added, Time_added) ";
                        $query2 .="VALUES ('$disc_Id', '$item_Id', curdate(), curtime() ) ";

                        $insert2 = mysqli_query($con, $query2);

                        if($insert2){

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

                    echo json_encode('2');
                }
            }

            else{

                echo json_encode('3');
            }
        }



        // =================== New Function ====================
            else if($_POST['action'] == 'new_transaction'){

                if(isset($_POST['transid']) && isset($_POST['emphash']) ){

                    $trans_Id   = $_POST['transid'];
                    $emp_hash   = $_POST['emphash'];

                    // ====================== Fetch Employee ID ===================
                        $query0 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                        $fetch0 = mysqli_query($con2, $query0);

                        if($fetch0){

                            $row0 = mysqli_fetch_assoc($fetch0);

                            $emp_Id = $row0['Emp_Id'];
                        }
                    // ====================== Fetch Employee ID END ===============

                    // ==================== Get Date an Time ==================
                        if($current_hour == '00' || $current_hour <= '05'){
                            
                            $the_date = date('Y-m-d', strtotime('-1 day'));
                        }
                        
                        else{
                            
                            $the_date = date('Y-m-d', strtotime('now'));
                        }
                    // ==================== Get Date an Time END ==============



                    $query = "INSERT INTO transactions (Trans_Id, Emp_Id, `Status`, Date_added, Time_added, `User_Id`) ";
                    $query .="VALUES ('$trans_Id', '$emp_Id', 2, '$the_date', curtime(), '$cookie_Id') ";

                    $insert = mysqli_query($con, $query);

                    if($insert){

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
        // =================== New Function END ================



    }

?>