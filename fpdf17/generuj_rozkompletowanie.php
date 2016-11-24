<?php
//zawieramy

include '../config.php';



// pobieramy dane usera
$user_data = get_user_data();
$rozWart=0;
//dane z posta

if($a=='podglad'){


    $pobierz_dane_do_protokolu=mysqli_query($polaczenie,"SELECT * FROM `rozkompletowanie` WHERE `nr_protokolu`='$nrID' ") or die('B³ad przy pobierz_dane_do_protoklu'.mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_dane_do_protokolu)>0)
    {
        while($pddp=mysqli_fetch_array($pobierz_dane_do_protokolu))
        {
            $id_protokolu=$pddp[1];
            $data=date("d/m/Y",strtotime($pddp[2]));

            $wartosc1= $pddp[11];
            $wartosc=number_format($wartosc1,2,',',' ');

            $imie1=iconv('utf-8','windows-1250',$pddp[3]);
            $imie2=iconv('utf-8','windows-1250',$pddp[4]);
            $imie3=iconv('utf-8','windows-1250',$pddp[5]);

            $wydzial_uzytkownik_111="KWP W£iI w Gorzów Wlkp.";
            $wydzial_uzytkownik_222="KWP W£iI w Gorzów Wlkp.";
            $wydzial_uzytkownik_333="KWP W£iI w Gorzów Wlkp.";
            $nazwa_sprzetu=iconv('utf-8','windows-1250',$pddp[9]);
            $nr_ewidencyjny=iconv('utf-8','windows-1250',$pddp[10]);
            $nazwa_elementu2=$pddp[17];

            $nazwa_elementu11="$pddp[17]";
            $nazwa_elementu=iconv('utf-8','windows-1250',$nazwa_elementu11);
            $wartosc_elementuw=$pddp[15];
            $wartosc_elementu=number_format($wartosc_elementuw,2,',',' ');


            $wydzial=iconv('utf-8','windows-1250',$pddp[12]);
            $wydzial11=iconv('utf-8','windows-1250',$pddp[14]);
            $wydzial12=iconv('utf-8','windows-1250',$pddp[16]);
            $ilosc1=iconv('utf-8','windows-1250','szt.');

            //$wydzia³_uzytkownik_1="KWP W£iI w Gorzów Wlkp.";
            $wartosc12=$wartosc1-$wartosc_elementu;
            $wartosc2=number_format($wartosc12,2,',',' ');
            $dodatkowy_opis=$pddp[18];
            $numer_seryjny2=$pddp[19];
            $nowy_numer_inwentarzowy2=$pddp[21];
        }
    }





    require('/var/www/html/fpdf17/mc_table.php');

    $prefix="9999";
    $id_protokolu2="$nrID"."$prefix";
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
    $pdf->EAN13(20,10,$id_protokolu2);
    $pdf->SetFont('arial_ce','B',9);
    $pdf->Cell(140);
    $pdf->Cell(22,0,'Gorzów Wlkp.',0,0,'L');

    $pdf->Cell(40,0,$data.'r.',0,0,'L');

    $pdf->Ln(25);
    $pdf->cell(10);
    $pdf->Cell(22,0,'"ZATWIERDZAM"',0,0,'L');
    $pdf->ln(15);
    $pdf->SetFont('arial_ce','B',12);
    $pdf->Cell(50);
    $pdf->Cell(22,0,'PROTOKÓ£  ROZKOMPLETOWANIA '.$nrID.'/'.date("Y"),0,0,'L');

    $pdf->SetFont('arial_ce','',9);
    $pdf->Ln(10);
    $pdf->Cell(28,0,'Sporz¹dzony dnia:',0,0,'L');
    $pdf->Cell(16,0,$data,0,0,'L');

    $pdf->Cell(30,0,' przez komisjê w sk³adzie:',0,0,'L');
    $pdf->Ln(8);
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(40,5,'Przewodnicz¹cy: ','LTR',0,'L',0);
    $pdf->SetFont('arial_ce','',9);   // empty cell with left,top, and right borders
    $pdf->Cell(75,5,$imie1,1,0,'L',0);
    $pdf->Cell(60,5,$wydzial_uzytkownik_111,1,0,'L',0);

    $pdf->Ln();
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(40,5,'Cz³onkowie:','LTR',0,'L',0);   // empty cell with left,top, and right borders
    $pdf->SetFont('arial_ce','',9);
    $pdf->Cell(75,5,$imie2,'1',0,'L',0);
    $pdf->Cell(60,5,$wydzial_uzytkownik_222,'1',0,'L',0);

    $pdf->Ln();

    $pdf->Cell(40,5,'','LBR',0,'L',0);   // empty cell with left,bottom, and right borders
    $pdf->Cell(75,5,$imie3,'LRB',0,'L',0);
    $pdf->Cell(60,5,$wydzial_uzytkownik_333,'LRB',0,'L',0);

    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    $pdf->Cell(28,0,'która dzia³aj¹c na polecenie Naczelnika Wydzia³u £¹cznoœci i Informatyki KWP w Gorzowie Wlkp dokona³a rozkompletowania:',0,0,'L');
    $pdf->Ln(10);
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(50,5,'Nazwa urz¹dzenia ',1,0,'C',0);
    $pdf->Cell(35,5,'Numer Ewidencyjny',1,0,'C',0);
    $pdf->Cell(15,5,'Iloœæ',1,0,'C',0);
    $pdf->Cell(30,5,'Wartoœæ',1,0,'C',0);
    $pdf->Cell(45,5,'Jednostka u¿ytkuj¹ca',1,0,'C',0);
    $pdf->Ln();
    $pdf->SetFont('arial_ce','',9);
    $pdf->SetWidths(array(50,35,15,30,45));

    $pdf->Row(array($nazwa_sprzetu,$nr_ewidencyjny,$ilosc1,$wartosc.' z³',$wydzial));
    $pdf->Ln(10);
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(28,0,'W wyniku rozkompletowania uzyskano i zaewidencjonowano nastêpujacy sprzêt: ',0,0,'L');
    $pdf->Ln(10);

    $pdf->Cell(50,5,'Nazwa urz¹dzenia ',1,0,'C',0);
    $pdf->Cell(35,5,'Numer Ewidencyjny',1,0,'C',0);
    $pdf->Cell(15,5,'Iloœæ',1,0,'C',0);
    $pdf->Cell(30,5,'Wartoœæ',1,0,'C',0);
    $pdf->Cell(45,5,'Jednostka u¿ytkuj¹ca',1,0,'C',0);
    $pdf->Ln();
    $pdf->SetFont('arial_ce','',9);
    $pdf->SetWidths(array(50,35,15,30,45));
    $pdf->Row(array($nazwa_sprzetu,$nr_ewidencyjny,$ilosc1,$wartosc2.' z³',$wydzial11));

    $pdf->Row(array($nazwa_elementu.' '.$dodatkowy_opis.' '.$numer_seryjny2,$nowy_numer_inwentarzowy2,$ilosc1,$wartosc_elementu.' z³',$wydzial12));
    $pdf->Ln(15);
    $pdf->Cell(20);
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(40,5,'Podpisy komisji',0,0,'L',0);
    $pdf->SetFont('arial_ce','',9);
    $pdf->Ln(10);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'1. _____________________________',0,0,'L',0);
    $pdf->Ln(8);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'2. _____________________________',0,0,'L',0);
    $pdf->Ln(8);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'3. _____________________________',0,0,'L',0);

    $pdf->AddPage('P','A4');
    $pdf->AddFont('arial_ce','','arial_ce.php');
    $pdf->AddFont('arial_ce','I','arial_ce_i.php');
    $pdf->AddFont('arial_ce','B','arial_ce_b.php');
    $pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
    $pdf->SetFont('arial_ce','B',9);
    $pdf->EAN13(20,10,$id_protokolu2);
    $pdf->SetFont('arial_ce','B',9);
    $pdf->Cell(140);
    $pdf->Cell(22,0,'Gorzów Wlkp.',0,0,'L');
    $pdf->Cell(40,0,$data.'r.',0,0,'L');

    $pdf->Ln(25);
    $pdf->cell(10);
    $pdf->Cell(22,0,'"ZATWIERDZAM"',0,0,'L');
    $pdf->ln(15);
    $pdf->SetFont('arial_ce','B',12);

    $pdf->Cell(180,0,'PROTOKÓ£  WYCENY',0,0,'C');
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Ln(10);

    $pdf->Cell(180,0,$nazwa_elementu.' '.$dodatkowy_opis,0,0,'C');
    $pdf->Ln(20);
    $pdf->Cell(5);
    $pdf->SetFont('arial_ce','',9);
    $pdf->MultiCell(180,5,'     W wyniku rozkomletowania: ' .$nazwa_sprzetu.' o numerze ewidencyjnym: '.$nr_ewidencyjny.', uzyskano: '.$nazwa_elementu.' '.$dodatkowy_opis.' '.$numer_seryjny2.'.',0,'J',0);


    $pdf->Ln(20);

    $pdf->SetFont('arial_ce','b',10);
    $pdf->Cell(50,0,'Komisja w sk³adzie:',0,0,'L',0);
    $pdf->SetFont('arial_ce','',10);
    $pdf->ln(5);
    $pdf->Cell(50,0,'1. '.$imie1,0,0,'L',0);
    $pdf->ln(5);
    $pdf->Cell(50,0,'2. '.$imie2,0,0,'L',0);
    $pdf->ln(5);
    $pdf->Cell(50,0,'3. '.$imie3,0,0,'L',0);
    $pdf->ln(10);
    $pdf->SetFont('arial_ce','',9);
    $pdf->Cell(200,0,'postanawia przyj¹æ cenê ewidencyjn¹ '.$nazwa_elementu.' w wysokoœci: '.$wartosc_elementu.' z³',0,0,'J',0);
    $pdf->Ln(20);
    $pdf->Cell(40,5,'Podpisy komisji:',0,0,'L',0);

    $pdf->Ln(10);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'1. _____________________________',0,0,'L',0);
    $pdf->Ln(8);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'2. _____________________________',0,0,'L',0);
    $pdf->Ln(8);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'3. _____________________________',0,0,'L',0);

    $pdf->Close();
    $pdf->Output();
}

