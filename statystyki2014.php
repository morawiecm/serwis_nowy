<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-03-16
 * Time: 08:48
 */

include 'polaczenieotrs2.php';

$liczba_zlecen=mysqli_query($polaczenie,"SELECT id FROM `ticket` WHERE `create_time` BETWEEN '2014-01-01' AND '2015-01-01' ") or die($polaczenie);
$licznik_ticketowa=mysqli_num_rows($liczba_zlecen);

echo"Liczba zlecen w 2014 : $licznik_ticketowa </br></br>";

$liczba_wpisow=mysqli_query($polaczenie,"SELECT id  FROM `article` WHERE `create_time` BETWEEN '2014-01-01' AND '2015-01-01'") or die($polaczenie);
$licznik_wpisow=mysqli_num_rows($liczba_wpisow);
$liczba_wpisow2=mysqli_query($polaczenie,"SELECT id  FROM `article_attachment` WHERE `create_time` BETWEEN '2014-01-01' AND '2015-01-01'") or die($polaczenie);
$licznik_wpisow2=mysqli_num_rows($liczba_wpisow2);
$licznik=$licznik_wpisow+$licznik_wpisow2;
echo"Liczba wszystkich wpisów od 2014-01-01 do 2015-01-01: $licznik</br></br></br>";
 $lp=0;
echo"<table><tr><th>LP.</th><th>Login</th><th>Imie i nazwisko</th><th>Wpisów</th></tr>";
$policz_wpisy=mysqli_query($polaczenie,"SELECT id FROM users") or die($polaczenie);
if(mysqli_num_rows($policz_wpisy)>0)
{
    while($wpisy=mysqli_fetch_array($policz_wpisy))
    {
        $wyszukaj_wpisy_uzytkownika=mysqli_query($polaczenie,"SELECT users.first_name, users.last_name, count(*), users.login FROM users INNER JOIN article ON users.id=article.create_by WHERE users.id = '$wpisy[0]' AND article.create_time between '2014-01-01' AND '2015-01-01'") or die($polaczenie);
        if(mysqli_num_rows($wyszukaj_wpisy_uzytkownika)>0)
        {

        while($wpis_uzytkownika=mysqli_fetch_array($wyszukaj_wpisy_uzytkownika))
        {
            $wyszukaj_wpisy_uzytkownika2=mysqli_query($polaczenie,"SELECT count(*), users.login FROM users INNER JOIN article_attachment ON users.id=article_attachment.create_by WHERE users.id = '$wpisy[0]' AND article_attachment.create_time between '2014-01-01' AND '2015-01-01'") or die($polaczenie);
            if(mysqli_num_rows($wyszukaj_wpisy_uzytkownika2))
            {
                while($ile=mysqli_fetch_array($wyszukaj_wpisy_uzytkownika2))
                {
                $wpiss=$ile[0];
            }}
            $lp++;
            $policzone=$wpis_uzytkownika[2]+$wpiss;
            echo"<tr><td>$lp.</td><td>$wpis_uzytkownika[3]</td><td> $wpis_uzytkownika[0] $wpis_uzytkownika[1]</td><td>$policzone</td> </tr>";
        }
        }
    }
    echo"</table>";
}



