<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-05-31
 * Time: 10:51
 */



function pobierzStatusPrzepustek()
{
    $polaczenie=polaczenie_z_baza();
    $liczbaUzytychPolicjant=0;
    $liczbaWszystkichPolicjant=0;
    $liczbaUzytychEmeryt=0;
    $liczbaWszystkichEmeryt=0;
    $liczbaUzytychRezerwa=0;
    $liczbaWszystkichRezerwa=0;
    $dane= array(6);

    $pobierzPrzepustki=mysqli_query($polaczenie,"SELECT numer_grupy, uzycie FROM przepustka");

    if(mysqli_num_rows($pobierzPrzepustki)>0)
    {
        while ($status=mysqli_fetch_array($pobierzPrzepustki))
        {
            if($status['numer_grupy']==1)
            {
                $liczbaWszystkichPolicjant++;
                if($status['uzycie']==1)
                {
                    $liczbaUzytychPolicjant++;
                }
            }
            elseif($status['numer_grupy']==2)
            {
                $liczbaWszystkichEmeryt++;
                if($status['uzycie']==1)
                {
                    $liczbaUzytychEmeryt++;
                }
            }
            elseif($status['numer_grupy']==3)
            {
                $liczbaWszystkichRezerwa++;
                if($status['uzycie']==1)
                {
                    $liczbaUzytychRezerwa++;
                }
            }
        }
    }
    $dane[0]="$liczbaUzytychPolicjant";
    $dane[1]="$liczbaWszystkichPolicjant";
    $dane[2]="$liczbaUzytychEmeryt";
    $dane[3]="$liczbaWszystkichEmeryt";
    $dane[4]="$liczbaUzytychRezerwa";
    $dane[5]="$liczbaWszystkichRezerwa";
return $dane;
}

function pobierzLiczbeOdwiedzajacyh()
{
    $polaczenie = polaczenie_z_baza();
    $liczbaOdwiedzajacych = mysqli_query($polaczenie,"SELECT id FROM odwiedziny WHERE godzina_wyjscia = '0000-00-00 00:00:00'");
    $odwiedzajacych=mysqli_num_rows($liczbaOdwiedzajacych);
return $odwiedzajacych;
}

function pobierzNazwePrzepustki($id_przepustki)
{
    $polaczenie=polaczenie_z_baza();
    $pobierzDanePrzepustki=mysqli_query($polaczenie,"SELECT nazwa FROM przepustka WHERE id='$id_przepustki'");
    if(mysqli_num_rows($pobierzDanePrzepustki)>0) {
        while ($przepustkaDane = mysqli_fetch_array($pobierzDanePrzepustki)) {
            $przepustka_nazwa = $przepustkaDane['nazwa'];
        }
    }
    return $przepustka_nazwa;
}

function pobierzDaneInteresanta($id_interesanta)
{
    $polaczenie=polaczenie_z_baza();
    $pobierzDaneInt=mysqli_query($polaczenie,"SELECT nr_telefonu FROM interesant_dokument WHERE id_interesanta= '$id_interesanta' ORDER BY data_dodania ASC LIMIT 1");
    if(mysqli_num_rows($pobierzDaneInt)>0)
    {
        while ($dane_int=mysqli_fetch_array($pobierzDaneInt))
        {
            $daneInteresanta=$dane_int['nr_telefonu'];
        }
    }
    return $daneInteresanta;
}

function pobierzDanePrzepustki($id_przepustki)
{
    $polaczenie= polaczenie_z_baza();
    $nazwa_przepustki='';
    $pobierzDanePrzepustki=mysqli_query($polaczenie,"SELECT nazwa FROM przepustka WHERE  id='$id_przepustki'");
    {
        if(mysqli_num_rows($pobierzDanePrzepustki)>0)
        {
            while ($dane_przepustki=mysqli_fetch_array($pobierzDanePrzepustki))
            {
                $nazwa_przepustki=$dane_przepustki['nazwa'];
            }
        }
    }
    return $nazwa_przepustki;
}
