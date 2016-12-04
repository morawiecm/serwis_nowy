<?php


include '../config.php';
include '../funkcje/funkcje_ewidencja.php';

$nazwa_jednostki = iconv('utf-8','windows-1250',PobierzNazweWydzialu($nrID));
$data_aktualna=date("d/m/Y");


    require('mc_table.php');
/*
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
*/
$pdf = new PDF_MC_Table();



    $pdf->AddPage('P','A4');
    $pdf->AliasNbPages();

    $pdf->AddFont('arial_ce','','arial_ce.php');
    $pdf->AddFont('arial_ce','I','arial_ce_i.php');
    $pdf->AddFont('arial_ce','B','arial_ce_b.php');
    $pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
    $pdf->SetFont('arial_ce','B',12);
    $pdf->Ln(5);
    $pdf->Cell(40,0,"Wykaz sprzêtu W£iI. Stan na dzieñ: $data_aktualna r.",0,1,'L');
    $pdf->Ln(5);
    $pdf->Cell(40,0,"Jednostka u¿ytkuj¹ca: $nazwa_jednostki.",0,1,'L');
    $pdf->Ln(14);
    //$pdf->Cell(90);
    //$pdf->Cell(90);

    $pdf->SetFont('arial_ce','B',9);
    $pdf->Cell(10,5,"LP",1,0,'C');
    $pdf->Cell(55,5,"MATERIA£",1,0,'C');
    $pdf->Cell(30,5,"NR FABRYCZNY",1,0,'C');
    $pdf->Cell(25,5,"NR INWENT",1,0,'C');
    $pdf->Cell(25,5,"NR INWENT 2",1,0,'C');
    $pdf->Cell(25,5,"NR INWENT 3",1,0,'C');
    $pdf->Cell(25,5,"WARTOŒÆ",1,1,'C');
    $pdf->SetWidths(array(10,55,30,25,25,25,25));
    $pdf->SetFont('arial_ce','',8);
    $lp=0;
    $razem = 0;
$nr_fabryczny = '';
$nazwa_sprzetu = '';
$nr_inwentarzowy = '';
$nr_inwentarzowy_1 = '';
$nr_inwentarzowy_2 = '';
$wartosc = 0.00;
$wartosc_format =0.00;


            $pobierz_dane_materialu = mysqli_query($polaczenie,"SELECT nr_fabryczny,nr_inwentarzowy,nr_inwentarzowy_1,nr_inwentarzowy_2,wartosc,nazwa_sprzetu FROM baza WHERE id_jednoski='$nrID' AND likwidacja IS NULL ")
                or die("Blad przy pobierz_dane_materialu".mysqli_error($polaczenie));
            while ($skladniki_asygnaty = mysqli_fetch_array($pobierz_dane_materialu))
            {
                $lp++;
                $nr_fabryczny = iconv('utf-8','windows-1250',$skladniki_asygnaty['nr_fabryczny']);
                $nazwa_sprzetu = iconv('utf-8','windows-1250',$skladniki_asygnaty['nazwa_sprzetu']);
                $nr_inwentarzowy = iconv('utf-8','windows-1250',$skladniki_asygnaty['nr_inwentarzowy']);
                $nr_inwentarzowy_1 = iconv('utf-8','windows-1250',$skladniki_asygnaty['nr_inwentarzowy_1']);
                $nr_inwentarzowy_2 = iconv('utf-8','windows-1250',$skladniki_asygnaty['nr_inwentarzowy_2']);
                $wartosc = $skladniki_asygnaty['wartosc'];
                $wartosc= number_format($wartosc,2,'.','');
                $wartosc_format  = number_format($skladniki_asygnaty['wartosc'],'2','.',' ');
                $razem += $wartosc;

            $pdf->Row(array($lp,$nazwa_sprzetu,$nr_fabryczny,$nr_inwentarzowy,$nr_inwentarzowy_1,$nr_inwentarzowy_2,$wartosc_format));
            }


$razem = number_format($razem,2,'.',' ');
    $pdf->Ln(5);

    //podsumowanie asygnaty
$pdf->SetFont('arial_ce','B',9);
    $pdf->Ln(5);
    $pdf->Cell(40,0,"Zakoñczono na pozycji:   ".$lp,0,0,'L');
    $pdf->Cell(57,0);
    $pdf->Cell(33,0,'WARTOŒÆ RAZEM: ');
    $pdf->Cell(30,0,$razem." z³",0,0,'R');
    //podpisy

    $pdf->Ln(12);
    $pdf->Cell(35,0,'Sporz¹dzi³:',0,0,'L');
$pdf->Cell(18,0);
//$pdf->SetXY(170,270);
//$pdf->Cell(0, 5, "Strona: " . $pdf->PageNo() . "/{nb}", 0, 1);


    $pdf->Close();
    $pdf->Output();


?>
