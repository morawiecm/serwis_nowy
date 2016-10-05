<?php

/**
 * @author 
 * @copyright 2012
 */


require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',5,5,35,25);
    // Arial bold 15
    $this->SetFont('Times','',10);
    // Move to the right
    $this->Cell(32);
    // Title
    $this->Cell(5,5,'Send-2 Roman Chiliñski',0,0,'L');
    $this->Cell(150,5,'Gorzów Wlkp. 05.08.2012',0,2,'R');
    // Line break
    
    $this->Cell(35,5,'Skladowa 2 66-400 Gorzów Wlkp',0,2,'L');
    $this->Cell(35,5,'Tel. 95 7121 521  Fax. 95 781 95 96',0,2,'L');
    $this->Ln();
    $this->Line(40,25,200,25);
    $this->Line(10,40,200,40);
    
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',10);
$pdf->Cell(70);
$pdf->Cell(0,0,'POTWIERDZENIE NADANIA',0,2,'L');
$pdf->Ln();
$pdf->SetFont('Times','',9);
$pdf->Cell(35,15,'NADAWCA:',0,0,'L');
$pdf->Cell(68);
$pdf->Cell(0,15,'ODBIORCA:',0,0,'L');
$pdf->Ln();
$pdf->Cell(19,0,'IMIE:',0,0,'L');
$pdf->Cell(85,0,'Mariusz',0,0,'L');
$pdf->Cell(19,0,'IMIE:',0,0,'L');
$pdf->Cell(50,0,'Mariusz',0,0,'L');
$pdf->Ln();
$pdf->Cell(19,10,'NAZWISKO:',0,0,'L');
$pdf->Cell(85,10,'Morawiec',0,0,'L');
$pdf->Cell(19,10,'NAZWISKO:',0,0,'L');
$pdf->Cell(50,10,'Morawiec',0,0,'L');
$pdf->Ln();
$pdf->Cell(19,0,'ULICA:',0,0,'L');
$pdf->Cell(85,0,'OGINSKIEGO',0,0,'L');
$pdf->Cell(19,0,'ULICA:',0,0,'L');
$pdf->Cell(50,0,'OGINSKIEGO',0,0,'L');
$pdf->Ln();
$pdf->Cell(19,10,'KOD POCZT:',0,0,'L');
$pdf->Cell(85,10,'66-400',0,0,'L');
$pdf->Cell(19,10,'KOD POCZT:',0,0,'L');
$pdf->Cell(50,10,'66-400',0,0,'L');
$pdf->Ln();
$pdf->Cell(19,0,'MIASTO:',0,0,'L');
$pdf->Cell(85,0,'Gorzów Wlkp',0,0,'L');
$pdf->Cell(19,0,'MIASTO:',0,0,'L');
$pdf->Cell(50,0,'Gorzów Wlkp',0,0,'L');
$pdf->Ln();
$pdf->Cell(19,10,'TELEFON:',0,0,'L');
$pdf->Cell(85,10,'506280099',0,0,'L');
$pdf->Cell(19,10,'TELEFON:',0,0,'L');
$pdf->Cell(50,10,'506280099',0,0,'L');
$pdf->Ln();
$pdf->Cell(19,0,'EMAIL:',0,0,'L');
$pdf->Cell(85,0,'mariusz@morawiec.org',0,0,'L');
$pdf->Cell(19,0,'EMAIL:',0,0,'L');
$pdf->Cell(50,0,'mariusz@morawiec.org',0,0,'L');
$pdf->Ln();
$pdf->Cell(60);
$pdf->Cell(120,20,'DANE PACZKI: ',0,0,'L');
$pdf->Ln();
$pdf->Cell(30,0,'POBRANIE',0,0,'L');
$pdf->Cell(85,0,'200 zl',0,0,'L');
$pdf->Cell(40,0,'WAGA PACZKI:',0,0,'L');
$pdf->Cell(85,0,'20KG',0,0,'L');
$pdf->Ln();
$pdf->Cell(30,10,'NUMER KONTA',0,0,'L');
$pdf->Cell(85,10,'11111111111111111111111111',0,0,'L');
$pdf->Cell(40,10,'WYMIARY PACZKI (D/S/W):',0,0,'L');
$pdf->Cell(85,10," 50 / 50 / 50",0,0,"L");
$pdf->Ln();
$pdf->Cell(30,0,'STANDARD:',0,0,'L');
$pdf->Cell(85,0,'TAK',0,0,'L');
$pdf->Cell(40,0,'UBEZPIECZENIE:',0,0,'L');
$pdf->Cell(85,0,'2000Z£',0,0,'L');
$pdf->Ln();
$pdf->MultiCell(200,30,'Oœwiadczam ¿e akceptujê warunki Regulaminu firmy Send-2, oraz upowa¿niam firmê Send-2  i jej pracowników do nadania w Moim imieniu ',0,2,'L');
$pdf->Cell(200,-20,'przesy³ki kurierskiej z terenu POLSKI',0,0,'L');

$pdf->Image('logo.png',5,135,35,25);
    $pdf->Cell(32);
    $pdf->Cell(5,70,'Send-2 Roman Chiliñski',0,0,'L');
    $pdf->Cell(100,70,'Gorzów Wlkp. 05.08.2012',0,2,'L');
    $pdf->Cell(0,0,'Skladowa 2 66-400 Gorzów Wlkp',0,0,'L');
    $pdf->Cell(0,0,'Tel. 95 7121 521  Fax. 95 781 95 96',0,0,'L');
    $pdf->Ln();
    $pdf->Line(40,25,200,25);
    $pdf->Line(10,40,200,40);
$pdf->Output();

?>