<?php
/**
 * Created by PhpStorm.
 * User: mariu
 * Date: 22.11.2016
 * Time: 15:11
 */

function PobierzNrProtokoluST()
{
    $nr_protokolu_st=0;
    $polaczenie = polaczenie_z_baza();
    //pobierz numer porotokolu z bazy

    $pobierz_numer_protokolu = mysqli_query($polaczenie,"SELECT tresc FROM ustawienia WHERE id = '4'") or die("Blad przy pobierz_numer_protokolu".mysqli_error($polaczenie));
    while ($numer = mysqli_fetch_array($pobierz_numer_protokolu))
    {
        $nr_protokolu_st = $numer['tresc'];
    }
    return $nr_protokolu_st;
}
function ZwiekszNrProtokoluST($nr_aktualny)
{
    $nr_aktualny++;
    $polaczenie = polaczenie_z_baza();
    //zwieksz numer porotokolu z bazy

    $zwieksz_numer_protokolu = mysqli_query($polaczenie,"UPDATE ustawienia SET tresc = '$nr_aktualny' WHERE id = '4'") or die("Blad przy zwieksz_numer_protokolu".mysqli_error($polaczenie));

}