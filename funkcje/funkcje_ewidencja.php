<?php


 /** Funkcja tworzaca liste rozwijaną (tabela slownik_zlodlo_finanosowania)
 *  z możliością przeciążenia wartości
 * - wartośc podana jako parametr będzie na 1 miescu  listy rozwijanej
 **/
function PobierzZrodloFinasowania($wartosc)
{
    //deklaracja zmiennych i ich wartosci
    $polaczenie = polaczenie_z_baza();
    $pierwszy_element_listy = '';
    $lista_rozwijana = '';

    //przeciązenie - dodanie elementu na 1 miejscu na liscie rozwijanej
    if($wartosc !='')
    {
        $pierwszy_element_listy = "<option selected='selected'>$wartosc</option>";
        $lista_rozwijana .=$pierwszy_element_listy;
    }
    //pobranie wartosci z bazy i wpisanie jej na liste rozwijana
    $pobierz_zrodlo_finanosowania_lista = mysqli_query($polaczenie, "SELECT nazwa FROM slownik_zrodlo_fianansowania")
    or die("Blad przy pobierz_zrodlo_finansowania_lista" . mysqli_error($polaczenie));
    if (mysqli_num_rows($pobierz_zrodlo_finanosowania_lista) > 0)
    {
        while ($lista = mysqli_fetch_array($pobierz_zrodlo_finanosowania_lista))
        {
            $lista_rozwijana .= "<option>$lista[nazwa]</option>";
        }
    }
    // w przypadku pustej bazy wyświetl komunikat
    else
    {
        $lista_rozwijana = "<option>Brak wartości w Słowniku - Źródło Finansowania. Dodaj!</option>";
    }

    return $lista_rozwijana;
}

/** Funkcja tworzaca liste rozwijaną (tabela slownik_sposob_likwidacji)
 *  z możliością przeciążenia wartości
 * - wartośc podana jako parametr będzie na 1 miescu  listy rozwijanej
 **/
function PobierzSposobLikwidacji($wartosc)
{
    //deklaracja zmiennych i ich wartosci
    $polaczenie = polaczenie_z_baza();
    $pierwszy_element_listy = '';
    $lista_rozwijana = '';

    //przeciązenie - dodanie elementu na 1 miejscu na liscie rozwijanej
    if($wartosc !='')
    {
        $pierwszy_element_listy = "<option selected='selected'>$wartosc</option>";
        $lista_rozwijana .=$pierwszy_element_listy;
    }
    //pobranie wartosci z bazy i wpisanie jej na liste rozwijana
    $pobierz_sposob_likwidacji_lista = mysqli_query($polaczenie, "SELECT nazwa FROM slownik_sposob_likwidacji")
    or die("Blad przy pobierz_zrodlo_finansowania_lista" . mysqli_error($polaczenie));
    if (mysqli_num_rows($pobierz_sposob_likwidacji_lista) > 0)
    {
        while ($lista = mysqli_fetch_array($pobierz_sposob_likwidacji_lista))
        {
            $lista_rozwijana .= "<option>$lista[nazwa]</option>";
        }
    }
    // w przypadku pustej bazy wyświetl komunikat
    else
    {
        $lista_rozwijana = "<option>Brak wartości w Słowniku -Sposób Likwidacji. Dodaj!</option>";
    }

    return $lista_rozwijana;
}

/** Funkcja tworzaca liste rozwijaną (tabela slownik_rodzaj_ewidencji)
 *  z możliością przeciążenia wartości
 * - wartośc podana jako parametr będzie na 1 miescu  listy rozwijanej
 **/
function PobierzRodzajEwidencji($wartosc)
{
    //deklaracja zmiennych i ich wartosci
    $polaczenie = polaczenie_z_baza();
    $pierwszy_element_listy = '';
    $lista_rozwijana = '';

    //przeciązenie - dodanie elementu na 1 miejscu na liscie rozwijanej
    if($wartosc !='')
    {
        $pobierz_wartosc_z_bazy_pasujaca = mysqli_query($polaczenie,"SELECT nazwa, nazwa_skrocona FROM slownik_rodzaj_ewidencji WHERE nazwa LIKE '$wartosc'")
            or die("Blad przy pobierz_wartosc_z_bazy_pasujaca ".mysqli_error($polaczenie));
        if(mysqli_num_rows($pobierz_wartosc_z_bazy_pasujaca)>0)
        {
            while ($wartosc_pobrana = mysqli_fetch_array($pobierz_wartosc_z_bazy_pasujaca))
            {
                $pierwszy_element_listy = "<option value='$wartosc_pobrana[nazwa_skrocona]' selected='selected'>$wartosc_pobrana[nazwa]</option>";
            }
        }
        $lista_rozwijana .=$pierwszy_element_listy;
    }
    //pobranie wartosci z bazy i wpisanie jej na liste rozwijana
    $pobierz_rodzaj_ewidencji_lista = mysqli_query($polaczenie, "SELECT nazwa, nazwa_skrocona FROM slownik_rodzaj_ewidencji")
    or die("Blad przy pobierz_rodzaj_ewidencji_lista" . mysqli_error($polaczenie));
    if (mysqli_num_rows($pobierz_rodzaj_ewidencji_lista) > 0)
    {
        while ($lista = mysqli_fetch_array($pobierz_rodzaj_ewidencji_lista))
        {
            $lista_rozwijana .= "<option value='$lista[nazwa_skrocona]'>$lista[nazwa]</option>";
        }
    }
    // w przypadku pustej bazy wyświetl komunikat
    else
    {
        $lista_rozwijana = "<option>Brak wartości w Słowniku - Rodzaj Ewidencji. Dodaj!</option>";
    }

    return $lista_rozwijana;
}

/** Funkcja pobierjaca jednostki i zwracajaca
 * je w  postaci listy rozwijanej */
function PobierzJednostki($wartosc)
{
    $nazwa_jednostki=$wartosc;
    $polaczenie = polaczenie_z_baza();
    $lista='';

    if($nazwa_jednostki!='')
    {
        $pobierz_jednostke = mysqli_query($polaczenie,"SELECT nazwa, kod_jednostki FROM jednostki WHERE kod_jednostki = '$wartosc'")
            or die("Blad przy pobierz_jednsotke".mysqli_error($polaczenie));
        if(mysqli_num_rows($pobierz_jednostke)>0)
        {
            while ($jednostka = mysqli_fetch_array($pobierz_jednostke))
            {
                $nazwa_jednostki .= "<option value='$jednostka[kod_jednostki]' selected='selected'>$jednostka[nazwa]</option>";
                $lista.=$nazwa_jednostki;
            }
        }
        else
        {
            $nazwa_jednostki .="<option value='$wartosc'>Brak jednostki lub została usunięta o kodzie : $wartosc</option>";
            $lista.=$nazwa_jednostki;
        }
    }
    else
    {
        $pobierz_jednostki = mysqli_query($polaczenie,"SELECT nazwa, kod_jednostki FROM jednostki WHERE aktywny = '0'")
        or die("Blad przy pobierz_jednsotke".mysqli_error($polaczenie));
        if(mysqli_num_rows($pobierz_jednostki)>0)
        {
            while ($jednostka = mysqli_fetch_array($pobierz_jednostki))
            {
                $lista.= "<option value='$jednostka[kod_jednostki]' selected='selected'>$jednostka[nazwa]</option>";
            }
        }
        else
        {
            $lista .= "<option value='$wartosc'>Brak dodanych jednostek w bazie dodaj w słowniku</option>";
        }
    }

    return $lista;
}