//pobieranie danych z bazy
elseif($a=='generuj'){
//sprawdz sume rozkompletowania
    $pobierzOrginal=mysqli_query($polaczenie,"SELECT `wartosc_orginalna` FROM `rozkompletowanie` WHERE `id`='$nrID'") or die("B³ad przy: pobierzOrginal".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierzOrginal)>0)
    {
        while($poOrg=mysqli_fetch_array($pobierzOrginal))
        {
            $wartORG=$poOrg[0];
        }
    }
    $pobierzRozkompletWart=mysqli_query($polaczenie,"SELECT `wartosc_wykomplet_sprzetu` FROM `rozkompletowanie_skladniki` WHERE `id_protokolu`='$nrID'")or die("B³ad przy: pobierzOrginal1".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierzRozkompletWart)>0)
    {
        while($RozkompletWart=mysqli_fetch_array($pobierzRozkompletWart))
        {
            $rozWart+=$RozkompletWart[0];
        }
    }
    $aktualizacjaWartosci=$wartORG-$rozWart;
    $aktualizacjaProtokoluWartoscPoRozkopletowaniu=mysqli_query($polaczenie,"UPDATE `rozkompletowanie` SET `wartosc_pomniejszona`='$aktualizacjaWartosci' WHERE `id`='$nrID'")or die("B³ad przy: pobierzOrginal2".mysqli_error($polaczenie));
