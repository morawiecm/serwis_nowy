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



if($a=='aktualizuj')
{
    echo NaglowekStrony("Liczniki","Wartości","Aktualny stan liczników");
    //dane z POST
    $licznik_wartosci_tab = Array($_POST['licznik_asygnaty'],$_POST['licznik_pst'],$_POST['licznik_pr']);
    $licznik_id_tab = Array(3,4,5);
    //petla zapisujaca wartosci przerzucone do tablicy
    for($i=0;$i<count($licznik_id_tab);$i++)
    {
        $aktualizuj_liczniki = mysqli_query($polaczenie,"UPDATE ustawienia SET tresc = '$licznik_wartosci_tab[$i]' WHERE id='$licznik_id_tab[$i]'")
            or die("Blad przy aktualizuj_liczniki".mysqli_error($polaczenie));

    }
    Przekierowanie("Zaktualizowano pomyślnie liczniki, nastąpi przekierowanie","liczniki_stan.php");
}

else
{
    echo NaglowekStrony("Liczniki","Wartości","Aktualny stan liczników");


    $pobierz_stan_licznikow = mysqli_query($polaczenie,"SELECT tresc FROM ustawienia") or die("Blad przy pobierz_stan_licznikow".mysqli_error($polaczenie));
    while ($licznik = mysqli_fetch_array($pobierz_stan_licznikow))
    {
        $licznik_tab[]=$licznik['tresc'];
    }

    echo "<table class='table table-bordered'><form method='post' action='liczniki_stan.php?a=aktualizuj'>";
    echo "<tr><th>Asygnaty:</th><td><input type='number' name='licznik_asygnaty' class='form-control' value='$licznik_tab[2]'></td></tr>";
    echo "<tr><th>Protokół Stanu Techniczego:</th><td><input type='number' name='licznik_pst' class='form-control' value='$licznik_tab[4]'></td></tr>";
    echo "<tr><th>Protokół Rozkompletowania:</th><td><input type='number' name='licznik_pr' class='form-control' value='$licznik_tab[3]'></td></tr>";
    echo "<tr><td colspan='2'><input type='submit' value='Aktualizuj liczniki' class='btn btn-danger form-control'></td></tr>";
    echo "</form></table>";
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
