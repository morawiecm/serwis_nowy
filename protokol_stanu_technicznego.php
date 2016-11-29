<?php
include 'config.php';
include 'funkcje/funkcje_ewidencja.php';
include 'funkcje/funkcje_historia.php';
include 'funkcje/funkcje_uzytkownicy.php';
include 'funkcje/funkcje_protokol_st.php';
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

include 'gora.php';
include 'pasek.php';
include 'menu.php';



if($a=='dodaj_do_koszyka')
{
    echo NaglowekStrony("Protokół Stanu technicznego","Dodanie do koszyka","Tworzenie nowego dokumentu.");
    if($nrID!='')
    {
        //deklaracja zmiennych
        $nr_inwentarzowy = '';
        $nr_fabryczny = '';
        $nazwa_sprzetu = '';
        $jednostka = '';
        $wartosc = '';
        $data_wprowadzenie = '';

        //Pobranie danych sprzetu
        $pobierz_dane_st = mysqli_query($polaczenie,"SELECT nr_inwentarzowy,nr_fabryczny,nazwa_sprzetu,id_jednoski,wartosc,data_wprowadzenia FROM baza WHERE lp ='$nrID'")
            or die("Blad przy pobierz_dane_st".mysqli_error($polaczenie));
        while ($sprzet = mysqli_fetch_array($pobierz_dane_st))
        {
            $nr_inwentarzowy = $sprzet['nr_inwentarzowy'];
            $nr_fabryczny = $sprzet['nr_fabryczny'];
            $nazwa_sprzetu = addslashes($sprzet['nazwa_sprzetu']);
            $jednostka = $sprzet['id_jednoski'];
            $wartosc = $sprzet['wartosc'];
            $data_wprowadzenie = $sprzet['data_wprowadzenia'];
        }
        //zapis informacji i dodanie do koszyka sprzetu
        $dodaj_do_koszyka_zapis = mysqli_query($polaczenie,"INSERT INTO protokoly_koszyk (id_usera, id_sprzetu, nr_ewidencyjny, nr_seryjny, nazwa_sprzetu, na_stanie, wartosc_poczatkowa, data_zakupu) 
        VALUES ('$uzytkownik_id','$nrID','$nr_inwentarzowy','$nr_fabryczny','$nazwa_sprzetu','$jednostka','$wartosc','$data_wprowadzenie')")
            or die("Blad przy dodaj_do_koszyka_zapis".mysqli_error($polaczenie));
       //komunikat dla użytkownika i przekierowanie do koszyka
        $komunikat =  "Dodano do koszyka: $nazwa_sprzetu. Nastąpi przekierowanie do koszyka";
        Przekierowanie($komunikat,"protokol_stanu_technicznego.php?a=koszyk");
    }
    else
    {
        Przekierowanie("Brak nr ID, dodanie niemożliwe. Spróbuj jeszcze raz","index.php");
    }

}
elseif($a=='koszyk')
{
    echo NaglowekStrony("Protokół Stanu technicznego","Koszyk","Tworzenie nowego dokumentu.");
    echo "<table class='table table-bordered'><form method='post' action='protokol_stanu_technicznego.php?a=formularz'> ";
    echo "<thead><tr><th>Nr seryjny</th><th>Nr inwentarzowy</th><th>Nazwa</th><th>Na stanie</th><th>Wybierz</th><th>Akcja</th></tr></thead>";
    //Pobranie zawartosci koszyka uzytkownika
    $pobierz_koszyk_uzytkownika = mysqli_query($polaczenie,"SELECT * FROM protokoly_koszyk WHERE id_usera = '$uzytkownik_id'") or die("Blad przy pobierz_koszyk_uzytkownika".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_koszyk_uzytkownika)>0)
    {
        while ($koszyk = mysqli_fetch_array($pobierz_koszyk_uzytkownika))
        {
            $na_stanie = PobierzNazweWydzialu($koszyk['na_stanie']);
            echo"<tr><td>$koszyk[nr_seryjny]</td><td>$koszyk[nr_ewidencyjny]</td><td>$koszyk[nazwa_sprzetu]</td><td>$na_stanie</td><td><input type='checkbox' name='id_sprzetu[]' value='$koszyk[id]'></td>
            <td><a href='protokol_stanu_technicznego.php?a=usun_z_koszyka&id=$koszyk[id]' class='btn-xs btn-danger'>USUŃ</a> </td></tr>";
        }
    }
    else
    {
        echo "<tr><td colspan=>Nie znaleziono nic w koszyku, dodaj jakiś element by utworzyć protokół</td></tr>";
    }
    echo "<p><input type='submit' value='Generuj protokół stanu techniczego' class='btn btn-info'></p>";
    echo "</form></table>";
}
elseif ($a=='edytuj')
{
    echo NaglowekStrony("Protokół Stanu Techniczniego","Edycja dokumentu","Edycja wpisów na dokumencie");
    //var_dump($_POST);
    $pobierz_dane_protokolu_glownego = mysqli_query($polaczenie, "SELECT * FROM protokol2 WHERE id ='$nrID'") or die("Blad przy pobierz_dane_protokolu_glownego".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_dane_protokolu_glownego)>0)
    {
        while ($edycja_protokol = mysqli_fetch_array($pobierz_dane_protokolu_glownego))
        {
            echo "<table class='table'><form method='post' action='protokol_stanu_technicznego.php?a=aktualizuj'>";
            echo "<tr><th>Nr protokołu</th><td><input type='text' name='protokol_nr' value='$edycja_protokol[nr_protokolu]' class='form-control'></td></tr>";
            echo "<tr><th>Data na protokole:</th><td><input type='text' name='protokol_data' id='datepicker' value='$edycja_protokol[data]' class='form-control'></td></tr>";
            echo "<tr><th>Koszt naprawy:</th><td><input type='text' name='protokol_koszt' value='$edycja_protokol[koszt_naprawy]' class='form-control'></td></tr>";
            echo "<tr><th>Stan techniczny</th><td><input type='text' name='protokol_stan_techniczny' value='$edycja_protokol[stan_techniczny]' class='form-control'></td></tr>";
            echo "<tr><th>Kategoria</th><td><input type='hidden' name='protokol_id' value='$nrID'><select name='protokol_kategoria' class='form-control'>
            <option value='$edycja_protokol[kategoria]' selected>$edycja_protokol[kategoria]</option>
            <option value='I - Sprzęt nowy'>I - Sprzęt nowy</option>
            <option value='II - Sprzęt używany nie wymagający naprawy'>II - Sprzęt używany nie wymagający naprawy</option>
            <option value='III - Sprzęt używany wymagający naprawy'>III - Sprzęt używany wymagający naprawy</option>
            <option value='IV - Przewidywany jednostkowy koszt remontu: koszt naprawy przekracza wartość rynkową - nieopłacalny'>IV - Przewidywany jednostkowy koszt remontu: koszt naprawy przekracza wartość rynkową - nieopłacalny</option>
            <option value='IV - Oprogramowanie przestarzałe nie spełnia wymogów Polityki Bezpieczeństwa'>IV - Oprogramowanie przestarzałe nie spełnia wymogów Polityki Bezpieczeństwa</option>
    </select></td></tr>";
            echo "<tr><th>Opinia co do dalszego przeznaczenia</th><td><input type='text' name='protokol_opinia' class='form-control' value='$edycja_protokol[opinia]'></td></tr>";
            echo "<tr><th rowspan='3'>Wybierz osoby do komisji: (Przy edycji należy wybrać ponownie)</th><td>1.<select name='protokol_komisja1' class='form-control'>";

            echo PobierzUzytkownikow();
            echo "</select></td></tr>";
            echo "<tr><td>2.<select name='protokol_komisja2' class='form-control'>";
            echo PobierzUzytkownikow();
            echo "</select></td></tr>";
            echo "<tr><td>3.<select name='protokol_komisja3' class='form-control'>";
            echo PobierzUzytkownikow();
            echo "</select></td></tr>";
            echo "<tr><td colspan='2'><input type='submit' value='Aktualizuj protokół' class='btn btn-warning form-control'></td></tr>";
            echo "</form></table>";
        }
    }



}

