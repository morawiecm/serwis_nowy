<?php


include '../config.php';

if($a=='naklejka')
{
    // DEKLARACJA ZMIENNYCH
    $nr_ewidencyjny='';
    $tekst='';

    //POBIERANIE DANYCH Z BAZY - TABELA NAKLEJKI
    $pobierz_dane_do_druku_naklejki = mysqli_query($polaczenie,"SELECT nr_inwent, nazwa FROM naklejki WHERE id = '$nrID'")
        or die("B³¹d przy pobierz_dane_do_druku_naklejki ".mysqli_error($polaczenie));
    if (mysqli_num_rows($pobierz_dane_do_druku_naklejki)>0)
    {
        while ($dane_do_druku_naklejki=mysqli_fetch_array($pobierz_dane_do_druku_naklejki))
        {
            $nr_ewidencyjny =  $dane_do_druku_naklejki['nr_inwent'];
            $tekst = iconv('utf-8', 'windows-1250', $dane_do_druku_naklejki['nazwa']);
        }
    }

    $ciag=$tekst;
    $podziel1=substr($tekst,0,26);
    $podziel2=substr($tekst,26,26);
    $podziel3=substr($tekst,52,26);
    ob_start();
    include('code39.php');
    $pdf = new PDF_Code39();
    $pdf->AddPage('l',array(50,25));
    $pdf->SetTopMargin(0);
    $pdf->SetLeftMargin(2.5);
//$pdf->SetRightMargin(0.5);
    $pdf->AddFont('arial_ce','','arial_ce.php');
    $pdf->AddFont('arial_ce','B','arial_ce_b.php');

    $pdf->SetFont('arial_ce','B',7);
    $pdf->Text(10,3,'MSWiA KWP Gorzów Wlkp.');
//$pdf->Ln(2);
    $pdf->Code39(2.9, 4, $nr_ewidencyjny,'true',false,0.27,6.5,false);
//$pdf->Code39(1.4, 4, $nrEwid,'true',false,0.27,8.5,false);
//Code39(float x, float y, string code [, boolean ext [, boolean cks [, float w [, float h [, boolean wide]]]]])
//Nazwa produktu podzielona na 3 linijki
    $pdf->SetFont('arial_ce','B',7);
    $pdf->Text(5.4,16,$podziel1);
    $pdf->Text(5.4,18.5,$podziel2);
    $pdf->Text(5.4,21,$podziel3);
    $pdf->Close();
    $pdf->Output();
    ob_end_flush();
}

?>
