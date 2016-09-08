<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-09-08
 * Time: 12:06
 */
include 'Polaczenie.php';
include 'Uzytkownik.php';

$polaczenie = new Polaczenie();
$pracownik = new Uzytkownik(56);

echo $pracownik->uzytkownik_imie;


