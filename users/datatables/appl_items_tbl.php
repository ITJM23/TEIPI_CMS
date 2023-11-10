<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array();

    $query ="SELECT discted_items.Discted_Item_Id, items.Item_name, discted_items.Date_added, discted_items.Time_added  ";
    $query .="FROM discted_items LEFT JOIN items ";
    $query .="ON discted_items.Item_Id = items.Item_Id ";
    $query .="WHERE discted_items.Status = 1 ";

    if($_POST['discid'] != ''){

        $disc_Id = $_POST['discid'];

        $query .='AND discted_items.Disc_Id = "'.$disc_Id.'" ';
    }

    if(isset($_POST["search"]["value"])){											

        $query .='AND items.Item_name LIKE "%'.$_POST["search"]["value"].'%" ';
    }

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY discted_items.Discted_Item_Id DESC ';
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

        $appl_item_Id   = $row['Discted_Item_Id'];
        $item_name      = $row['Item_name'];
        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];

        $date_mod = date('F d, Y', strtotime($date_added)) ." | ". date('h:i A', strtotime($time_added));

        $sub_array = array();

        $sub_array[] = $item_name;
        $sub_array[] = $date_mod;
        $sub_array[] = '<button type="button" class="btn btn-danger" onclick="deleteApplItem(`'.$appl_item_Id.'`)">Delete</button>';

        $data[] = $sub_array;
    }

    $output = array(
        'draw' => intval($_POST['draw']),
        'recordsFiltered' => $count,
        'data' => $data
    );

    echo json_encode($output);

?>