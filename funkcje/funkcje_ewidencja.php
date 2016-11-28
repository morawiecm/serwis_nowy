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
    $nazwa_jednostki2=$wartosc;
    $polaczenie = polaczenie_z_baza();
    $lista='';

    if($nazwa_jednostki!='')
    {
        $pobierz_jednostke = mysqli_query($polaczenie,"SELECT nazwa, id FROM jednostki WHERE nazwa LIKE '$wartosc' ORDER BY nazwa ASC")
            or die("Blad przy pobierz_jednsotke".mysqli_error($polaczenie));
        if(mysqli_num_rows($pobierz_jednostke)>0)
        {
            while ($jednostka = mysqli_fetch_array($pobierz_jednostke))
            {
                $nazwa_jednostki .= "<option value='$jednostka[id]' selected='selected'>$jednostka[nazwa]</option>";
                $lista.=$nazwa_jednostki;
            }
        }
        elseif (mysqli_num_rows($pobierz_jednostke)==0)
        {
            $pobierz_jednostke2 = mysqli_query($polaczenie,"SELECT nazwa, id FROM jednostki WHERE id LIKE '$wartosc' ORDER BY nazwa ASC")
            or die("Blad przy pobierz_jednsotke".mysqli_error($polaczenie));
            if(mysqli_num_rows($pobierz_jednostke2)>0)
            {
                while ($jednostka2 = mysqli_fetch_array($pobierz_jednostke2))
                {
                    $nazwa_jednostki2 .= "<option value='$jednostka2[id]' selected='selected'>$jednostka2[nazwa]</option>";
                    $lista.=$nazwa_jednostki2;
                }
            }
        }
        else
        {
            $nazwa_jednostki .="<option value='$wartosc'>Brak jednostki lub została usunięta o kodzie : $wartosc</option>";
            $lista.=$nazwa_jednostki;
        }
    }


        $pobierz_jednostki = mysqli_query($polaczenie,"SELECT nazwa, id FROM jednostki WHERE aktywny = '0' ORDER BY nazwa ASC")
        or die("Blad przy pobierz_jednsotke".mysqli_error($polaczenie));
        if(mysqli_num_rows($pobierz_jednostki)>0)
        {
            while ($jednostka = mysqli_fetch_array($pobierz_jednostki))
            {
                $lista.= "<option value='$jednostka[id]' >$jednostka[nazwa]</option>";
            }
        }
        else
        {
            $lista .= "<option value='$wartosc'>Brak dodanych jednostek w bazie dodaj w słowniku</option>";
        }


    return $lista;
}

function PoliczStanWydzialu($id_wydzialu)
{
    $stan = 0;
    $polaczenie = polaczenie_z_baza();

    $pobierz_stan_wydzialu = mysqli_query($polaczenie,"SELECT lp FROM baza  WHERE jed_uzytkujaca = $id_wydzialu AND sposob_likwidacji IS NULL ");
    $stan = mysqli_num_rows($pobierz_stan_wydzialu);

    return $stan;
}

function PobierzNazweWydzialu($id_wydzialu)
{
    $nazwa_wydzialu = "";

    $polaczenie = polaczenie_z_baza();

    $pobierz_nazwe_wydzialu  =  mysqli_query($polaczenie,"SELECT nazwa FROM jednostki WHERE id = '$id_wydzialu'")
        or die("Bład przy pobierz_nazwe_wydzialu");
    if(mysqli_num_rows($pobierz_nazwe_wydzialu)>0)
    {
        while ($wydzial = mysqli_fetch_array($pobierz_nazwe_wydzialu))
        {
            $nazwa_wydzialu = $wydzial['nazwa'];
        }
    }
    else
    {
        $nazwa_wydzialu = "Brak wydziału o podanym ID lub został usunięty";
    }

    return $nazwa_wydzialu;
}

function PobierzNumerWydzialu($nazwa_wydzialu)
{
    $numer_wydzialu = "";

    $polaczenie = polaczenie_z_baza();

    $pobierz_numer_wydzialu  =  mysqli_query($polaczenie,"SELECT id FROM jednostki WHERE nazwa LIKE '$nazwa_wydzialu'")
    or die("Bład przy pobierz_numer_wydzialu");
    if(mysqli_num_rows($pobierz_numer_wydzialu)>0)
    {
        while ($numer = mysqli_fetch_array($pobierz_numer_wydzialu))
        {
            $numer_wydzialu = $numer['id'];
        }
    }
    else
    {
        $numer_wydzialu = "Brak wydziału o podanej nazwie lub został usunięty";
    }

    return $numer_wydzialu;
}

