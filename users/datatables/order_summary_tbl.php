<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array();

    $query ="SELECT DISTINCT trans_details.Item_Id, trans_details.Quantity, transactions.Status, items.Item_name, items.Price, transactions.Date_added, transactions.Time_added, "; //jm
    $query .="COUNT(trans_details.Item_Id) as Orders ";
    $query .="FROM trans_details ";
    $query .="LEFT JOIN transactions ";
    $query .="ON trans_details.Trans_Id = transactions.Trans_Id ";
    $query .="LEFT JOIN items ";
    $query .="ON trans_details.Item_Id = items.Item_Id ";
    $query .="WHERE transactions.Status = 1 ";

    if($_POST['catid'] != ''){

        $cat_Id = $_POST['catid'];

        $query .='AND items.Cat_Id = "'.$cat_Id.'" ';
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

        $query .='AND items.Item_name LIKE "%'.$_POST["search"]["value"].'%" ';
    }

    $query .='GROUP BY trans_details.Item_Id ';

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY COUNT(trans_details.Item_Id) DESC ';
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

        $appl_item_Id   = $row['Item_Id'];
        $item_name      = $row['Item_name'];
        $item_price     = $row['Price'];
        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];
        $item_quantity  = $row['Quantity']; //jm

        $total_orders   = $row['Orders'];

        $date_mod = date('F d, Y', strtotime($date_added)) ." | ". date('h:i A', strtotime($time_added));

        $sub_array = array();

        $sub_array[] = $item_name;
        $sub_array[] = number_Format($item_price, 2);
        $sub_array[] = $total_orders;

        $data[] = $sub_array;
    }

    $output = array(
        'draw' => intval($_POST['draw']),
        'recordsFiltered' => $count,
        'data' => $data
    );

    echo json_encode($output);

?>