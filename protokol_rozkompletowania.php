<?php
include 'config.php';
include 'funkcje/funkcje_ewidencja.php';
include 'funkcje/funkcje_historia.php';
include 'funkcje/funkcje_uzytkownicy.php';
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
$roz = trim($_REQUEST['roz']);
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



if($a=='dodaj')
{
    echo NaglowekStrony("Protokół rozkompletowania","Tworzenie dokumentu","Tworzenie protokołu rozkompletowania");
    echo "<table class='table table-bordered'><form method='post' action='protokol_rozkompletowania.php?a=zapisz_protokol'>";

        if($nrID=='') {


            $pobierz_dane_do_rozkompletowania = mysqli_query($polaczenie, "SELECT lp, nazwa_sprzetu,wartosc,jed_uzytkujaca,nr_inwentarzowy FROM baza WHERE lp = '$roz'")
            or die("Blad przy pobierz_dane_do_rozkompletowania" . mysqli_error($polaczenie));
            while ($dane_sprzetu = mysqli_fetch_array($pobierz_dane_do_rozkompletowania)) {
                $nr_protokolu_r = PobierzNrProtokoluRozkompletowania();
                $nr_protokolu_rozkompletowania = $nr_protokolu_r . "/" . date("Y");

                echo "<tr><th>Nr protokolu</th><td><input type='text' name='protokol_nr' class='form-control' value='$nr_protokolu_rozkompletowania'></td></tr>";
                echo "<tr><th>Data protokolu</th><td><input type='text' name='protokol_data' class='form-control' id = 'datepicker' value='$data_skrocona'></td></tr>";
                echo "<tr><th colspan='2' class='text-center text-bold'>KOMISJA</th></tr>";
                echo "<tr><th>Przewodniczący</th><td><select name='protokol_komisja_1' class='form-control'>";
                echo PobierzUzytkownikow();
                echo "</select></td></tr>";
                echo "<tr><th>Komisja 1:</th><td><select name='protokol_komisja_2' class='form-control'>";
                echo PobierzUzytkownikow();
                echo "</select></td></tr>";
                echo "<tr><th>Komisja 2:</th><td><select name='protokol_komisja_3' class='form-control'>";
                echo PobierzUzytkownikow();
                echo "</select></td></tr>";
                echo "<tr><th colspan='2' class='text-center text-bold'>ROZKOMPLETOWANIE SPRZĘT:($dane_sprzetu[lp])$dane_sprzetu[nr_inwentarzowy]</th></tr>";
                echo "<tr><th>Nazwa sprzętu:</th><td><input type='text' name='protokol_nazwa_glowna' value='$dane_sprzetu[nazwa_sprzetu]' class='form-control'></td></tr>";
                echo "<tr><th>Wartosc sprzętu</th><td><input type='text' name='protokol_wartosc_glowna' value='$dane_sprzetu[wartosc]' class='form-control'></td></tr>";
                echo "<tr><th>Na stanie</th><td><input type='text' name='protokol_na_stanie_glowna' value='$dane_sprzetu[jed_uzytkujaca]' class='form-control'></td></tr>";
                echo "<tr><th colspan='2'><input type='hidden' name='ewidencyjny' value='$dane_sprzetu[nr_inwentarzowy]'><input type='hidden' name='id_lpp' value='$dane_sprzetu[lp]'><input type='submit' value='Zapisz protokół i przejdź do dodania składników' class='btn btn-primary form-control'></th></tr>";            }
        }

    else {
        $pobierz_dane_do_rozkompletowania = mysqli_query($polaczenie, "SELECT lp, nazwa_sprzetu,wartosc,jed_uzytkujaca,nr_inwentarzowy FROM baza WHERE lp = '$roz'")
        or die("Blad przy pobierz_dane_do_rozkompletowania" . mysqli_error($polaczenie));
        while ($dane_sprzetu = mysqli_fetch_array($pobierz_dane_do_rozkompletowania)) {
            $nr_protokolu_r = PobierzNrProtokoluRozkompletowania();
            $nr_protokolu_rozkompletowania = $nr_protokolu_r . "/" . date("Y");

            echo "<tr><th>Nr protokolu</th><td><input type='text' name='protokol_nr' class='form-control' value='$nr_protokolu_rozkompletowania'></td></tr>";
            echo "<tr><th>Data protokolu</th><td><input type='text' name='protokol_data' class='form-control' id = 'datepicker' value='$data_skrocona'></td></tr>";
            echo "<tr><th colspan='2' class='text-center text-bold'>KOMISJA</th></tr>";
            echo "<tr><th>Przewodniczący</th><td><select name='protokol_komisja_1' class='form-control'>";
            echo PobierzUzytkownikow();
            echo "</select></td></tr>";
            echo "<tr><th>Komisja 1:</th><td><select name='protokol_komisja_2' class='form-control'>";
            echo PobierzUzytkownikow();
            echo "</select></td></tr>";
            echo "<tr><th>Komisja 2:</th><td><select name='protokol_komisja_3' class='form-control'>";
            echo PobierzUzytkownikow();
            echo "</select></td></tr>";
            echo "<tr><th colspan='2' class='text-center text-bold'>ROZKOMPLETOWANIE SPRZĘT:($dane_sprzetu[lp])$dane_sprzetu[nr_iwnwentarzowy]</th></tr>";
            echo "<tr><th>Nazwa sprzętu:</th><td><input type='text' name='protokol_nazwa_glowna' value='$dane_sprzetu[nazwa_sprzetu]' class='form-control'></td></tr>";
            echo "<tr><th>Wartosc sprzętu</th><td><input type='text' name='protokol_wartosc_glowna' value='$dane_sprzetu[wartosc]' class='form-control'></td></tr>";
            echo "<tr><th>Na stanie</th><td><input type='text' name='protokol_na_stanie_glowna' value='$dane_sprzetu[jed_uzytkujaca]' class='form-control'></td></tr>";
            echo "<tr><th colspan='2'><input type='hidden' name='ewidencyjny' value='$dane_sprzetu[nr_inwentarzowy]'><input type='hidden' name='id_lpp' value='$dane_sprzetu[lp]'><input type='submit' value='Zapisz protokół i przejdź do dodania składników' class='btn btn-primary form-control'></th></tr>";
        }
    }
    echo "</table></form>";

}
elseif ($a=='zapisz_protokol')
{
    echo NaglowekStrony("Protokół rozkompletowania","Tworzenie dokumentu","Dodawanie składników protokołu rozkompletowania");

    //dane z POST
    $protokol_nr=$_POST['protokol_nr'];
    $protokol_data =$_POST['protokol_data'];
    $protokol_komisja_1=$_POST['protokol_komisja_1'];
    $protokol_komisja_2=$_POST['protokol_komisja_2'];
    $protokol_komisja_3=$_POST['protokol_komisja_3'];
    $protokol_nazwa_glowna=$_POST['protokol_nazwa_glowna'];
    $protokol_wartosc_glowna=$_POST['protokol_wartosc_glowna'];
    $protokol_na_stanie_glowna=$_POST['protokol_na_stanie_glowna'];
    $protokol_id_lp = $_POST['id_lpp'];
    $protokol_ewidencyjny = $_POST['ewidencyjny'];

    $zapisz_protokol_glowny = mysqli_query($polaczenie,"INSERT INTO rozkompletowanie ( nr_protokolu, data_protokolu, czlonek_komisji_1, czlonek_komisji_2, czlonek_komisji_3,
    nazwa_srodka_trwalego, nr_ewidencyjny, wartosc_orginalna, jednostka_uzytkujaca_orginal,utworzyl,nr_protokolu2,typ_protokolu,dodatkowy_opis) 
    VALUES ('$protokol_nr','$protokol_data','$protokol_komisja_1','$protokol_komisja_2','$protokol_komisja_3','$protokol_nazwa_glowna','$protokol_ewidencyjny','$protokol_wartosc_glowna','$protokol_na_stanie_glowna',
    '$użytkownik_imie_nazwisko','$protokol_id_lp',0,'')")
    or die("Blad przy zapisz_protokol_glowny".mysqli_error($polaczenie));
    $nr_prot_nowy = mysqli_insert_id($polaczenie);

    echo "<table class='table table-bordered'><form method='post' action='protokol_rozkompletowania.php?a=zapisz_skladniki_roz'>";
    echo "<tr><th>Nazwa</th><td><input type='text' name='nazwa' class='form-control'></td></tr>";
    echo "<tr><th>Nr Seryjny</th><td><input type='text' name='seryjny' class='form-control'></td></tr>";
    echo "<tr><th>Wartosc</th><td><input type='text' name='wartosc' class='form-control'></td></tr>";
    echo "<tr><th>Jednostka po rozkompletowaniu</th><td><select name='jednostka' class='form-control'>";
    echo PobierzJednostki("Wybierz jednostke");
    echo "</select></td><input name='id_protokolu' value='$nr_prot_nowy'></tr>";
    echo "<tr><td colspan='2'><input type='submit' value='Dodaj składnik do protokołu' class='btn btn-warning'></td></tr>";


    echo "</form></table>";

}
elseif ($a=='zapisz_skladniki_roz')
{
    echo NaglowekStrony("Protokół rozkompletowania","Tworzenie dokumentu","Zapisywanie składników protokołu rozkompletowania");
var_dump($_POST);
Przekierowanie("Dodano do protokolu skladnik,","index.php");
}
elseif ($a=='edycja')
{
    echo NaglowekStrony("Protokół rozkompletowania","Edycja dokumentu","Edycja dokumentów");
    //var_dump($_POST);
    $pobierz_dane_rozkompletowanie = mysqli_query($polaczenie,"SELECT nr_protokolu,id,data_protokolu,czlonek_komisji_1,czlonek_komisji_2,czlonek_komisji_3,nr_ewidencyjny,nazwa_srodka_trwalego  FROM rozkompletowanie WHERE id='$nrID'")
        or die("Blad przy pobierz_dane_rozkompletowanie".mysqli_error($polaczenie));
    while ($protokol_glowny = mysqli_fetch_array($pobierz_dane_rozkompletowanie))
    {
        echo"<table class='table table-bordered'><form method='post' action='protokol_rozkompletowania.php?a=aktualizuj_protokol'>";
        echo"<tr><td>Nr protokolu:</ts><td><input type='text' name='nr_protokolu' value='$protokol_glowny[nr_protokolu]' class='form-control'><input type='hidden' name='id_protokolu' value='$protokol_glowny[id]'></td></tr>";
        echo"<tr><td>Data protokolu:</td><td><input type='text' name='data_protokolu' class='form-control' id='datepicker' value='$protokol_glowny[data_protokolu]'/></td></tr>";
        echo"<tr><td colspan='2' class='text-bold text-center'>KOMISJA</td></tr>";
        echo"<tr><td>Przewodniczący:</td><td><select name='czlonek_komisji_1' class='form-control'><option value='$protokol_glowny[czlonek_komisji_1]'>$protokol_glowny[czlonek_komisji_1]</option></select>";
        echo"<tr><td>Członek 1:</td><td><select name='czlonek_komisji_2' class='form-control'><option value='$protokol_glowny[czlonek_komisji_2]'>$protokol_glowny[czlonek_komisji_2]</option></select>";
        echo"<tr><td>Członek 2:</td><td><select name='czlonek_komisji_3' class='form-control'><option value='$protokol_glowny[czlonek_komisji_3]'>$protokol_glowny[czlonek_komisji_3]</option></select>";
        echo"<tr><td colspan='2'><input type='submit' value='Aktualizuj dane protokolu' class='btn btn-primary form-control'></td></tr>";
        echo"</form></table>";
        echo"<table class='table table-bordered'>";
        echo"<tr><td colspan='5' class='text-bold text-center'> ROZKOMPLETOWANIE:$protokol_glowny[nr_ewidencyjny] - $protokol_glowny[nazwa_srodka_trwalego] </td></tr>";

        $pobierz_skladniki_rozkompletowania = mysqli_query($polaczenie,"SELECT nazwa_wykomplet_sprzetu,wartosc_wykomplet_sprzetu,nr_inwentarzowy_nowy,id FROM rozkompletowanie_skladniki WHERE id_protokolu = '$protokol_glowny[id]'") or die("Blad przy pobierz_skladniki_rozkompletowania".mysqli_error($polaczenie));
        $liczba_skladnikow_rozkompletowania = mysqli_num_rows($pobierz_skladniki_rozkompletowania);
        echo"<tr><td colspan='5' class='text-center'>SKŁADNIKI PROTOKOŁU($liczba_skladnikow_rozkompletowania):</td></tr>";
        if($liczba_skladnikow_rozkompletowania>0)
        {
            echo "<tr><th>Nr inwetarzowy</th><th>Nazwa sprzetu</th><th>Wartośc</th><th>Akcja</th></tr>";
            while ($skladnik_rozkompletowania = mysqli_fetch_array($pobierz_skladniki_rozkompletowania))
            {
                $wartosc_format = number_format($skladnik_rozkompletowania['wartosc_wykomplet_sprzetu'],2,'.','');
                echo"<tr><td>$skladnik_rozkompletowania[nr_inwentarzowy_nowy]</td><td>$skladnik_rozkompletowania[nazwa_wykomplet_sprzetu]</td><td>$wartosc_format zł</td><td>
                <a HREF='protokol_rozkompletowania.php?a=edytuj_skladnik&id=$skladnik_rozkompletowania[id]' class='btn-xs btn-primary'>EDYTUJ</a>
                <a href='srodek_trwaly.php?a=dodaj&id=$skladnik_rozkompletowania[id]' class='btn-xs btn-success'>DODAJ DO BAZY</a>";
                if($liczba_skladnikow_rozkompletowania>1)
                {
                    echo "<a href='protokol_rozkompletowania.php?a=usun_skladnik&id=$skladnik_rozkompletowania[id]' class='btn-xs btn-info'>USUŃ</a>";
                }
                echo "</td></tr>";
                echo "<tr><td colspan='4'><a href='protokol_rozkompletowania.php?a=dodaj_skladnik&id=$protokol_glowny[id]' class='btn btn-danger form-control'>Dodaj kolejny składnik do protokołu $protokol_glowny[nr_protokolu]</a></td></tr>";
            }
        }
        echo"</table>";

    }

}

