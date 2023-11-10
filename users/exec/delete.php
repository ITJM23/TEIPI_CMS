<?php
    
    include "../includes/db.php";
    include "../includes/functions.php";

    if(isset($_POST['action'])){



        if($_POST['action'] == 'remove_zero_qty'){

            $query  = "DELETE FROM trans_details WHERE Quantity = 0 ";
            $remove = mysqli_query($con, $query); 

            if($remove){

                echo json_encode('1');
            }

            else{

                echo json_encode('2');
            }
        }



        else if($_POST['action'] == 'delete_cust'){

            if(isset($_POST['transcid'])){

                $transc_Id = $_POST['transcid'];

                $query  = "DELETE FROM trans_custom WHERE Trans_C_Id = '$transc_Id' ";
                $delete = mysqli_query($con, $query);

                if($delete){

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

        

        else if($_POST['action'] == 'delete_disc'){

            if(isset($_POST['transdid'])){

                $trans_d_Id = $_POST['transdid'];

                $query  = "DELETE FROM trans_disc WHERE Trans_D_Id = '$trans_d_Id' ";
                $delete = mysqli_query($con, $query);

                if($delete){

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



        else if($_POST['action'] == 'delete_item'){

            if(isset($_POST['itemid'])){

                $item_Id = $_POST['itemid'];

                $query  = "UPDATE items SET Status = 0 WHERE Item_Id = '$item_Id' ";
                $remove = mysqli_query($con, $query);

                if($remove){

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

        

        else if($_POST['action'] == 'inactive_cashless'){

            if(isset($_POST['creditid'])){

                $credit_Id = $_POST['creditid'];

                $query  = "DELETE FROM emp_credits WHERE Credit_Id = '$credit_Id' ";
                $remove = mysqli_query($con, $query);

                if($remove){

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



        else if($_POST['action'] == 'delete_acc'){

            if(isset($_POST['accid'])){

                $acc_Id = $_POST['accid'];

                $query  = "UPDATE users SET `Status` = 2 WHERE User_Id = '$acc_Id' ";
                $remove = mysqli_query($con, $query);

                if($remove){

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



        else if($_POST['action'] == 'delete_disc_sett'){

            if(isset($_POST['discid'])){

                $disc_Id = $_POST['discid'];

                $query  = "UPDATE discounts SET `Status` = 0 WHERE Disc_Id = '$disc_Id' ";
                $remove = mysqli_query($con, $query);

                if($remove){

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

        

        else if($_POST['action'] == 'delete_cat'){

            if(isset($_POST['catid'])){

                $cat_Id = $_POST['catid'];

                $query  = "UPDATE categories SET `Status` = 0 WHERE Cat_Id = '$cat_Id' ";
                $remove = mysqli_query($con, $query);

                if($remove){

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