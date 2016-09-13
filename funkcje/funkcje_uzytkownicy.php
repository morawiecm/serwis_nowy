<?php

//include 'polaczenie.php';
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-09-09
 * Time: 12:28
 */


function pobierz_sekcje()
{
    $polaczenie=polaczenie_z_baza();
    $lista='';
    $pobierzJednostki=mysqli_query($polaczenie,"SELECT nazwa_grupy FROM uzytkownicy_grupy");
    if(mysqli_num_rows($pobierzJednostki)>0)
    {
        while ($jednostka=mysqli_fetch_array($pobierzJednostki))
        {
            $lista.="<option>$jednostka[nazwa_grupy]</option>";
        }
    }
    else
    {
        $lista.="<option value='pusta_tabela db_jednostka_policji'>Brak sekcji w bazie. Dodaj</option>";

    }
    return $lista;

}
function zablokuj_uzytkownika($id_uzytkownika)
{
    $data_aktualna=date("Y-m-d H:i:s");
    $polaczenie = polaczenie_z_baza();
    $zablokuj_zapytanie = "UPDATE users SET aktywny='1', data_ustania_uprawnien = '$data_aktualna' WHERE user_id = $id_uzytkownika";
    mysqli_query($polaczenie,$zablokuj_zapytanie) or die("Blad przy $zablokuj_zapytanie".mysqli_error());

}
function odblokuj_uzytkownika($id_uzytkownika)
{
    $data_aktualna=date("Y-m-d H:i:s");
    $polaczenie = polaczenie_z_baza();
    $odblokuj_zapytanie = "UPDATE users SET aktywny='0', data_ustania_uprawnien = '0000-00-00' WHERE user_id = $id_uzytkownika";
    mysqli_query($polaczenie,$odblokuj_zapytanie) or die("Blad przy $odblokuj_zapytanie".mysqli_error());

}
function wyswietl_pelniona_funkcje_lista($id_uzytkownika)
{
    $polaczenie=polaczenie_z_baza();
    $funkcja=0;
    $lista='pusta';
    $pobierz_funkje_uzytkownika = mysqli_query($polaczenie,"SELECT funkcja FROM users WHERE user_id = '$id_uzytkownika'")
        or die("Bład przy pobierz_funkcje_uzytkownika".mysqli_error());
    if(mysqli_num_rows($pobierz_funkje_uzytkownika)>0)
    {
        while ($funkcja_uzytkownika=mysqli_fetch_array($pobierz_funkje_uzytkownika))
        {
            $funkcja=$funkcja_uzytkownika['funkcja'];
            $pelniona_funkcja_aktualna = wyswietl_pelniona_funkcje($funkcja);
            $lista.="<option value='$funkcja'>$pelniona_funkcja_aktualna</option>";
            $lista.="<option value='0'>Użytkownik</option>";
            $lista.="<option value='1'>Kierownik</option>";
            $lista.="<option value='2'>Kordynator</option>";
            $lista.="<option value='3'>Naczelnik</option>";
        }
    }


    return $lista;


}
function wyswietl_pelniona_funkcje($nr_funkcji)
{
    $funkcja='';
    switch ($nr_funkcji)
    {
        case '0':
            return $funkcja = 'Użytkownik';
            break;
        case '1':
            return $funkcja = "Kierownik";
            break;
        case '2':
            return $funkcja = "Kordynator";
            break;
        case '3':
            return $funkcja = "Naczelnik";
            break;
    }
}
function sprawdz_nr_grupy($sekcja)
{
    $polaczenie = polaczenie_z_baza();
    $nr_grupy='';
    $wyszukaj_grupe=mysqli_query($polaczenie,"SELECT id FROM uzytkownicy_grupy WHERE nazwa_grupy LIKE '$sekcja'")
        or die("Blad przy wyszukaj_grupe".mysqli_error($polaczenie));

        while ($grupa=mysqli_fetch_array($wyszukaj_grupe))
        {
            $nr_grupy = $grupa['id'];
        }

    return $nr_grupy;
}
function PobierzImieNazwisko($id_uzytkownika)
{
    $polaczenie= polaczenie_z_baza();
    $imie_nazwisko='';
    $pobierz_imie_i_nazwisko=mysqli_query($polaczenie,"SELECT imie, nazwisko FROM users WHERE user_id='$id_uzytkownika'")
        or die("Bład przy pobierz_imie_i_nazwisko".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_imie_i_nazwisko)>0)
    {
        while ($dane=mysqli_fetch_array($pobierz_imie_i_nazwisko))
        {
            $imie_nazwisko = $dane['imie']." ".$dane['nazwisko'];
        }
    }
    else
    {
        $imie_nazwisko="Bład pobierania danych uzytkownika!";
    }
    return $imie_nazwisko;
}

function PobierzUzytkownikow()
{
    $polaczenie= polaczenie_z_baza();
    $id_imie_nazwisko='';
    $pobierz_imie_i_nazwisko=mysqli_query($polaczenie,"SELECT user_id, imie, nazwisko FROM users WHERE aktywny='0' ORDER BY nazwisko ASC")
    or die("Bład przy pobierz_imie_i_nazwisko".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_imie_i_nazwisko)>0)
    {
        while ($dane=mysqli_fetch_array($pobierz_imie_i_nazwisko))
        {
            $id_imie_nazwisko .="<option value='".$dane['user_id']."'>".$dane['nazwisko']." ".$dane['imie']."</option>";
        }
    }
    else
    {
        $id_imie_nazwisko="Bład pobierania danych uzytkownika!";
    }
    return $id_imie_nazwisko;
}


function PobierzKierownikow()
{
    $polaczenie= polaczenie_z_baza();
    $lista='';
    $pobierz_kierownikow=mysqli_query($polaczenie,"SELECT user_id, imie, nazwisko FROM users WHERE funkcja>0 AND aktywny='0'")
        or die("Blad przy pobierz_kierownikow".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_kierownikow)>0)
    {
        while ($kierownicy=mysqli_fetch_array($pobierz_kierownikow))
        {
            $lista.="<option value='".$kierownicy['user_id']."'>".$kierownicy['imie']." ".$kierownicy['nazwisko']."</option>";
        }
    }
    else
    {
        $lista="<option>Brak kadry zarządzającej. Dodaj funkcje</option>";
    }
    return $lista;
}
function PobierzGrupeKierownika($id_uzytkownika)
{
    $polaczenie= polaczenie_z_baza();
    $id_grupy='';
    $pobierz_grupe=mysqli_query($polaczenie,"SELECT grupa FROM users WHERE user_id='$id_uzytkownika'")
    or die("Bład przy pobierz_imie_i_nazwisko".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_grupe)>0)
    {
        while ($dane=mysqli_fetch_array($pobierz_grupe))
        {
            $id_grupy = $dane['grupa'];
        }
    }
    return $id_grupy;
}
