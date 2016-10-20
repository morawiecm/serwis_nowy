<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-10-07
 * Time: 10:15
 */

define('DBHOST', '192.168.1.180');
define('DBUSER', 'mariusz');
define('DBPASS', '123mariusz321');
define('DBNAME', 'policja');
//Polaczenie MySQLi
//error_reporting(2);
$polaczenie=polaczenie_z_baza();

function polaczenie_z_baza()
{
    $polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
    mysqli_set_charset($polaczenie, "utf8");

    return $polaczenie;
}
$licznk = 0;
$kopiuj = mysqli_query($polaczenie,"SELECT Lp, Nazwisko, Jednostka, Wykaz FROM usersSTAARA") or die(mysqli_error($polaczenie));
if(mysqli_num_rows($kopiuj)>0)
{
    while ($dane = mysqli_fetch_array($kopiuj))
    {

        $lp = $dane['Lp'];
        $naz = $dane['Nazwisko'];
        $jedn = $dane['Jednostka'];
        $wyk = $dane['Wykaz'];

        $aktualizuj = mysqli_query($polaczenie,"UPDATE users SET Jednostka = '$jedn', Wykaz = '$wyk' WHERE Lp = '$lp'")
            or die ("Blad przy aktualizuj".mysqli_error($polaczenie));
        echo"$lp - $naz - $jedn - $wyk </br>";
        $licznk++;
        echo"\n $licznk</br>";
    }
}