elseif ($a=='formularz')
{
    echo NaglowekStrony("Asygnata","Edycja dokumentu","Edycja wpisów na  dokumencie");
    //var_dump($_POST);
    //Dane z POST
    $nr_id_tab = $_POST['id_sprzetu'];
    $liczba_pozycji = count($nr_id_tab);

    //Formularz do wypelnieniea
    echo "<table class='table'><form method='post' action='protokol_stanu_technicznego.php?a=zapisz'>";
    echo "<tr><th>Data na protokole:</th><td><input type='text' name='protokol_data' id='datepicker' value='$data_skrocona' class='form-control'></td></tr>";
    echo "<tr><th>Koszt naprawy:</th><td><input type='text' name='protokol_koszt' value='nieoplacalny' class='form-control'></td></tr>";
    echo "<tr><th>Stan techniczny</th><td><input type='text' name='protokol_stan_techniczny' value='Uszkodzona elektronika' class='form-control'></td></tr>";
    echo "<tr><th>Kategoria</th><td><select name='protokol_kategoria' class='form-control'>
            <option value='I - Sprzęt nowy'>I - Sprzęt nowy</option>
            <option value='II - Sprzęt używany nie wymagający naprawy'>II - Sprzęt używany nie wymagający naprawy</option>
            <option value='III - Sprzęt używany wymagający naprawy'>III - Sprzęt używany wymagający naprawy</option>
            <option value='IV - Przewidywany jednostkowy koszt remontu: koszt naprawy przekracza wartość rynkową - nieopłacalny' selected>IV - Przewidywany jednostkowy koszt remontu: koszt naprawy przekracza wartość rynkową - nieopłacalny</option>
            <option value='IV - Oprogramowanie przestarzałe nie spełnia wymogów Polityki Bezpieczeństwa'>IV - Oprogramowanie przestarzałe nie spełnia wymogów Polityki Bezpieczeństwa</option>
    </select></td></tr>";
    echo "<tr><th>Opinia co do dalszego przeznaczenia</th><td><input type='text' name='protokol_opinia' class='form-control' value='zdjąć ze stanu, wybrakować, upłynnić lub wyzłomować'></td></tr>";
    echo "<tr><th rowspan='3'>Wybierz osoby do komisji:</th><td>1.<select name='protokol_komisja1' class='form-control'>";
    echo PobierzUzytkownikow();
    echo "</select></td></tr>";
    echo "<tr><td>2.<select name='protokol_komisja2' class='form-control'>";
    echo PobierzUzytkownikow();
    echo "</select></td></tr>";
    echo "<tr><td>3.<select name='protokol_komisja3' class='form-control'>";
    echo PobierzUzytkownikow();
    echo "</select></td></tr>";
    echo "<tr><td colspan='2'><input type='submit' value='Zapisz protokół' class='btn btn-primary form-control'></td></tr>";
    for ($i=0;$i<$liczba_pozycji;$i++)
    {
        echo "<input type='hidden' name='id_pozycja[]' value='$nr_id_tab[$i]'>";
    }
    echo"</form></table>";


}
elseif ($a=='usun_z_koszyka')
{
    if($nrID!='')
    {
        echo NaglowekStrony("Protokół Stanu technicznego","Koszyk - usuwanie pozycji","Usuwanie pozycji z koszyka.");
        //usuniecie pozycji z koszyka
        $usun_z_koszyka = mysqli_query($polaczenie,"DELETE FROM protokoly_koszyk WHERE id = '$nrID'")
            or die("Blad przy usun_z_koszyka".mysqli_error($polaczenie));
        Przekierowanie("Usunięto pozycję z koszyka, nastąpi przekierowanie","protokol_stanu_technicznego.php?a=koszyk");

    }
    else
    {
        Przekierowanie("Brak nr ID, dodanie niemożliwe. Spróbuj jeszcze raz","index.php");
    }
}
elseif ($a=='zapisz')
{
    echo NaglowekStrony("Protokół Stanu technicznego","Koszyk - zapisywanie porotokołu","Zapisywanie porotokołu do bazy");
    //var_dump($_POST);
    $nr_nowy_protokolu = PobierzNrProtokoluST();
    $numer_protokolu = $nr_nowy_protokolu."/".date("Y");

    //dane z POST do protokolu
    $protokol_data = $_POST['protokol_data'];
    $protokol_koszt = $_POST['protokol_koszt'];
    $protokol_stan_techniczny = $_POST['protokol_stan_techniczny'];
    $protokol_kategoria = $_POST['protokol_kategoria'];
    $protokol_opinia = $_POST['protokol_opinia'];
    $protokol_komisja1 = PobierzImieNazwisko($_POST['protokol_komisja1']);
    $protokol_komisja2 = PobierzImieNazwisko($_POST['protokol_komisja2']);
    $protokol_komisja3 = PobierzImieNazwisko($_POST['protokol_komisja3']);

    // skladniki protokolu
    $id_pozycja_tab = $_POST['id_pozycja'];
    $liczba_pozycji = count($id_pozycja_tab);

    //Zapisz protokol glowny
    $polaczenie2 = polaczenie_z_baza();
    $zapisz_protokol_glowny_st = mysqli_query($polaczenie2,"INSERT INTO protokol2 (id_protokolu, data, uzytkownik, komisja1, komisja2, komisja3, koszt_naprawy, kategoria, opinia, stan_techniczny, status_p,nr_protokolu)
      VALUES ('$nr_nowy_protokolu','$data_skrocona','$uzytkownik_nazwa','$protokol_komisja1','$protokol_komisja2','$protokol_komisja3','$protokol_koszt','$protokol_kategoria','$protokol_opinia','$protokol_stan_techniczny',6, '$numer_protokolu')")
        or die("Blad przy zapisz_protokol_glowny_st".mysqli_error($polaczenie2));
    $nr_nowy_protokolu_id = mysqli_insert_id($polaczenie2);
    //Zapisz skladniki protokolu
    for($ii = 0;$ii<$liczba_pozycji;$ii++)
    {
        $id_protokol_skladnik = $id_pozycja_tab[$ii];
        //Pobierz dane o sprzecie
        $pobierz_dane_z_rekordu = mysqli_query($polaczenie,"SELECT id_sprzetu FROM protokoly_koszyk WHERE id='$id_protokol_skladnik'") or die("Blad przy pobierz_dane_z_rekordu".mysqli_error($polaczenie));

            while ($dane = mysqli_fetch_array($pobierz_dane_z_rekordu))
            {
                $id_lp_skladnika = $dane['id_sprzetu'];
            }

        $pobierz_dane_sprzetu = mysqli_query($polaczenie,"SELECT nr_inwentarzowy_1,nr_inwentarzowy,nr_fabryczny,nazwa_sprzetu,wartosc,id_jednoski,data_wprowadzenia,lp FROM baza WHERE lp = '$id_lp_skladnika'") or die("Blad przy pobierz_dane_sprzetu".mysqli_error($polaczenie));
            while ($dane_sprzet = mysqli_fetch_array($pobierz_dane_sprzetu))
            {
                $nr_inwentarzowy = $dane_sprzet['nr_inwentarzowy'];
                if($nr_inwentarzowy=='')
                {
                    $nr_inwentarzowy = $dane_sprzet['nr_inwentarzowy_1'];
                }
                /*
                else
                {
                    if($dane_sprzet['nr_inwentarzowy_1']!='')
                    {
                        $nr_inwentarzowy = $dane_sprzet['nr_inwentarzowy'].", ".$dane_sprzet['nr_inwentarzowy_1'];
                    }
                }
                */
                $numer_seryjny = $dane_sprzet['nr_fabryczny'];
                $nazwa = addslashes($dane_sprzet['nazwa_sprzetu']);
                $wartosc = $dane_sprzet['wartosc'];
                $na_stanie = PobierzNazweWydzialu($dane_sprzet['id_jednoski']);
                $data_zakupu = $dane_sprzet['data_wprowadzenia'];
                $id_lpp = $dane_sprzet['lp'];

            }
        $zapisz_skladniki_protokolu_st = mysqli_query($polaczenie,"INSERT INTO protokol_skladniki (id_protokol, nr_ewidencyjny, nr_seryjny, nazwa, wartosc, na_stanie, data_zakupu, wybrakowano, kto_utworzyl, data_utworzenia, id_lp, nr_protokolu)
        VALUES ('$nr_nowy_protokolu_id','$nr_inwentarzowy','$numer_seryjny','$nazwa','$wartosc','$na_stanie','$data_zakupu','','$użytkownik_imie_nazwisko','$data_pelana','$id_lpp','$numer_protokolu')")
            or die("Blad przy zapisz_skladniki_protokolu_st".mysqli_error($polaczenie));

        //usuniecei pozycji z koszyka
        $usun_z_koszyka_skladnik = mysqli_query($polaczenie,"DELETE FROM protokoly_koszyk WHERE id = '$id_protokol_skladnik'") or die("Blad przy usun_z_koszyka_skladnik".mysqli_error($polaczenie));

    }

    ZwiekszNrProtokoluST($nr_nowy_protokolu);
Przekierowanie("Utworzono pomyślnie protokół $numer_protokolu, zostaniesz przeniesiony na stronę główną","index.php");
}
elseif ($a=='aktualizuj')
{
    echo NaglowekStrony("Protokól Stanu Technicznego","Aktualizacja dokumentu","Aktualizacja dokumentu");
    //var_dump($_POST);

    //Zrzut danych z POST
    $protokol_id = $_POST['protokol_id'];
    $protokol_nr = $_POST['protokol_nr'];
    $protokol_data = $_POST['protokol_data'];
    $protokol_koszt = $_POST['protokol_koszt'];
    $protokol_stan_techniczny = $_POST['protokol_stan_techniczny'];
    $protokol_kategoria  = $_POST['protokol_kategoria'];
    $protokol_opinia = $_POST['protokol_opinia'];
    $protokol_komisja1 = PobierzImieNazwisko($_POST['protokol_komisja1']);
    $protokol_komisja2 = PobierzImieNazwisko($_POST['protokol_komisja2']);
    $protokol_komisja3 = PobierzImieNazwisko($_POST['protokol_komisja3']);

    //aktualizacja danych w bazie

    $aktualizuj_protokol = mysqli_query($polaczenie,"UPDATE protokol2 SET nr_protokolu = '$protokol_nr', data = '$protokol_data', koszt_naprawy = '$protokol_koszt', stan_techniczny = '$protokol_stan_techniczny',
    kategoria = '$protokol_kategoria', opinia = '$protokol_opinia', komisja1 = '$protokol_komisja1', komisja2 = '$protokol_komisja2', komisja3 = '$protokol_komisja3' WHERE id = '$protokol_id'")
        or die("Blad przy aktualizuj_protokol".mysqli_error($polaczenie));
    Przekierowanie("Zaktualizowano pomyślnie protokół nr : $protokol_nr","protokol_stanu_technicznego.php");



}
elseif ($a=='usun_skladnik')
{
    echo NaglowekStrony("Protokól Stanu Technicznego","Lista dokumentów","Lista dokumentów");
    $usun_skladnik_z_bazy = mysqli_query($polaczenie,"DELETE FROM protokol_skladniki WHERE id = '$nrID'")
        or die("Blad przy usun_skladnik_z_bazy".mysqli_error($polaczenie));
    Przekierowanie("Usunueto protokol z bazy..","protokol_stanu_technicznego.php");

}
elseif ($a=='akceptacja')
{

}
else
{
    echo NaglowekStrony("Protokól Stanu Technicznego","Lista dokumentów","Lista dokumentów");
    echo "<p><a href='protokol_stanu_technicznego.php?a=koszyk' class='btn btn-info'>KOSZYK</a> </p>";
    echo "<table class='table table-bordered' id = 'example1'>";
    echo "<thead><tr><th>Nr Protokołu</th><th>Data utworzenia</th><th>Nr seryjny</th><th>Nr inwentarzowy</th><th>Nazwa</th><th>Akcja</th></tr></thead>";
    //Pobranie zawartosci koszyka uzytkownika
    $pobierz_koszyk_uzytkownika = mysqli_query($polaczenie,"SELECT protokol2.nr_protokolu,protokol2.data, RIGHT(protokol2.data,6) as rok, protokol_skladniki.nr_seryjny,protokol_skladniki.nr_ewidencyjny,
    protokol_skladniki.nazwa,protokol2.id,protokol2.id_protokolu, protokol_skladniki.id as ajdi 
    FROM protokol2 
    INNER JOIN protokol_skladniki ON protokol2.id = protokol_skladniki.id_protokol")
        or die("Blad przy pobierz_koszyk_uzytkownika".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_koszyk_uzytkownika)>0)
    {
        while ($protokol = mysqli_fetch_array($pobierz_koszyk_uzytkownika))
        {
            if($protokol['nr_protokolu']=='')
            {
                $rok = substr($protokol['rok'],0,3);
                $rok = $protokol['id_protokolu'].$rok;
            }
            echo"<tr><td>$protokol[nr_protokolu] $rok</td><td>$protokol[data]</td><td>$protokol[nr_seryjny]</td><td>$protokol[nr_ewidencyjny]</td><td>$protokol[nazwa]</td>
            <td><a href='protokol_stanu_technicznego.php?a=edytuj&id=$protokol[id]' class='btn-xs btn-warning'>EDYTUJ</a>
            <a href='fpdf17/generuj_protokol_st.php?a=generuj&id=$protokol[id]' class='btn-xs btn-success'>PDF</a>
            <a href='protokol_stanu_technicznego.php?a=usun_skladnik&id=$protokol[ajdi]' class='btn-xs btn-danger'>USUŃ</a></td></tr>";

            //AKCEPTACJA
            $rok ='';
        }
    }
    else
    {
        echo "<tr><td colspan='6'>Nie znaleziono nic w bazie, dodaj jakiś element by utworzyć protokół</td></tr>";
    }
    echo "</form></table>";

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
