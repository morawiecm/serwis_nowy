<?php
include 'config.php';
include 'funkcje/funkcje_ewidencja.php';
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



if($a=='dodaj')
{
    echo NaglowekStrony("Asygnaty","Lista","Lista asygnat");

}
elseif ($a=='wyswietl')
{
    $nazwa_mag = PobierzNazweMagazynu($nrID);
    echo NaglowekStrony("Magazyn","Stan","Stan magazynu $nazwa_mag[0] ($nazwa_mag[1])");

    $pobierz_zawartosc_magazynu = mysqli_query($polaczenie,"SELECT id,id_lp,data_wprowadzenia,uwagi FROM magazyn WHERE magazyn = '$nrID'")
        or die("Blad przy pobierz_zawartosc magazynu".mysqli_error($polaczenie));

        echo "<table class='table table-bordered' id='example1'>";
        echo "<thead><tr><th>Nr ewidencyjny</th><th>Nr fabryczny</th><th>Nazwa sprzetu</th><th>Data wprowadzenia</th><th>Uwagi</th><th>Akcja</th></tr></thead>";
    if(mysqli_num_rows($pobierz_zawartosc_magazynu)>0)
    {
        while($magazyn = mysqli_fetch_array($pobierz_zawartosc_magazynu))
        {
            $dane = PobierzDaneMagazyn($magazyn['id_lp']);

            echo "<tr><td>$dane[0] $dane[1] $dane[2]</td><td>$dane[3]</td><td>$dane[4]</td><td>$magazyn[data_wprowadzenia]</td><td>$magazyn[uwagi]</td><td>Wydaj Usun</td></tr>";
        }
    }
    else
    {
        echo "<tr><td>Magazyn jest pusty...dodaj coś</td><td></td><td></td><td></td><td></td><td></td></tr>";
    }
        echo "</table>";



}
elseif ($a=='edycja')
{
    //var_dump($_POST);

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
else
{
    echo NaglowekStrony("Błąd","","");

    Przekierowanie("Blad! nie powinno cię tu być, zostaniesz przeniesiony w bezpieczne miejsce","index.php");

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
