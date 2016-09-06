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
// 1 $pobierzRekordy=mysqli_query($polaczenie,"SELECT lp, nr_inwentarzowy_klasyfikacja, nr_inwentarzowy_rodzaj, nrinwentnowy FROM baza WHERE nr_inwentarzowy IS NULL AND nrinwentnowy!=''") or die(mysqli_error($polaczenie));
// 2$pobierzRekordy=mysqli_query($polaczenie,"SELECT lp, nr_inwentarzowy_klasyfikacja, nr_inwentarzowy_rodzaj, nrinwentnowy FROM baza WHERE 	nr_aktualny=''") or die(mysqli_error($polaczenie));
$pobierzRekordy=mysqli_query($polaczenie,"SELECT lp, nr_inwentarzowy FROM baza WHERE nr_inwentarzowy !=''") or die(mysqli_error($polaczenie));
if(mysqli_num_rows($pobierzRekordy)>0)
{
    while($rekordy=mysqli_fetch_array($pobierzRekordy))
    {
      // $lp=$rekordy[0];
      //  $a=$rekordy[1];
      //  $b=$rekordy[2];
      // $c=$rekordy[3];


        //  $nowy_numer=$a.'-'.$b.'-'.$c;
            $nowy_numer=$rekordy[1];

        //1 i  2 $zaktualizuj_rekord=mysqli_query($polaczenie,"UPDATE baza SET nr_aktualny='$nowy_numer' WHERE lp='$lp'") or die(mysqli_error($polacznie));
        $zaktualizuj_rekord=mysqli_query($polaczenie,"UPDATE baza SET nr_stary='$nowy_numer' WHERE lp='$lp'") or die(mysqli_error($polacznie));
        $lp++;
        echo"$lp. $nowy_numer </br>";
    }
}
// 3.  UPDATE bazan SET nr_aktualny='' WHERE nr_aktualny='--'
?>