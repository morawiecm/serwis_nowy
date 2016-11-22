<?php
/**
 * Created by PhpStorm.
 * User: mariu
 * Date: 22.11.2016
 * Time: 13:47
 */
include '../config.php';
include '../funkcje/funkcje_historia.php';


if ($a=='generuj')
{

    $pobranie_danych_protokol_glowny = mysqli_query($polaczenie, "SELECT * FROM protokol2 WHERE id = '$nrID'") or die("Blad przy pobieranie_danych_protokol_glowny" . mysqli_error($polaczenie));
    if (mysqli_num_rows($pobranie_danych_protokol_glowny) > 0) {
        while ($daneProtokolGlowny = mysqli_fetch_array($pobranie_danych_protokol_glowny)) {
            $imie1 = iconv('utf-8', 'windows-1250', $daneProtokolGlowny[4]);
            $imie2 = iconv('utf-8', 'windows-1250', $daneProtokolGlowny[5]);
            $imie3 = iconv('utf-8', 'windows-1250', $daneProtokolGlowny[6]);

            $data = $daneProtokolGlowny[2];
            $koszt = iconv('utf-8', 'windows-1250', $daneProtokolGlowny[7]);
            $stan_techniczny1 = iconv('utf-8','windows-1250',$daneProtokolGlowny[10]);
            $kategoria_n1 = iconv('utf-8', 'windows-1250',$daneProtokolGlowny[8]);
            $kategoria_n = iconv('utf-8', 'windows-1250', $daneProtokolGlowny[8]);
            $opinia = iconv('utf-8', 'windows-1250', $daneProtokolGlowny[9]);
        }
    }

    include('mc_table.php');

//generowanie pdfa
    class PDF extends FPDF
    {
        function Footer()
        {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Page number
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    $pdf = new PDF_MC_Table();


    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4');
    $pdf->AddFont('arial_ce', '', 'arial_ce.php');
    $pdf->AddFont('arial_ce', 'I', 'arial_ce_i.php');
    $pdf->AddFont('arial_ce', 'B', 'arial_ce_b.php');
    $pdf->AddFont('arial_ce', 'BI', 'arial_ce_bi.php');
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->EAN13(20, 10, "$nrID");

    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Cell(140);
    $pdf->Cell(22, 0, 'Gorzów Wlkp.', 0, 0, 'L');
    $pdf->Cell(40, 0, $data, 0, 0, 'L');
    $pdf->Ln(10);
    $pdf->SetFont('arial_ce', '', 8);
    $pdf->Cell(20,5);
    $pdf->Cell(20,5,$nrID);
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce', 'B', 12);
    $pdf->Cell(60);
    $pdf->Cell(22, 0, 'PROTOKÓ£  STANU  TECHNICZNEGO', 0, 0, 'L');
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Ln(8);
    $pdf->Cell(90, 0, 'I. Sporz¹dzony w: Wydziale £¹cznoœci i Informatyki KWP w Gorzowie Wlkp.', 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(25, 5, 'Nr ewidencyjny', 1, 0, 'C');
    $pdf->Cell(30, 5, 'Nr fabryczny', 1, 0, 'C');
    $pdf->Cell(48, 5, 'Nazwa sprzêtu', 1, 0, 'C');
    $pdf->Cell(32, 5, 'Na stanie', 1, 0, 'C');
    $pdf->Cell(25, 5, 'Data zakupu', 1, 0, 'C');
    $pdf->Cell(30, 5, 'Wart. pocz¹tkowa', 1, 0, 'C');
    $pdf->SetFont('arial_ce', '', 8);
    $pdf->Ln();
    $pobranie_skladnikow_do_protokolu2 = mysqli_query($polaczenie, "SELECT * FROM protokol_skladniki WHERE id_protokol = '$nrID'") or die('B³ad przy pobieranie_skladnikow_do_protokolu2'.mysqli_error($polaczenie));
    $licznik=mysqli_num_rows($pobranie_skladnikow_do_protokolu2);
    if ($licznik > 0) {
        $pdf->SetWidths(array(25, 30, 48, 32, 25, 30));
        while ($skladniki = mysqli_fetch_array($pobranie_skladnikow_do_protokolu2)) {
            $nr_ewidencyjny = $skladniki[2];
            $nr_seryjny = $skladniki[3];
            $nazwa = iconv('utf-8', 'windows-1250', $skladniki[4]);
            $wartosc = number_format($skladniki[5], 2, '.', '') . " z³";
            $naStanie = iconv('utf-8', 'windows-1250', $skladniki[6]);
            $data_zakupu = $skladniki[7];

            $pdf->Row(array($nr_ewidencyjny, $nr_seryjny, $nazwa, $naStanie, $data_zakupu, $wartosc));

        }
    }
    if($licznik>6 || $licznik>13)
    {
        $pdf->SetXY(170,270);
        $pdf->Cell(0, 5, "Strona: " . $pdf->PageNo() . "/{totalPages}", 0, 1);
        $pdf->AddPage('P','A4');
        $pdf->AddFont('arial_ce','','arial_ce.php');
        $pdf->AddFont('arial_ce','I','arial_ce_i.php');
        $pdf->AddFont('arial_ce','B','arial_ce_b.php');
        $pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
        $pdf->EAN13(20, 10, "$nrID");

        $pdf->SetFont('arial_ce', 'B', 9);
        $pdf->Cell(140);
        $pdf->Cell(22, 0, 'Gorzów Wlkp.', 0, 0, 'L');
        $pdf->Cell(40, 0, $data, 0, 0, 'L');
        $pdf->Ln(10);
        $pdf->SetFont('arial_ce', '', 8);
        $pdf->Cell(20,5);
        $pdf->Cell(20,5,"$nrID");

    }

    $pdf->Ln(10);
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Cell(35, 0, 'Komisja w sk³adzie: ', 0, 0, 'L');
    $pdf->Ln(8);
    $pdf->Cell(5);
    $pdf->SetFont('arial_ce', '', 9);
    $pdf->Cell(5, 0, '1. ', 0, 0, 'L');
    $pdf->Cell(50, 0, $imie1, 0, 0, 'L');
    #$pdf->Ln(8);
    $pdf->Cell(5);
    $pdf->Cell(5, 0, '2. ', 0, 0, 'L');
    $pdf->Cell(50, 0, $imie2, 0, 0, 'L');
    #$pdf->Ln(8);
    $pdf->Cell(5);
    $pdf->Cell(5, 0, '3. ', 0, 0, 'L');
    $pdf->Cell(50, 0, $imie3, 0, 0, 'L');
    $pdf->Ln(8);
    $pdf->Cell(35, 0, 'Na podstawie polecenia Naczelnika Wydzia³u £¹cznoœci i Informatyki dokona³a przegl¹du technicznego wymienionego na ', 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(35, 0, 'wstêpie sprzêtu i stwierdzi³a:', 0, 0, 'L');
    $pdf->Ln(8);
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Cell(28, 0, 'Koszt naprawy: ', 0, 0, 'L');
    $pdf->SetFont('arial_ce', '', 9);
    $pdf->Cell(40, 0, $koszt, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Cell(28, 0, 'Stan techniczny: ', 0, 0);
    $pdf->SetFont('arial_ce', '', 9);
    $pdf->MultiCell(140, 5, $stan_techniczny1);
    #$pdf->MultiCell(35, 0, $stan_tech1, 0, 0, 'L');
    $pdf->Ln(5);
    /*if($stan_tech2!='')
    {
        $pdf->Cell(25);
        $pdf->Cell(35, 0, $stan_tech2, 0, 0, 'L');
        $pdf->Ln(5);
    }*/
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Cell(28, 0, 'Kategoria: ', 0, 0, 'L');
    $pdf->SetFont('arial_ce', '', 9);
    $pdf->Cell(35, 0, $kategoria_n, 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Cell(58, 0, 'Opinia co do dalszego przeznaczenia: ', 0, 0, 'L');
    $pdf->SetFont('arial_ce', '', 9);
    $pdf->Cell(35, 0, $opinia, 0, 0, 'L');
    $pdf->Ln(10);
    $pdf->Cell(55, 0, 'Podpisy komisji: ', 0, 0, 'L');
    $pdf->Ln(12);
    $pdf->Cell(10);
    $pdf->Cell(35, 0, '.........................................', 0, 0, 'L');
    $pdf->Cell(30);
    $pdf->Cell(35, 0, '.........................................', 0, 0, 'L');
    $pdf->Cell(30);
    $pdf->Cell(35, 0, '.........................................', 0, 0, 'L');
    $pdf->Ln(10);
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Cell(50, 0, 'II. Wniosek komisji akceptujê i przedstawiam do zatwierdzenia.');
    $pdf->Ln(12);
    $pdf->SetFont('arial_ce', '', 9);
    $pdf->Cell(140);
    $pdf->Cell(35, 0, '.........................................', 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(142);
    $pdf->SetFont('arial_ce', '', 7);
    $pdf->Cell(35, 0, '(podpis Naczelnika W£iI)', 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce', 'B', 9);
    $pdf->Cell(50, 0, 'III. Wniosek komisji zatwierdzam');
    $pdf->Ln(20);
    $pdf->SetFont('arial_ce', '', 9);
    $pdf->Cell(140);
    $pdf->Cell(35, 0, '.........................................', 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(130);
    $pdf->SetFont('arial_ce', '', 7);
    $pdf->Cell(35, 0, '(pieczêæ i podpis Kierownika jednostki bud¿etowej)', 0, 0, 'L');
    if($licznik>6)
    {
        $pdf->SetXY(170,270);
        $pdf->Cell(0, 5, "Strona: " . $pdf->PageNo() . "/{totalPages}", 0, 1);
    }
    $pdf->Close();
    $pdf->Output();




}
elseif($a=='zapisz')
{

}
