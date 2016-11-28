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


include 'gora.php';
include 'pasek.php';
include 'menu.php';


if ($a == 'dodaj') {
    echo NaglowekStrony("Magazyn", "Słownik", "Lista magazynów");
    echo "<p>Dodawanie nowego Magazynu do  Słownika</p>";
    echo "<table class='table table-bordered'><form method='post' action='slownik_magazyn.php?a=zapisz'>";
    echo "<tr><th>Nazwa:</th><td><input type='text' name='nazwa' class='form-control'></td></tr>";
    echo "<tr><th>Nazwa skrocona:</th><td><input type='text' name='nazwa_skrocona' class='form-control'></td></tr>";
    echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapisz' class='btn btn-warning form-control' value='Zapisz'></th></tr>";
    echo "</form></table>";
} elseif ($a == 'zapisz') {
    echo NaglowekStrony("Magazyn", "Słownik", "Zapisywanie magazynów");
    if ($_POST['przycisk_zapisz'] != '') {
        //dane z POST
        $nazwa = trim($_POST['nazwa']);
        $nazwa_skrocona = trim($_POST['nazwa_skrocona']);
        //zapis do bazy
        $zapisz_magazyn = mysqli_query($polaczenie, "INSERT INTO slownik_magazyn (nazwa,nazwa_skrocona) VALUES ('$nazwa','$nazwa_skrocona')")
        or die("Bład przy zapisz_magazyn" . mysqli_error($polaczenie));
        Przekierowanie("Zapisano pomyślnie wartość $nazwa, Za chwilę zostaniesz przekierowany", "slownik_magazyn.php");
    } else {
        Przekierowanie("Bład. nie powinno Cie tu być...", "slownik_magazyn.php");
    }
} elseif ($a == 'edycja') {
    echo NaglowekStrony("Magazyn", "Słownik", "Edycja magazynów");
    if ($nrID != '') {
        $pobierz_magazyn = mysqli_query($polaczenie, "SELECT nazwa, nazwa_skrocona FROM slownik_magazyn WHERE id = '$nrID'")
        or die("Bład przy pobierz_magazyn_wartosc" . mysqli_error($polaczenie));
        if (mysqli_num_rows($pobierz_magazyn) > 0) {
            while ($edycja = mysqli_fetch_array($pobierz_magazyn)) {
                echo "<p>Edycja Magazynu</p>";
                echo "<table class='table table-bordered'><form method='post' action='slownik_magazyn.php?a=aktualizuj'>";
                echo "<tr><th>Nazwa:</th><td><input type='text' name='edycja_nazwa' class='form-control' value='$edycja[nazwa]'></td></tr>";
                echo "<tr><th>Nazwa skrocona:</th><td><input type='text' name='edycja_nazwa_skrocona' class='form-control' value='$edycja[nazwa_skrocona]'></td></tr>";
                echo "<tr><th colspan='2'><input type='hidden' name='id_rekordu' value='$nrID'><input type='submit' name='przycisk_aktualizuj' class='btn btn-warning form-control' value='Aktualizuj'></th></tr>";
                echo "</form></table>";
            }
        }

    } else {
        Przekierowanie("Bład. nie powinno Cie tu być...", "slownik_magazyn.php");
    }
} elseif ($a == 'aktualizuj') {
    echo NaglowekStrony("Magazyn", "Słownik", "Aktualizacja magazynów");
    if ($_POST['przycisk_aktualizuj'] != '') {
        //dane z POST
        $nazwa = trim($_POST['edycja_nazwa']);
        $id_rekordu = $_POST['id_rekordu'];
        $nazwa_skrocona = trim($_POST['edycja_nazwa_skrocona']);
        //zapis do bazy
        $aktualizuj_magazyn = mysqli_query($polaczenie, "UPDATE slownik_magazyn SET nazwa = '$nazwa', nazwa_skrocona = '$nazwa_skrocona' WHERE id = '$id_rekordu'")
        or die("Bład przy aktualizuj_magazyn" . mysqli_error($polaczenie));
        echo "Zaktualizowano pomyślnie wartość $nazwa <a href='slownik_magazyn.php'>POWRÓT</a>";
    } else {
        Przekierowanie("Bład. nie powinno Cie tu być...", "slownik_magazyn.php");
    }
} elseif ($a == 'usun') {
    echo NaglowekStrony("Magazyn", "Słownik", "Usuwanie magazynów");
    if ($nrID != '') {
        $usun_magazyn = mysqli_query($polaczenie, "DELETE FROM slownik_magazyn WHERE id ='$nrID'")
        or die("Bład przy usun_magazyn" . mysqli_error($polaczenie));
        Przekierowanie("Usunięto prawidłowo wpis...", "slownik_magazyn.php");
    } else {
        Przekierowanie("Bład. nie powinno Cie tu być...", "slownik_magazyn.php");
    }
} else {
    echo NaglowekStrony("Magazyn", "Słownik", "Lista magazynów");
    echo '<p><a href="slownik_magazyn.php?a=dodaj" class="btn btn-primary">Dodaj nową pozycję</a></p>
                        <table class="table table-bordered">';
    echo "<thead><tr><th>LP</th><th>Nazwa</th><th>Nazwa skrócona</th><th>Akcja</th></tr></thead>";
    //Pobieranie zawartosci tabeli magazyn
    $pobierz_magazyn = mysqli_query($polaczenie, "SELECT id,nazwa,nazwa_skrocona FROM slownik_magazyn")
    or die("Blad przy pobierz_magazyn");
    if (mysqli_num_rows($pobierz_magazyn) > 0) {
        while ($magazyn = mysqli_fetch_array($pobierz_magazyn)) {
            echo "<tr><td>$magazyn[id]</td><td>$magazyn[nazwa]</td><td>$magazyn[nazwa_skrocona]</td><td>
                                <a href='slownik_magazyn.php?a=edycja&id=$magazyn[id]' class='btn-sm btn-success'>Edytuj</a>
                                </td></tr>";
        }
    } else {
                                //<a href='slownik_magazyn.php?a=usun&id=$magazyn[id]' class='btn-sm btn-danger'>Usuń</a>
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

<?php include 'dol.php'; ?>
