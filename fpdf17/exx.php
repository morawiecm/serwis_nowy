<?php

//dane z formularza
$nrEwid=$_POST['nrEwid'];
$nazwa=$_POST['nazwa'];
$nazwa=iconv('utf-8','windows-1250',$nazwa);
$ciag=$nazwa;
                        $podziel=substr($ciag,0,32);
                        $podziel2=substr($ciag,32,60);
include('code39.php');
$pdf = new PDF_Code39();
//$pdf->AddPage('l',array(50,25));
//$pdf->AddPage('l',array(205,126));
$pdf->AddPage('l',array(50,25));
//$pdf->AddPage('l',array(55,35));
$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(2.5);
//$pdf->SetRightMargin(0.5);
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
//$pdf->AddPage('l',array(113.39,85.04));

//MSWiA KWP Gorz?w Wlkp.
$pdf->SetFont('arial_ce','B',7);
//$pdf->Cell(2);
$pdf->Text(10,3,'MSWiA KWP Gorzów Wlkp.');
//$pdf->Ln(2);
$pdf->Code39(2.9, 4, $nrEwid,'true',false,0.27,8.5,false);
//$pdf->Code39(1.4, 4, $nrEwid,'true',false,0.27,8.5,false);
//Code39(float x, float y, string code [, boolean ext [, boolean cks [, float w [, float h [, boolean wide]]]]])
//Nazwa produktu
//$pdf->Ln(2);
$pdf->SetFont('arial_ce','B',7);
$pdf->Text(5.4,18,$podziel);
$pdf->Text(5.4,20.5,$podziel2);
$pdf->Close();
$pdf->Output();
?>
