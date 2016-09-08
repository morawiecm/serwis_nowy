<?php

/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-09-08
 * Time: 11:54
 */
class Uzytkownik extends Polaczenie
{
    public $uzytkownik_id;
    public $uzytkownik_login;
    public $uzytkownik_imie;
    public $uzytkownik_nazwisko;
    public $uzytkownik_wydzial;
    public $uzytkonik_sekcja;
    public $uzytkownik_pomieszczenie;
    public $uzytkownik_uprawnienia;
    public $uzytkownik_logowanie_data;
    public $uzytkownik_logowanie_ip;

    function __construct($id_uzytkownika)
    {
        $this->uzytkownik_id=$id_uzytkownika;
        parent::PolaczZBaza();
        $this->PobierzDaneUzytkownika();
    }

    function PobierzDaneUzytkownika()
    {

        $polaczenie = $this->polaczenie_z_baza;
        $pobierz_dane_uzytkownika= $polaczenie->query("SELECT imie, nazwisko FROM users WHERE user_id = '{$this->uzytkownik_id}'");
        $wynik = $pobierz_dane_uzytkownika->fetch_assoc();
        $this->uzytkownik_imie = $wynik['imie'];
        $this->uzytkownik_nazwisko =$wynik['nazwisko'];


       // echo $this->uzytkownik_imie." ".$this->uzytkownik_nazwisko;
    }
    function WyswietlDane()
    {
        echo $this->uzytkownik_imie." ";
        echo $this->uzytkownik_login."\n ";
    }

}