//pobierz dane do protokolu
    $pobierz_dane_do_protokolu=mysqli_query($polaczenie,"SELECT * FROM `rozkompletowanie` WHERE `id`='$nrID' ") or die('B³ad przy pobierz_dane_do_protoklu'.mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_dane_do_protokolu)>0)
    {
        while($pddp=mysqli_fetch_array($pobierz_dane_do_protokolu))
        {
            //id protoklu jest kodemkreskowym z prefixem
            $kod_kreskowy=$pddp[0];
            //nr protokolu
            $id_protokolu=$pddp[1];
            //data protokolu
            $data=date("d/m/Y",strtotime($pddp[2]));

            //komisja
            $imie1=iconv('utf-8','windows-1250',$pddp[3]);
            $imie2=iconv('utf-8','windows-1250',$pddp[4]);
            $imie3=iconv('utf-8','windows-1250',$pddp[5]);

            $wydzial_uzytkownik_111="KWP W£iI w Gorzów Wlkp.";
            $wydzial_uzytkownik_222="KWP W£iI w Gorzów Wlkp.";
            $wydzial_uzytkownik_333="KWP W£iI w Gorzów Wlkp.";

            //ORGINALNY SPRZET PRZED WYKOPLETOWANIEM:
            //nazwa rozkompletowanego sprzetu
            $nazwa_sprzetu=iconv('utf-8','windows-1250',$pddp[9]);
            // nr ewidencyjny rozkompletowanego sprzetu
            $nr_ewidencyjny=iconv('utf-8','windows-1250',$pddp[10]);
            //wartosc rozkompletowanego sprzetu orginalna
            $wartosc1= $pddp[11];
            $wartosc=number_format($wartosc1,2,',',' ');
            //Jednostka uzytkujaca
            $wydzial=iconv('utf-8','windows-1250',$pddp[12]);
            $wydzial11=iconv('utf-8','windows-1250',$pddp[14]);

            $wartosc2=number_format($pddp[13],2,',',' ');
            /*
             $nazwa_elementu2=$pddp[17];

                     $nazwa_elementu11="$pddp[17]";
                     $nazwa_elementu=iconv('utf-8','windows-1250',$nazwa_elementu11);
                     $wartosc_elementuw=$pddp[15];
                     $wartosc_elementu=number_format($wartosc_elementuw,2,',',' ');




             $wydzial12=iconv('utf-8','windows-1250',$pddp[16]);
             $ilosc1=iconv('utf-8','windows-1250','szt.');

             $wartosc12=$wartosc1-$wartosc_elementu;

             $dodatkowy_opis=$pddp[18];
             $numer_seryjny2=$pddp[19];
             $nowy_numer_inwentarzowy2=$pddp[21];
             */
        }
    }





    require($_SERVER['DOCUMENT_ROOT']."/fpdf17/mc_table.php");

    $prefix="9999";
    $id_protokolu2="$kod_kreskowy"."$prefix";
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




    $pdf=new PDF_MC_Table();
