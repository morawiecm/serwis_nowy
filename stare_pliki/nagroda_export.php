<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>

    <title>Nagrody</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=export_nagrody.xls");

// Add data table
include 'config.php';
include 'nagroda_funkcje.php';

$kwartal = kwartal();
$pobierz_uzytkownikow_grupy = mysqli_query($polaczenie, "
                                 SELECT nagroda_osoby.id_osoby, 
                                nagroda_osoby.id_nagrody, 
                                nagroda_osoby.akceptacja, 
                                nagroda_osoby.kwartal,
                                nagroda_osoby.uzasadnienie as uzasadninie,
                                users.imie as imie,
                                users.nazwisko as nazwisko
                                FROM nagroda_osoby 
                                INNER JOIN users ON nagroda_osoby.id_osoby=users.user_id
                                WHERE nagroda_osoby.kwartal='$kwartal'
        
                               ") or die ("Blad przy pobierz_uzytkownikow_grupy" . mysqli_error($polaczenie));

if (mysqli_num_rows($pobierz_uzytkownikow_grupy) > 0) {
    $lista = lista_grup();
    echo "<table class='table'>";
    echo "<tr><th>Imie i nazwisko</th><th>Kwota nagrody</th></tr>";
    while ($uzytkownicy_grupy = mysqli_fetch_array($pobierz_uzytkownikow_grupy)) {

        $wartoscGrupy = wylicz_wartosc_grupy($uzytkownicy_grupy['id_nagrody']);

        echo "<tr><td>$uzytkownicy_grupy[imie] $uzytkownicy_grupy[nazwisko] </td><td> $wartoscGrupy zł</td></tr>";
    }
    echo "</table>";
}
?>