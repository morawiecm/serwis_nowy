<?php
include 'config.php';
include './funkcje/funkcje_naklejka.php';
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
$uzytkownik_pokoj = $user_data['pomieszczenie'];
$użytkownik_imie_nazwisko = $uzytkownik_imie . " " . $uzytkownik_nazwisko;
//dane z POST

if(isset($_REQUEST['nr_inwentarzowy']))
{
    $nr_inwentarzowy = $_REQUEST['nr_inwentarzowy'];
}
else
{
    $nr_inwentarzowy='';
}

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
            Naklejki
            <small>Do wydrukowania</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Naklejki</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                // KREATOR PROJEKTOWANIA NAKLEJKI
                if($a=='projekt')
                {

                }
                // KONIEC PROJEKTOWANIA NAKLEJKI

                // DRUKOWANIE NAKLEJKI - SKLADNIK Z INVEO
                elseif ($a=='skladnik_inveo')
                {
                    if(isset($nrID))
                    {
                        if (isset($nr_inwentarzowy))
                        {
                            $naklejka_tresc=PobierzOpisInveo($nrID);
                            echo "<table class='table'><form action='naklejka.php?a=zapisz_projekt' method='post'>";
                            echo "<tr><th>Nr Ewidencyjny</th><td><input type='text' class='form-control' disabled='disabled' name='naklejka_nr_ewidencyjny' value='$nr_inwentarzowy'></td></tr>";
                            echo "<tr><th>Treść (Max 70 znaków):</th><td><input type='text' class='form-control' name='naklejka_tresc' value='$naklejka_tresc'></td></tr>";
                            echo "<tr><th>Naklejkę dostarczyć do: </th><td><input type='text' name='naklejka_przeznacznie' class='form-control' value='$użytkownik_imie_nazwisko pok: $uzytkownik_pokoj'></td></tr>";
                            echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapisz' class='btn btn-primary form-control' value='Zapisz naklejkę'></th></tr>";
                            echo "</form></table>";
                        }
                        else
                        {
                            echo"<p>Błąd! Brak Nr inwentarzowego głownego składnika lub wybrany składnik nie istnieje. Spróbuj jeszcze raz</p>";
                        }
                    }
                    else
                    {
                        echo"<p>Błąd! Brak nr ID składnika z Inveo lub wybrany składnik nie istnieje. Spróbuj jeszcze raz</p>";
                    }
                }
                // KONIEC  NAKLEJKI - SKLADNIK Z INVEO

                // NAKLEJKI - SRODEK TRWAŁY
                elseif ($a=='srodek_trwaly')
                {

                }
                // KONIEC NAKLEJKI - SRODEK TRWAŁY

                // ZAPIS PROJEKTU NAKLEJKI

                elseif ($a=='zapisz_projekt')
                {
                    if(isset($_POST['przycisk_zapisz']))
                    {

                    }
                    else
                    {
                        Przekierowanie('Bład zapisu nastąpi powrót..','naklejka.php');
                    }
                }
                // KONIEC ZAPIS PROJEKTU NAKLEJKI


                // WYŚWIETL WSZYSTKIE NIEWYDRUKOWANE NAKLEJKI
                else
                {
                    echo"<p><a href='naklejka.php?a=projekt' class='btn btn-success'>Zaprojektuj naklejkę</a></p>";

                }
                // KONIEC WYWIETL WSZYSTKIE NAKLEJKI

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
