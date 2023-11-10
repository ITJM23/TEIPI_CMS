<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Item_name", "Quantity");

    $query ="SELECT trans_disc.Disc_Id, discounts.Disc_name, discounts.Disc_amount ";
    $query .="FROM trans_disc LEFT JOIN discounts ";
    $query .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
    $query .="WHERE NOT trans_disc.Trans_Id = '' ";

    if($_POST['transid'] != ''){

        $trans_Id = $_POST['transid'];

        $query .="AND trans_disc.Trans_Id = '$trans_Id' ";
    }


    if(isset($_POST["search"]["value"])){											

        $query .='AND discounts.Disc_name LIKE "%'.$_POST["search"]["value"].'%" ';
    }

    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY trans_disc.Trans_D_Id DESC ';
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

        $disc_name      = $row['Disc_name'];
        $disc_amount    = $row['Disc_amount'];

        $sub_array = array();

        $sub_array[] = $disc_name;
        $sub_array[] = $disc_amount;

        $data[] = $sub_array;
    }

    $output = array(
        'draw' => intval($_POST['draw']),
        'recordsFiltered' => $count,
        'data' => $data
    );

    echo json_encode($output);

?>