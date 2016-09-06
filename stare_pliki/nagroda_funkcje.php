<?php


// Polaczenie sie z baza danych
function polaczenie_z_baza()
{
    $polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
    mysqli_set_charset($polaczenie, "utf8");

    return $polaczenie;
}

function lista_grup(){
    $lista='';
    $polaczenie=polaczenie_z_baza();
    $pobierz_liste_grup=mysqli_query($polaczenie,"SELECT * FROM nagroda_poziomy WHERE id!=1") or die("Blad przy pobierz_liste_grup".mysqli_error($polaczenie));
    while ($lista_poziomow=mysqli_fetch_array($pobierz_liste_grup)){
        $lista.="<option value='".$lista_poziomow[0]."'>".$lista_poziomow[1]."</option>";
    }
    return $lista;

}

//funkcja zwracajaca kwartal z daty dzisiejszej
function kwartal()
{
    $kwartal=date("m");
    if($kwartal<4)
    {
        $kwartal=1;
    }
    elseif ($kwartal<7)
    {
        $kwartal=2;
    }
    elseif ($kwartal<10)
    {
        $kwartal=3;
    }
    else
    {
        $kwartal=4;
    }
    return $kwartal;
}

// funkcja liczaca liczbe uzytkownikow w wskazanej grupie
function policz_uzytkownikow_w_grupie($id_grupy)
{
    $kwartal=kwartal();
    $polaczenie=polaczenie_z_baza();
    $pobierz_liczbe_uzytownikow_w_grupie=mysqli_query($polaczenie,"SELECT COUNT(nagroda_osoby.id_nagrody) FROM nagroda_osoby WHERE id_nagrody='$id_grupy' and kwartal='$kwartal'");
    if(mysqli_num_rows($pobierz_liczbe_uzytownikow_w_grupie)>0)
    {
        while ($liczba_uzytkownikow_w_grupie=mysqli_fetch_array($pobierz_liczbe_uzytownikow_w_grupie))
        {
            $liczbaUzytkownikowWgrupie=$liczba_uzytkownikow_w_grupie[0];
        }
    }
    else
    {
        $liczbaUzytkownikowWgrupie=0;
    }
    return $liczbaUzytkownikowWgrupie;
}

//zlicza wszystkich uzytkowników bioracych w podziale na nagrody
function policz_uzytkownikow_w_grupach()
{
    $liczba_uzytkownikow_w_grupach=0;
    $polaczenie=polaczenie_z_baza();
    $pobierz_grupy=mysqli_query($polaczenie,"SELECT id FROM nagroda_poziomy");

    while ($grupy=mysqli_fetch_array($pobierz_grupy))
    {
        if($grupy[0]==5)
        {
            $liczba_uzytkownikow_w_grupach+=0;
        }
        else
        {
            $liczba_uzytkownikow_w_grupach+=policz_uzytkownikow_w_grupie($grupy[0]);
        }
    }
    return $liczba_uzytkownikow_w_grupach;
}
//funkcja pobiera wartosc procentowa wskazanej grupy
function pobierz_wage_grupy($id_grupy)
{
    $polaczenie=polaczenie_z_baza();
    $pobierz_wage_grupy=mysqli_query($polaczenie,"SELECT wartosc_procetowa FROM nagroda_poziomy WHERE id='$id_grupy'");
    while ($waga_grupy=mysqli_fetch_array($pobierz_wage_grupy))
    {
        $wagaGrupy=$waga_grupy[0];
    }
    return $wagaGrupy;
}
//funkcja zliczajaca wszystkie wagi * uzytkownicy by obliczyc 1 %
function suma_wag_grup()
{
    $suma_wag=0;
    $polaczenie=polaczenie_z_baza();
    $pobierz_grupy=mysqli_query($polaczenie,"SELECT id FROM nagroda_poziomy");
    while ($grupy=mysqli_fetch_array($pobierz_grupy))
    {
        $suma_wag+=pobierz_wage_grupy($grupy[0])*policz_uzytkownikow_w_grupie($grupy[0]);
    }
    return $suma_wag;
}

