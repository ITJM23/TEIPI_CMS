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

            if($_GET['pm'] == 'Cash'){

                $this->Cell(0,5,'Cash transactions as of', 0, 0, 'C');
            }

            else if($_GET['pm'] == 'Credit'){

                $this->Cell(0,5,'Credit transactions as of', 0, 0, 'C');
            }

            else{

                $this->Cell(0,5,'Canteen transactions as of', 0, 0, 'C');
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







        function canteenTrans(){

            //Table Header 
            $this->SetFont('Times','B', 12);
            $this->Cell(50, 10, 'DATE', 1, 0, 'C');
            $this->Cell(60, 10, 'TRANSACTION SLIP', 1, 0, 'C');
            $this->Cell(70, 10, 'EMPLOYEE', 1, 0, 'C');
            $this->Cell(50, 10, 'PAYMENT', 1, 0, 'C');
            $this->Cell(50, 10, 'TOTAL', 1, 0, 'C');
            $this->Ln();
            //Table Header END
        }



        function canteenTransTable($con, $con2){

            $query ="SELECT Trans_Id, Emp_Id, Grand_Total, Pay_Method, Date_added, Time_added ";
            $query .="FROM transactions WHERE NOT Pay_Method = '' ";

            if($_GET['pm'] != ''){

                $payment_mode = $_GET['pm'];
        
                $query .="AND Pay_Method = '$payment_mode' ";
            }
        
            if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){
        
                $date_fil1 = $_GET['datefil1'];
                $date_fil2 = $_GET['datefil2'];
        
                $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
            }
        
            else{
        
                $query .="AND Date_added = curdate() ";
            }

            $query .="ORDER BY Date_added DESC ";

            $fetch = mysqli_query($con, $query);

            $count = mysqli_num_rows($fetch);

            if($count == NULL){

                $this->Cell(280, 10, 'None', 1, 0, 'C');

            }

            else{

                while($row = mysqli_fetch_assoc($fetch)){
                    
                    $trans_Id       = $row['Trans_Id'];
                    $emp_Id         = $row['Emp_Id'];
                    $payment_m      = $row['Pay_Method'];
                    $g_total        = $row['Grand_Total'];
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
                    $this->Cell(50, 10, $payment_m, 1, 0, 'C');
                    $this->Cell(50, 10, number_format($g_total, 2), 1, 0, 'C');
                    $this->Ln();
                }
            }
        }






        function totalTrans($con){

            $this->Ln();
            $this->SetFont('Times','', 12);

            // ======================== Total Transactions ========================
                $this->Cell(40, 10,'Total Transaction/s: ', 0, 0, 'B');

                $query ="SELECT COUNT(Trans_Id) as Total ";
                $query .="FROM transactions ";
                $query .="WHERE Status = 1 ";
                
                if($_GET['pm'] != ''){

                    $payment_mode = $_GET['pm'];
            
                    $query .="AND Pay_Method = '$payment_mode' ";
                }
                
                if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){

                    $date_fil1 = $_GET['datefil1'];
                    $date_fil2 = $_GET['datefil2'];

                    $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                }

                else{

                    $query .="AND Date_added = curdate() ";
                }

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $total = $row['Total'];

                    $this->Cell(40, 10, $total, 0, 0, 'B');
                }

                $this->Ln();
            // ======================== Total Transactions END ====================

        }



        function totalDisc($con, $pm_Id){

            // ======================== Total Discount ============================

                if($pm_Id == 'Cash'){

                    $pay_method = 'Cash';

                    $this->Cell(40, 10,'Total Cash: ', 0, 0, 'B');
                }

                else if($pm_Id == 'Credit'){

                    $pay_method = 'Credit';

                    $this->Cell(40, 10,'Total Credit: ', 0, 0, 'B');

                }

                $query ="SELECT SUM(Grand_Total) as Total FROM transactions ";
                $query .="WHERE Status = 1 AND Pay_Method = '$pay_method' ";

                if($_GET['datefil1'] != '' && $_GET['datefil2'] != ''){

                    $date_fil1 = $_GET['datefil1'];
                    $date_fil2 = $_GET['datefil2'];

                    $query .="AND Date_added BETWEEN '$date_fil1' AND '$date_fil2' ";
                }

                else{

                    $query .="AND Date_added = curdate() ";
                }

                $fetch = mysqli_query($con, $query);

                if($fetch){

                    $row = mysqli_fetch_assoc($fetch);

                    $total = $row['Total'];
                    
                    $this->Cell(40, 10, "P".number_Format($total, 2), 0, 0, 'B');
                }
                
                $this->Ln();
            // ======================== Total Discount END ========================
        }
        

    }

    $pdf = new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L', 'A4', 0);
    $pdf->Branch($con);
    $pdf->canteenTrans();
    $pdf->canteenTransTable($con, $con2);
    $pdf->totalTrans($con);
    $pdf->totalDisc($con, 'Cash');
    $pdf->totalDisc($con, 'Credit');
    $pdf->Output();

?>