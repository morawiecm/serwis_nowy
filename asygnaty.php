<?php
include 'config.php';
include 'funkcje/funkcje_ewidencja.php';
include 'funkcje/funkcje_historia.php';
check_login();
// dane uzytkownika z sesji
$user_data = get_user_data();
$uzytkownik_imie = $user_data['imie'];
$uzytkownik_nazwisko = $user_data['nazwisko'];
$uzytkownik_nazwa = $user_data['user_name'];
$uzytkownik_id = $user_data['user_id'];
$uzytkownik_wydzial = $user_data['wydzial'];
$uzytkownik_sekcja = $user_data['sekcja'];
$uzytkownik_uprawnienia = $user_data['specialne'];
$użytkownik_imie_nazwisko = $uzytkownik_imie . " " . $uzytkownik_nazwisko;
$data_pelana  = date("Y-m-d H:i:s");
$data_skrocona = date("Y-m-d");
//dane z POST


if ($uzytkownik_uprawnienia == 1) {
    $uprawienia = 'Administrator';
} else {
    $uprawienia = 'Użytkownik';
}

//print_r($_POST);
?>


<?php
include 'gora.php';
include 'pasek.php';
include 'menu.php';



if($a=='dodaj')
{
    echo NaglowekStrony("Asygnaty","Lista","Lista asygnat");

}
elseif ($a=='edycja')
{
    echo NaglowekStrony("Asygnata","Edycja dokumentu","Edycja wpsiów na  dokumencie");
    //var_dump($_POST);
    $id_sprzetu = $nrID;
    //$liczba_elementow = count($id_sprzetu);

    $pobierz_asygnate_edycja = mysqli_query($polaczenie, "SELECT data_asygnaty,nr_asygnaty,id_do,do,od,id_od,uwagi,id FROM asygnata WHERE id = '$id_sprzetu'")
        or die("Blad przy pobierz_asygnate_edycja".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_asygnate_edycja)>0)
    {
        while ($asygnata_edycja = mysqli_fetch_array($pobierz_asygnate_edycja))
        {
            echo "<table class='table table-bordered'><form method='post' action='asygnaty.php?a=aktualizuj'>";
            //Glowne elementy
            echo "<tr><th>Na stan:</th><td><select name='wydzial_od' class='form-control'>";
            echo PobierzJednostki($asygnata_edycja['od']);
            echo "</select> </td></tr>";
            echo "<tr><th>Na stan:</th><td><select name='wydzial_do' class='form-control'>";
            echo PobierzJednostki($asygnata_edycja['do']);
            echo "</select> </td></tr>";
            echo "<tr><th>Data dokumentu</th><td><input type='text' name='data_dokumentu' id='datepicker' value='$asygnata_edycja[data_asygnaty]' class='form-control datepicker'></td></tr>";
            echo "<tr><th>Uwagi:</th><td><textarea class='form-control' rows='6' name='uwagi'>$asygnata_edycja[uwagi]</textarea></td></tr>";
            echo "<input type='hidden' name='id_asygnaty_glownej' value='$asygnata_edycja[id]'/>";
            $i=0;
            echo "<tr><th class='text-center' colspan='2'>Skladniki Asygnaty:</th></tr>";
            //Elementy Asygnaty
            $pobierz_asygnate_skladniki_edycja = mysqli_query($polaczenie,"SELECT id,id_lp,uwaga FROM asygnata_skladniki WHERE id_asygnaty ='$id_sprzetu'")
                or die("Blad przy pobierz_asygnate_skladniki_edycja".mysqli_error($polaczenie));
            if(mysqli_num_rows($pobierz_asygnate_skladniki_edycja)>0)
            {
                while ($skladniki_asygnata_edycja = mysqli_fetch_array($pobierz_asygnate_skladniki_edycja))
                {
                    $i++;
                    $nazwa_sprzetu = PobierzNazweSprzetu($skladniki_asygnata_edycja['id_lp']);
                    echo "<tr><th>$i. $nazwa_sprzetu</th><input type='hidden' name='tablica_id[]' value='$skladniki_asygnata_edycja[id]'><td><a href='asygnaty.php?a=usun_skladnik&id=$skladniki_asygnata_edycja[id]' class=' btn btn-success'>
                    USUŃ SKŁADNIK</a></td></tr>";
                    echo "<tr><th>Uwaga:</th><td><input type='text' name='uwaga_osobno[]' value='$skladniki_asygnata_edycja[uwaga]' class='form-control'></td></tr>";
                }


            }
            echo "<tr><th colspan='2'><input type='submit' value='Aktualizuj Asygnate' class='btn btn-primary form-control'></th></tr>";
            echo "</form></table>";
        }
    }
}
elseif ($a=='aktualizuj')
{
    echo NaglowekStrony("Asygnata","Aktualizacja dokumentu","Aktualizacja wpisów w dokumencie");
    //dane z POST - asygnata glowna
    $id_asygnaty_glownej = $_POST['id_asygnaty_glownej'];
    $wydzial_od = $_POST['wydzial_od'];
    $wydzial_od_nazwa = PobierzNazweWydzialu($_POST['wydzial_od']);
    $wydzial_do = $_POST['wydzial_do'];
    $wydzial_do_nazwa = PobierzNazweWydzialu($_POST['wydzial_do']);
    $data_dokumentu = $_POST['data_dokumentu'];
    $uwagi = addslashes($_POST['uwagi']);
    //dane z POST - skladniki asygnaty
    $tablica_id = $_POST['tablica_id'];
    $uwaga_osobno = $_POST['uwaga_osobno'];
    $licznik_skladnikow = count($tablica_id);

    //aktualizacja asygnaty glownej
    $aktualizuj_asygnate_glowna = mysqli_query($polaczenie,"UPDATE asygnata SET data_asygnaty = '$data_dokumentu', uwagi = '$uwagi',id_od = $wydzial_od,id_do = '$wydzial_do',od = '$wydzial_od_nazwa', do = '$wydzial_do_nazwa' WHERE id = '$id_asygnaty_glownej'")
        or die("Blad przy aktualizuj_asygnate_glowna".mysqli_error($polaczenie));

    //aktualizacja skladnikow
    for ($i=0;$i<$licznik_skladnikow;$i++)
    {
        $id_rekordu = $tablica_id[$i];
        $uwagaosobno = $uwaga_osobno[$i];
        $aktualizuj_skladnik = mysqli_query($polaczenie,"UPDATE asygnata_skladniki SET uwaga = '$uwagaosobno' WHERE id = '$id_rekordu'")
            or die("Blad przy aktualizuj_skladnik".mysqli_error($polaczenie));
    }
    Przekierowanie("Zaktualizowano pomyślnie asygnatę. Nastąpi przekierowanie","asygnaty.php");

}
elseif ($a=='usun_skladnik')
{
    if($nrID!='')
    {
        echo NaglowekStrony("Asygnaty","Edycja","Usunięcie składnika z asygnaty");
        $usun_pozycje_z_asygnaty = mysqli_query($polaczenie,"DELETE FROM asygnata_skladniki WHERE id = '$nrID'")
            or die("Blad przy usun_pozycje_z_asygnaty".mysqli_error($polaczenie));
        Przekierowanie("Usunięto składnik asygnaty. Zostaniesz za chwilę przekierowany","asygnaty.php");
    }
}
elseif ($a=='akceptacja')
{
    if($nrID!='')
    {
        $uwaga_nowa = '';
        $uwaga_orginal = '';
        //aktualizacja skladnikow
        $zmien_wydzial_srodka_trwalego = mysqli_query($polaczenie,"SELECT id_asygnaty, nr_asygnaty, id_lp, uwaga, do, od FROM asygnata_skladniki WHERE id_asygnaty = '$nrID'")
            or die("Blad przy zmien_wydzial_srodkta_twalego".mysqli_error($polaczenie));
        if(mysqli_num_rows($zmien_wydzial_srodka_trwalego)>0)
        {
            echo NaglowekStrony("Asygnaty","Akceptacja","Zmiana Jednostki i Wydziału dla wskazanych elementów");
            //aktualizacja asygnaty tylko w przypadku jezeli asygnata posiada skladniki

            $aktualizauj_asygnate_akceptacja = mysqli_query($polaczenie,"UPDATE asygnata SET akceptacja = 1 WHERE id = '$nrID'")
            or die("Blad przy aktualizuj_asygnate_akceptacja".mysqli_error($polaczenie));
            PorownajNrAsygnat($nrID);

            while ($asygnata_skladnik = mysqli_fetch_array($zmien_wydzial_srodka_trwalego))
            {
                $id_do = PobierzNumerWydzialu("$asygnata_skladnik[do]");
                //Pobranie pola uwagi z bazy
                $pobierz_pole_uwaga_baza = mysqli_query($polaczenie,"SELECT uwagi,notatki FROM baza WHERE lp = '$asygnata_skladnik[id_lp]'")
                    or die("Blad przy pobierz_pole_uwaga_baza".mysqli_error($polaczenie));
                while ($pole_uwaga = mysqli_fetch_array($pobierz_pole_uwaga_baza))
                {
                    $uwaga_orginal = $pole_uwaga['uwagi']." ".$pole_uwaga['notatki'];
                    $uwaga_orginal = addslashes($uwaga_orginal);

                }

                $data_asygnaty = PobierzDateAsygnaty($nrID);
                $wydzial_orginal = PobierzWydzialSprzetu($asygnata_skladnik['id_lp']);
                $wydzial_orginal = PobierzNazweWydzialu($wydzial_orginal);

                $uwaga_nowa = $uwaga_orginal.".Utworzono Asygnatę o nr: ".$asygnata_skladnik['nr_asygnaty']." dnia: ".$data_asygnaty." na podstawie której przepisano z Jednostki/Wydziału: ".$wydzial_orginal.
                    " na Jednostkę/Wydział: ".$asygnata_skladnik['do'];
                if($asygnata_skladnik['uwaga']!='')
                {
                    $uwaga_nowa.=". Informacja dodatkowa: ".$asygnata_skladnik['uwaga'].".";
                }
                $zmien_dane_w_bazie = mysqli_query($polaczenie,"UPDATE baza SET id_jednoski = '$id_do', uwagi = '$uwaga_nowa', notatki = '' WHERE lp = '$asygnata_skladnik[id_lp]'")
                    or die("Blad przy zmien_dane_w_bazie".mysqli_error($polaczenie));
                // zapis w historii                 $id_srodka_trwalego, $kod, $tresc_problem, $data_wpisu, $kto_wpisal,$tresc_rozwiazanie, $dokument, $informacje_dodatkowe, $nr_inwentarzowy, $nr_inwentarzowy2, $uzytkownik_wydzial
                Historia($asygnata_skladnik['id_lp'],9,$asygnata_skladnik['do'],$data_pelana,$użytkownik_imie_nazwisko,$asygnata_skladnik['od'],$asygnata_skladnik['nr_asygnaty'],$nrID,'','',$uzytkownik_wydzial." - ".$uzytkownik_sekcja);
                //Przekieruj uzytkownika w razie powodzenia
            }
                Przekierowanie("Zaktualizowano wszystkie wpisy umieszone na dokumencie","asygnaty.php");
        }
        else
        {
            echo NaglowekStrony("Asygnaty","Akceptacja","Bład przy zmianie stanu");

            Przekierowanie("Bład ! asygnata nie posiada składników dodaj jakiś!","asygnaty.php");
        }


    }
    else
    {
        Przekierowanie("Błedny nr ID, spróbuj jeszcze raz","asygnaty.php");
    }
}
else
{
    echo NaglowekStrony("Asygnaty","Lista","Lista asygnat");
    //przyciski nad zakladkami

    echo "<p><a href='asygnata_koszyk.php' class='btn btn-primary'>Przejdz do koszyka</a> </p>";

    //zakladki deklaracja
    echo '<div class="nav-tabs-custom">';
    echo '<ul class="nav nav-tabs">';
    //echo "<li class='active'><a href='#tab_0' data-toggle='tab'>Koszyk</a></li>";
    echo "<li class='active'><a href='#tab_1' data-toggle='tab'>Niezakceptowane</a></li>";
    echo "<li><a href='#tab_2' data-toggle='tab'>Zakceptowane</a></li>";
    echo "<li><a href='#tab_3' data-toggle='tab'>Wszystkie</a></li>";
    echo '</ul>';

    //konec deklaracji zakldki

    //zakladki
    echo '<div class="tab-content">';

    //zakladka niezakceptowane
    echo'<div class="tab-pane active" id="tab_1">';
    echo"<table class='table table-bordered'>";
    echo "<thead><tr><th>NR ASYGNATY</th><th>WYDZIAŁ</th><th>DATA</th><th>AKCJA</th></tr></thead>";

    $pobierz_asygnaty_nieazakceptowane = mysqli_query($polaczenie, "SELECT data_asygnaty,nr_asygnaty, do,id FROM asygnata WHERE akceptacja = 0")
        or die("Blad przy pobierz_asygnaty_nizakceptowane".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_asygnaty_nieazakceptowane)>0)
    {
        while ($niezaakceptowane = mysqli_fetch_array($pobierz_asygnaty_nieazakceptowane))
        {
            echo "<tr><td>$niezaakceptowane[nr_asygnaty]</td><td>$niezaakceptowane[do]</td><td>$niezaakceptowane[data_asygnaty]</td>
            <td><a href='./fpdf17/generuj_asygnate.php?id=$niezaakceptowane[id]' class='btn btn-success'>POKAŻ</a>
            <a href='asygnaty.php?a=edycja&id=$niezaakceptowane[id]' class='btn btn-info'>EDYTUJ</a>
            <a href='asygnaty.php?a=usun&id=$niezaakceptowane[id]' class='btn btn-danger'>USUŃ</a>
            <a href='asygnaty.php?a=akceptacja&id=$niezaakceptowane[id]' class='btn bg-teal'>AKCEPTACJA</a>
            </td></tr>";
        }
    }
    else
    {
        echo "<tr><td colspan='4'>Brak asygnat do zakceptowania</td></tr>";
    }

    echo "</table>";
    echo '</div>';
    //koniec - zakladka niezakceptowane

    //zakladka zakceptowane
    echo'<div class="tab-pane" id="tab_2">';
    echo"<table class='table table-bordered'>";
    echo "<thead><tr><th>NR ASYGNATY</th><th>WYDZIAŁ</th><th>DATA</th><th>AKCJA</th></tr></thead>";

    $pobierz_asygnaty_zaakceptowane = mysqli_query($polaczenie, "SELECT data_asygnaty,nr_asygnaty, do,id FROM asygnata WHERE akceptacja = 1")
    or die("Blad przy pobierz_asygnaty_zaakceptowane".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_asygnaty_zaakceptowane)>0)
    {
        while ($niezaakceptowane = mysqli_fetch_array($pobierz_asygnaty_zaakceptowane))
        {
            echo "<tr><td>$niezaakceptowane[nr_asygnaty]</td><td>$niezaakceptowane[do]</td><td>$niezaakceptowane[data_asygnaty]</td>
            <td><a href='./fpdf17/generuj_asygnate.php?id=$niezaakceptowane[id]' class='btn btn-success'>POKAŻ</a>
            <a href='asygnaty.php?a=edycja&id=$niezaakceptowane[id]' class='btn btn-info'>EDYTUJ</a>
            <a href='asygnaty.php?a=usun&id=$niezaakceptowane[id]' class='btn btn-danger'>USUŃ</a>
            </td></tr>";
        }
    }
    else
    {
        echo "<tr><td colspan='4'>Brak asygnat zakceptowanych</td></tr>";
    }

    echo "</table>";
    echo '</div>';
    //koniec - zakladka zakceptowane

    //zakladka wszystkie
    echo'<div class="tab-pane" id="tab_3">';
    echo"<table class='table table-bordered'>";
    echo "<thead><tr><th>NR ASYGNATY</th><th>WYDZIAŁ</th><th>DATA</th><th>AKCJA</th></tr></thead>";

    $pobierz_asygnaty_wszystkie = mysqli_query($polaczenie, "SELECT data_asygnaty,nr_asygnaty, do,id,akceptacja FROM asygnata")
    or die("Blad przy pobierz_asygnaty_wszystkie".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_asygnaty_wszystkie)>0)
    {
        while ($niezaakceptowane = mysqli_fetch_array($pobierz_asygnaty_wszystkie))
        {
            echo "<tr><td>$niezaakceptowane[nr_asygnaty]</td><td>$niezaakceptowane[do]</td><td>$niezaakceptowane[data_asygnaty]</td>
            <td><a href='./fpdf17/generuj_asygnate.php?id=$niezaakceptowane[id]' class='btn btn-success'>POKAŻ</a>
            <a href='asygnaty.php?a=edycja&id=$niezaakceptowane[id]' class='btn btn-info'>EDYTUJ</a>
            <a href='asygnaty.php?a=usun&id=$niezaakceptowane[id]' class='btn btn-danger'>USUŃ</a>";
            if($niezaakceptowane['akceptacja'] == 0)
            {
                echo "<a href='asygnaty.php?a=akceptacja&id=$niezaakceptowane[id]' class='btn bg-teal'>AKCEPTACJA</a>";
            }
            echo "</td></tr>";
        }
    }
    else
    {
        echo "<tr><td colspan='4'>Brak asygnat w systemie</td></tr>";
    }

    echo "</table>";
    echo '</div>';
    //koniec - zakladka wszystkie

    echo '</div>';

}
?>


            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include'dol.php'; ?>