//$pdf= new PDF();
    $pdf->AliasNbPages('{totalPages}');
    $pdf->AddPage('P','A4');
    $pdf->AddFont('arial_ce','','arial_ce.php');
    $pdf->AddFont('arial_ce','I','arial_ce_i.php');
    $pdf->AddFont('arial_ce','B','arial_ce_b.php');
    $pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
    $pdf->SetFont('arial_ce','B',9);
    $pdf->EAN13(20,10,$id_protokolu2);
    $pdf->SetFont('arial_ce','B',9);
    $pdf->Cell(140);
    $pdf->Cell(22,0,'Gorzów Wlkp.',0,0,'L');

    $pdf->Cell(40,0,$data.'r.',0,0,'L');

    $pdf->Ln(25);
    $pdf->cell(10);
    $pdf->Cell(22,0,'"ZATWIERDZAM"',0,0,'L');
    $pdf->ln(10);
    $pdf->SetFont('arial_ce','B',12);
    $pdf->Cell(50);
    $pdf->Cell(22,0,'PROTOKÓ£  ROZKOMPLETOWANIA '.$id_protokolu,0,0,'L');

    $pdf->SetFont('arial_ce','',9);
    $pdf->Ln(10);
    $pdf->Cell(28,0,'Sporz¹dzony dnia:',0,0,'L');
    $pdf->Cell(16,0,$data,0,0,'L');

    $pdf->Cell(30,0,' przez komisjê w sk³adzie:',0,0,'L');
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(40,5,'Przewodnicz¹cy: ','LTR',0,'L',0);
    $pdf->SetFont('arial_ce','',9);   // empty cell with left,top, and right borders
    $pdf->Cell(75,5,$imie1,1,0,'L',0);
    $pdf->Cell(60,5,$wydzial_uzytkownik_111,1,0,'L',0);

    $pdf->Ln();
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(40,5,'Cz³onkowie:','LTR',0,'L',0);   // empty cell with left,top, and right borders
    $pdf->SetFont('arial_ce','',9);
    $pdf->Cell(75,5,$imie2,'1',0,'L',0);
    $pdf->Cell(60,5,$wydzial_uzytkownik_222,'1',0,'L',0);

    $pdf->Ln();

    $pdf->Cell(40,5,'','LBR',0,'L',0);   // empty cell with left,bottom, and right borders
    $pdf->Cell(75,5,$imie3,'LRB',0,'L',0);
    $pdf->Cell(60,5,$wydzial_uzytkownik_333,'LRB',0,'L',0);

    $pdf->Ln();
    $pdf->Ln();
    //           $pdf->Ln();

    $pdf->Cell(28,0,'która dzia³aj¹c na polecenie Naczelnika Wydzia³u £¹cznoœci i Informatyki KWP w Gorzowie Wlkp dokona³a rozkompletowania:',0,0,'L');
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(65,5,'Nazwa urz¹dzenia ',1,0,'C',0);
    $pdf->Cell(35,5,'Numer Ewidencyjny',1,0,'C',0);
