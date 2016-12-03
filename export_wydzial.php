<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>

    <title>KWP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=export_wydzialu.xls");

include 'config.php';
include  'funkcje/funkcje_ewidencja.php';
$data_dzis = date("d-m-Y");
$wydzial = PobierzNazweWydzialu($nrID);
if($nrID!='')
{
    echo"<table>
                            <thead>
                            <tr><td colspan = '7' style='font-weight:bold'>Stan wydziału : $wydzial na dzień: $data_dzis</td></tr>
                            <tr>

                                <th>Nr iwnet 1</th>
                                <th>Nr iwnet 2</th>
                                <th>Nr iwnet 3</th>
                                <th>Nr seryjny</th>
                                <th>Nazwa</th>
                                <th>Wartośc</th>
                                <th>Uwaga</th>
                                


                            </tr>
                            </thead>
                            <tbody>";
    $pobierzTabelecpv = mysqli_query($polaczenie, "SELECT nr_inwentarzowy, nr_inwentarzowy_1,nr_inwentarzowy_2,nazwa_sprzetu,nr_fabryczny,uwagi,notatki,wartosc
FROM baza WHERE id_jednoski ='$nrID' AND likwidacja IS NULL ") or die ("Blad przy pobierzTabelecpv " . mysqli_error($polaczenie));
    if (mysqli_num_rows($pobierzTabelecpv) > 0) {
        while ($tabelacpv = mysqli_fetch_array($pobierzTabelecpv)) {

            echo "<tr><td>$tabelacpv[0]</td><td>$tabelacpv[1]</td><td>$tabelacpv[2]</td><td>$tabelacpv[4]</td><td>$tabelacpv[3]</td><td>$tabelacpv[7]</td><td>$tabelacpv[5], $tabelacpv[6]</td></tr>";
        }
    }
    echo"</tbody></table>";
}
else {
    $jedostka = Array();
    $licznik =0;
    $pobierz_jednostki = mysqli_query($polaczenie,"SELECT id,nazwa FROM jednostki") or die(mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_jednostki)>0)
    {
        while ($jed = mysqli_fetch_array($pobierz_jednostki))
        {
            $jednostka[$licznik]['id']=$jed['id'];
            $jednostka[$licznik]['nazwa']=$jed['nazwa'];
            $licznik++;
        }
    }


    echo "<table>
                            <thead>
                            <tr><td colspan = '7' style='font-weight:bold'>Stan na dzień: $data_dzis</td></tr>
                            <tr>

                                <th>Nr iwnet 1</th>
                                <th>Nr iwnet 2</th>
                                <th>Nr iwnet 3</th>
                                <th>Nr seryjny</th>
                                <th>Nazwa</th>
                                <th>Wartośc</th>
                                <th>Jednostka</th>
                                <th>Uwaga</th>
                                


                            </tr>
                            </thead>
                            <tbody>";
    $pobierzTabelecpv = mysqli_query($polaczenie, "SELECT nr_inwentarzowy, nr_inwentarzowy_1,nr_inwentarzowy_2,nazwa_sprzetu,nr_fabryczny,uwagi,notatki,wartosc,id_jednoski
FROM baza WHERE likwidacja IS NULL") or die ("Blad przy pobierzTabelecpv " . mysqli_error($polaczenie));
    if (mysqli_num_rows($pobierzTabelecpv) > 0) {
        $jednostka_nazwa_pelna='';
        //$jednostkak='';
        $jednostka_nazwa='';

        while ($tabelacpv = mysqli_fetch_array($pobierzTabelecpv)) {
            $jednostka_nr = $tabelacpv[8];
            $jednostka_nazwa = array_search($jednostka_nr,array_column($jednostka,'id'));
            $jednostka_nazwa_pelna = $jednostka[$jednostka_nazwa]['nazwa'];
            echo "<tr><td>$tabelacpv[0]</td><td>$tabelacpv[1]</td><td>$tabelacpv[2]</td><td>$tabelacpv[4]</td><td>$tabelacpv[3]</td><td>$tabelacpv[7]</td><td>$jednostka_nazwa_pelna</td><td>$tabelacpv[5], $tabelacpv[6]</td></tr>";
        }
    }
    echo "</tbody></table>";
}