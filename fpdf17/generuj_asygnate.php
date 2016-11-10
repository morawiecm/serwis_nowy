<?php


include '../config.php';



    require('mc_table.php');

    $prefix="9999";
    //$id_protokolu2="$id_protokolu"."$prefix";
    $nrID = 4;

    $pobierz_asygnate_z_bazy = mysqli_query($polaczenie,"SELECT data_asygnaty, do, od, nr_asygnaty, typ, uwagi FROM asygnata WHERE id ='$nrID'")
        or die("Blad przy pobierz_asygnate_z_bazy".mysqli_error($polaczenie));
if(mysqli_num_rows($pobierz_asygnate_z_bazy)>0)
{
    while ($dane_asygnata = mysqli_fetch_array($pobierz_asygnate_z_bazy))
    {
        $asygnata_data = $dane_asygnata['data_asygnaty'];
        $typ_asygnaty = $dane_asygnata['typ'];
        if($typ_asygnaty==0)
        {
            $asygnata_typ = "WYDANIA";
        }
        else
        {
            $asygnata_typ = "PRZEKAZANIA";
        }
        $nr_asygnaty = iconv('utf-8','windows-1250',$dane_asygnata['nr_asygnaty']);
        $od = iconv('utf-8','windows-1250',$dane_asygnata['od']);
        $do = iconv('utf-8','windows-1250',$dane_asygnata['do']);
        $uwagi = iconv('utf-8','windows-1250',$dane_asygnata['uwagi']);

    }
}
//generowanie pdfa
    class PDF extends FPDF
    {

    }
    $pdf=new PDF_MC_Table();



    $pdf->AliasNbPages();
    $pdf->AddPage('P','A4');
    $pdf->AddFont('arial_ce','','arial_ce.php');
    $pdf->AddFont('arial_ce','I','arial_ce_i.php');
    $pdf->AddFont('arial_ce','B','arial_ce_b.php');
    $pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
    $pdf->SetFont('arial_ce','B',9);
    //$pdf->EAN13(20,10,$id_protokolu2);
    $pdf->SetFont('arial_ce','B',9);
    $pdf->Cell(40,0,"WYDZIA£ £¥CZNOŒCI I INFORMATYKI",0,0,'L');
    $pdf->Cell(90);
    $pdf->Cell(22,0,'DATA WYSTAWIENIA DOKUMENTU',0,0,'L');
    $pdf->Ln(3);
    $pdf->Cell(40,0,"KWP W GORZOWIE WLKP.",0,0,'L');
    $pdf->Cell(90);
    $pdf->Cell(20,0,"Gorzów Wlkp.");
    $pdf->Cell(30,0,$asygnata_data,0,0,'R');
    $pdf->Ln(14);
    //$pdf->Cell(90);
    //$pdf->Cell(90);
    $pdf->SetFont('arial_ce','B',14);
    $pdf->Cell(190,0,"DOWÓD"." ".$asygnata_typ." NR: ".$nr_asygnaty,0,0,'C');
    $pdf->Ln(14);
    $pdf->SetFont('arial_ce','B',10);
    $pdf->Cell(10,0,"Dla:",0,0,'L');
    $pdf->SetFont('arial_ce','',10);
    $pdf->Cell(90,0,$do,0,0,'L');
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce','B',10);
    $pdf->Cell(10,0,"Od:",0,0,'L');
    $pdf->SetFont('arial_ce','',10);
    $pdf->Cell(90,0,$od,0,0,'L');
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce','B',10);
    $pdf->Cell(22,0,"Podstawa: ",0,0,'L');
    $pdf->SetFont('arial_ce','',10);
    $pdf->Cell(90,0,"Polecenie Naczelnika Wydzia³u £¹cznoœci i Informatyki KWP w Gorzowie Wlkp.",0,0,'L');
    $pdf->Ln(10);
    $pdf->SetFont('arial_ce','B',9);
    $pdf->Cell(10,5,"LP",1,0,'C');
    $pdf->Cell(27,5,"NR KARTY EWID.",1,0,'C');
    $pdf->Cell(70,5,"NAZWA SPRZÊTU (MATERIA£U)",1,0,'C');
    $pdf->Cell(12,5,"J.M",1,0,'C');
    $pdf->Cell(12,5,"ILOŒÆ",1,0,'C');
    $pdf->Cell(29,5,"WARTOŒÆ EWID.",1,0,'C');
    $pdf->Cell(35,5,"UWAGI",1,1,'C');
    $pdf->SetWidths(array(10,27,70,12,12,29,35));
    $pdf->SetFont('arial_ce','',8);
    $lp=0;
    $razem = 0;
    //skladniki asygnaty

    $pobierz_skladniki_asygnaty = mysqli_query($polaczenie,"SELECT id_lp, uwaga FROM asygnata_skladniki WHERE id_asygnaty = '$nrID'")
        or die("Blad przy pobierz_skaldniki_asygnaty".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_skladniki_asygnaty)>0)
    {
        while ($asygnata_skladniki = mysqli_fetch_array($pobierz_skladniki_asygnaty))
        {
            $lp++;
            $uwaga = $asygnata_skladniki['uwaga'];
            $pobierz_dane_materialu = mysqli_query($polaczenie,"SELECT nr_fabryczny,nr_inwentarzowy,nr_inwentarzowy_1,jed_miary,wartosc,rodzaj_ewidencyjny,nazwa_sprzetu FROM baza WHERE lp = '$asygnata_skladniki[id_lp]'")
                or die("Blad przy pobierz_dane_materialu".mysqli_error($polaczenie));
            while ($skladniki_asygnaty = mysqli_fetch_array($pobierz_dane_materialu))
            {
                $nr_karty_ewid = iconv('utf-8','windows-1250',$skladniki_asygnaty['rodzaj_ewidencyjny']);
                $nr_fabryczny = iconv('utf-8','windows-1250',$skladniki_asygnaty['nr_fabryczny']);
                $nazwa_sprzetu = iconv('utf-8','windows-1250',$skladniki_asygnaty['nazwa_sprzetu']);
                $nr_inwentarzowy = iconv('utf-8','windows-1250',$skladniki_asygnaty['nr_inwentarzowy']);
                $nr_inwentarzowy_1 = iconv('utf-8','windows-1250',$skladniki_asygnaty['nr_inwentarzowy_1']);
                $jed_miary = iconv('utf-8','windows-1250',$skladniki_asygnaty['jed_miary']);
                $wartosc = $skladniki_asygnaty['wartosc'];
                $wartosc= number_format($wartosc,2,'.','');
                $razem += $wartosc;

            }
            $pdf->Row(array($lp,$nr_karty_ewid,$nazwa_sprzetu."\n Nr fabry.: ".$nr_fabryczny."\n Nr inw.nowy: ".$nr_inwentarzowy."\n Nr inw.stary: ".$nr_inwentarzowy_1,$jed_miary,'1',$wartosc." z³",$uwaga));
        }
    }


    //podsumowanie asygnaty
