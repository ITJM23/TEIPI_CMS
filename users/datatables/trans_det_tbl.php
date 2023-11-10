<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Item_name", "Quantity");

    $query ="SELECT trans_details.Quantity, items.Item_name, items.Price ";
    $query .="FROM trans_details LEFT JOIN items ";
    $query .="ON trans_details.Item_Id = items.Item_Id ";
    $query .="WHERE NOT Trans_det_Id = '' ";

    if($_POST['transid'] != ''){

        $trans_Id = $_POST['transid'];

        $query .="AND trans_details.Trans_Id = '$trans_Id' ";
    }


    if(isset($_POST["search"]["value"])){											

        $query .='AND items.Item_name LIKE "%'.$_POST["search"]["value"].'%" ';
    }

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY trans_details.Trans_det_Id DESC ';
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

        $item_name  = $row['Item_name'];
        $item_qty   = $row['Quantity'];
        $item_price = $row['Price'];

        $sub_array = array();

        $sub_array[] = substr($item_name, 0, 15)."...";
        $sub_array[] = $item_qty;

        $g_total = $item_price * $item_qty;

        $sub_array[] = number_format($g_total,2);

        $data[] = $sub_array;
    }

    $output = array(
        'draw' => intval($_POST['draw']),
        'recordsFiltered' => $count,
        'data' => $data
    );

    echo json_encode($output);

?>