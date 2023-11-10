<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Cat_name", "Arrangement", "Date_added", " ");

    $query ="SELECT Cat_Id, Cat_name, Arrangement, Date_added, Time_added ";
    $query .="FROM categories ";
    $query .="WHERE Status = 1 ";

    if(isset($_POST["search"]["value"])){											

        $query .='AND (Cat_name LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .='OR Arrangement LIKE "%'.$_POST["search"]["value"].'%") ';
    }

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY Arrangement DESC ';
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

        $cat_Id        = $row['Cat_Id'];
        $cat_name       = $row['Cat_name'];
        $arrangemnt     = $row['Arrangement'];
        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];

        $sub_array = array();

        $sub_array[] = "<b>".$cat_name."</b>";
        $sub_array[] = $arrangemnt;
        $sub_array[] = date('F d, Y', strtotime($date_added)) . " | " . date('h:i A', strtotime($time_added));
        $sub_array[] = "
                        <button type='button' class='btn btn-outline-primary btn-sm' onclick='editCat(`".$cat_Id."`)'><i class='mdi mdi-pencil'></i> Edit</button>
                        <button type='button' class='btn btn-outline-danger btn-sm' onclick='deleteCat(`".$cat_Id."`)'><i class='mdi mdi-delete'></i> Delete</button>
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