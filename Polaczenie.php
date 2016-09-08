<?php

/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-09-08
 * Time: 12:17
 */
class Polaczenie
{
    public $DBHOST = 'localhost';
    public $DBUSER = 'root';
    public $DBPASS = 'em';
    public $DBNAME = 'baza_nowa';
    public $polaczenie_z_baza;

    function __construct()
    {
        $this->PolaczZBaza();
    }


    function PolaczZBaza()
    {
        $this->polaczenie_z_baza=new mysqli($this->DBHOST,$this->DBUSER,$this->DBPASS,$this->DBNAME);
        mysqli_set_charset($this->polaczenie_z_baza,"utf8");
        if(mysqli_connect_errno())
        {
            echo "Bład połaczenia z bazą:".mysqli_connect_errno();
            exit();
        }
    }
    function WykonajZapytanie()
    {
        $polaczenie = $this->polaczenie_z_baza;
        $zapytanie = $polaczenie->query("SELECT * FROM users");
        while ($wynik = $zapytanie->fetch_assoc())
        {
            $tablica[]=$wynik['user_name'];
        }
        return $tablica;
    }
}