<?php

    require('../assets/fpdf/fpdf.php');

    include "includes/db.php";
    include "includes/functions.php";

    class myPDF extends FPDF{



        function Header(){

            $this->SetFont('Arial','B', 11);
            $this->Cell(0,5,'Tsukiden Electric Industries Philippines, Inc.',0,0,'C');
            $this->Ln();
                
        }



        function Branch($con){

            $this->SetFont('Times','', 12);
            $this->Cell(0,10, "101 Technology Ave, Laguna Technopark, Binan, Laguna", 0, 0, 'C');
            $this->Ln();
            $this->SetFont('Times','', 12);
            $this->Cell(0,5, "Laguna Technopark, Binan, Laguna", 0, 0, 'C');
            $this->Ln();
            $this->SetFont('Times','', 12);
            $this->Cell(0,10, "(049) 541 3166", 0, 0, 'C');
            $this->Ln(20);
            $this->SetFont('Times','', 13);

            $this->Cell(0,5,'Canteen Transactions as of', 0, 0, 'C');

            $this->Ln();
            $this->SetFont('Times','B', 12);

            if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){

                $date_fil1 = $_GET['datefil1'];
                $date_fil2 = $_GET['datefil2'];

                $this->Cell(0,10, date('F d, Y', strtotime($date_fil1)) ." to ". date('F d, Y', strtotime($date_fil2)), 0, 0, 'C');
            }

            else{

                $this->Cell(0,10, date('F d, Y', strtotime("now")), 0, 0, 'C');
            }

            $this->Ln(15);
        }



        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','',8);
            $this->Cell(0,10,'Page'.$this->PageNo().'/{nb}', 0, 0, 'C');

        }







        function transDiscount(){

            //Table Header 
            $this->SetFont('Times','B', 12);
            $this->Cell(50, 10, 'DATE', 1, 0, 'C');
            $this->Cell(70, 10, 'EMPLOYEE', 1, 0, 'C');
            $this->Cell(50, 10, 'GRAND TOTAL', 1, 0, 'C');
            $this->Cell(50, 10, 'PAYMENT', 1, 0, 'C');
            $this->Ln();
            //Table Header END
        }



        function transDiscountTable($con, $con2){

            $query ="SELECT DISTINCT Trans_Id, Transc_Id, Emp_Id, Pay_amount, Grand_Total, Trans_change, Pay_amount, Pay_Method, Date_added, Time_added ";
            $query .="FROM transactions ";
            $query .="WHERE Status = 1 ";

            if($_GET['empid'] != ''){

                $emp_Id = $_GET['empid'];
        
                $query2 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_Id' ";
                $fetch2 = mysqli_query($con2, $query2);
        
                if($fetch2){
        
                    $row2 = mysqli_fetch_assoc($fetch2);
        
                    $emp_Id = $row2['Emp_Id'];
        
                    $query .="AND Emp_Id = '$emp_Id' ";
                }
        
            }

            if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){

                $date_fil1 = $_GET['datefil1'];
                $date_fil2 = $_GET['datefil2'];
        
                $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
            }
        
            else{
        
                $query .="AND Date_added = curdate() ";
            }

            $query .='ORDER BY Date_added DESC, Time_added DESC ';

            $fetch = mysqli_query($con, $query);

            $count = mysqli_num_rows($fetch);

            if($count == NULL){

                $this->Cell(280, 10, 'None', 1, 0, 'C');

            }

            else{

                while($row = mysqli_fetch_assoc($fetch)){
                    
                    $trans_Id       = $row['Trans_Id'];
                    $emp_id         = $row['Emp_Id'];
                    $pay_amount     = $row['Pay_amount'];
                    $g_total        = $row['Grand_Total'];
                    $pay_change     = $row['Trans_change'];
                    $pay_method     = $row['Pay_Method'];
                    $date_added     = $row['Date_added'];
                    $time_added     = $row['Time_added'];

                    $date_mod = date('M d, Y', strtotime($date_added)) ." | ". date('h:i A', strtotime($time_added));

                    // ================== Get employee info =====================
                        $query3 = "SELECT Lname, Fname FROM emp_info WHERE Emp_Id = '$emp_id' ";
                        $fetch3 = mysqli_query($con2, $query3);

                        if($fetch3){

                            $row3 = mysqli_fetch_assoc($fetch3);

                            $lname = $row3['Lname'];
                            $fname = $row3['Fname'];

                            $fullname = $fname ." ". $lname;

                        }
                    // ================== Get employee info END =================

                    $this->SetFont('Times','B', 12);
                    $this->Cell(50, 10, 'DATE', 1, 0, 'C');
                    $this->Cell(70, 10, 'EMPLOYEE', 1, 0, 'C');
                    $this->Cell(40, 10, 'TOTAL', 1, 0, 'C');
                    $this->Cell(30, 10, 'PAYMENT', 1, 0, 'C');
                    $this->Ln();

                    $this->SetFont('Times','', 12);
                    $this->Cell(50, 10, $date_mod, 1, 0, 'C');
                    // $this->Cell(60, 10, substr($trans_Id, 0, 10), 1, 0, 'C');
                    $this->Cell(70, 10, $fullname, 1, 0, 'C');
                    $this->Cell(40, 10, $g_total, 1, 0, 'C');
                    $this->Cell(30, 10, $pay_method, 1, 0, 'C');
                    $this->Ln();
                    $this->Ln();
                    
                    $this->SetFont('Times','B', 12);
                    $this->Cell(70, 10, 'ITEM', 1, 0, 'C');
                    $this->Cell(30, 10, 'QTY', 1, 0, 'C');
                    $this->Cell(50, 10, 'PRICE', 1, 0, 'C');
                    $this->Ln();

                    $query4 ="SELECT trans_details.Quantity, items.Item_name, items.Price ";
                    $query4 .="FROM trans_details LEFT JOIN items ";
                    $query4 .="ON trans_details.Item_Id = items.Item_Id ";
                    $query4 .="WHERE NOT Trans_det_Id = '' ";
                    $query4 .="AND trans_details.Trans_Id = '$trans_Id' ";

                    $fetch4 = mysqli_query($con, $query4);

                    if($fetch4){

                        while($row = mysqli_fetch_assoc($fetch4)){

                            $item_name  = $row['Item_name'];
                            $item_qty   = $row['Quantity'];
                            $item_price = $row['Price'];
                            
                            $this->SetFont('Times','', 12);
                            $this->Cell(70, 10, $item_name, 1, 0, 'C');
                            $this->Cell(30, 10, $item_qty, 1, 0, 'C');
                            $this->Cell(50, 10, number_format($item_price, 2), 1, 0, 'C');
                            $this->Ln();
                        }

                        $this->Ln();
                    }

                    $this->SetFont('Times','B', 12);
                    $this->Cell(70, 10, 'DISCOUNT', 1, 0, 'C');
                    $this->Cell(40, 10, 'PRICE', 1, 0, 'C');
                    $this->Ln();

                    $query5 ="SELECT trans_disc.Disc_Id, discounts.Disc_name, discounts.Disc_amount ";
                    $query5 .="FROM trans_disc LEFT JOIN discounts ";
                    $query5 .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
                    $query5 .="WHERE NOT trans_disc.Trans_Id = '' ";
                    $query5 .="AND trans_disc.Trans_Id = '$trans_Id' ";

                    $fetch5 = mysqli_query($con, $query5);

                    $count5 = mysqli_num_rows($fetch5);

                    if($fetch5){

                        if($count5 > 0){

                            while($row = mysqli_fetch_assoc($fetch5)){

                                $disc_name      = $row['Disc_name'];
                                $disc_amount    = $row['Disc_amount'];

                                $this->SetFont('Times','', 12);
                                $this->Cell(70, 10, $disc_name, 1, 0, 'C');
                                $this->Cell(40, 10, $disc_amount, 1, 0, 'C');
                                $this->Ln();
                            }

                        }

                        else{

                            $this->Cell(110, 10, 'None', 1, 0, 'C');
                        }

                        $this->Ln();
                        $this->Ln();

                    }

                }
            }
        }






        function totalCredits($con, $con2){

            $this->SetFont('Times','', 12);

            // ======================== Total Transactions ========================
                $this->Cell(40, 10,'Total Credits', 0, 0, 'B');

                $query ="SELECT SUM(Grand_Total) as Total FROM transactions ";
                $query .="WHERE Status = 1 AND Pay_Method = 'Credit' ";

                if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){

                    $date_fil1 = $_GET['datefil1'];
                    $date_fil2 = $_GET['datefil2'];

                    $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                }

                else{

                    $query .="AND Date_added = curdate() ";
                }

                if($_GET['empid'] != ''){

                    $emp_hash = $_GET['empid'];;

                    $query2 = "SELECT Emp_Id FROM employees WHERE Emp_Hash = '$emp_hash' ";
                    $fetch2 = mysqli_query($con2, $query2);

                    if($fetch2){

                        $row2 = mysqli_fetch_assoc($fetch2);

                        $emp_Id = $row2['Emp_Id'];

                        $query .="AND Emp_Id = '$emp_Id' ";
                    }
                }

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $total = $row['Total'];
                }

                $this->Cell(40, 10, number_format($total, 2), 0, 0, 'B');
                $this->Ln();
            // ======================== Total Transactions END ====================

        }



        function totalDisc($con, $disc_Id){

            // ======================== Total Discount ============================

                if($disc_Id == 1){

                    $this->Cell(40, 10,'Total 10 Pesos', 0, 0, 'B');
                }

                else if($disc_Id == 2){

                    $this->Cell(40, 10,'Total Free Rice', 0, 0, 'B');

                }

                $query = "SELECT trans_disc.Disc_Id, transactions.Trans_Id, discounts.Disc_amount ";
                $query .="FROM trans_disc LEFT JOIN transactions ";
                $query .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
                $query .="LEFT JOIN discounts ";
                $query .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
                $query .="WHERE trans_disc.Disc_Id = '$disc_Id' AND transactions.Status = 1 ";

                if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){

                    $date_fil1 = $_GET['datefil1'];
                    $date_fil2 = $_GET['datefil2'];

                    $query .="AND transactions.Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                }

                else{

                    $query .="AND transactions.Date_added = curdate() ";
                }

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $total_amount = 0;

                    while($row = mysqli_fetch_assoc($fetch)){

                        $disc_amount = $row['Disc_amount'];

                        $total_amount += $disc_amount;
                    }
                    
                    $this->Cell(40, 10, "P".number_Format($total_amount, 2), 0, 0, 'B');
                }
                
                $this->Ln();
            // ======================== Total Discount END ========================
        }
        

    }

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->Branch($con);
    // $pdf->transDiscount();
    $pdf->transDiscountTable($con, $con2);
    $pdf->totalCredits($con, $con2);
    // $pdf->totalDisc($con, 1);
    // $pdf->totalDisc($con, 2);
    $pdf->Output();

?>