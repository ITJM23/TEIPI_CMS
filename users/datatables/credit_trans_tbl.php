<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Date_added", "Trans_Id", "Lname", "Grand_Total");

    $query ="SELECT Trans_Id, Emp_Id, Grand_Total, Pay_Method, Date_added, Time_added ";
    $query .="FROM transactions WHERE NOT Pay_Method = '' AND Status = 1 ";

    if($_POST['payment'] != ''){

        $payment_mode = $_POST['payment'];

        $query .="AND Pay_Method = '$payment_mode' ";
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

        $query .='AND Grand_Total LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
        $emp_Id         = $row['Emp_Id'];
        $gtotal         = $row['Grand_Total'];
        $pay_method     = $row['Pay_Method'];
        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];

        $query2 = "SELECT employees.Emp_Id, emp_info.Lname, emp_info.Fname ";
        $query2 .="FROM employees LEFT JOIN emp_info ";
        $query2 .="ON employees.Emp_Id = emp_info.Emp_Id ";
        $query2 .="WHERE employees.Emp_Id = '$emp_Id' ";

        $fetch2 = mysqli_query($con2, $query2);

        if($fetch2){

            $row2 = mysqli_fetch_assoc($fetch2);

            $emp_id = $row2['Emp_Id'];
            $lname  = $row2['Lname'];
            $fname  = $row2['Fname'];

            $emp_name = $fname ." ". $lname;
        }

        $sub_array = array();

        $sub_array[] = date('M d, Y', strtotime($date_added)) . " | " . date('h:i A', strtotime($time_added));
        $sub_array[] = substr($trans_Id, 0, 10);
        $sub_array[] = "<b>".$emp_name."</b>";
        $sub_array[] = "<b>".$pay_method."</b>";
        $sub_array[] = number_format($gtotal, 2);

        $data[] = $sub_array;
    }

    $output = array(
        'draw' => intval($_POST['draw']),
        'recordsFiltered' => $count,
        'data' => $data
    );

    echo json_encode($output);

?>