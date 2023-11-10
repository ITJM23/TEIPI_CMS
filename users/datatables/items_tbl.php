<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Item_name", "Price", "Arrangement", "Date_added", " ");

    $query ="SELECT items.Item_Id, items.Item_name, items.Price, items.Arrangement, items.Date_added, items.Time_added, categories.Cat_name ";
    $query .="FROM items LEFT JOIN categories ";
    $query .="ON items.Cat_Id = categories.Cat_Id ";
    $query .="WHERE items.Status = 1 ";

    if(isset($_POST["search"]["value"])){											

        $query .='AND (items.Item_name LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .='OR categories.Cat_name LIKE "%'.$_POST["search"]["value"].'%") ';
    }

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY items.Arrangement DESC ';
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

        $item_Id        = $row['Item_Id'];
        $item_name      = $row['Item_name'];
        $cat_name       = $row['Cat_name'];
        $item_price     = $row['Price'];
        $arrangemnt     = $row['Arrangement'];
        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];

        $sub_array = array();

        $sub_array[] = "<b>".$item_name."</b>";
        $sub_array[] = $cat_name;
        $sub_array[] = "<b>".$item_price."</b>";
        $sub_array[] = $arrangemnt;
        $sub_array[] = date('F d, Y', strtotime($date_added)) . " | " . date('h:i A', strtotime($time_added));
        $sub_array[] = "
                        <button type='button' class='btn btn-outline-primary btn-sm' onclick='editItem(`".$item_Id."`)'><i class='mdi mdi-pencil'></i> Edit</button>
                        <button type='button' class='btn btn-outline-danger btn-sm' onclick='deleteItem(`".$item_Id."`)'><i class='mdi mdi-delete'></i> Delete</button>
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