//$pdf->Cell(15,5,'Iloœæ',1,0,'C',0);
    $pdf->Cell(30,5,'Wartoœæ',1,0,'C',0);
    $pdf->Cell(45,5,'Jednostka u¿ytkuj¹ca',1,0,'C',0);
    $pdf->Ln();
    $pdf->SetFont('arial_ce','',9);
    $pdf->SetWidths(array(65,35,30,45));

    $pdf->Row(array($nazwa_sprzetu,$nr_ewidencyjny,$wartosc.' z³',$wydzial));
    $pdf->Ln(5);
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Cell(28,0,'W wyniku rozkompletowania uzyskano i zaewidencjonowano nastêpujacy sprzêt: ',0,0,'L');
    $pdf->Ln(5);

    $pdf->Cell(65,5,'Nazwa urz¹dzenia ',1,0,'C',0);
    $pdf->Cell(35,5,'Numer Ewidencyjny',1,0,'C',0);
//$pdf->Cell(15,5,'Iloœæ',1,0,'C',0);
    $pdf->Cell(30,5,'Wartoœæ',1,0,'C',0);
    $pdf->Cell(45,5,'Jednostka u¿ytkuj¹ca',1,0,'C',0);
    $pdf->Ln();
    $pdf->SetFont('arial_ce','',9);
    $pdf->SetWidths(array(65,35,30,45));
//ROZKOMLPETOWANA ORGINAL
    $pdf->Row(array($nazwa_sprzetu,$nr_ewidencyjny,$wartosc2.' z³',$wydzial11));
