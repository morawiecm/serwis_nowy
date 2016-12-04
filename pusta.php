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
elseif ($a=='edycja')
{
    echo NaglowekStrony("Asygnata","Edycja dokumentu","Edycja wpsiów na  dokumencie");
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
    echo NaglowekStrony("Asygnata","Edycja dokumentu","Edycja wpsiów na  dokumencie");

    $jedostka = Array();
    $licznik =0;
    $pobierz_jednostki = mysqli_query($polaczenie,"SELECT id,nazwa FROM jednostki") or die(mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_jednostki)>0)
    {
        while ($jed = mysqli_fetch_array($pobierz_jednostki))
        {
            $jednostka[$licznik]['id']=$jed['id'];
            $jednostka[$licznik]['nazwa']=$jed['nazwa'];
            $licznik++;
        }
    }

    $jednostka_nazwa = array_search('4',array_column($jednostka,'id'));
    $jednostka_nazwa_pelna = $jednostka[$jednostka_nazwa]['nazwa'];
    echo $jednostka_nazwa_pelna;


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