function PobierzIdJednostki($id_srodtka_trwalego)
{
    $polaczenie = polaczenie_z_baza();
    $id_jednostki = '';

    $pobierz_id_jednostki  = mysqli_query($polaczenie, "SELECT id_jednoski FROM baza WHERE lp = '$id_srodtka_trwalego'")
        or die("Blad przy pobierz_id_jednostki".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_id_jednostki)>0)
    {
        while ($jednostka_id = mysqli_fetch_array($pobierz_id_jednostki))
        {
            $id_jednostki = $jednostka_id['id_jednoski'];
        }
    }
    return $id_jednostki;

}
function PobierzNazweSprzetu($id_srodka_trwalego)
{
    $polaczenie = polaczenie_z_baza();
    $nazwa_sprzetu = '';

    $pobierz_nazwe_sprzetu =  mysqli_query($polaczenie,"SELECT nazwa_sprzetu, nr_inwentarzowy FROM baza WHERE lp ='$id_srodka_trwalego'") or die(mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_nazwe_sprzetu)>0)
    {
        while ($sprzet = mysqli_fetch_array($pobierz_nazwe_sprzetu))
        {
            $nazwa_sprzetu = $sprzet['nr_inwentarzowy']." ".$sprzet['nazwa_sprzetu'];
        }
    }

    return $nazwa_sprzetu;
}
function PobierzWydzialSprzetu($id_srodka_trwalego)
{
    $polaczenie = polaczenie_z_baza();
    $wydzial_sprzetu = '';

    $pobierz_nazwe_sprzetu =  mysqli_query($polaczenie,"SELECT id_jednoski FROM baza WHERE lp ='$id_srodka_trwalego'") or die(mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_nazwe_sprzetu)>0)
    {
        while ($sprzet = mysqli_fetch_array($pobierz_nazwe_sprzetu))
        {
            $wydzial_sprzetu = $sprzet['id_jednoski'];
        }
    }

    return $wydzial_sprzetu;
}
function PobierzNrAsygnaty()
{
    $polaczenie = polaczenie_z_baza();
    $nr_asygnaty = '';

    $pobierz_nr_asygnaty = mysqli_query($polaczenie,"SELECT tresc FROM ustawienia WHERE id ='3'") or die("Blad przy pobierz_nr_asygnaty".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_nr_asygnaty)>0)
    {
        while ($asygnatanr = mysqli_fetch_array($pobierz_nr_asygnaty))
        {
            $nr_asygnaty = $asygnatanr['tresc'];
            // w przypadku gdy w bazie bedzie nr 0 zwieksz o 1 nr
            if($nr_asygnaty =='0')
            {
                AktualizujNrAsygnaty($nr_asygnaty);
            }
        }
    }
    else
    {
        $nr_asygnaty = "Blad przy pobraniu nr! usunieto rekord w bazie";
    }

    return $nr_asygnaty;
}

function PobierzNrProtokoluRozkompletowania()
{
    $polaczenie = polaczenie_z_baza();
    $nr_asygnaty = '';

    $pobierz_nr_asygnaty = mysqli_query($polaczenie,"SELECT tresc FROM ustawienia WHERE id ='4'") or die("Blad przy pobierz_nr_asygnaty".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_nr_asygnaty)>0)
    {
        while ($asygnatanr = mysqli_fetch_array($pobierz_nr_asygnaty))
        {
            $nr_asygnaty = $asygnatanr['tresc'];
            // w przypadku gdy w bazie bedzie nr 0 zwieksz o 1 nr
            if($nr_asygnaty =='0')
            {
                AktualizujNrAsygnaty($nr_asygnaty);
            }
        }
    }
    else
    {
        $nr_asygnaty = "Blad przy pobraniu nr! usunieto rekord w bazie";
    }

    return $nr_asygnaty;
}

function PobierzDateAsygnaty($id_asygnaty)
{
    $polaczenie = polaczenie_z_baza();
    $data_asygnaty = '';

    $pobierz_date_asygnaty = mysqli_query($polaczenie,"SELECT data_asygnaty FROM asygnata WHERE id ='$id_asygnaty'") or die("Blad przy pobierz_date_asygnaty".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_date_asygnaty)>0)
    {
        while ($asygnatadata = mysqli_fetch_array($pobierz_date_asygnaty))
        {
            $data_asygnaty = $asygnatadata['data_asygnaty'];
        }
    }

    return $data_asygnaty;
}

