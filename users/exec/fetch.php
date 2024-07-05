<?php
    
    include "../includes/db.php";
    include "../includes/functions.php";

    date_default_timezone_set("Asia/Manila");

    $current_hour = date('H', strtotime("now"));

    //========================== Checking User IDs ===========================
        if(isset($_COOKIE['CMS_usr_Id'])){

            $user_Id = $_COOKIE['CMS_usr_Id'];
        }

        else{

            $user_Id = 0;
        }
    //========================== Checking User IDs END =======================

    if(isset($_POST['action'])){



        if($_POST['action'] == 'user_info'){

            $query = "SELECT Lname, Fname, Username FROM users WHERE User_Id = '$user_Id' ";
            $fetch = mysqli_query($con, $query);

            if($fetch){

                $row = mysqli_fetch_assoc($fetch);

                $fname      = $row['Fname'];
                $lname      = $row['Lname'];
                $username   = $row['Username'];

                $arr = array('Fname' => $fname, 'Lname' => $lname, 'Usrname' => $username);

                echo json_encode($arr);
            }
        }

        

        else if($_POST['action'] == 'category_tabs'){

            $query = "SELECT Cat_Id, Cat_name FROM categories WHERE `Status` = 1 ";
            $fetch = mysqli_query($con, $query);

            if($fetch){

                $categories_arr = [];

                while($row = mysqli_fetch_assoc($fetch)){

                    $cat_Id     = $row['Cat_Id'];
                    $cat_name   = $row['Cat_name'];

                    $category_arr = array(
                        'Cat_Id' => $cat_Id,
                        'Cat_name' => $cat_name
                    );

                    array_push($categories_arr, $category_arr);
                }

                echo json_encode($categories_arr);
            }
        }

        

        else if($_POST['action'] == 'item_list'){

            $query = "SELECT Item_Id, Item_name, Price ";
            $query .="FROM items ";
            $query .="WHERE Status = 1 ";

            if($_POST['searchval'] != ''){

                $search_val = $_POST['searchval'];

                $query .="AND Item_name LIKE '%".$search_val."%' ";
            }

            if($_POST['catid'] != ''){

                $cat_Id = $_POST['catid'];

                $query .="AND Cat_Id = '$cat_Id' ";
            }

            $query .="ORDER BY Arrangement ASC ";

            $fetch = mysqli_query($con, $query);

            $count = mysqli_num_rows($fetch);

            if($fetch){

                $items_arr = array();

                $output ='';

                if($count > 0){

                    while($row = mysqli_fetch_assoc($fetch)){

                        $item_Id    = $row['Item_Id'];
                        $item_name  = $row['Item_name'];
                        $item_price = $row['Price'];
    
                        $item_arr = array(
                            'Item_Id' => $item_Id,
                            'Item_name' => $item_name,
                            'Item_price' => number_format($item_price, 2)
                        );

                        array_push($items_arr, $item_arr);
                    }
                }

                // else{

                //     $output .='<div class="col-lg-12 text-center">';
                //     $output .='<h5>No Results</h5>';
                //     $output .='</div>';
                // }

                echo json_encode($items_arr);
            }
        
        }



        else if($_POST['action'] == 'emp_dd'){

            $query = "SELECT employees.Emp_Id, employees.Emp_Hash, emp_info.Lname, emp_info.Fname, emp_info.Mname ";
            $query .="FROM employees LEFT JOIN emp_info ";
            $query .="ON employees.Emp_Id = emp_info.Emp_Id ";
            $query .="WHERE employees.randSalt1 = 1 AND Status = 1 ";

            $fetch = mysqli_query($con2, $query);

            // $count = mysqli_num_rows($fetch);

            if($fetch){

                $output ='';

                $output .='<option value="">Select an employee here</option>';

                while($row = mysqli_fetch_assoc($fetch)){

                    $emp_Id     = $row['Emp_Id'];
                    $emp_hash   = $row['Emp_Hash'];
                    $lname      = $row['Lname'];
                    $fname      = $row['Fname'];
                    $mname      = $row['Mname'];

                    $fullname = $fname ." ". $mname ." ". $lname;

                    $output .='<option value="'.$emp_hash.'">'.$fullname.'</option>';
                }

                echo json_encode($output);
            }
        }



        else if($_POST['action'] == 'login'){

            if(isset($_POST['username']) && isset($_POST['password'])){

                $username = $_POST['username'];
                $password = $_POST['password'];

                $query = "SELECT User_Id, Username, `Password`, User_lvl_Id ";
                $query .="FROM users WHERE Username = '$username' ";
                $query .="AND Status = 1 ";

                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                if($count > 0){

                    while($row = mysqli_fetch_array($fetch)){
                        
                        $db_user_Id         = escape($row['User_Id']);
                        $db_username		= escape($row['Username']);
                        $db_user_password 	= escape($row['Password']);
                        $db_user_level 		= escape($row['User_lvl_Id']);
                    }
    
                    if(isset($db_user_password)){
    
                        if(password_verify($password, $db_user_password)){
    
                            setcookie("CMS_usr_Id", $db_user_Id, time()+3600 * 24 * 365, '/');
                            setcookie("CMS_usrname", $db_username, time()+3600 * 24 * 365, '/');
                            setcookie("CMS_usrlevel", $db_user_level, time()+3600 * 24 * 365, '/');
    
                            if($db_user_level == 1){
    
                                echo json_encode('user1');
    
                            }
    
                            else if($db_user_level == 2){
    
                                echo json_encode('user2');
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
    
                    echo json_encode('4');
                    
                }
            }

            else{
    
                echo json_encode('3');
                
            }

        }



        else if($_POST['action'] == 'gnrt_trans_Id'){

            $datenow = date('YmdHis');
            $idmaking = md5(date(strtotime("now")).$user_Id);
            $currdate = $idmaking . $datenow;

            //edit id making jm

            

            $arr = array('TransId' => $currdate, 'TransId2' => substr($currdate, 0,10), 'UserId' => $user_Id);

            echo json_encode($arr);
        }



        else if($_POST['action'] == 'get_cart_orders'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query = "SELECT 
                            trans_details.Trans_det_Id, 
                            trans_details.Quantity, 
                            items.Item_name, 
                            items.Price ";

                $query .="FROM 
                            trans_details 
                        LEFT JOIN 
                            items ";

                $query .="ON trans_details.Item_Id = items.Item_Id ";

                $query .="WHERE     
                            trans_details.Trans_Id = '$trans_Id' 
                            AND NOT trans_details.Quantity = 0 ";

                $query .="ORDER BY trans_details.Trans_det_Id DESC ";


                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                if($fetch){

                    if($count > 0){

                        $orders_arr = array();

                        while($row = mysqli_fetch_assoc($fetch)){
                            
                            $trans_Id   = $row['Trans_det_Id'];
                            $item_name  = $row['Item_name'];
                            $item_qty   = $row['Quantity'];
                            $item_price = $row['Price'];

                            $order_arr = array(
                                'Trans_Id' => $trans_Id,
                                'Item_name' => $item_name,
                                'Item_qty' => $item_qty,
                                'Item_price' => number_format($item_price)
                            );

                            array_push($orders_arr, $order_arr);
                        }

                    }

                    else{

                        $orders_arr = array();
                    }

                    echo json_encode($orders_arr);
                }
            }
        }



        else if($_POST['action'] == 'get_cust_list'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query = "SELECT Trans_C_Id, Amount FROM trans_custom WHERE Trans_Id = '$trans_Id' ORDER BY Trans_C_Id DESC ";
                $fetch = mysqli_query($con, $query);

                if($fetch){
                    
                    $output ='';

                    while($row = mysqli_fetch_assoc($fetch)){

                        $trans_C_Id = $row['Trans_C_Id'];
                        $cust_amount= $row['Amount'];

                        $output .='<div class="d-flex align-items-center" style="justify-content: space-between;">';
                        $output .='<div>';
                        $output .='<h5>Custom Amount</h5>';
                        $output .='<p><b>P'.number_format($cust_amount).'</b></p>';
                        $output .='</div>';
                        $output .='<div class="d-flex align-tems-center">';
                        $output .='<button type="button" class="btn btn-danger" onclick="deleteCust(`'.$trans_C_Id.'`)"><span class="fa fa-trash"></span></button>';
                        $output .='</div>';
                        $output .='</div><hr>';
                    }

                    echo json_encode($output);
                }
            }
        }

        

        else if($_POST['action'] == 'get_discounts'){


            if($_POST['emphash'] != '' ){

                $emp_hash = $_POST['emphash'];

                // =================== Getting employee ID ====================
                    $query0 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                    $fetch0 = mysqli_query($con2, $query0);

                    if($fetch0){

                        $row0 = mysqli_fetch_assoc($fetch0);

                        $emp_Id = $row0['Emp_Id'];
                    }
                // =================== Getting employee ID END ================
            }
            

            $query = "SELECT discounts.Disc_Id, discounts.Disc_name, disc_settings.Quantity ";
            $query .="FROM discounts LEFT JOIN disc_settings ";
            $query .="ON discounts.Disc_Id = disc_settings.Disc_Id ";
            $query .="WHERE NOT discounts.Status = '' ";

            $fetch = mysqli_query($con, $query);

            if($fetch){

                $output ='';

                $discounts_arr = array();

                while($row = mysqli_fetch_assoc($fetch)){

                    $disc_Id    = $row['Disc_Id'];
                    $disc_name  = $row['Disc_name'];
                    $disc_freq  = $row['Quantity'];


                    if($current_hour == '00' || $current_hour <= '05'){

                        $the_date = date('Y-m-d', strtotime('-1 day'));
                    }
    
                    else{
    
                        $the_date = date('Y-m-d', strtotime('now'));
                    }


                    $query1 = "SELECT COUNT(transactions.Trans_Id) as Total1, trans_disc.Disc_Id, transactions.Emp_Id ";
                    $query1 .="FROM trans_disc LEFT JOIN transactions ";
                    $query1 .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
                    $query1 .="WHERE transactions.Emp_Id = '$emp_Id' ";
                    $query1 .="AND trans_disc.Disc_Id = '$disc_Id' ";
                    $query1 .="AND transactions.Date_added = '$the_date' ";
                    $query1 .="AND NOT transactions.Status = 3 ";

                    $fetch1 = mysqli_query($con, $query1);

                    if($fetch1){

                        $row1 = mysqli_fetch_assoc($fetch1);

                        $count1 = $row1['Total1'];

                        // $count1 = mysqli_num_rows($fetch1);

                        $avail_disc = ($disc_freq - $count1);
                    }


                    $discount_arr = array(
                        'Disc_Id' => $disc_Id,
                        'Disc_name' => $disc_name,
                        'Avail_disc' => $avail_disc,
                    );

                    array_push($discounts_arr, $discount_arr);

                }

                echo json_encode($discounts_arr);
            }
        }

        

        else if($_POST['action'] == 'get_cart_total'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                // ======================= Transaction Details =======================
                
                $query = "SELECT trans_details.Quantity, items.Price ";
                $query .="FROM trans_details LEFT JOIN items ";
                $query .="ON trans_details.Item_Id = items.Item_Id ";
                $query .="WHERE trans_details.Trans_Id = '$trans_Id' ";

                $fetch = mysqli_query($con, $query);

                $subtotal = 0;

                if($fetch){

                    while($row = mysqli_fetch_assoc($fetch)){

                        $order_qty  = $row['Quantity'];
                        $item_price = $row['Price'];

                        $sum = $item_price * $order_qty;

                        $subtotal += $sum;
                    }
                    // ======================= Transaction Details END ===================



                    // ================= Discounts ===================
                        $query1 = "SELECT trans_disc.Disc_Id, discounts.Disc_amount ";
                        $query1 .="FROM trans_disc LEFT JOIN discounts ";
                        $query1 .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
                        $query1 .="WHERE Trans_Id = '$trans_Id' ";

                        $fetch1 = mysqli_query($con, $query1);

                        $total_disc = 0;

                        if($fetch1){

                            while($row = mysqli_fetch_assoc($fetch1)){

                                $disc_amount = $row['Disc_amount'];

                                $total_disc += $disc_amount;
                            }
                        }
                    // ================= Discounts END ===============

                    // $order_sum = $subtotal + $custtotal;

                    $grand_total = $subtotal - $total_disc;

                    // $arr = array(
                    //     'Total1' => $grand_total,
                    //     'Total2' => number_format($grand_total, 2)
                    // );

                    echo json_encode($grand_total);
                }
            }
        }



        else if($_POST['action'] == 'selected_disc'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query = "SELECT trans_disc.Trans_D_Id, discounts.Disc_name ";
                $query .="FROM trans_disc LEFT JOIN discounts ";
                $query .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
                $query .="WHERE trans_disc.Trans_Id = '$trans_Id' ";

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $output ='';

                    $selected_discs = array();

                    while($row = mysqli_fetch_assoc($fetch)){

                        $trans_d_Id = $row['Trans_D_Id'];
                        $disc_name  = $row['Disc_name'];

                        $selected_disc = array(
                            'Trans_D_Id' => $trans_d_Id,
                            'Disc_name' => $disc_name
                        );

                        array_push($selected_discs, $selected_disc);
                    }

                    echo json_encode($selected_discs);
                }
            }
        }

        

        else if($_POST['action'] == 'edit_item'){

            if(isset($_POST['itemid'])){

                $item_Id = $_POST['itemid'];

                $query = "SELECT Cat_Id, Item_name, Price, Arrangement, Barcode_val ";
                $query .="FROM items WHERE Item_Id = '$item_Id' ";

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $cat_Id         = $row['Cat_Id'];
                    $item_name      = $row['Item_name'];
                    $item_price     = $row['Price'];
                    $arrangemnt     = $row['Arrangement'];
                    $barcode_val    = $row['Barcode_val'];

                    $arr = array(
                        'CatId' => $cat_Id,
                        'ItemName' => $item_name,
                        'ItemPrice' => $item_price,
                        'Arrngemnt' => $arrangemnt,
                        'Barcode' => $barcode_val
                    );

                    echo json_encode($arr);
                }
            }
        }

        

        else if($_POST['action'] == 'order_info'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query = "SELECT Emp_Id, Pay_amount, Grand_Total, Trans_change, Pay_Method ";
                $query .="FROM transactions ";
                $query .="WHERE Trans_Id = '$trans_Id' ";

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $emp_Id     = $row['Emp_Id'];
                    $pay_amount = $row['Pay_amount'];
                    $g_total    = $row['Grand_Total'];
                    $pay_change = $row['Trans_change'];
                    $pay_method = $row['Pay_Method'];

                    $query2 = "SELECT Lname, Fname, Mname FROM emp_info WHERE Emp_Id = '$emp_Id' ";
                    $fetch2 = mysqli_query($con2, $query2);

                    if($fetch2){

                        $row2 = mysqli_fetch_assoc($fetch2);

                        $lname = $row2['Lname'];
                        $fname = $row2['Fname'];
                        $mname = $row2['Mname'];

                        $arr = array(
                            'Payment' => number_format($pay_amount, 2),
                            'GTotal' => number_format($g_total, 2),
                            'PChange' => number_format($pay_change, 2),
                            'PMethod' => $pay_method,
                            'Lname' => $lname,
                            'Fname' => $fname,
                            'Mname' => $mname
                        );

                        echo json_encode($arr);
                    }


                }
            }
        }



        else if($_POST['action'] == 'discount_dd'){

            $query = "SELECT Disc_Id, Disc_name FROM discounts WHERE Status = 1 ";
            $fetch = mysqli_query($con, $query);

            if($fetch){

                $output ='';

                $output .='<option value="">Select discount here</option>';

                while($row = mysqli_fetch_assoc($fetch)){

                    $disc_Id    = $row['Disc_Id'];
                    $disc_name  = $row['Disc_name'];

                    $output .='<option value="'.$disc_Id.'">'.$disc_name.'</option>';
                }

                echo json_encode($output);
            }
        }



        else if($_POST['action'] == 'edit_acc_info'){

            if(isset($_POST['accid'])){

                $acc_Id = $_POST['accid'];

                $query = "SELECT Lname, Fname, Username, User_lvl_Id FROM users WHERE User_Id = '$acc_Id' ";
                $fetch = mysqli_query($con, $query);

                if($fetch){

                    while($row = mysqli_fetch_assoc($fetch)){

                        $lname      = $row['Lname'];
                        $fname      = $row['Fname'];
                        $usrname    = $row['Username'];
                        $usrlvlid   = $row['User_lvl_Id'];

                        $arr = array(
                            'Lname' => $lname,
                            'Fname' => $fname,
                            'Usrname'=> $usrname,
                            'Level' => $usrlvlid
                        );

                        echo json_encode($arr);
                    }
                }
            }
        }



        else if($_POST['action'] == 'active_transc'){

            if($current_hour == '00' || $current_hour <= '05'){

                $the_date = date('Y-m-d', strtotime('-1 day'));
            }

            else{

                $the_date = date('Y-m-d', strtotime('now'));
            }

            $query = "SELECT Trans_Id, Emp_Id FROM transactions ";
            // $query .="WHERE Status = 2 AND User_Id = '$user_Id' AND Date_added = '$the_date' ";
            $query .="WHERE Status = 2 AND Date_added = '$the_date' ";
            $query .="AND `User_Id` = '$user_Id' ";
            $query .="ORDER BY Transc_Id DESC LIMIT 1 ";

            $fetch = mysqli_query($con, $query);

            $count = mysqli_num_rows($fetch);

            if($fetch){

                if($count > 0){
                
                $row = mysqli_fetch_assoc($fetch);

                $trans_Id    = $row['Trans_Id'];
                $emp_Id      = $row['Emp_Id'];

                $query2 = "SELECT Lname, Fname FROM emp_info WHERE Emp_Id = '$emp_Id' ";
                $fetch2 = mysqli_query($con2, $query2);

                if($fetch2){

                        $row2 = mysqli_fetch_assoc($fetch2);

                        $lname = $row2['Lname'];
                        $fname = $row2['Fname'];

                        $arr = array(
                            'Lname' => $lname,
                            'Fname' => $fname,
                            'EmpId' => $emp_Id,
                            'TransId' => $trans_Id
                        );

                        echo json_encode($arr);
                    }

                    else{

                        echo json_encode('2');
                    }

                }

                else{

                    $arr = array(
                        'Lname' => "",
                        'Fname' => "",
                        'EmpId' => "",
                        'TransId' => ""
                    );

                    echo json_encode($arr);
                }
            }

            else{

                echo json_encode('2');
            }

        }



        else if($_POST['action'] == 'credit_chckr'){

            if(isset($_POST['empid'])){

                $emp_Id = $_POST['empid'];

                $query = "SELECT `Status` FROM emp_credits WHERE Emp_Id = '$emp_Id' ";
                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                if($fetch){

                    if($count > 0){

                        $row = mysqli_fetch_assoc($fetch);

                        $status = $row['Status'];

                        if($status == 1){

                            echo json_encode('1');
                        }

                        else if($status == 0){

                            echo json_encode('0');
                        }

                    }

                    else{

                        echo json_encode('0');

                    }

                }
            }
        }

        

        else if($_POST['action'] == 'discount_tbl'){

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query = "SELECT trans_disc.Disc_Id, discounts.Disc_name ";
                $query .="FROM trans_disc LEFT JOIN discounts ";
                $query .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
                $query .="WHERE Trans_Id = '$trans_Id' ";

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $output ='';

                    while($row = mysqli_fetch_assoc($fetch)){

                        $disc_name = $row['Disc_name'];

                        $output .='<tr>';
                        $output .='<td><b>'.$disc_name.'</b></td>';
                        $output .='<td><h5>1</h5></td>';
                        $output .='</tr>';

                    }

                    echo json_encode($output);
                }
            }
        }

        

        else if($_POST['action'] == 'orders_tbl'){ //jm

            if(isset($_POST['transid'])){

                $trans_Id = $_POST['transid'];

                $query = "SELECT trans_details.Quantity, items.Item_name, items.Price ";
                $query .="FROM trans_details LEFT JOIN items ";
                $query .="ON trans_details.Item_Id = items.Item_Id ";
                $query .="WHERE trans_details.Trans_Id = '$trans_Id' ";

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $n = 1;

                    $output ='';

                    while($row = mysqli_fetch_assoc($fetch)){

                        $item_name  = $row['Item_name'];
                        $item_price = $row['Price'];
                        $item_qty   = $row['Quantity'];

                        $sub_total = $item_price * $item_qty;

                        $output .='<tr>';
                        $output .='<td>'.$n++.'</td>';
                        $output .='<td>'.$item_name.'</td>';
                        $output .='<td><b>'.number_format($item_price, 2).'</b></td>';
                        $output .='<td>'.$item_qty.'</td>';
                        $output .='<td><b>'.number_format($sub_total, 2).'</b></td>';
                        $output .='</tr>';

                    }

                    $query2 = "SELECT Amount FROM trans_custom WHERE Trans_Id = '$trans_Id' ";
                    $fetch2 = mysqli_query($con, $query2);

                    if($fetch2){

                        while($row = mysqli_fetch_assoc($fetch2)){

                            $cust_amount = $row['Amount'];

                            $output .='<tr>';
                            $output .='<td>---</td>';
                            $output .='<td>Custom Amount</td>';
                            $output .='<td>'.number_format($cust_amount, 2).'</td>';
                            $output .='<td>1</td>';
                            $output .='<td>'.number_format($cust_amount, 2).'</td>';
                            $output .='</tr>';
                        }
                    }

                    echo json_encode($output);
                }

            }
        }



        else if($_POST['action'] == 'total_disc'){

            if(isset($_POST['discid'])){

                $disc_Id = $_POST['discid'];

                $query = "SELECT trans_disc.Disc_Id, transactions.Trans_Id, discounts.Disc_amount ";
                $query .="FROM trans_disc LEFT JOIN transactions ";
                $query .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
                $query .="LEFT JOIN discounts ";
                $query .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
                $query .="WHERE trans_disc.Disc_Id = '$disc_Id' AND transactions.Status = 1 ";

                if($_POST['datefil1'] != '' && $_POST['datefil2'] != ''){

                    $date_fil1 = $_POST['datefil1'];
                    $date_fil2 = $_POST['datefil2'];

                    $query .="AND transactions.Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                }

                else{

                    $query .="AND transactions.Date_added = curdate() ";
                }

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $total_amount = 0;

                    while($row = mysqli_fetch_assoc($fetch)){

                        $disc_amount = $row['Disc_amount'];

                        $total_amount += $disc_amount;
                    }
                    
                    echo json_encode(number_Format($total_amount, 2));
                }
            }
        }



        else if($_POST['action'] == 'count_trans'){

            $query = "SELECT DISTINCT trans_disc.Trans_Id ";
            $query .="FROM trans_disc LEFT JOIN transactions ";
            $query .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
            $query .="WHERE transactions.Status = 1 ";

            if($_POST['datefil1'] != '' && $_POST['datefil2'] != ''){

                $date_fil1 = $_POST['datefil1'];
                $date_fil2 = $_POST['datefil2'];

                $query .="AND transactions.Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
            }

            else{

                $query .="AND transactions.Date_added = curdate() ";
            }

            $fetch = mysqli_query($con, $query);

            $count = mysqli_num_rows($fetch);

            if($fetch){

                echo json_encode($count);
            }
        }



        else if($_POST['action'] == 'total_credits'){

            if(isset($_POST['datefil1']) && isset($_POST['datefil2'])){

                $date_fil1 = $_POST['datefil1'];
                $date_fil2 = $_POST['datefil2'];

                $query ="SELECT SUM(Grand_Total) as Total FROM transactions ";
                $query .="WHERE Status = 1 AND Pay_Method = 'Credit' ";

                if($_POST['datefil1'] != '' && $_POST['datefil2'] != ''){

                    $date_fil1 = $_POST['datefil1'];
                    $date_fil2 = $_POST['datefil2'];

                    $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                }

                else{

                    $query .="AND Date_added = curdate() ";
                }

                if($_POST['emphash'] != ''){

                    $emp_hash = $_POST['emphash'];

                    $query2 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                    $fetch2 = mysqli_query($con2, $query2);

                    if($fetch2){

                        $row2 = mysqli_fetch_assoc($fetch2);

                        $emp_Id = $row2['Emp_Id'];

                        $query .="AND Emp_Id = '$emp_Id' ";
                    }
                }

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $total = $row['Total'];

                    echo json_encode(number_format($total, 2));
                }
            }
        }

        

        else if($_POST['action'] == 'count_c_transc'){

            $query ="SELECT COUNT(Trans_Id) as Total ";
            $query .="FROM transactions ";
            // $query .="WHERE Status = 1 AND Pay_Method = 'Credit' ";
            $query .="WHERE Status = 1 ";
            
            if($_POST['datefil1'] != '' && $_POST['datefil2'] != ''){

                $date_fil1 = $_POST['datefil1'];
                $date_fil2 = $_POST['datefil2'];

                $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
            }

            else{

                $query .="AND Date_added = curdate() ";
            }

            if($_POST['emphash'] != ''){

                $emp_hash = $_POST['emphash'];

                $query2 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                $fetch2 = mysqli_query($con2, $query2);

                if($fetch2){

                    $row2 = mysqli_fetch_assoc($fetch2);

                    $emp_Id = $row2['Emp_Id'];

                    $query .="AND Emp_Id = '$emp_Id' ";
                }
            }

            $fetch = mysqli_query($con, $query);

            if($fetch){

                $row = mysqli_fetch_assoc($fetch);

                $total = $row['Total'];

                echo json_encode($total);
            }
        }



        else if($_POST['action'] == 'change_bg'){

            if(isset($_POST['colorid'])){

                $color_Id = $_POST['colorid'];

                setcookie("CMS_bg_color", $color_Id, time()+3600 * 24 * 365, '/');
            }
        }



        else if($_POST['action'] == 'get_bg_cookie'){

            $cookie_val = $_COOKIE['CMS_bg_color'];

            echo json_encode($cookie_val);
        }



        else if($_POST['action'] == 'total_cash'){

            if(isset($_POST['datefil1']) && isset($_POST['datefil2'])){

                $date_fil1 = $_POST['datefil1'];
                $date_fil2 = $_POST['datefil2'];

                $query ="SELECT SUM(Grand_Total) as Total FROM transactions ";
                $query .="WHERE Status = 1 AND Pay_Method = 'Cash' ";

                if($_POST['datefil1'] != '' && $_POST['datefil2'] != ''){

                    $date_fil1 = $_POST['datefil1'];
                    $date_fil2 = $_POST['datefil2'];

                    $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                }

                else{

                    $query .="AND Date_added = curdate() ";
                }

                if($_POST['emphash'] != ''){

                    $emp_hash = $_POST['emphash'];

                    $query2 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                    $fetch2 = mysqli_query($con2, $query2);

                    if($fetch2){

                        $row2 = mysqli_fetch_assoc($fetch2);

                        $emp_Id = $row2['Emp_Id'];

                        $query .="AND Emp_Id = '$emp_Id' ";
                    }
                }

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $total = $row['Total'];

                    echo json_encode(number_format($total, 2));
                }
            }
        }



        else if($_POST['action'] == 'edit_disc'){

            if(isset($_POST['discid'])){

                $disc_Id = $_POST['discid'];

                $query = "SELECT discounts.Disc_name, discounts.Disc_amount, disc_settings.Quantity ";
                $query .="FROM discounts LEFT JOIN disc_settings ";
                $query .="ON discounts.Disc_Id = disc_settings.Disc_Id ";
                $query .="WHERE discounts.Disc_Id = '$disc_Id' ";

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $disc_name      = $row['Disc_name'];
                    $disc_amount    = $row['Disc_amount'];
                    $disc_quant     = $row['Quantity'];

                    $arr = array(
                        'DiscName' => $disc_name,
                        'DiscAmount' => floatval($disc_amount),
                        'DiscQty' => $disc_quant
                    );

                    echo json_encode($arr);
                }
            }
        }



        else if($_POST['action'] == 'cat_dd'){

            $query = "SELECT Cat_Id, Cat_name FROM categories WHERE `Status` = 1 ";
            $fetch = mysqli_query($con, $query);

            if($fetch){

                $output ='<option value="">Select category here</option>';

                while($row = mysqli_fetch_assoc($fetch)){

                    $cat_Id     = $row['Cat_Id'];
                    $cat_name   = $row['Cat_name'];

                    $output .='<option value="'.$cat_Id.'">'.$cat_name.'</option>';
                }

                echo json_encode($output);
            }
        }



        else if($_POST['action'] == 'cat_info'){

            if(isset($_POST['catid'])){

                $cat_Id = $_POST['catid'];

                $query = "SELECT Arrangement, Cat_name FROM categories WHERE Cat_Id = '$cat_Id' ";
                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $arrngmnt   = $row['Arrangement'];
                    $cat_name   = $row['Cat_name'];

                    $arr = array(
                        'Arrngmnt' => $arrngmnt,
                        'CatName' => $cat_name
                    );

                    echo json_encode($arr);
                }
            }
        }



        else if($_POST['action'] == 'get_cutoff'){

            if(isset($_POST['coval'])){

                $cutoff_val = $_POST['coval'];

                if($cutoff_val == '1st'){

                    $first_date = date('Y-m-01', strtotime("now"));
                    $last_date  = date('Y-m-d', strtotime('+14 days', strtotime($first_date)));

                    // $day = date("Y-m-d", $last_date);

                    $arr = array(
                        'FirstDate' => $first_date,
                        'LastDate' => $last_date
                    );

                    echo json_encode($arr);
                }

                else if($cutoff_val == '2nd'){

                    $date = strtotime("now");

                    $no_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime("now")), date('Y', strtotime("now")) );

                    $last_date = strtotime(date("Y-m-t", $date ));
  
                    $day = date("Y-m-d", $last_date);

                    if($no_of_days == '31'){

                        $first_date = date('Y-m-d', strtotime('-15 days', strtotime($day)));
                    }

                    else if($no_of_days == '30'){

                        $first_date = date('Y-m-d', strtotime('-14 days', strtotime($day)));
                    }

                    else if($no_of_days == '28'){

                        $first_date = date('Y-m-d', strtotime('-12 days', strtotime($day)));
                    }

                    $arr = array(
                        'FirstDate' => $first_date,
                        'LastDate' => $day
                    );

                    echo json_encode($arr);

                }

                else{

                    $date = strtotime("now");

                    $first_date = date('Y-m-01', $date);
                    $last_date  = strtotime(date("Y-m-t", $date ));
                    $day        = date("Y-m-d", $last_date);

                    $arr = array(
                        'FirstDate' => $first_date,
                        'LastDate' => $day
                    );

                    echo json_encode($arr);
                }
            }
        }



        else if($_POST['action'] == 'emp_info'){

            if(isset($_POST['emphash'])){

                $emp_hash = $_POST['emphash'];

                $query = "SELECT employees.Emp_Id, emp_info.Lname, emp_info.Fname, emp_info.Mname ";
                $query .="FROM employees LEFT JOIN emp_info ";
                $query .="ON employees.Emp_Id = emp_info.Emp_Id ";
                $query .="WHERE employees.Emp_Hash = '$emp_hash' AND employees.Status = 1 ";

                $fetch = mysqli_query($con2, $query);

                $count = mysqli_num_rows($fetch);

                if($fetch){

                    if($count > 0){

                        $row = mysqli_fetch_assoc($fetch);
    
                        $emp_Id = $row['Emp_Id'];
                        $lname  = $row['Lname'];
                        $fname  = $row['Fname'];
    
                        $fullname = $fname ." ". $lname;
    
                        $arr = array(
                            'EmpId' => $emp_Id,
                            'Lname' => $lname,
                            'Fname' => $fname,
                            'FullName' => $fullname,
                            'EmpCount' => $count
                        );
                    }

                    else{

                        $arr = array(
                            'EmpId' => "",
                            'Lname' => "",
                            'Fname' => "",
                            'FullName' => "",
                            'EmpCount' => 0
                        );
    
                    }
                    
                    echo json_encode($arr);
                }
            }
        }



        
        // ===================== Dashboard Functions =======================
        else if($_POST['action'] == 'daily_emp_count'){
            
            $query = "SELECT DISTINCT Emp_Id FROM transactions WHERE Date_added = curdate() AND `Status` = 1 ";
            $fetch = mysqli_query($con, $query);

            $count = mysqli_num_rows($fetch);

            if($fetch){

                echo json_encode($count);
            }
            
        }

        

        else if($_POST['action'] == 'discount_chart'){

            $labels     = array();
            $data_set   = array();
            // $bg_colors  = array("#b9c2ca", "#e2e2e2");
            $bg_colors  = array(
                "#e1e3e4", 
                "#b6c3ca",
                "#8da4b2",
                "#65869a",
                "#3c6883",
                "#004c6d"
            );

            $output ='';

            $query = "SELECT Disc_Id, Disc_name FROM discounts WHERE `Status` = 1 ";
            $fetch = mysqli_query($con, $query);

            if($fetch){

                $n = 0;

                while($row = mysqli_fetch_assoc($fetch)){

                    $disc_Id    = $row['Disc_Id'];
                    $disc_name  = $row['Disc_name'];

                    array_push($labels, $disc_name);
                

                    $query2 = "SELECT trans_disc.Disc_Id, SUM(discounts.Disc_amount) as Total, transactions.Status ";
                    $query2 .="FROM trans_disc LEFT JOIN discounts ";
                    $query2 .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
                    $query2 .="LEFT JOIN transactions ";
                    $query2 .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
                    $query2 .="WHERE trans_disc.Disc_Id = '$disc_Id' AND transactions.Status = 1 AND transactions.Date_added = curdate() ";

                    $fetch2 = mysqli_query($con, $query2);

                    if($fetch2){

                        $row2 = mysqli_fetch_assoc($fetch2);

                        $disc_amount = $row2['Total'];

                        array_push($data_set, $disc_amount);
                    }


                    $output .='<tr>';
                    $output .='<td><i class="fa fa-circle mr-2" style="color:'.$bg_colors[$n++].';"></i>'.$disc_name.'</td>';
                    $output .='<td><b>P'.number_format($disc_amount, 2).'</b></td>';
                    $output .='</tr>';
                }

                $arr = array(
                    'Labels' => $labels, 
                    'Discs' => $data_set,
                    'BGColors' => $bg_colors,
                    'TblDisp' => $output
                );

                echo json_encode($arr);
            }
        }



        else if($_POST['action'] == 'weekly_summ_chart'){

            $monday_d     = date('Y-m-d', strtotime('monday this week'));
            $tuesday_d    = date('Y-m-d', strtotime('tuesday this week'));
            $wednesday_d  = date('Y-m-d', strtotime('wednesday this week'));
            $thursday_d   = date('Y-m-d', strtotime('thursday this week'));
            $friday_d     = date('Y-m-d', strtotime('friday this week'));
            $saturday_d   = date('Y-m-d', strtotime('saturday this week'));
            // $sunday_d     = date('Y-m-d', strtotime('sunday this week'));

            $monday     = date('l', strtotime('monday this week'));
            $tuesday    = date('l', strtotime('tuesday this week'));
            $wednesday  = date('l', strtotime('wednesday this week'));
            $thursday   = date('l', strtotime('thursday this week'));
            $friday     = date('l', strtotime('friday this week'));
            $saturday   = date('l', strtotime('saturday this week'));
            // $sunday     = date('l', strtotime('sunday this week'));

            $days   = array($monday, $tuesday, $wednesday, $thursday, $friday, $saturday);
            $dates  = array($monday_d, $tuesday_d, $wednesday_d, $thursday_d, $friday_d, $saturday_d); 


            $cash_dataset   = array();
            $credit_dataset = array();

            foreach($dates as $date){

                // ================== Credit Dataset ====================
                    $query1 = "SELECT SUM(Grand_Total) as Total1 ";
                    $query1 .="FROM transactions ";
                    $query1 .="WHERE Date_added = '$date' AND Status = 1 AND Pay_Method = 'Cash' ";

                    $fetch1 = mysqli_query($con, $query1);

                    if($fetch1){

                        $row1 = mysqli_fetch_assoc($fetch1);

                        $total_cash = $row1['Total1'];

                        array_push($cash_dataset, $total_cash);
                    }
                // ================== Credit Dataset END ================

                // ================== Credit Dataset ====================
                    $query2 = "SELECT SUM(Grand_Total) as Total2 ";
                    $query2 .="FROM transactions ";
                    $query2 .="WHERE Date_added = '$date' AND Status = 1 AND Pay_Method = 'Credit' ";

                    $fetch2 = mysqli_query($con, $query2);

                    if($fetch2){

                        $row2 = mysqli_fetch_assoc($fetch2);

                        $total_credit = $row2['Total2'];

                        array_push($credit_dataset, $total_credit);
                    }
                // ================== Credit Dataset END ================
            }

            $arr = array(
                'DaysArr' => $days,
                'CashArr' => $cash_dataset,
                'CreditArr' => $credit_dataset
            );

            echo json_encode($arr);
        }
        // ===================== Dashboard Functions END ===================



        else if($_POST['action'] == 'item_dd'){

            $query = "SELECT Item_Id, Item_name FROM items WHERE `Status` = 1 ";
            $fetch = mysqli_query($con, $query);

            if($fetch){

                $output ='';

                $output .='<option value="">Select item here</option>';

                while($row = mysqli_fetch_assoc($fetch)){

                    $item_Id    = $row['Item_Id'];
                    $item_name  = $row['Item_name'];

                    $output .='<option value="'.$item_Id.'">'.$item_name.'</option>';
                }

                echo json_encode($output);
            }
        }



        else if($_POST['action'] == 'check_restrictions'){

            $query = "SELECT Sett_val FROM settings WHERE Sett_name = 'Allow_items' ";
            $fetch = mysqli_query($con, $query);

            if($fetch){

                $row = mysqli_fetch_assoc($fetch);

                $sett_val = $row['Sett_val'];

                echo json_encode($sett_val);
            }
        }



        else if($_POST['action'] == 'discount_cards'){

            $query0 = "SELECT Disc_Id, Disc_name FROM discounts WHERE `Status` = 1 ";
            $fetch0 = mysqli_query($con, $query0);

            $count = mysqli_num_rows($fetch0);

            if($fetch0){

                $output ='';

                while($row0 = mysqli_fetch_assoc($fetch0)){

                    $disc_Id    = $row0['Disc_Id'];
                    $disc_name  = $row0['Disc_name'];

                    $query = "SELECT trans_disc.Disc_Id, transactions.Trans_Id, discounts.Disc_amount ";
                    $query .="FROM trans_disc LEFT JOIN transactions ";
                    $query .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
                    $query .="LEFT JOIN discounts ";
                    $query .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
                    $query .="WHERE trans_disc.Disc_Id = '$disc_Id' AND transactions.Status = 1 ";

                    if($_POST['datefil1'] != '' && $_POST['datefil2'] != ''){

                        $date_fil1 = $_POST['datefil1'];
                        $date_fil2 = $_POST['datefil2'];

                        $query .="AND transactions.Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                    }

                    else{

                        $query .="AND transactions.Date_added = curdate() ";
                    }

                    $fetch = mysqli_query($con, $query);

                    if($fetch){

                        $total_amount = 0;

                        

                        while($row = mysqli_fetch_assoc($fetch)){

                            // $disc_name   = $row['Disc_name'];
                            $disc_amount = $row['Disc_amount'];


                            $total_amount += $disc_amount;
                        }
                        
                        if($count <= 3){

                            $output .='<div class="col-lg-4">';
                        }

                        else{

                            $output .='<div class="col-lg-3">';
                        }

                        $output .='<div class="card border border-info">';
                        $output .='<div class="card-body text-info">';
                        $output .='<h4 class="mb-0 font-weight-bold">P'.number_Format($total_amount, 2).'<span class="float-right"><i class="fa-solid fa-percent"></i></span></h4><br>';
                        $output .='<p class="mb-0 small-font">Total '.$disc_name.' <span class="float-right text-success" style="font-weight:bold"></span></p>';
                        $output .='</div>';
                        $output .='</div>';
                        $output .='</div>';

                    }
                }

                echo json_encode($output);
            }
        }

    }

?>