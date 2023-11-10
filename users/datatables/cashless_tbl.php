<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    $column = array("Emp_Id", "Lname", "Date_added", "Status", "");

    $query ="SELECT Credit_Id, Emp_Id, Date_added, Time_added, `Status` ";
    $query .="FROM emp_credits ";
    $query .="WHERE Status = 1 ";

    if($_POST['emphash']){

        $emp_hash = $_POST['emphash'];

        $query0 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
        $fetch0 = mysqli_query($con2, $query0);

        if($fetch0){

            $row0 = mysqli_fetch_assoc($fetch0);

            $emp_Id = $row0['Emp_Id'];

            $query .="AND Emp_Id = '$emp_Id' ";
        }

    }

    if(isset($_POST["search"]["value"])){											

        $query .='AND `Status` LIKE "%'.$_POST["search"]["value"].'%" ';
    }
    
    if(isset($_POST["order"])){

        $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
    } 

    else{

        $query .='ORDER BY Emp_Id DESC ';
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

        $credit_Id      = $row['Credit_Id'];
        $emp_Id         = $row['Emp_Id'];
        $date_added     = $row['Date_added'];
        $time_added     = $row['Time_added'];
        $status         = $row['Status'];

        $date_mod = date('M d, Y', strtotime($date_added)) ." | ". date('H:i A', strtotime($time_added));
        
        $query3 = "SELECT employees.Emp_Num, emp_info.Lname, emp_info.Fname ";
        $query3 .="FROM employees LEFT JOIN emp_info ";
        $query3 .="ON employees.Emp_Id = emp_info.Emp_Id ";
        $query3 .="WHERE emp_info.Emp_Id = '$emp_Id' ";

        $fetch3 = mysqli_query($con2, $query3);

        $count3 = mysqli_num_rows($fetch3);

        if($count3 > 0){

            if($fetch3){

                $row2 = mysqli_fetch_assoc($fetch3);
    
                $emp_num    = $row2['Emp_Num'];
                $lname      = $row2['Lname'];
                $fname      = $row2['Fname'];
    
                $emp_name = $fname ." ". $lname;
            }

        }  

        else{

            $emp_num    = "---";
            $lname      = "---";
            $fname      = "---";

            $emp_name = $fname ." ". $lname;
        }

        $sub_array = array();

        $sub_array[] = "<b>".$emp_num."</b>";
        $sub_array[] = "<b>".htmlspecialchars($emp_name)."</b>";
        $sub_array[] = $date_mod;

        if($status == '1'){

            $sub_array[] = "<span class='badge badge-success'>Active</span>";
        }

        else if($status == '2'){

            $sub_array[] = "<h3><span class='badge badge-warning'>Inactive</span></h3>";
        }

        $sub_array[] = "<button type='button' class='btn btn-outline-danger btn-sm' onclick='setInactive(`".$credit_Id."`)'><span class='fa fa-close'></span> Delete</button>";

        $data[] = $sub_array;
    }

    $output = array(
        'draw' => intval($_POST['draw']),
        'recordsFiltered' => $count,
        'data' => $data
    );

    echo json_encode($output);

?>