elseif ($a=='aktualizuj')
{

}
elseif ($a=='usun_skladnik')
{

}
elseif ($a=='akceptacja')
{

}
elseif ($a=='edytuj_skladnik')
{
    echo NaglowekStrony("Protokół rozkompletowania","Edycja składnika","Edycja składnika - PR");
    $pobierz_skladnik_rozkompletowania = mysqli_query($polaczenie,"SELECT 
    nr_inwentarzowy_nowy,
    jednostka_miary_wykomplet_sprzetu,
      nr_seryjny,
        nr_protokolu,
          wartosc_wykomplet_sprzetu,
            nazwa_wykomplet_sprzetu,
              model_dodatkowy_opis,
              jednostka_uzytkujaca
    FROM rozkompletowanie_skladniki WHERE id = '$nrID'")
    or die("Blad przy pobierz_skladnik_rozkompletowania".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_skladnik_rozkompletowania)>0)
    {
    echo "<table class='table table-bordered'><form method='post' action='protokol_rozkompletowania.php?a=zapisz_skladnik'>";
        while ($skladnik = mysqli_fetch_array($pobierz_skladnik_rozkompletowania))
        {
            $wartosc = number_format($skladnik['wartosc_wykomplet_sprzetu'],2,'.','');
            echo"<tr><th>Nazwa:</th><td><input type='text' name='nazwa' value='$skladnik[nazwa_wykomplet_sprzetu]' class='form-control'></td></tr>";
            echo"<tr><th>Opis dodatkowy:</th><td><input type='text' name='opis_dodatkowy' value='$skladnik[model_dodatkowy_opis]' class='form-control'></td></tr>";
            echo "<tr><th>Nr seryjny</th><td><input type='text' value='$skladnik[nr_seryjny]' class='form-control' name='nr_seryjny'></td></tr>";
            echo "<tr><th>Nr ewidencyjny nowy</th><td>$skladnik[nr_inwentarzowy_nowy]</td></tr>";
            echo "<tr><th>Jednostka miary</th><td><input type='text' name='jed_miary' value='$skladnik[jednostka_miary_wykomplet_sprzetu]' class='form-control'></td></tr>";
            echo "<tr><th>Wartość</th><td><input type='text' name='wartosc' value='$wartosc' class='form-control'></td></tr>";
            echo "<tr><th>Jednostka uzytkujaca po</th><td><select name='jednostka_uzytkujaca' class='form-control'>";
            echo PobierzJednostki($skladnik['jednostka_uzytkujaca']);
            echo"</select></td></tr>";
            echo"<tr><td colspan='2'><input type='hidden' name='id_rozkompletowanie_skladnik' value='$nrID'><input type='submit' value='Aktualizuj składnik' class='btn btn-warning form-control'></td></tr>";
            echo"</form></table>";
        }
    }

}
elseif ($a=='zapisz_skladnik')
{
    echo NaglowekStrony("Protokół rozkompletowania","Aktualizacja składnika","Aktualizacja składnika rozkompletowanie");
    //dane z POST
    $nazwa = addslashes($_POST['nazwa']);
    $opis_dodatkowy = addslashes($_POST['opis_dodatkowy']);
    $nr_seryjny = $_POST['nr_seryjny'];
    $jed_miary = $_POST['jed_miary'];
    $wartosc = $_POST['wartosc'];
    $jednostka_uzytkujaca = $_POST['jednostka_uzytkujaca'];
    $id_rozkompletowanie_skladnik = $_POST['id_rozkompletowanie_skladnik'];

    //zapis do bazy
    $aktualizuj_skladnik_rozkompletowania = mysqli_query($polaczenie,"UPDATE rozkompletowanie_skladniki SET model_dodatkowy_opis ='$opis_dodatkowy',jednostka_uzytkujaca='$jednostka_uzytkujaca',jednostka_miary_wykomplet_sprzetu='$jed_miary',
    wartosc_wykomplet_sprzetu='$wartosc',nazwa_wykomplet_sprzetu='$nazwa',nr_seryjny='$nr_seryjny' WHERE id = '$id_rozkompletowanie_skladnik'")
        or die("Blad przy aktualizuj_skladnik_rozkompletowania".mysqli_error($polaczenie));
    Przekierowanie("Zaktualizowano pomyślnie $nazwa, za chwilę zostaniesz przekierowany do Protokołów","protokol_rozkompletowania.php");

}
else
{
    echo NaglowekStrony("Protokół rozkompletowania","Lista dokumentów","Lista dokumentów");


    $pobierz_rozkompletowania = mysqli_query($polaczenie,"SELECT id,nr_protokolu,data_protokolu,akceptacja FROM rozkompletowanie ORDER BY id ASC ")
        or die("Blad przy pobierz_rozkompletowania: ".mysqli_error($polaczenie));
    echo "<table class='table table-bordered' id='example1'>";
    echo "<thead><tr><th>Nr protokołu</th><th>Data protokolu</th><th>Akcja</th></tr></thead>";
    if(mysqli_num_rows($pobierz_rozkompletowania)>0)
    {
        while ($protokol=mysqli_fetch_array($pobierz_rozkompletowania))
        {
            echo "<tr><td>$protokol[nr_protokolu]</td><td>$protokol[data_protokolu]</td><td><a href='protokol_rozkompletowania.php?a=edycja&id=$protokol[id]' class='btn-xs btn-info'>Edycja</a><a href='fpdf17/generuj_rozkompletowanie.php?a=generuj&id=$protokol[id]' class='btn-xs btn-success'>PDF</a></td></tr>";
        }
    }
    echo "</table>";

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
