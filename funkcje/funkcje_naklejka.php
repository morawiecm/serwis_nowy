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

function ZmienStatusWydrukowane($nr_id_rekordu)
{
    $polaczenie = polaczenie_z_baza();
    $aktualna_data = date("Y-m-d H:i:s");
    $zmien_status_wydrukowane = mysqli_query($polaczenie,"UPDATE naklejki SET status = '1', data_druku = '$aktualna_data' 
    WHERE id = '$nr_id_rekordu'") or die("Blad przy zmien_status_wydrukowane ".mysqli_error($polaczenie));
}

function UsunNaklejke($nr_id_rekordu)
{
    $polaczenie = polaczenie_z_baza();
    $usun_naklejke = mysqli_query($polaczenie,"DELETE FROM naklejki WHERE id = '$nr_id_rekordu'")
        or die("Blad przy usun_naklejke ".mysqli_error($polaczenie));
}
function UsunStareNaklejki()
{
    $aktualna_data = date("Y-m-d");

    $polaczenie = polaczenie_z_baza();
    $usun_naklejke = mysqli_query($polaczenie,"DELETE FROM naklejki WHERE status = 1 AND  data_druku < '0000-00-00'")
    or die("Blad przy usun_naklejke ".mysqli_error($polaczenie));
}