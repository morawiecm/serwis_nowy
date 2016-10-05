<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-10-05
 * Time: 12:29
 */

function PobierzOpisInveo($nr_id_rekordu)
{
    $opis='';
    $polaczenie = polaczenie_z_baza();
    $pobierz_opis_inveo = mysqli_query($polaczenie,"SELECT STS_LP, STS_OPIS FROM inveo_skladniki WHERE id = '$nr_id_rekordu'")
        or die("Bład przy pobierz_opis_inveo");
    if(mysqli_num_rows($pobierz_opis_inveo)>0)
    {
        while ($opis_inveo=mysqli_fetch_array($pobierz_opis_inveo))
        {
            $opis = "U".$opis_inveo['STS_LP'].": ".$opis_inveo['STS_OPIS'];
        }
    }
    else
    {
        $opis="Brak opisu w bazie";
    }
    return $opis;
}
