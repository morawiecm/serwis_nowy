<?php
/**
 * Created by PhpStorm.
 * User: mariu
 * Date: 12.09.2016
 * Time: 19:40
 */

function ZnacznikCzasowy($start, $koniec) {
    $start = strtotime($start);
    $koniec = strtotime($koniec);
    return $koniec-$start;
}

function ZnacznikCzasowyNaCzas($czas)
{
    $wynik = array();
    // zmienne pomocne przy obliczeniach (dlugość w sekundach)
    $tydzien = 7 * 24 * 60 * 60;
    $dzien = 24 * 60 * 60;
    $godzina = 60 * 60;
    $minuta = 60;

    if (($wynik[0] = intval($czas / $tydzien)))
        $czas %= $tydzien;

    if (($wynik[1] = intval($czas / $dzien)))
        $czas %= $dzien;

    if (($godzina[2] = intval($czas / $godzina)))
        $czas %= $godzina;

    $wynik[3] = intval($czas / $minuta);
    return $wynik;
}
function PoliczMinuty($id_uzytkownika)
{
    $polaczenie=polaczenie_z_baza();
    $minuty=0;
    $pobierz_minuty_uzytkownika=mysqli_query($polaczenie,"SELECT minut,typ_wyjscia FROM nadgodziny WHERE id_usera = '$id_uzytkownika'")
     or die("Blad przy pobierz_minuty_uzytkownika".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_minuty_uzytkownika)>0)
    {
        while ($godziny_uzytkownika=mysqli_fetch_array($pobierz_minuty_uzytkownika))
        {
            if($godziny_uzytkownika['typ_wyjscia']=='0')
            {
                $minuty+=$godziny_uzytkownika['minut'];
            }
            elseif($godziny_uzytkownika['typ_wyjscia']=='1')
            {
                $minuty-=$godziny_uzytkownika['minut'];
            }
        }
    }
    return $minuty;
}