<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Trans_Id", "Grand_Total", "Pay_amount", "Trans_change", "Pay_Method", "Date_added", "");

    $query ="SELECT Trans_Id, Transc_Id, Emp_Id, Pay_amount, Grand_Total, Trans_change, Pay_amount, Pay_Method, Date_added, Time_added ";
    $query .="FROM transactions ";
    $query .="WHERE Status = 1 ";

    if($_POST['empid'] != ''){

        $emp_Id = $_POST['empid'];

        $query2 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_Id' ";
        $fetch2 = mysqli_query($con2, $query2);

        if($fetch2){

            $row2 = mysqli_fetch_assoc($fetch2);

            $emp_Id = $row2['Emp_Id'];

            $query .="AND Emp_Id = '$emp_Id' ";
        }

    }

    if($_POST['datefil1'] != '' && $_POST['datefil2'] != ''){

        $date_fil1 = $_POST['datefil1'];
        $date_fil2 = $_POST['datefil2'];

        $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
    }

    else{

        $query .="AND Date_added = curdate() ";
    }


    if(isset($_POST["search"]["value"])){											

        $query .='AND Pay_Method LIKE "%'.$_POST["search"]["value"].'%" ';
    }

    // $query .="GROUP BY Trans_Id ";

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY Date_added DESC, Time_added DESC ';
    }

    $query1 ='';

    if($_POST["length"] != -1){

        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $count = mysqli_num_rows(mysqli_query($con, $query));

    $result = mysqli_query($con, $query . $query1);

    confirmQuery($result);

    $data = array();

    $n = 1;

    while($row = mysqli_fetch_assoc($result)){

        $trans_Id       = $row['Trans_Id'];
        $emp_id         = $row['Emp_Id'];
        $pay_amount     = $row['Pay_amount'];
        $g_total        = $row['Grand_Total'];
        $pay_change     = $row['Trans_change'];
        $pay_method     = $row['Pay_Method'];
        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];

        // ================== Get employee info =====================
            $query3 = "SELECT Lname, Fname FROM emp_info WHERE Emp_Id = '$emp_id' ";
            $fetch3 = mysqli_query($con2, $query3);

            if($fetch3){

                $row3 = mysqli_fetch_assoc($fetch3);

                $lname = $row3['Lname'];
                $fname = $row3['Fname'];

                $fullname = $fname ." ". $lname;

            }
        // ================== Get employee info END =================
        

        $sub_array = array();

        $sub_array[] = date('M d, Y', strtotime($date_added)) . " | " . date('h:i A', strtotime($time_added));
        $sub_array[] = substr($trans_Id, 0, 10);
        $sub_array[] = "<b>".$fullname."</b>";
        $sub_array[] = "<b>".number_format($g_total, 2)."</b>";
        // $sub_array[] = number_format($pay_amount, 2);
        // $sub_array[] = number_format($pay_change, 2);
        $sub_array[] = "<b>".$pay_method."</b>";
        $sub_array[] = "
                        <button type='button' class='btn btn-outline-info btn-sm' onclick='viewTransDet(`".$trans_Id."`)'><i class='fa fa-search'></i> View</button>
                    ";

        $data[] = $sub_array;
    }

    $output = array(
        'draw' => intval($_POST['draw']),
        'recordsFiltered' => $count,
        'data' => $data
    );

    echo json_encode($output);

?>