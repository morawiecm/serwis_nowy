<?php
include 'config.php';
include 'funkcje/funkcje_ewidencja.php';
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
//dane z POST



if(isset($_POST['dokument']))
{
    $dokument=$_POST['dokument'];
}
else
{
    $dokument='';
}


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
                    echo PobierzJednostki();
                    echo "</select></td></tr>";
                    echo "<tr><th>Rodzaj Ewidencji</th><td><select name='ewidencja_rodzaj_ewidencyjny' class='form-control'>";
                    echo PobierzRodzajEwidencji();
                    echo"</select></td></tr>";
                    echo "<tr><th>Źródło Finansowania</th><td><select name='ewidencja_zrodlo_finanosowania' class='form-control'>";
                    echo PobierzZrodloFinasowania();
                    echo"</select></td></tr>";
                    echo "<tr><th>Data Przyjęcia</th><td><input type='text' name='ewidencja_data_przyjecia' class='form-control' id='datepicker'></td></tr>";
                    echo "<tr><th>Notatki/Uwagi</th><td><textarea name='ewidencja_uwagi' class='form-control'></textarea></td></tr>";
                    echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapis' value='Dodaj do ewidencji' class='btn btn-danger form-control'></th></tr>";
                    echo"</form></table>";
                }

                elseif ($a=='zapisz')
                {
                    var_dump($_POST);
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
                                echo "<tr><th>Uwagi/Notatki</th><td><textarea name='ewidencja_uwagi' class='form-control' rows='8'>$dane[uwagi], $dane[notatki]</textarea></td></tr>";
                                echo "<tr><th colspan='2'><input type='submit' name='przycisk_aktualizuj' value='Aktualizuj wpis w ewidencji' class='btn btn-warning form-control'></th></tr>";
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

                else
                {
                  echo "Coś tu powinno być ";
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
