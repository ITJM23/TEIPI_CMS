<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Date_added", "Trans_Id", "Disc_name", "Disc_amount");

    $query ="SELECT trans_disc.Trans_Id, discounts.Disc_name, discounts.Disc_amount, ";
    $query .="transactions.Emp_Id, transactions.Date_added, transactions.Time_added ";
    $query .="FROM trans_disc LEFT JOIN discounts ";
    $query .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
    $query .="LEFT JOIN transactions ";
    $query .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
    $query .="WHERE NOT trans_disc.Trans_D_Id = '' AND transactions.Status = 1 ";

    if($_POST['discid'] != ''){

        $disc_Id = $_POST['discid'];

        $query .="AND trans_disc.Disc_Id = '$disc_Id' ";
    }

    if($_POST['datefil1'] != '' && $_POST['datefil2'] != ''){

        $date_fil1 = $_POST['datefil1'];
        $date_fil2 = $_POST['datefil2'];

        $query .="AND transactions.Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
    }

    else{

        $query .="AND transactions.Date_added = curdate() ";
    }


    if(isset($_POST["search"]["value"])){											

        $query .='AND discounts.Disc_name LIKE "%'.$_POST["search"]["value"].'%" ';
    }

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY transactions.Date_added DESC, transactions.Time_added DESC ';
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
        $disc_name      = $row['Disc_name'];
        $disc_amount    = $row['Disc_amount'];
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
        $sub_array[] = "<b>".substr($trans_Id, 0, 10)."</b>";
        $sub_array[] = "<b>".$emp_name."</b>";
        $sub_array[] = $disc_name;
        $sub_array[] = "<b>".$disc_amount."</b>";

        $data[] = $sub_array;
    }

    $output = array(
        'draw' => intval($_POST['draw']),
        'recordsFiltered' => $count,
        'data' => $data
    );

    echo json_encode($output);

?>