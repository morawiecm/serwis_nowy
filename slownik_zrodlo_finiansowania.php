<?php
include 'config.php';
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


if ($uzytkownik_uprawnienia == 1) {
    $uprawienia = 'Administrator';
} else {
    $uprawienia = 'Użytkownik';
}

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
            Słownik
            <small>Źródło finansowania</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Źródło finansowania</h3>

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
                        echo "<p>Dodawanie nowego źródła fianansowania do Słownika</p>";
                        echo "<table class='table table-bordered'><form method='post' action='slownik_zrodlo_finiansowania.php?a=zapisz'>";
                        echo "<tr><th>Nazwa:</th><td><input type='text' name='nazwa' class='form-control'></td></tr>";
                        echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapisz' class='btn btn-warning form-control' value='Zapisz'></th></tr>";
                        echo "</form></table>";
                    }

                    elseif ($a=='zapisz')
                    {
                        if($_POST['przycisk_zapisz']!='')
                        {
                            //dane z POST
                            $nazwa = trim($_POST['nazwa']);
                            //zapis do bazy
                            $zapisz_zrodlo_finansowania = mysqli_query($polaczenie,"INSERT INTO slownik_zrodlo_fianansowania (nazwa) VALUES ('$nazwa')")
                                or die("Bład przy zapisz_zrodlo_finansowania".mysqli_error($polaczenie));
                            echo "Zapisano pomyślnie wartość $nazwa <a href='slownik_zrodlo_finiansowania.php'>POWRÓT</a>";
                        }
                        else
                        {
                            Przekierowanie("Bład. nie powinno Cie tu być...","slownik_zrodlo_finiansowania.php");
                        }
                    }

                    elseif($a=='edycja')
                    {
                        if($nrID!='')
                        {
                            $pobierz_zrodlo_finansowania_wartosc = mysqli_query($polaczenie,"SELECT nazwa FROM slownik_zrodlo_fianansowania WHERE id = '$nrID'")
                                or die("Bład przy pobierz_zrodlo_finansowania_wartosc".mysqli_error($polaczenie));
                            if(mysqli_num_rows($pobierz_zrodlo_finansowania_wartosc)>0)
                            {
                                while ($edycja = mysqli_fetch_array($pobierz_zrodlo_finansowania_wartosc))
                                {
                                    echo "<p>Edycja źródła fianansowania</p>";
                                    echo "<table class='table table-bordered'><form method='post' action='slownik_zrodlo_finiansowania.php?a=aktualizuj'>";
                                    echo "<tr><th>Nazwa:</th><td><input type='text' name='edycja_nazwa' class='form-control' value='$edycja[nazwa]'></td></tr>";
                                    echo "<tr><th colspan='2'><input type='hidden' name='id_rekordu' value='$nrID'><input type='submit' name='przycisk_aktualizuj' class='btn btn-warning form-control' value='Aktualizuj'></th></tr>";
                                    echo "</form></table>";
                                }
                            }

                        }
                        else
                        {
                            Przekierowanie("Bład. nie powinno Cie tu być...","slownik_zrodlo_finiansowania.php");
                        }
                    }

                    elseif ($a=='aktualizuj')
                    {
                        if($_POST['przycisk_aktualizuj']!='')
                        {
                            //dane z POST
                            $nazwa = trim($_POST['edycja_nazwa']);
                            $id_rekordu = $_POST['id_rekordu'];
                            //zapis do bazy
                            $aktualizuj_zrodlo_finansowania = mysqli_query($polaczenie,"UPDATE slownik_zrodlo_fianansowania SET nazwa = '$nazwa' WHERE id = '$id_rekordu'")
                            or die("Bład przy aktualizuj_zrodlo_finansowania".mysqli_error($polaczenie));
                            echo "Zaktualizowano pomyślnie wartość $nazwa <a href='slownik_zrodlo_finiansowania.php'>POWRÓT</a>";
                        }
                        else
                        {
                            Przekierowanie("Bład. nie powinno Cie tu być...","slownik_zrodlo_finiansowania.php");
                        }
                    }

                    elseif ($a=='usun')
                    {
                        if($nrID!='')
                        {
                            $usun_zrodlo_finansowania = mysqli_query($polaczenie,"DELETE FROM slownik_zrodlo_fianansowania WHERE id ='$nrID'")
                                or die("Bład przy usun_zrodlo_finansowania".mysqli_error($polaczenie));
                            Przekierowanie("Usunięto prawidłowo wpis...","slownik_zrodlo_finiansowania.php");
                        }
                        else
                        {
                            Przekierowanie("Bład. nie powinno Cie tu być...","slownik_zrodlo_finiansowania.php");
                        }
                    }

                    else
                    {
                        echo '<p><a href="slownik_zrodlo_finiansowania.php?a=dodaj" class="btn btn-primary">Dodaj nową pozycję</a></p>
                        <table class="table table-bordered">';
                        echo "<thead><tr><th>LP</th><th>Nazwa</th><th>Akcja</th></tr></thead>";
                        //Pobieranie zawartosci tabeli zrodlo_finansowania
                        $pobierz_zrodlo_finansowania = mysqli_query($polaczenie,"SELECT id,nazwa FROM slownik_zrodlo_fianansowania")
                            or die("Blad przy pobierz_zrodlo_finansowania");
                        if (mysqli_num_rows($pobierz_zrodlo_finansowania)>0)
                        {
                            while ($zrodlo_finansowania = mysqli_fetch_array($pobierz_zrodlo_finansowania))
                            {
                                echo "<tr><td>$zrodlo_finansowania[id]</td><td>$zrodlo_finansowania[nazwa]</td><td>
                                <a href='slownik_zrodlo_finiansowania.php?a=edycja&id=$zrodlo_finansowania[id]' class='btn-sm btn-success'>Edytuj</a>
                                <a href='slownik_zrodlo_finiansowania.php?a=usun&id=$zrodlo_finansowania[id]' class='btn-sm btn-danger'>Usuń</a>
                                </td></tr>";
                            }
                        }
                        else
                        {
                            echo "<tr><td colspan='3'>Brak danych w tabeli. Dodaj wartości</td></tr>";
                        }
                        echo "</table>";
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