function SprawdzWydzialyAsygnata($id_sprzetu)
{

    $czy_zgodne = true;
    //$liczba_sprzetu = count($id_sprzetu);
    $ll = 0;
    foreach ($id_sprzetu as $nr_sprzetu)
    {
        $wydzialy[$ll] = PobierzWydzialSprzetu($nr_sprzetu);
        $ll++;
    }

    $liczba_wydzialow =  count($id_sprzetu);
    $wydzial_id = $wydzialy[0];
    for($i=1;$i<$liczba_wydzialow;$i++)
    {
        if ($wydzial_id!=$wydzialy[$i])
        {
            $czy_zgodne = false;
        }
    }
    return $czy_zgodne;
}
function AktualizujNrAsygnaty($wartosc)
{
    //zmienne
    $polaczenie = polaczenie_z_baza();
    $nr_aktualny = $wartosc;
    $nr_aktualny++;
    //zaktualizuj dane w bazie
    $zwieksz_nr_asygnaty = mysqli_query($polaczenie,"UPDATE ustawienia SET tresc = '$nr_aktualny' WHERE id = 3")
    or die("Blad przy zwieksz_nr_asygnaty".mysqli_error($polaczenie));

}
function AktualizujNrProtokolRozkompletowania($wartosc)
{
    //zmienne
    $polaczenie = polaczenie_z_baza();
    $nr_aktualny = $wartosc;
    $nr_aktualny++;
    //zaktualizuj dane w bazie
    $zwieksz_nr_asygnaty = mysqli_query($polaczenie,"UPDATE ustawienia SET tresc = '$nr_aktualny' WHERE id = 4")
    or die("Blad przy function AktualizujNrProtokolRozkompletowania".mysqli_error($polaczenie));

}
function WyslijNaMagazyn($id_sprzetu)
{
    
}

function PorownajNrAsygnat($id_asygnaty)
{
    $polaczenie = polaczenie_z_baza();
    $polaczenie2 = polaczenie_z_baza();

    $pobierz_nr_asygnaty_aktualny = mysqli_query($polaczenie,"SELECT nr_asygnaty, id_do FROM asygnata WHERE id = '$id_asygnaty'")
        or die("Blad przy pobierz_nr_asygnaty_aktualny".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_nr_asygnaty_aktualny)>0)
    {
        while ($asygnata_glowna = mysqli_fetch_array($pobierz_nr_asygnaty_aktualny))
        {
            $do_nazwa = PobierzNazweWydzialu($asygnata_glowna['id_do']);
            $aktualizuj_skladnik_asygnaty = mysqli_query($polaczenie2,"UPDATE asygnata_skladniki SET nr_asygnaty = '$asygnata_glowna[nr_asygnaty]', do = '$do_nazwa' WHERE id_asygnaty = '$id_asygnaty'")
                or die("Blad przy aktualizuj_skladnik_asygnaty".mysqli_error($polaczenie2));
        }
    }
}
function PobierzNazweDateSprzetuZRozkompletowania($id_protokolu)
{
    $polaczenie = polaczenie_z_baza();
    $nazwa_sprzetu[]='';
    $pobierz_nazwe_sprzetu_z_protkolu = mysqli_query($polaczenie,"SELECT nazwa_srodka_trwalego,data_protokolu,nr_ewidencyjny FROM rozkompletowanie WHERE id ='$id_protokolu'")
        or die("Blad przy pobierz_nazwe_sprzetu_z_protokolu".mysqli_query($polaczenie));
    while ($nazwa = mysqli_fetch_array($pobierz_nazwe_sprzetu_z_protkolu))
    {
        $nazwa_sprzetu[0] = $nazwa['nazwa_srodka_trwalego'];
        $nazwa_sprzetu[1] = $nazwa['data_protokolu'];
        $nazwa_sprzetu[2] = $nazwa['nr_ewidencyjny'];
    }

    return $nazwa_sprzetu;
}
function AktualizujRozkompletowanieSkladnik($id_rekordu_rozkompletowanie,$st_ewidencja_nr_ewidencyjny)
{
    $polaczenie = polaczenie_z_baza();
    $dodaj_numer_st = mysqli_query($polaczenie,"UPDATE rozkompletowanie_skladniki SET  nr_inwentarzowy_nowy = '$st_ewidencja_nr_ewidencyjny' WHERE id='$id_rekordu_rozkompletowanie'")
        or die("Blad przy dodaj_numer_st".mysqli_error($polaczenie));
}