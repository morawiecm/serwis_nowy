<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-02-15
 * Time: 14:22
 */

include 'config.php';

//pobranie rekordow z tabeli `baza`

//tabela baza
//$pobierzRekordy=mysqli_query($polaczenie,"SELECT jed_uzytkujaca, lp FROM baza") or die(mysqli_error($polaczenie));
$pobierzRekordy=mysqli_query($polaczenie,"SELECT jed_uzytkujaca, lp FROM baza_inwentaryzacja") or die(mysqli_error($polaczenie));

//tabela tonery
 //   $pobierzRekordy=mysqli_query($polaczenie,"SELECT wydzial, id FROM tonery") or die(mysqli_error($polaczenie));
if(mysqli_num_rows($pobierzRekordy)>0)
{
    while($rekordy=mysqli_fetch_array($pobierzRekordy))
    {
        $jednostka=$rekordy[0];
        $lp=$rekordy[1];

        $wyszukaj_jednostke=mysqli_query($polaczenie,"SELECT nazwa FROM jednostki WHERE id='$jednostka'") or die("blad przy wyszukaj_jednostke".mysqli_error($polaczenie));
        if(mysqli_num_rows($wyszukaj_jednostke)==1)
        {
            while($nowaJednostka=mysqli_fetch_array($wyszukaj_jednostke))
            {
                $nowa_nazwa=$nowaJednostka[0];
                if($nowa_nazwa!='')
                {
                    //tabela baza
                    $zaktualizuj_rekord=mysqli_query($polaczenie,"UPDATE baza_inwentaryzacja SET jed_uzytkujaca='$nowa_nazwa' WHERE lp='$lp'") or die(mysqli_error($polacznie));
                    //tabela tonery
                    //$zaktualizuj_rekord=mysqli_query($polaczenie,"UPDATE tonery SET wydzial='$nowa_nazwa' WHERE id='$lp'") or die(mysqli_error($polacznie));
                }

            }

        }
        echo"$jednostka $lp $nowa_nazwa </br>";
    }
}

?>