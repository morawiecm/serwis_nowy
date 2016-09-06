<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>

    <title>Aktualizacja tabeli serwis -> Historia</title>

    <link rel="stylesheet" href="js/pace-theme-loading-bar.css"/>

    <script>
        paceOptions = {
            elements: true
        };
    </script>
    <script src="js/pace.js"></script>
<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-02-25
 * Time: 13:21
 */
include "config.php";
$lp = 0;
$pobierz_wszystko_z_tabeli_serwis = mysqli_query($polaczenie, "SELECT * FROM serwis") or die("bald przy pobierz_wszystko_z_tabeli_serwis");
if (mysqli_num_rows($pobierz_wszystko_z_tabeli_serwis) > 0) {
    while ($tabelaSerwis = mysqli_fetch_array($pobierz_wszystko_z_tabeli_serwis)) {
        $lp++;
        echo "$lp";
        if ($tabelaSerwis[8] == 'tak') {
            $rozkompletowanie_wpis=mysqli_query($polaczenie,"INSERT INTO historia (id, kto_utworzyl, wydział, data_utworzenia, kod, nr_inwentarzowy, nr_inwentarzowy_2, problem, rozwiazanie, dokument, dodatkowe)
             VALUES ('','$tabelaSerwis[1]','$tabelaSerwis[3]','$tabelaSerwis[2]','1','$tabelaSerwis[9]','','$tabelaSerwis[12]','','$tabelaSerwis[11]','$tabelaSerwis[5]')") or die("blad przy rozkompletowanie_wpis".mysqli_error($polaczenie));
            echo " 1 rozkompletowanie</br>";

        } else {
            if ($tabelaSerwis[13] == 'tak') {
                $drukarka_wpis=mysqli_query($polaczenie,"INSERT INTO historia (id, kto_utworzyl, wydział, data_utworzenia, kod, nr_inwentarzowy, nr_inwentarzowy_2, problem, rozwiazanie, dokument, dodatkowe)
             VALUES ('','$tabelaSerwis[1]','$tabelaSerwis[3]','$tabelaSerwis[2]','6','$tabelaSerwis[9]','','$tabelaSerwis[11]','','','$tabelaSerwis[8]')") or die("blad przy drukarka_wpis".mysqli_error($polaczenie));

                echo " 6 drukarka</br>";
            } elseif ($tabelaSerwis[10] != '') {
                $magazyn_wpis=mysqli_query($polaczenie,"INSERT INTO historia (id, kto_utworzyl, wydział, data_utworzenia, kod, nr_inwentarzowy, nr_inwentarzowy_2, problem, rozwiazanie, dokument, dodatkowe)
             VALUES ('','$tabelaSerwis[1]','$tabelaSerwis[3]','$tabelaSerwis[2]','4','$tabelaSerwis[9]','','$tabelaSerwis[10]','$tabelaSerwis[11]','','')") or die("blad przy magazyn_wpis".mysqli_error($polaczenie));

                echo " 4 magazyn </br>";
            } else {
                $serwis_wpis=mysqli_query($polaczenie,"INSERT INTO historia (id, kto_utworzyl, wydział, data_utworzenia, kod, nr_inwentarzowy, nr_inwentarzowy_2, problem, rozwiazanie, dokument, dodatkowe)
             VALUES ('','$tabelaSerwis[1]','$tabelaSerwis[3]','$tabelaSerwis[2]','3','$tabelaSerwis[9]','','$tabelaSerwis[4]','$tabelaSerwis[5]','$tabelaSerwis[8]','')") or die("blad przy serwis_wpis".mysqli_error($polaczenie));
                echo " 3 serwis </br>";
            }
        }
    }
}