//WYKOMPLETOWANIE
//pobranie skladnikow wykompletowania:
    $pobranieSkladnikowWykompletowania=mysqli_query($polaczenie,"SELECT * FROM `rozkompletowanie_skladniki` WHERE `id_protokolu`='$nrID'") or die("B³ad przy pobraniu danych pobranieSkladnikowWykompletowania: ".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobranieSkladnikowWykompletowania)>0 && mysqli_num_rows($pobranieSkladnikowWykompletowania)<6)
    {
        while($skladnikiWykompletowania=mysqli_fetch_array($pobranieSkladnikowWykompletowania))
        {
            $pdf->Row(array(iconv('utf-8','windows-1250',$skladnikiWykompletowania[4]).' '.iconv('utf-8','windows-1250',$skladnikiWykompletowania[8]).' '.iconv('utf-8','windows-1250',$skladnikiWykompletowania[9]),iconv('utf-8','windows-1250',$skladnikiWykompletowania[3]),number_format($skladnikiWykompletowania[6],2,',',' ').' z³',iconv('utf-8','windows-1250',$skladnikiWykompletowania[7])));
        }
        $pdf->Ln(15);
        $pdf->Cell(20);
        $pdf->SetFont('arial_ce','b',9);
        $pdf->Cell(40,5,'Podpisy komisji',0,0,'L',0);
        $pdf->SetFont('arial_ce','',9);
        $pdf->Ln(10);
        $pdf->Cell(30);
        $pdf->Cell(40,5,'1. _____________________________',0,0,'L',0);
        $pdf->Ln(8);
        $pdf->Cell(30);
        $pdf->Cell(40,5,'2. _____________________________',0,0,'L',0);
        $pdf->Ln(8);
        $pdf->Cell(30);
        $pdf->Cell(40,5,'3. _____________________________',0,0,'L',0);
        $pdf->SetXY(170,270);
        $pdf->Cell(0, 5, "Strona: " . $pdf->PageNo() . "/{totalPages}", 0, 1);
    }
    else
    {
        while($skladnikiWykompletowania=mysqli_fetch_array($pobranieSkladnikowWykompletowania))
        {
            $pdf->Row(array(iconv('utf-8','windows-1250',$skladnikiWykompletowania[4]).' '.iconv('utf-8','windows-1250',$skladnikiWykompletowania[8]).' '.iconv('utf-8','windows-1250',$skladnikiWykompletowania[9]),iconv('utf-8','windows-1250',$skladnikiWykompletowania[3]),number_format($skladnikiWykompletowania[6],2,',',' ').' z³'.' z³',iconv('utf-8','windows-1250',$skladnikiWykompletowania[7])));
        }
        $pdf->SetXY(170,270);
        $pdf->Cell(0, 5, "Strona: " . $pdf->PageNo() . "/{totalPages}", 0, 1);
        $pdf->AddPage('P','A4');
        $pdf->AddFont('arial_ce','','arial_ce.php');
        $pdf->AddFont('arial_ce','I','arial_ce_i.php');
        $pdf->AddFont('arial_ce','B','arial_ce_b.php');
        $pdf->AddFont('arial_ce','BI','arial_ce_bi.php');

        $pdf->Ln(15);
        $pdf->Cell(20);
        $pdf->SetFont('arial_ce','b',9);
        $pdf->Cell(40,5,'Podpisy komisji',0,0,'L',0);
        $pdf->SetFont('arial_ce','',9);
        $pdf->Ln(10);
        $pdf->Cell(30);
        $pdf->Cell(40,5,'1. _____________________________',0,0,'L',0);
        $pdf->Ln(8);
        $pdf->Cell(30);
        $pdf->Cell(40,5,'2. _____________________________',0,0,'L',0);
        $pdf->Ln(8);
        $pdf->Cell(30);
        $pdf->Cell(40,5,'3. _____________________________',0,0,'L',0);
        $pdf->SetXY(170,270);
        $pdf->Cell(0, 5, "Strona: " . $pdf->PageNo() . "/{totalPages}", 0, 1);
    }



    $pdf->AddPage('P','A4');
    $pdf->AddFont('arial_ce','','arial_ce.php');
    $pdf->AddFont('arial_ce','I','arial_ce_i.php');
    $pdf->AddFont('arial_ce','B','arial_ce_b.php');
    $pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
    $pdf->SetFont('arial_ce','B',9);
    $pdf->EAN13(20,10,$id_protokolu2);
    $pdf->SetFont('arial_ce','B',9);
    $pdf->Cell(140);
    $pdf->Cell(22,0,'Gorzów Wlkp.',0,0,'L');
    $pdf->Cell(40,0,$data.'r.',0,0,'L');

    $pdf->Ln(25);
    $pdf->cell(10);
    $pdf->Cell(22,0,'"ZATWIERDZAM"',0,0,'L');
    $pdf->ln(15);
    $pdf->SetFont('arial_ce','B',12);

    $pdf->Cell(180,0,'PROTOKÓ£  WYCENY',0,0,'C');
    $pdf->SetFont('arial_ce','b',9);
    $pdf->Ln(15);
    $pdf->Cell(5);
    $pdf->SetFont('arial_ce','',9);
    $pdf->MultiCell(180,5,'       Komisja w wyniku rozkomletowania: ' .$nazwa_sprzetu.' o numerze ewidencyjnym: '.$nr_ewidencyjny.', uzyska³a     i przyjê³a cenê ewidencyjn¹ dla:',0,'J',0);
    $pdf->Ln(6);
