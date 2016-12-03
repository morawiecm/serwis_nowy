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
    echo NaglowekStrony("Kategoria PST", "Słownik", "Dodanie nowej Kategorii do Protokołu Stanu Technicznego");
    echo "<table class='table table-bordered'><form method='post' action='slownik_kategoria_pst.php?a=zapisz'>";
    echo "<tr><th>Nazwa:</th><td><input type='text' name='nazwa' class='form-control'></td></tr>";
    echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapisz' class='btn btn-warning form-control' value='Zapisz'></th></tr>";
    echo "</form></table>";
} elseif ($a == 'zapisz') {
    echo NaglowekStrony("Kategoria PST", "Słownik", "Zapisywanie nowej Kategorii do Protokołu Stanu Technicznego");
    if ($_POST['przycisk_zapisz'] != '') {
        //dane z POST
        $nazwa = trim($_POST['nazwa']);
        //zapis do bazy
        $zapisz_kategorie = mysqli_query($polaczenie, "INSERT INTO slownik_kategoria_pst (nazwa) VALUES ('$nazwa')")
        or die("Bład przy zapisz_kategorie" . mysqli_error($polaczenie));
        Przekierowanie("Zapisano pomyślnie wartość $nazwa, Za chwilę zostaniesz przekierowany", "slownik_kategoria_pst.php");
    } else {
        Przekierowanie("Bład. nie powinno Cie tu być...", "slownik_kategoria_pst.php");
    }
} elseif ($a == 'edycja') {
    echo NaglowekStrony("Kategoria PST", "Słownik", "Edycja wybranej Kategorii do Protokołu Stanu Technicznego");
    if ($nrID != '') {
        $pobierz_kat = mysqli_query($polaczenie, "SELECT nazwa FROM slownik_kategoria_pst WHERE id = '$nrID'")
        or die("Bład przy pobierz_kat" . mysqli_error($polaczenie));
        if (mysqli_num_rows($pobierz_kat) > 0) {
            while ($edycja = mysqli_fetch_array($pobierz_kat)) {
                echo "<table class='table table-bordered'><form method='post' action='slownik_kategoria_pst.php?a=aktualizuj'>";
                echo "<tr><th>Nazwa:</th><td><input type='text' name='edycja_nazwa' class='form-control' value='$edycja[nazwa]'></td></tr>";
                echo "<tr><th colspan='2'><input type='hidden' name='id_rekordu' value='$nrID'><input type='submit' name='przycisk_aktualizuj' class='btn btn-warning form-control' value='Aktualizuj'></th></tr>";
                echo "</form></table>";
            }
        }

    } else {
        Przekierowanie("Bład. nie powinno Cie tu być...", "slownik_kategoria_pst.php");
    }
} elseif ($a == 'aktualizuj') {
    echo NaglowekStrony("Kategoria PST", "Słownik", "Aktualizacja Kategorii do Protokołu Stanu Technicznego");
    if ($_POST['przycisk_aktualizuj'] != '') {
        //dane z POST
        $nazwa = trim($_POST['edycja_nazwa']);
        $id_rekordu = $_POST['id_rekordu'];
        //zapis do bazy
        $aktualizuj_kategorie = mysqli_query($polaczenie, "UPDATE slownik_kategoria_pst SET nazwa = '$nazwa' WHERE id = '$id_rekordu'")
        or die("Bład przy aktualizuj_kategorie" . mysqli_error($polaczenie));
        echo "Zaktualizowano pomyślnie wartość $nazwa <a href='slownik_kategoria_pst.php'>POWRÓT</a>";
    } else {
        Przekierowanie("Bład. nie powinno Cie tu być...", "slownik_kategoria_pst.php");
    }
} elseif ($a == 'usun') {
    echo NaglowekStrony("Kategoria PST", "Słownik", "Usuwanie Kategorii do Protokołu Stanu Technicznego");
    if ($nrID != '') {
        $usun_kat = mysqli_query($polaczenie, "DELETE FROM slownik_kategoria_pst WHERE id ='$nrID'")
        or die("Bład przy usun_kat" . mysqli_error($polaczenie));
        Przekierowanie("Usunięto prawidłowo wpis...", "slownik_kategoria_pst.php");
    } else {
        Przekierowanie("Bład. nie powinno Cie tu być...", "slownik_kategoria_pst.php");
    }
} else {
    echo NaglowekStrony("Kategoria PST", "Słownik", "Lista wszystkich Kategorii do Protokołu Stanu Technicznego");
    echo '<p><a href="slownik_kategoria_pst.php?a=dodaj" class="btn btn-primary">Dodaj nową pozycję</a></p>
                        <table class="table table-bordered">';
    echo "<thead><tr><th>LP</th><th>Nazwa</th><th>Akcja</th></tr></thead>";
    //Pobieranie zawartosci tabeli magazyn
    $pobierz_kategorie = mysqli_query($polaczenie, "SELECT id,nazwa FROM slownik_kategoria_pst")
    or die("Blad przy pobierz_kategorie");
    if (mysqli_num_rows($pobierz_kategorie) > 0) {
        while ($kategoria = mysqli_fetch_array($pobierz_kategorie)) {
            echo "<tr><td>$kategoria[id]</td><td>$kategoria[nazwa]</td><td>
                                <a href='slownik_kategoria_pst.php?a=edycja&id=$kategoria[id]' class='btn-sm btn-success'>Edytuj</a>
                                </td></tr>";
        }
    } else {
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
