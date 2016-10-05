<?php

/**
 * @author 
 * @copyright 2012@var ;
 */
 include('baza.php');
 $a = trim($_REQUEST['a']); 
    if(isset($_GET['id'])) $id=$_GET['id']; else $id=0;

if($a == 'generuj') { 
    /* zapytanie do tabeli */ 
    $ido=$_SESSION['ido'];
    $idn=$_SESSION['idn'];
    $wynik = mysql_query("SELECT * FROM nadawca WHERE
    id='$idn'")
    or die('B³¹d zapytania');

if(mysql_num_rows($wynik) > 0) { 
while($n = mysql_fetch_array($wynik)) { 

}}
    $wynik2 = mysql_query("SELECT * FROM odbiorca WHERE
    id='$ido'")
    or die('B³¹d zapytania');

if(mysql_num_rows($wynik2) > 0) { 
while($o = mysql_fetch_array($wynik2)) { 

}}
 $wynik3 = mysql_query("SELECT * FROM przesylki ORDER BY `id` DESC Limit 1
    ")
    or die('B³¹d zapytania');

if(mysql_num_rows($wynik3) > 0) { 
while($d = mysql_fetch_array($wynik3)) { 
    $id_idzlecenia=$d[0];
    $id_idzlecenia++;

}}

$data_przyjecia=date("y-m-d");
$email_nad="$n[17]";
$email_odb="$o[17]";
$imie_nad="$n[5]";
$imie_odb="$o[5]";
$kod_nad="$n[7]";
$kod_odb="$o[7]";
$miasto_nad="$n[8]";
$miasto_odb="$o[8]";
$nazwisko_nad="$n[3]";
$nazwisko_odb="$o[3]";
$tel_nad="$n[14] $n[15] $n[20] $n[21]";
$ulica_nad="$n[9] $n[10] / $n[11]";
$tel_odb="$o[14] $o[15] $o[20] $o[21]";
$ulica_odb="$o[9] $o[10] / $o[11]";

$waga=$_SESSION['waga'];
$waga_gab=$_SESSION['waga_gab'];
$dlugosc=$_SESSION['dlugosc'];
$szerokosc=$_SESSION['szerokosc'];
$wysokosc=$_SESSION['wysokosc'];
$nr_konta=$_SESSION['nr_konta'];
$nazwa_banku=$_SESSION['nazwa_banku'];
$kwota_pobrania=$_SESSION['kwota_pobrania'];
$typ=$_SESSION['typ'];
$ubezpiecznie=$_SESSION['ubezpiecznie'];
$oddzial=$_SESSION['oddzial'];

//Generowanie PDF'a'
require('./fpdf17/ean13.php');

class PDF extends FPDF
{
// Page header

}

$pdf=new PDF_EAN13();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$pdf->AddFont('arial_ce','','arial_ce.php');
$pdf->AddFont('arial_ce','I','arial_ce_i.php');
$pdf->AddFont('arial_ce','B','arial_ce_b.php');
$pdf->AddFont('arial_ce','BI','arial_ce_bi.php');
$pdf->SetFont('arial_ce','B',9);
$pdf->Image('logo.png',5,5,30,20);
$pdf->Image('logo.png',155,5,30,20);
$pdf->Cell(25);
$pdf->Cell(70,0,'SEND-2 ',0,0,'L');
$pdf->Cell(50,0,$oddzial.' '.$data_przyjecia,0,0,'L');
$pdf->Cell(30);
$pdf->Cell(70,0,'SEND-2 ',0,0,'L');
$pdf->Cell(30,0,$oddzial.' '.$data_przyjecia,0,1,'L');
$pdf->Cell(25);
$pdf->Cell(50,10,'UL. SK£ADOWA 2 66-400 GORZÓW WLKP.',0,0,'L');

$pdf->Cell(100);
$pdf->Cell(50,10,'UL. SK£ADOWA 2 66-400 GORZÓW WLKP.',0,1,'L');
$pdf->Cell(25);
$pdf->Cell(50,0,'TEL. 95 7121 521  FAX. 95 781 95 96',0,0,'L');
$pdf->Cell(100);
$pdf->Cell(50,0,'TEL. 95 7121 521  FAX. 95 781 95 96',0,1,'L');
$pdf->Ln(10);
$pdf->Cell(50);
$pdf->Cell(95,0,'POTWIERDZENIE NADANIA',0,0,'L');
$pdf->Cell(50);
$pdf->Cell(100,0,'POTWIERDZENIE NADANIA',0,2,'L');
//linie
$pdf->Line(5,33,295,33);
$pdf->Line(5,27,295,27);
$pdf->Line(148,0,148,210);

$pdf->Ln(5);
$pdf->SetFont('Times','',9);
$pdf->Cell(10);
$pdf->Cell(20,0,'NADAWCA:',0,0,'L');
$pdf->Cell(50);
$pdf->Cell(35,0,'ODBIORCA:',0,0,'L');
$pdf->Cell(40);
$pdf->Cell(20,0,'NADAWCA:',0,0,'L');
$pdf->Cell(50);
$pdf->Cell(35,0,'ODBIORCA:',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(20,0,'IMIE:',0,0,'L');
$pdf->Cell(50,0,$imie_nad,0,0,'L');
$pdf->Cell(20,0,'IMIE:',0,0,'L');
$pdf->Cell(50,0,$imie_odb,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(20,0,'IMIE:',0,0,'L');
$pdf->Cell(50,0,$imie_nad,0,0,'L');
$pdf->Cell(20,0,'IMIE:',0,0,'L');
$pdf->Cell(50,0,$imie_odb,0,0,'L');
$pdf->Ln(5);
$pdf->Cell(20,0,'NAZWISKO:',0,0,'L');
$pdf->Cell(50,0,$nazwisko_nad,0,0,'L');
$pdf->Cell(20,0,'NAZWISKO:',0,0,'L');
$pdf->Cell(50,0,$nazwisko_odb,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(20,0,'NAZWISKO:',0,0,'L');
$pdf->Cell(50,0,$nazwisko_nad,0,0,'L');
$pdf->Cell(20,0,'NAZWISKO:',0,0,'L');
$pdf->Cell(50,0,$nazwisko_odb,0,0,'L');
$pdf->Ln(5);
$pdf->Cell(20,0,'ULICA:',0,0,'L');
$pdf->Cell(50,0,$ulica_nad,0,0,'L');
$pdf->Cell(20,0,'ULICA:',0,0,'L');
$pdf->Cell(50,0,$ulica_odb,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(20,0,'ULICA:',0,0,'L');
$pdf->Cell(50,0,$ulica_nad,0,0,'L');
$pdf->Cell(20,0,'ULICA:',0,0,'L');
$pdf->Cell(50,0,$ulica_odb,0,0,'L');
$pdf->Ln(5);
$pdf->Cell(20,0,'KOD POCZT:',0,0,'L');
$pdf->Cell(50,0,$kod_nad,0,0,'L');
$pdf->Cell(20,0,'KOD POCZT:',0,0,'L');
$pdf->Cell(50,0,$kod_odb,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(20,0,'KOD POCZT:',0,0,'L');
$pdf->Cell(50,0,$kod_nad,0,0,'L');
$pdf->Cell(20,0,'KOD POCZT:',0,0,'L');
$pdf->Cell(50,0,$kod_odb,0,0,'L');
$pdf->Ln(5);
$pdf->Cell(20,0,'MIASTO:',0,0,'L');
$pdf->Cell(50,0,$miasto_nad,0,0,'L');
$pdf->Cell(20,0,'MIASTO:',0,0,'L');
$pdf->Cell(50,0,$miasto_odb,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(20,0,'MIASTO:',0,0,'L');
$pdf->Cell(50,0,$miasto_nad,0,0,'L');
$pdf->Cell(20,0,'MIASTO:',0,0,'L');
$pdf->Cell(50,0,$miasto_odb,0,0,'L');
$pdf->Ln(5);
$pdf->Cell(20,0,'TELEFON:',0,0,'L');
$pdf->Cell(50,0,$tel_nad,0,0,'L');
$pdf->Cell(20,0,'TELEFON:',0,0,'L');
$pdf->Cell(50,0,$tel_odb,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(20,0,'TELEFON:',0,0,'L');
$pdf->Cell(50,0,$tel_nad,0,0,'L');
$pdf->Cell(20,0,'TELEFON:',0,0,'L');
$pdf->Cell(50,0,$tel_odb,0,0,'L');
$pdf->Ln(5);
$pdf->Cell(20,0,'EMAIL:',0,0,'L');
$pdf->Cell(50,0,$email_nad,0,0,'L');
$pdf->Cell(20,0,'EMAIL:',0,0,'L');
$pdf->Cell(50,0,$email_odb,0,0,'L');
$pdf->Cell(5);
$pdf->Cell(20,0,'EMAIL:',0,0,'L');
$pdf->Cell(50,0,$email_nad,0,0,'L');
$pdf->Cell(20,0,'EMAIL:',0,0,'L');
$pdf->Cell(50,0,$email_odb,0,0,'L');
$pdf->Ln(10);
$pdf->Cell(50);
$pdf->SetFont('arial_ce','B','8');
$pdf->Cell(50,0,'DANE PACZKI: ',0,0,'L');
$pdf->Cell(100);
$pdf->Cell(50,0,'DANE PACZKI: ',0,0,'L');
$pdf->Ln(5);
$pdf->SetFont('arial_ce','','8');
$pdf->Cell(40,0,'WYMIARY PACZKI (D/S/W):',0,0,'L');
$pdf->Cell(30,0," $dlugosc / $szerokosc / $wysokosc",0,0,"L");
$pdf->Cell(40,0,'WAGA PACZKI:',0,0,'L');
$pdf->Cell(20,0,$waga.'kg',0,0,'L');
$pdf->Cell(15);
$pdf->Cell(40,0,'WYMIARY PACZKI (D/S/W):',0,0,'L');
$pdf->Cell(30,0," $dlugosc / $szerokosc / $wysokosc",0,0,"L");
$pdf->Cell(40,0,'WAGA PACZKI:',0,0,'L');
$pdf->Cell(20,0,$waga.'kg',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(40,0,'PACZKA:',0,0,'L');
$pdf->Cell(30,0,$typ,0,0,'L');
$pdf->Cell(40,0,'WAGA GABARYTOWA:',0,0,'L');
$pdf->Cell(20,0,$waga_gab.'kg',0,0,'L');
$pdf->Cell(15);
$pdf->Cell(40,0,'PACZKA:',0,0,'L');
$pdf->Cell(30,0,$typ,0,0,'L');
$pdf->Cell(40,0,'WAGA GABARYTOWA:',0,0,'L');
$pdf->Cell(20,0,$waga_gab.'kg',0,0,'L');
$pdf->Ln(10);
$pdf->Cell(40,0,'UBEZPIECZENIE:',0,0,'L');
$pdf->Cell(30,0,$ubezpiecznie,0,0,'L');
$pdf->Cell(40,0,'POBRANIE',0,0,'L');
$pdf->Cell(20,0,$kwota_pobrania,0,0,'L');
$pdf->Cell(15);
$pdf->Cell(40,0,'UBEZPIECZENIE:',0,0,'L');
$pdf->Cell(30,0,$ubezpiecznie,0,0,'L');
$pdf->Cell(40,0,'POBRANIE',0,0,'L');
$pdf->Cell(20,0,$kwota_pobrania,0,0,'L');
$pdf->Ln(5);
$pdf->Cell(22,0,'NUMER KONTA',0,0,'L');
$pdf->Cell(48,0,$nr_konta,0,0,'L');
$pdf->Cell(25,0,'NAZWA BANKU:',0,0,'L');
$pdf->Cell(50,0,$nazwa_banku,0,0,'L');
$pdf->Cell(22,0,'NUMER KONTA',0,0,'L');
$pdf->Cell(48,0,$nr_konta,0,0,'L');
$pdf->Cell(25,0,'NAZWA BANKU:',0,0,'L');
$pdf->Cell(50,0,$nazwa_banku,0,0,'L');
$pdf->Ln(5);
//$pdf->Cell(30,0,'NR ZLECENIA',0,0,'L');
$pdf->EAN13(108,12,$id_idzlecenia);
$pdf->Cell(115);
//$pdf->Cell(30,0,'NR ZLECENIA',0,0,'L');
$pdf->EAN13(260,12,$id_idzlecenia);
$pdf->Ln(5);
$pdf->Cell(50,0,'NR LISTU PRZEWOZOWEGO:',0,0,'L');
$pdf->Cell(20,0,'...............................................................',0,0,'L');
$pdf->Cell(75);
$pdf->Cell(50,0,'NR LISTU PRZEWOZOWEGO:',0,0,'L');
$pdf->Cell(20,0,'...............................................................',0,0,'L');
$pdf->Ln(10);
$pdf->SetFont('arial_ce','','6');
$pdf->Cell(145,0,'Oœwiadczam ¿e akceptujê warunki Regulaminu firmy Send-2, oraz upowa¿niam firmê Send-2  i jej pracowników do nadania w Moim',0,0,'L');
$pdf->Cell(148,0,'Oœwiadczam ¿e akceptujê warunki Regulaminu firmy Send-2, oraz upowa¿niam firmê Send-2  i jej pracowników do nadania w Moim',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(145,0,'imieniu przesy³ki kurierskiej z terenu POLSKI',0,0,'L');
$pdf->Cell(145,0,'imieniu przesy³ki kurierskiej z terenu POLSKI',0,0,'L');
$pdf->Ln(10);
$pdf->Cell(145,0,'Niniejszym zgadzam siê na wykorzystanie i przetwarzanie moich danych osobowych w celach marketingowych oraz umieszczenie ich',0,0,'L');
$pdf->Cell(145,0,'Niniejszym zgadzam siê na wykorzystanie i przetwarzanie moich danych osobowych w celach marketingowych oraz umieszczenie ich',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(145,0,'w bazie danych, prowadzonej przez Send-2 Roman Chiliñski z siedzib¹ w: 66-400 Gorzów Wlkp., ul. Sk³adowa 2– zgodnie z ustaw¹',0,0,'L');
$pdf->Cell(145,0,'w bazie danych, prowadzonej przez Send-2 Roman Chiliñski z siedzib¹ w: 66-400 Gorzów Wlkp., ul. Sk³adowa 2– zgodnie z ustaw¹',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(145,0,'z dnia 29 sierpnia 1997 roku o ochronie danych osobowych (Dz. U. z 2002 r. Nr 101, poz. 926, z póŸniejszymi zmianami). Powy¿sze',0,0,'L');
$pdf->Cell(145,0,'z dnia 29 sierpnia 1997 roku o ochronie danych osobowych (Dz. U. z 2002 r. Nr 101, poz. 926, z póŸniejszymi zmianami). Powy¿sze',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(145,0,'oœwiadczenie jest dobrowolne. Osoba, która sk³ada powy¿sze oœwiadczenie, ma prawo do wgl¹du do swoich danych zamieszczonych',0,0,'L');
$pdf->Cell(145,0,'oœwiadczenie jest dobrowolne. Osoba, która sk³ada powy¿sze oœwiadczenie, ma prawo do wgl¹du do swoich danych zamieszczonych',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(145,0,'w bazie, oraz do ich poprawiania',0,0,'L');
$pdf->Cell(145,0,'w bazie, oraz do ich poprawiania',0,0,'L');
$pdf->Ln(15);
$pdf->SetFont('Arial','','8');
$pdf->Cell(5);
$pdf->Cell(30,0,'...............................................................',0,0,'L');
$pdf->Cell(50);
$pdf->Cell(30,0,'.........................................................',0,0,'L');
$pdf->Cell(35);
$pdf->Cell(30,0,'...............................................................',0,0,'L');
$pdf->Cell(50);
$pdf->Cell(30,0,'.........................................................',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(10);
$pdf->SetFont('arial_ce','','6');
$pdf->Cell(25,0,'PODPIS I PIECZ¥TKA PRACOWNIKA',0,0,'L');
$pdf->Cell(60);
$pdf->Cell(25,0,'PODPIS NADAWCY',0,0,'L');
$pdf->Cell(35);
$pdf->Cell(25,0,'PODPIS I PIECZ¥TKA PRACOWNIKA',0,0,'L');
$pdf->Cell(60);
$pdf->Cell(25,0,'PODPIS NADAWCY',0,0,'L');

$pdf->Close();
$pdf->Output();
}

?>