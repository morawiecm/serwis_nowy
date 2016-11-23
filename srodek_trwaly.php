<?php
include 'config.php';
include 'funkcje/funkcje_ewidencja.php';
include 'funkcje/funkcje_naklejka.php';
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
$data_aktualna_pelna = date("Y-m-d H:i:s");
$data_aktualna_skrocona = date("Y-m-d");
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
?>

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dodanie nowego
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Ewidencja - dodanie nowego składnika</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                if($a=='dodaj')
                {
                    echo"<table class='table table-bordered table-striped'><form action='srodek_trwaly.php?a=zapisz' method='post'>";
                    echo "<tr><th>Nazwa</th><td><input type='text' name='ewidencja_nazwa' class='form-control'></td></tr>";
                    echo "<tr><th>Nr Ewidencyjny</th><td><input type='text' name='ewidencja_nr_ewidencyjny' class='form-control'></td></tr>";
                    echo "<tr><th>Nr Seryjny</th><td><input type='text' name='ewidencja_nr_seryjny' class='form-control'></td></tr>";
                    echo "<tr><th>Wartość</th><td><input type='text' name='ewidencja_wartosc' class='form-control'></td></tr>";
                    echo "<tr><th>Jednostka miary</th><td><input type='text' name='ewidencja_jednostka_miary' class='form-control' value='szt.'></td></tr>";
                    echo "<tr><th>Jednostka Użytkująca</th><td><select name='ewidencja_jednostka_uzytkujaca' class='form-control'>";
                    echo PobierzJednostki('Wybierz z listy');
                    echo "</select></td></tr>";
                    echo "<tr><th>Rodzaj Ewidencji</th><td><select name='ewidencja_rodzaj_ewidencyjny' class='form-control'>";
                    echo PobierzRodzajEwidencji('Wybierz z listy');
                    echo"</select></td></tr>";
                    echo "<tr><th>Źródło Finansowania</th><td><select name='ewidencja_zrodlo_finansowania' class='form-control'>";
                    echo PobierzZrodloFinasowania('Wybierz z listy');
                    echo"</select></td></tr>";
                    echo "<tr><th>Data Przyjęcia</th><td><input type='text' name='ewidencja_data_przyjecia' class='form-control' id='datepicker'></td></tr>";
                    echo "<tr><th>Notatki/Uwagi</th><td><textarea name='ewidencja_uwagi' class='form-control'></textarea></td></tr>";
                    echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapis' value='Dodaj do ewidencji' class='btn btn-danger form-control'></th></tr>";
                    echo"</form></table>";
                }

                elseif ($a=='zapisz')
                {
                    if(isset($_POST['przycisk_zapis']))
                    {
                        //dane  z POST
                        $st_ewidencja_nazwa = trim($_POST['ewidencja_nazwa']);
                        $st_ewidencja_nr_ewidencyjny = trim($_POST['ewidencja_nr_ewidencyjny']);
                        $st_ewidencja_nr_seryjny = trim($_POST['ewidencja_nr_seryjny']);
                        $st_ewidencja_wartosc = trim($_POST['ewidencja_wartosc']);
                        $st_ewidencja_jednostka_miary = trim($_POST['ewidencja_jednostka_miary']);
                        $st_ewidencja_jednostka_uzytkujaca = trim($_POST['ewidencja_jednostka_uzytkujaca']);
                        $st_ewidencja_rodzaj_ewidencyjny = trim($_POST['ewidencja_rodzaj_ewidencyjny']);
                        $st_ewidencja_zrodlo_finansowania = trim($_POST['ewidencja_zrodlo_finansowania']);
                        $st_ewidencja_data_przyjecia = $_POST['ewidencja_data_przyjecia'];
                        $st_ewidencja_uwagi = trim(addslashes($_POST['ewidencja_uwagi']));

                        // dodanie nowego srodka do bazy danych
                        $zapisz_nowy_srodek = mysqli_query($polaczenie,"INSERT INTO baza (nr_inwentarzowy, nr_fabryczny, nazwa_sprzetu,
                        wartosc, jed_miary, jed_uzytkujaca, uwagi,id_jednoski, data_wprowadzenia, zrodlo_finansowania, rodzaj_ewidencyjny)
                        VALUES ('$st_ewidencja_nr_ewidencyjny','$st_ewidencja_nr_seryjny','$st_ewidencja_nazwa','$st_ewidencja_wartosc','$st_ewidencja_jednostka_miary','$st_ewidencja_jednostka_uzytkujaca','$st_ewidencja_uwagi',
                        '$st_ewidencja_jednostka_uzytkujaca','$st_ewidencja_data_przyjecia','$st_ewidencja_zrodlo_finansowania','$st_ewidencja_rodzaj_ewidencyjny')")
                        or die("Blad przy  zapisz_nowy_srodek".mysqli_error($polaczenie));

                        //zamawianie automatyczne naklejki
                        $st_dodane_id = mysqli_insert_id($polaczenie);
                        ZamowNaklejke($st_dodane_id);

                        //stwórz zapis w histori
                        Historia("$st_dodane_id",7,"$st_ewidencja_nazwa","$data_aktualna_pelna","$użytkownik_imie_nazwisko","","","","$st_ewidencja_nr_ewidencyjny","","$uzytkownik_wydzial - $uzytkownik_sekcja");

                        //po dodaniu przekieruj do drukowania naklejki
                        Przekierowanie("Dodano pomyślnie: $st_ewidencja_nazwa o numerze_ewidencyjnym $st_ewidencja_nr_ewidencyjny. Zostaniesz przekierowany do naklejek","naklejka.php");
                    }
                    else
                    {
                        echo Przekierowanie("Bład nie powinno cię tu być, spróbuj ponownie","index.php");
                    }
                }

                elseif($a=='edytuj')
                {
                    if($nrID!='')
                    {

                        $pobierz_dane_ewidencyjne = mysqli_query($polaczenie, "SELECT nr_inwentarzowy, nazwa_sprzetu, nr_fabryczny, wartosc, jed_miary,
                        id_jednoski, zrodlo_finansowania, rodzaj_ewidencyjny, data_wprowadzenia, uwagi, notatki 
                        FROM baza WHERE lp = '$nrID'")
                            or die("Bład przy pobierz_dane_ewidencyjne".mysqli_error($polaczenie));
                        if(mysqli_num_rows($pobierz_dane_ewidencyjne)>0)
                        {
                            while ($dane = mysqli_fetch_array($pobierz_dane_ewidencyjne))
                            {
                                $pole_uwaga = stripslashes($dane['uwagi']."".$dane['notatki']);
                                echo"<table class='table table-bordered table-striped'><form action='srodek_trwaly.php?a=aktualizuj' method='post'>";
                                echo "<tr><th>Nazwa</th><td><input type='text' name='ewidencja_nazwa' class='form-control' value='$dane[nazwa_sprzetu]'></td></tr>";
                                echo "<tr><th>Nr Ewidencyjny</th><td><input type='text' name='ewidencja_nr_ewidencyjny' class='form-control' value='$dane[nr_inwentarzowy]'></td></tr>";
                                echo "<tr><th>Nr Seryjny</th><td><input type='text' name='ewidencja_nr_seryjny' class='form-control' value='$dane[nr_fabryczny]'></td></tr>";
                                echo "<tr><th>Wartość</th><td><input type='text' name='ewidencja_wartosc' class='form-control' value='$dane[wartosc]'></td></tr>";
                                echo "<tr><th>Jednostka miary</th><td><input type='text' name='ewidencja_jednostka_miary' class='form-control' value='$dane[jed_miary]'></td></tr>";
                                echo "<tr><th>Jednostka Użytkująca</th><td><select name='ewidencja_jednostka_uzytkujaca' class='form-control'>";
                                echo PobierzJednostki($dane['id_jednoski']);
                                echo "</select></td></tr>";
                                echo "<tr><th>Rodzaj Ewidencji</th><td><select name='ewidencja_rodzaj_ewidencyjny' class='form-control'>";
                                echo PobierzRodzajEwidencji($dane['rodzaj_ewidencyjny']);
                                echo"</select></td></tr>";
                                echo "<tr><th>Źródło Finansowania</th><td><select name='ewidencja_zrodlo_finanosowania' class='form-control'>";
                                echo PobierzZrodloFinasowania($dane['zrodlo_finansowania']);
                                echo"</select></td></tr>";
                                echo "<tr><th>Data Przyjęcia</th><td><input type='text' name='ewidencja_data_przyjecia' class='form-control' id='datepicker' value='$dane[data_wprowadzenia]'></td></tr>";
                                echo "<tr><th>Uwagi/Notatki</th><td><textarea name='ewidencja_uwagi' class='form-control' rows='8'>$pole_uwaga</textarea></td></tr>";
                                echo "<tr><th colspan='2'><input type='hidden' value='$nrID' name='ewidencja_id_st'><input type='submit' name='przycisk_aktualizuj' value='Aktualizuj wpis w ewidencji' class='btn btn-warning form-control'></th></tr>";
                                echo"</form></table>";
                            }
                        }
                        else
                        {
                            echo Przekierowanie("Błedny nr ID (ewidencyjny), spróbuj ponownie","index.php");
                        }

                    }
                    else
                    {
                        echo Przekierowanie("Brak nr ID ewidycyjnego, spróbuj ponownie","index.php");
                    }

                }

                elseif($a=='wydzialy')
                {
                    $zapytanie_pobierz_wydzialy = "SELECT id, nazwa,kod_jednostki FROM jednostki WHERE aktywny = 0 AND kod_jednostki NOT LIKE  '666'";
                    $pobierz_wydzialy_stan = mysqli_query($polaczenie,$zapytanie_pobierz_wydzialy) or die("Blad przy pobierz_wydzialy_stan".mysqli_query($polaczenie));
                    if(mysqli_num_rows($pobierz_wydzialy_stan)>0)
                    {
                        echo "<table class='table table-bordered' id='example1'>";
                        echo "<thead><tr><th>Nazwa jednostki</th><th>Kod jednostki</th><th>Akcja</th></tr></thead>";
                        while ($wydzialy_stan = mysqli_fetch_array($pobierz_wydzialy_stan))
                        {
                            $stan_wydzialu = PoliczStanWydzialu($wydzialy_stan['id']);
                            echo "<tr><td>$wydzialy_stan[nazwa]</td><td>$wydzialy_stan[kod_jednostki]</td>
                            <td>
                            <a href='export_wydzial.php?id=$wydzialy_stan[id]' class='btn-xs btn-success'>Export do Excela</a>
                            </td></tr>";
                        }
                        echo "</table>";
                        //<a href='srodek_trwaly.php?a=pokaz_wydzial&id=$wydzialy_stan[id]' class='btn-xs btn-primary'>Pokaz Wydział</a>
                    }
                }
                elseif ($a=='pokaz_wydzial')
                {
                    if($nrID!='')
                    {

                    }
                    else
                    {
                        echo Przekierowanie("Nie wybrano wydziału / jednostki, spróbuj ponownie","srodek_trwaly.php?a=wydzialy");
                    }
                }



                elseif ($a=='aktualizuj')
                {

                        if(isset($_POST['przycisk_aktualizuj']))
                        {
                            //dane  z POST
                            $st_ewidencja_nazwa = trim($_POST['ewidencja_nazwa']);
                            $st_ewidencja_nr_ewidencyjny = trim($_POST['ewidencja_nr_ewidencyjny']);
                            $st_ewidencja_nr_seryjny = trim($_POST['ewidencja_nr_seryjny']);
                            $st_ewidencja_wartosc = trim($_POST['ewidencja_wartosc']);
                            $st_ewidencja_jednostka_miary = trim($_POST['ewidencja_jednostka_miary']);
                            $st_ewidencja_jednostka_uzytkujaca = trim($_POST['ewidencja_jednostka_uzytkujaca']);
                            $st_ewidencja_rodzaj_ewidencyjny = trim($_POST['ewidencja_rodzaj_ewidencyjny']);
                            $st_ewidencja_zrodlo_finansowania = trim($_POST['ewidencja_zrodlo_finanosowania']);
                            $st_ewidencja_data_przyjecia = $_POST['ewidencja_data_przyjecia'];
                            $st_ewidencja_uwagi = trim(addslashes($_POST['ewidencja_uwagi']));
                            $st_id_st = $_POST['ewidencja_id_st'];

                            // aktualizacja danych
                            $aktualizacja_srodka_trwalego = mysqli_query($polaczenie,"UPDATE baza SET 
                            nr_inwentarzowy = '$st_ewidencja_nr_ewidencyjny',
                            nazwa_sprzetu = '$st_ewidencja_nazwa', 
                            data_wprowadzenia = '$st_ewidencja_data_przyjecia', 
                            id_jednoski = '$st_ewidencja_jednostka_uzytkujaca', 
                            jed_miary = '$st_ewidencja_jednostka_miary', 
                            zrodlo_finansowania = '$st_ewidencja_zrodlo_finansowania',
                            nr_fabryczny = '$st_ewidencja_nr_seryjny',
                            wartosc = '$st_ewidencja_wartosc',
                            jed_uzytkujaca = '$st_ewidencja_jednostka_uzytkujaca',
                            uwagi = '$st_ewidencja_uwagi',
                            notatki = ''
                            WHERE lp = '$st_id_st'")
                                or die("Blad przy aktualizacja_srodka_trwalego".mysqli_error($polaczenie));

                            //Wpis do histori z informacja o aktualizacji środka trwałego
                            Historia("$st_dodane_id",8,"$st_ewidencja_nazwa","$data_aktualna_pelna","$użytkownik_imie_nazwisko","","","","$st_ewidencja_nr_ewidencyjny","","$uzytkownik_wydzial - $uzytkownik_sekcja");

                            //Po wszystkim przekieruj użytkownika do index.php
                            Przekierowanie("Zaktualizowano pomyślnie: $st_ewidencja_nazwa o numerze_ewidencyjnym $st_ewidencja_nr_ewidencyjny. Zostaniesz przekierowany do strony głównej","index.php");

                        }
                        else
                        {
                            echo Przekierowanie("Bład nie powinno cię tu być, spróbuj ponownie","index.php");
                        }





                }

                else
                {
                    echo Przekierowanie("Bład nie powinno cię tu być, spróbuj ponownie","index.php");
                }
                ?>
            </div>

        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include'dol.php'; ?>
