<?php

    require('../assets/fpdf/fpdf.php');

    include "includes/db.php";
    include "includes/functions.php";

    class myPDF extends FPDF{



        function Header(){

            $this->SetFont('Arial','B', 14);
            $this->Cell(0,5,'Tsukiden Electric Industries Philippines, Inc.',0,0,'C');
            $this->Ln();
                
        }



        function Branch($con){

            $this->SetFont('Times','', 12);
            $this->Cell(0,10, "Address", 0, 0, 'C');
            $this->Ln();
            $this->SetFont('Times','', 12);
            $this->Cell(0,5, "Location", 0, 0, 'C');
            $this->Ln();
            $this->SetFont('Times','', 12);
            $this->Cell(0,10, "Phone Number", 0, 0, 'C');
            $this->Ln(20);
            $this->SetFont('Times','', 13);

            if($_GET['discid'] == '1'){

                $this->Cell(0,5,'10 Pesos Discounts as of', 0, 0, 'C');
            }

            else if($_GET['discid'] == '2'){

                $this->Cell(0,5,'Free Rice Discounts as of', 0, 0, 'C');
            }

            else{

                $this->Cell(0,5,'Transaction Discounts as of', 0, 0, 'C');
            }

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
            $this->Cell(60, 10, 'TRANSACTION SLIP', 1, 0, 'C');
            $this->Cell(70, 10, 'EMPLOYEE', 1, 0, 'C');
            $this->Cell(50, 10, 'DISCOUNT', 1, 0, 'C');
            $this->Cell(50, 10, 'AMOUNT', 1, 0, 'C');
            $this->Ln();
            //Table Header END
        }



        function transDiscountTable($con, $con2){

            $query ="SELECT trans_disc.Trans_Id, discounts.Disc_name, discounts.Disc_amount, ";
            $query .="transactions.Emp_Id, transactions.Date_added, transactions.Time_added ";
            $query .="FROM trans_disc LEFT JOIN discounts ";
            $query .="ON trans_disc.Disc_Id = discounts.Disc_Id ";
            $query .="LEFT JOIN transactions ";
            $query .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
            $query .="WHERE NOT trans_disc.Trans_D_Id = '' AND transactions.Status = 1 ";

            if($_GET['discid'] != ''){

                $disc_Id = $_GET['discid'];

                $query .="AND trans_disc.Disc_Id = '$disc_Id' ";
            }

            if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){

                $date_fil1 = $_GET['datefil1'];
                $date_fil2 = $_GET['datefil2'];

                $query .="AND transactions.Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
            }

            else{

                $query .="AND transactions.Date_added = curdate() ";
            }

            $query .="ORDER BY transactions.Date_added DESC ";

            $fetch = mysqli_query($con, $query);

            $count = mysqli_num_rows($fetch);

            if($count == NULL){

                $this->Cell(280, 10, 'None', 1, 0, 'C');

            }

            else{

                while($row = mysqli_fetch_assoc($fetch)){
                    
                    $trans_Id       = $row['Trans_Id'];
                    $emp_Id         = $row['Emp_Id'];
                    $disc_name      = $row['Disc_name'];
                    $disc_amount    = $row['Disc_amount'];
                    $date_added     = $row['Date_added'];
                    $time_added     = $row['Time_added'];

                    $date_mod = date('M d, Y', strtotime($date_added)) ." | ". date('h:i A', strtotime($time_added));

                    $query2 = "SELECT employees.Emp_Id, emp_info.Lname, emp_info.Fname ";
                    $query2 .="FROM employees LEFT JOIN emp_info ";
                    $query2 .="ON employees.Emp_Id = emp_info.Emp_Id ";
                    $query2 .="WHERE employees.Emp_Id = '$emp_Id' ";

                    $fetch2 = mysqli_query($con2, $query2);

                    if($fetch2){

                        $row2 = mysqli_fetch_assoc($fetch2);

                        $emp_id = $row2['Emp_Id'];
                        $lname  = $row2['Lname'];
                        $fname  = $row2['Fname'];

                        $emp_name = $fname ." ". $lname;
                    }

                    $this->SetFont('Times','', 12);
                    $this->Cell(50, 10, $date_mod, 1, 0, 'C');
                    $this->Cell(60, 10, substr($trans_Id, 0, 10), 1, 0, 'C');
                    $this->Cell(70, 10, $emp_name, 1, 0, 'C');
                    $this->Cell(50, 10, $disc_name, 1, 0, 'C');
                    $this->Cell(50, 10, $disc_amount, 1, 0, 'C');
                    $this->Ln();
                }
            }
        }






        function totalTrans($con){

            $this->Ln();
            $this->SetFont('Times','', 12);

            // ======================== Total Transactions ========================
                $this->Cell(40, 10,'Total Transactions', 0, 0, 'B');

                $query = "SELECT DISTINCT trans_disc.Trans_Id ";
                $query .="FROM trans_disc LEFT JOIN transactions ";
                $query .="ON trans_disc.Trans_Id = transactions.Trans_Id ";
                $query .="WHERE transactions.Status = 1 ";

                if($_GET['discid'] != ''){

                    $disc_Id = $_GET['discid'];

                    $query .="AND trans_disc.Disc_Id = '$disc_Id' ";
                }

                if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){

                    $date_fil1 = $_GET['datefil1'];
                    $date_fil2 = $_GET['datefil2'];

                    $query .="AND transactions.Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                }

                else{

                    $query .="AND transactions.Date_added = curdate() ";
                }

                $fetch = mysqli_query($con, $query);

                $count = mysqli_num_rows($fetch);

                $this->Cell(40, 10, $count, 0, 0, 'B');
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
    $pdf->AddPage('L', 'A4', 0);
    $pdf->Branch($con);
    $pdf->transDiscount();
    $pdf->transDiscountTable($con, $con2);
    $pdf->totalTrans($con);
    $pdf->totalDisc($con, 1);
    $pdf->totalDisc($con, 2);
    $pdf->Output();

?>