//funkcja wyliczajac 1 %
function wylicz_procent()
{
    $suma_wag=suma_wag_grup();
    $kwota_calkowia=pobierz_kwote_do_podzialu();
    $kwota_nie_mniej=pobierz_kwote_nie_mniej();
    $liczba_osob=policz_uzytkownikow_w_grupach();
    if($kwota_nie_mniej==0)
    {
        $jeden_procent=$kwota_calkowia/$suma_wag;
    }
    else
    {
        $jeden_procent=($kwota_calkowia-($kwota_nie_mniej*$liczba_osob))/$suma_wag;
    }
return $jeden_procent;
}

//funkcja pobierajaca nazwę grupy
function pobierz_nazwe_grupy($id_grupy)
{
    $polaczenie=polaczenie_z_baza();
    $pobierz_nazwe_grupy=mysqli_query($polaczenie,"SELECT nazwa_grupy FROM nagroda_poziomy WHERE id='$id_grupy'");
    while ($nazwa_grupy=mysqli_fetch_array($pobierz_nazwe_grupy))
    {
        $nazwaGrupy=$nazwa_grupy[0];
    }
    return $nazwaGrupy;
}
// funkcja pierajaca kwotę całkowitą do podziału
function pobierz_kwote_do_podzialu()
{
    $polaczenie=polaczenie_z_baza();
    $pobierz_kwote_do_podzialu=mysqli_query($polaczenie,"SELECT tresc FROM ustawienia WHERE  id=2");
    while ($kwota_do_podzialu=mysqli_fetch_array($pobierz_kwote_do_podzialu))
    {
        $kwotaDoPodzialu=$kwota_do_podzialu[0];
    }
    return $kwotaDoPodzialu;
}
// funkcja pobierajaca kwotę nie mnijesza niz . ( na jedna osobe jaka przypada)
function pobierz_kwote_nie_mniej()
{
    $polaczenie=polaczenie_z_baza();
    $pobierz_kwote_nie_mniej=mysqli_query($polaczenie,"SELECT tresc FROM ustawienia WHERE id=3");
    while ($kwota_nie_mniej=mysqli_fetch_array($pobierz_kwote_nie_mniej))
    {
        $kwotaNieMniej=$kwota_nie_mniej[0];
    }
    return $kwotaNieMniej;
}
//funkcja wyliczajaca wartosc dla grupy
function wylicz_wartosc_grupy($id_grupy)
{
    if($id_grupy==6)
    {
        $wartoscGrupy=pobierz_kwote_nie_mniej();
    }
    else
    {

        $jeden_procent=wylicz_procent();
        $wartosc_procentowa_grupy=pobierz_wage_grupy($id_grupy);
        $kwota_nie_mniej=pobierz_kwote_nie_mniej();
        $wartoscGrupy=$wartosc_procentowa_grupy*$jeden_procent;
        if($kwota_nie_mniej!=0)
        {
            if($id_grupy==5)
            {
                $wartoscGrupy=0;
            }
            else
            {
                $wartoscGrupy+=$kwota_nie_mniej;
            }
        }
        $wartoscGrupy=number_format($wartoscGrupy,2,'.',' ');

    }
    return $wartoscGrupy;
}

function aktualizacja_grupy_nagroda($id_usera, $id_grupy)
{
    $polaczenie=polaczenie_z_baza();
    $kwartal=kwartal();
    $aktualizuj_grupe_nagroda=mysqli_query($polaczenie,"UPDATE nagroda_osoby SET id_nagrody='$id_grupy' WHERE id_osoby='$id_usera' AND kwartal='$kwartal'");
        return "Zaktualizowano pomyślnie <a href='nagroda.php'>POWRÓT</a>";
}

function aktualizacja_wagi_grupy($id_grupy, $wartosc_grupy)
{
    $polaczenie=polaczenie_z_baza();
    $aktualizuj_wage_grupy=mysqli_query($polaczenie,"UPDATE nagroda_poziomy SET wartosc_procetowa='$wartosc_grupy' WHERE id='$id_grupy'");

    return "Zaktualiowano pomyślnie <a href='nagroda.php'>POWRÓT</a>";
}
