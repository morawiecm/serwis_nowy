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
            <small>Jednostki w woj. lubuskim</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Jednostki w woj. lubuskim</h3>

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
                        echo "<p>Dodawanie nowej jednostki do Słownika</p>";
                        echo "<table class='table table-bordered'><form method='post' action='slownik_rodzaj_ewidencji.php?a=zapisz'>";
                        echo "<tr><th>Nazwa: </th><td><input type='text' name='nazwa' class='form-control'></td></tr>";
                        echo "<tr><th>Kod: </th><td><input type='text' name='kod' class='form-control'></td></tr>";
                        echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapisz' class='btn btn-warning form-control' value='Zapisz'></th></tr>";
                        echo "</form></table>";
                    }

                    elseif ($a=='zapisz')
                    {
                        if($_POST['przycisk_zapisz']!='')
                        {
                            //dane z POST
                            $nazwa = trim($_POST['nazwa']);
                            $kod = trim($_POST['kod']);
                            //zapis do bazy
                            $zapisz_jednostke = mysqli_query($polaczenie,"INSERT INTO jednostki(nazwa, kod_jednostki) VALUES ('$nazwa','$kod')")
                                or die("Bład przy zapisz_jednostke".mysqli_error($polaczenie));
                            echo "Zapisano pomyślnie wartość $nazwa ($kod)<a href='slownik_jednostki.php'>POWRÓT</a>";
                        }
                        else
                        {
                            Przekierowanie("Bład. nie powinno Cie tu być...","slownik_jednostki.php");
                        }
                    }

                    elseif($a=='edycja')
                    {
                        if($nrID!='')
                        {
                            $pobierz_jednostke = mysqli_query($polaczenie,"SELECT nazwa, kod_jednostki FROM jednostki WHERE id = '$nrID'")
                                or die("Bład przy pobierz_jednostke".mysqli_error($polaczenie));
                            if(mysqli_num_rows($pobierz_jednostke)>0)
                            {
                                while ($edycja = mysqli_fetch_array($pobierz_jednostke))
                                {
                                    echo "<p>Edycja Jednostki</p>";
                                    echo "<table class='table table-bordered'><form method='post' action='slownik_rodzaj_ewidencji.php?a=aktualizuj'>";
                                    echo "<tr><th>Nazwa:</th><td><input type='text' name='edycja_nazwa' class='form-control' value='$edycja[nazwa]'></td></tr>";
                                    echo "<tr><th>Kod</th><td><input type='text' name='edycja_kod' class='form-control' value='$edycja[kod_jednostki]'></td></tr>";
                                    echo "<tr><th colspan='2'><input type='hidden' name='id_rekordu' value='$nrID'><input type='submit' name='przycisk_aktualizuj' class='btn btn-warning form-control' value='Aktualizuj'></th></tr>";
                                    echo "</form></table>";
                                }
                            }

                        }
                        else
                        {
                            Przekierowanie("Bład. nie powinno Cie tu być...","slownik_jednostki.php");
                        }
                    }

                    elseif ($a=='aktualizuj')
                    {
                        if($_POST['przycisk_aktualizuj']!='')
                        {
                            //dane z POST
                            $nazwa = trim($_POST['edycja_nazwa']);
                            $kod = trim($_POST['edycja_kod']);
                            $id_rekordu = $_POST['id_rekordu'];
                            //zapis do bazy
                            $aktualizuj_jednostke = mysqli_query($polaczenie,"UPDATE jednostki SET nazwa = '$nazwa', kod_jednostki = '$kod' WHERE id = '$id_rekordu'")
                            or die("Bład przy aktualizuj_jednostke".mysqli_error($polaczenie));
                            echo "Zaktualizowano pomyślnie wartość $nazwa ($kod) <a href='slownik_jednostki.php'>POWRÓT</a>";
                        }
                        else
                        {
                            Przekierowanie("Bład. nie powinno Cie tu być...","slownik_jednostki");
                        }
                    }

                    elseif ($a=='usun')
                    {
                        if($nrID!='')
                        {
                            $usun_rodzaj_ewidencji = mysqli_query($polaczenie,"UPDATE jednostki SET aktywny='1' WHERE id ='$nrID'")
                                or die("Bład przy usun_jednostke".mysqli_error($polaczenie));
                            Przekierowanie("Usunięto prawidłowo wpis...","slownik_jednostki.php");
                        }
                        else
                        {
                            Przekierowanie("Bład. nie powinno Cie tu być...","slownik_jednostki.php");
                        }
                    }

                    else
                    {
                        echo '<p><a href="slownik_jednostki.php?a=dodaj" class="btn btn-primary">Dodaj nową pozycję</a></p>
                        <table class="table table-bordered" id="example1">';
                        echo "<thead><tr><th>LP</th><th>Nazwa</th><th>Kod</th><th>Akcja</th></tr></thead>";
                        //Pobieranie zawartosci tabeli rodzaj_ewidencji
                        $pobierz_jednostki = mysqli_query($polaczenie,"SELECT id, nazwa, kod_jednostki FROM jednostki WHERE aktywny = '0'")
                            or die("Blad przy pobierz_jednostki".mysqli_error($polaczenie));
                        if (mysqli_num_rows($pobierz_jednostki)>0)
                        {
                            while ($rodzaj_ewidencji = mysqli_fetch_array($pobierz_jednostki))
                            {
                                echo "<tr><td>$rodzaj_ewidencji[id]</td><td>$rodzaj_ewidencji[nazwa]</td><td>$rodzaj_ewidencji[kod_jednostki]</td><td>
                                <a href='slownik_rodzaj_ewidencji.php?a=edycja&id=$rodzaj_ewidencji[id]' class='btn-sm btn-success'>Edytuj</a>
                                <a href='slownik_rodzaj_ewidencji.php?a=usun&id=$rodzaj_ewidencji[id]' class='btn-sm btn-danger'>Usuń</a>
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