$pdf->SetFont('arial_ce','B',9);
    $pdf->Ln(5);
    $pdf->Cell(40,0,"Zakoñczono na pozycji:   ".$lp,0,0,'L');
    $pdf->Cell(57,0);
    $pdf->Cell(33,0,'WARTOŒÆ RAZEM: ');
    $pdf->Cell(30,0,$razem." z³",0,0,'R');
    //podpisy

    $pdf->Ln(12);
    $pdf->Cell(35,0,'Dowód opracowa³:',0,0,'L');
$pdf->Cell(18,0);
$pdf->Cell(35,0,'Polecenie wyda³:',0,0,'L');
$pdf->Cell(18,0);
$pdf->Cell(35,0,'Wydaj¹cy:',0,0,'L');
$pdf->Cell(18,0);
$pdf->Cell(35,0,'Przyjmuj¹cy:',0,0,'L');

$pdf->Ln(16);
$pdf->Cell(35,0,'.................................',0,0,'L');
$pdf->Cell(18,0);
$pdf->Cell(35,0,'.................................',0,0,'L');
$pdf->Cell(18,0);
$pdf->Cell(35,0,'.................................',0,0,'L');
$pdf->Cell(18,0);
$pdf->Cell(35,0,'.................................',0,0,'L');
    //uwagi

$pdf->Ln(8);
$pdf->Cell(35,0,'UWAGI:',0,0,'L');
$pdf->Ln(5);
$pdf->SetFont('arial_ce','',9);
$pdf->Cell(35,0,'jakis tam ticket',0,0,'L');







    $pdf->Close();
    $pdf->Output();


?>
