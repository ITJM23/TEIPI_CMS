<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("", "users.Username", "user_level.User_level", "users.Date_added", "", "");

    $query ="SELECT users.User_Id, users.Username, user_level.User_level, users.Date_added, users.Time_added, users.Status ";
    $query .="FROM users LEFT JOIN user_level ";
    $query .="ON users.User_lvl_Id = user_level.User_lvl_Id ";
    $query .="WHERE users.Status = 1 AND NOT users.User_Id = '".$_COOKIE['CMS_usr_Id']."' ";

    if(isset($_POST["search"]["value"])){											

        $query .='AND (users.Username LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .='OR user_level.User_level LIKE "%'.$_POST["search"]["value"].'%") ';
    }

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY users.Date_added DESC, users.Time_added DESC ';
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

        $user_Id        = $row['User_Id'];
        $user_name      = $row['Username'];
        $user_level     = $row['User_level'];
        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];
        $status         = $row['Status'];

        $sub_array = array();

        $sub_array[] = $user_Id;
        $sub_array[] = "<b>".$user_name."</b>";
        $sub_array[] = "<b>".$user_level."</b>";
        $sub_array[] = date('F d, Y', strtotime($date_added)) . " | " . date('h:i A', strtotime($time_added));

        if($status == '1'){

            $sub_array[] = "<h5><span class='badge badge-success'>Active</span></h5>";
        }

        else{

            $sub_array[] = "<h5><span class='badge badge-danger'>Inactive</span></h5>";
        }

        $sub_array[] = "
                        <button type='button' class='btn btn-outline-primary btn-sm' onclick='editAcc(`".$user_Id."`)'><i class='mdi mdi-pencil'></i> Edit</button>
                        <button type='button' class='btn btn-outline-danger btn-sm' onclick='deleteUser(`".$user_Id."`)'><i class='mdi mdi-delete'></i> Delete</button>
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