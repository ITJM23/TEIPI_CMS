<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Disc_name", "Disc_amount", "Quantity", "Date_added", "");

    $query ="SELECT discounts.Disc_Id, discounts.Disc_name, discounts.Disc_amount, discounts.Date_added, discounts.Time_added, disc_settings.Quantity ";
    $query .="FROM discounts LEFT JOIN disc_settings ";
    $query .="ON discounts.Disc_Id = disc_settings.Disc_Id ";
    $query .="WHERE NOT discounts.Status = 0 ";


    if(isset($_POST["search"]["value"])){											

        $query .='AND discounts.Disc_name LIKE "%'.$_POST["search"]["value"].'%" ';
    }

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY discounts.Date_added DESC ';
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

        $disc_Id        = $row['Disc_Id'];
        $disc_name      = $row['Disc_name'];
        $disc_amount    = $row['Disc_amount'];
        $disc_freq      = $row['Quantity'];

        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];

        $date_mod = date('F d, Y', strtotime($date_added)) ." | ". date('h:i A', strtotime($time_added));

        $sub_array = array();

        $sub_array[] = "<b>".$disc_name."</b>";
        $sub_array[] = "<b>".number_format($disc_amount, 2)."</b>";
        $sub_array[] = $disc_freq;
        $sub_array[] = $date_mod;

        $sub_array[] = "
            <button type='button' class='btn btn-outline-primary' onclick='editDisc(`".$disc_Id."`)'>Edit</button>
            <button type='button' class='btn btn-outline-danger' onclick='deleteDisc(`".$disc_Id."`)'>Delete</button>
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