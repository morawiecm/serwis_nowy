<?php
/**
 * Created by PhpStorm.
 * User: mariusz morawiec
 * Date: 01.11.2016
 * Time: 08:53
 */

function Historia($id_srodka_trwalego, $kod, $tresc_problem, $data_wpisu, $kto_wpisal,$tresc_rozwiazanie, $dokument, $informacje_dodatkowe, $nr_inwentarzowy, $nr_inwentarzowy2, $uzytkownik_wydzial)
{
    $zapytanie ="";
    $polaczenie = polaczenie_z_baza();
    $zapytanie = "INSERT INTO historia (kto_utworzyl, wydział, data_utworzenia, kod, nr_inwentarzowy, nr_inwentarzowy_2, problem, rozwiazanie, dokument, dodatkowe, id_srodka_trwalego) VALUES 
     ('$kto_wpisal','$uzytkownik_wydzial','$data_wpisu','$kod','$nr_inwentarzowy','$nr_inwentarzowy2','$tresc_problem','$tresc_rozwiazanie','$dokument','$informacje_dodatkowe','$id_srodka_trwalego')";
    $zapisz_do_histori = mysqli_query($polaczenie,"$zapytanie") or die("Blad przy zapisz_do_histori");

}