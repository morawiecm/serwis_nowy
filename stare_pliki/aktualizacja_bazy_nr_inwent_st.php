<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-02-15
 * Time: 14:22
 */

include 'config.php';

//pobranie rekordow z tabeli `baza`
$lp=0;
//1 $pobierzRekordy=mysqli_query($polaczenie,"SELECT lp, nr_aktualny, nr_stary FROM baza WHERE lp>29400") or die(mysqli_error($polaczenie));
$pobierzRekordy=mysqli_query($polaczenie,"SELECT lp, nr_aktualny, nr_stary FROM bazan WHERE nr_stary!=''") or die(mysqli_error($polaczenie));

if(mysqli_num_rows($pobierzRekordy)>0)
{
    while($rekordy=mysqli_fetch_array($pobierzRekordy))
    {
        $lp=$rekordy[0];
        $a=$rekordy[1];
        $b=$rekordy[2];
        if(strlen($b)==8)
        {
            if(substr($b,0,5)=="000000")
            {
                $b=substr($b,6);
            }
            
        }
        
        //1 $zaktualizuj_rekord=mysqli_query($polaczenie,"UPDATE baza_inwentaryzacja SET id_lp='$lp' WHERE nr_inwentarzowy='$a' AND nr_inwentarzowy_1='$b' AND id_lp=''") or die(mysqli_error($polacznie));
        $zaktualizuj_rekord=mysqli_query($polaczenie,"UPDATE baza_inwentaryzacja SET id_lp='$lp' WHERE nr_inwentarzowy='$a' AND nr_inwentarzowy_1='$b' AND id_lp=''") or die(mysqli_error($polacznie));
        
        $lp++;
        echo"$lp</br>";
    }
}

?>