//pobranie skladnikow rozkompletowania:
    $pobranieSkladnikowWykompletowania2=mysqli_query($polaczenie,"SELECT * FROM `rozkompletowanie_skladniki` WHERE `id_protokolu`='$nrID'") or die("B³ad przy pobraniu danych pobranieSkladnikowWykompletowania: ".mysql_error());
    if(mysqli_num_rows($pobranieSkladnikowWykompletowania2)>0)
    {
        while($skladnikiWykompletowania=mysqli_fetch_array($pobranieSkladnikowWykompletowania2))
        {
            $s1=iconv('utf-8','windows-1250',$skladnikiWykompletowania[4]);
            $s2=iconv('utf-8','windows-1250',$skladnikiWykompletowania[8]);
            $s3=iconv('utf-8','windows-1250',$skladnikiWykompletowania[9]);
            $s4=iconv('utf-8','windows-1250',$skladnikiWykompletowania[3]);
            $s5=number_format($skladnikiWykompletowania[6],2,',',' ').' z³';
            $tekst='- '.$s1.' '.$s2.' '.$s3.' '.$s4.' - '.$s5;
            $pdf->Cell(5);
            $pdf->MultiCell(180,5,$tekst,0,'L',0);
            $pdf->Ln(5);
            //iconv('utf-8','windows-1250',$skladnikiWykompletowania[8]).' '.iconv('utf-8','windows-1250',$skladnikiWykompletowania[9]),iconv('utf-8','windows-1250',$skladnikiWykompletowania[3]),number_format($skladnikiWykompletowania[6],2,',',' ').' z³',iconv('utf-8','windows-1250',$skladnikiWykompletowania[7])));
        }
    }
    $pdf->Ln(10);
    $pdf->SetFont('arial_ce','b',10);
    $pdf->Cell(50,0,'Komisja w sk³adzie:',0,0,'L',0);
    $pdf->SetFont('arial_ce','',10);
    $pdf->ln(5);
    $pdf->Cell(50,0,'1. '.$imie1,0,0,'L',0);
    $pdf->ln(5);
    $pdf->Cell(50,0,'2. '.$imie2,0,0,'L',0);
    $pdf->ln(5);
    $pdf->Cell(50,0,'3. '.$imie3,0,0,'L',0);
    $pdf->Ln(10);
    $pdf->SetFont('arial_ce','',9);
//$pdf->Cell(200,0,'postanawia przyj¹æ cenê ewidencyjn¹ '.$nazwa_elementu.' w wysokoœci: '.$wartosc_elementu.' z³',0,0,'J',0);
    $pdf->Cell(40,5,'Podpisy komisji:',0,0,'L',0);
    $pdf->Ln(8);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'1. _____________________________',0,0,'L',0);
    $pdf->Ln(8);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'2. _____________________________',0,0,'L',0);
    $pdf->Ln(8);
    $pdf->Cell(30);
    $pdf->Cell(40,5,'3. _____________________________',0,0,'L',0);
    $pdf->SetXY(170,270);
    $pdf->Cell(0, 5, "Strona: " . $pdf->PageNo() . "/{totalPages}", 0, 1);
    $pdf->Close();
    $pdf->Output();
}


?>