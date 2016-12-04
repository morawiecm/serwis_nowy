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
$data_skrocona = date("Y-m-d");
//dane z POST


if(isset($_REQUEST['roz']))
{
    $roz = trim($_REQUEST['roz']);
}
else
{
    $roz ='';
}

if ($uzytkownik_uprawnienia == 1) {
    $uprawienia = 'Administrator';
} else {
    $uprawienia = 'Użytkownik';
}

//print_r($_POST);

include 'gora.php';
include 'pasek.php';
include 'menu.php';



if($a=='zmien_haslo')
{
echo NaglowekStrony("Profil użytkownika","Hasło","Zmiana hasła użytkownika");
    if (isset($_POST['przycisk_zmien_haslo'])) {
        if (isset($_POST['stare_haslo']) && isset($_POST['nowe_haslo']) && isset($_POST['nowe_haslo2'])) {
            //dane z POST oczyszczone
            $stare_haslo = clear($_POST['stare_haslo']);
            $nowe_haslo = clear($_POST['nowe_haslo']);
            $nowe_haslo2 = clear($_POST['nowe_haslo2']);

            if ($nowe_haslo == $nowe_haslo2) {
                $spelnia_polityke = sprawdzHasloPolityka($nowe_haslo2);
                if ($spelnia_polityke == true) {
                    $stare_haslo = codepass($stare_haslo);
                    $nowe_haslo = codepass($nowe_haslo);
                    $nowe_haslo2 = codepass($nowe_haslo2);
                } else {
                    echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Hasło nie spełnia polityki..
                  </div>';
                }
            }
            if ($nowe_haslo == $nowe_haslo2 && $spelnia_polityke == true) {
                $pobierz_daneUzytkownika = mysqli_query($polaczenie, "SELECT user_password FROM users WHERE user_id='$uzytkownik_id'") or die("Blad przy pobierz_daneUzytkownika" . mysqli_error($polaczenie));
                if (mysqli_num_rows($pobierz_daneUzytkownika) == 1) {
                    while ($haslo_baza = mysqli_fetch_array($pobierz_daneUzytkownika)) {
                        $haslo = $haslo_baza['user_password'];
                        if ($haslo == $stare_haslo) {
                            $aktualna_data = date("Y-m-d");
                            $zapiszNoweHaslo = mysqli_query($polaczenie, "UPDATE users SET user_password='$nowe_haslo2', data_zmiany_hasla='$aktualna_data' WHERE user_id='$uzytkownik_id'")
                            or die("Bład przy zapiszNoweHaslo" . mysqli_error($polaczenie));
                            echo '<div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    Hasło zostsło zmienione!..<a href="index.php">POWRÓT</a> 
                                     </div>';
                            ?>
                            <script>
                                setTimeout(function () {
                                    window.location.href = 'index.php'; // the redirect goes here

                                }, 3000);
                            </script><?php
                        }
                    }
                } else {
                    echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Blad nie znaleziono użytkownika o podanym id..
                  </div>';
                }
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Wszystkie pola muszą być wypełnione..
                  </div>';
        }
    } else {
        //var_dump($_POST);
        echo "<p>Hasło musi spełniać następujace wymogi:</p>";
        echo "<p>- Musi mieć min 8 znaków</p>";
        echo "<p>- Musi posiadać jedną wielką literę</p>";
        echo "<p>- Musi posiadać znak specjalny</p>";
        echo "<p>- Musi posiadać conajmniej jedną cyfrę</p>";
        echo "<p>- Nie może sie powtarzać</br></p>";
        echo "<table class='table'><form name='edycja_hasla' method='post' action='profil.php?a=zmien_haslo'>";
        echo "<tr><th>Podaj stare hasło:</th><td><input type='password' name='stare_haslo' class='form-control'></td></tr>";
        echo "<tr><th>Podaj nowe hasło:</th><td><input type='password' name='nowe_haslo' class='form-control'></td></tr>";
        echo "<tr><th>Powtórz nowe hasło:</th><td><input type='password' name='nowe_haslo2' class='form-control'></td></tr>";
        echo "<tr><th colspan='2'><input type='submit' value='Zmien hasło' class='btn btn-danger form-control' name='przycisk_zmien_haslo'></th>";
        echo "</form></table>";
    }

}
else{

echo NaglowekStrony("Profil użytkownika","Informacje","Dane użytkownika: informacje");

// sprawdzamy czy znalazło użytkownika
// jeśli nie to wyświetlamy komunikat
// a jeśli tak to wyświetlamy wszystkie jego dane
// jeśli user nie ma podanej strony www lub skąd jest to wyświetlamy "brak"
if($user_data === false) {
    echo '<p>Niestety, taki użytkownik nie istnieje.</p>
        <p>[<a href="index.php">Powrót</a>]</p>';
} else {
    echo '<h2>Profil użytkownika</h2>';
        /*
        <P>Typ konta:';
        if($user_data['specialne']!='1')
        {
            echo(' użytkownik');
        }
        else{
            echo(' administrator');
        }
        */
        echo'<table class="table table-bordered">

        <tr><th>Login:</th><td class="text-bold">'.$user_data['user_name'].'</td></tr>
        <tr><th>Imię i nazwsko:</th><td>'.$użytkownik_imie_nazwisko.'</td></tr>
        <tr><th>Email:</th><td> '.$user_data['user_email'].'</td></tr>
        <tr><th>Data rejestracji:</th><td> '.date("d.m.Y, H:i", $user_data['user_regdate']).'</td></tr>
        <tr><th>Data ostatniego logowania:</th><td> '.(empty($user_data['user_website']) ? 'brak' : $user_data['user_website']).' IP: '.$user_data['logowanie_ip'].'</td></tr>
        <tr><th>Wydział:</th><td> '.(empty($user_data['wydzial']) ? 'brak' : $user_data['wydzial']).'</td></tr>
        <tr><th>Sekcja:</th><td> '.(empty($user_data['sekcja']) ? 'brak' : $user_data['sekcja']).'</td></tr>
        <tr><td colspan =2><a href="profil.php?a=zmien_haslo" class="btn btn-success form-control">Zmiana hasla</a></td></tr>';
        echo "</table>";

}
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
