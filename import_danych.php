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
            Import Danych serwis 1.0
            <small>do serwis 2.0</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Import Danych Serwis 1.0 do Serwis 2.0</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">


            <!-- /.box-body -->
            <?php
            $polaczenie_drugie = polaczenie_z_baza();
            if($a=='baza_przeniesienie')
            {
                $baza_orginal = "baza";
                $baza_przeznaczenie = "baza_nowa";

                $pobierz_orginal = mysqli_query($polaczenie, "SELECT * FROM $baza_orginal") or die("Blad przy pobierz_orginal".mysqli_error($polaczenie));
                if(mysqli_num_rows($pobierz_orginal)>0)
                {
                    while ($dane = mysqli_fetch_array($pobierz_orginal))
                    {
                        //zmienne:
                        $nr_inwentarzowy= '';
                        $nr_inwentarzowy_1= '';
                        $nr_inwentarzowy_2= '';
                        $nr_fabryczny= '';
                        $nazwa_sprzetu='';
                        $nr_inwentarzowy_klasyfikacja= '';
                        $nr_inwentarzowy_rodzaj= '';
                        $nr_inwentarzowy_4_id= '';
                        $wartosc= '';
                        $jed_miary= '';
                        $jed_uzytkujaca= '';
                        $uwagi= '';
                        $likwidacja= '';
                        $id_jednoski= '';
                        $data_wprowadzenia= '';
                        $zrodlo_finansowania= '';
                        $notatki= '';
                        $rodzaj_ewidencyjny= '';
                        $sposob_likwidacji= '';
                        $Podstawa= '';
                        $nr_dokmentu= '';


                        $nr_inwentarzowy= $dane['nr_aktualny'];
                        $nr_inwentarzowy_1= $dane['nr_inwentarzowy'];
                        $nr_inwentarzowy_2= $dane['inwentarzowy2'];
                        $nr_fabryczny= $dane['nr_fabryczny'];
                        $nazwa_sprzetu=addslashes($dane['Materiał']);
                        $nr_inwentarzowy_klasyfikacja= $dane['nr_inwentarzowy_klasyfikacja'];
                        $nr_inwentarzowy_rodzaj= $dane['nr_inwentarzowy_rodzaj'];
                        $nr_inwentarzowy_4_id= $dane['nrinwentnowy'];
                        $wartosc= $dane['wartość'];
                        $jed_miary= $dane['jed_miary'];
                        $jed_uzytkujaca= $dane['jed_użytkuj'];
                        $uwagi= addslashes($dane['uwagi']);
                        $likwidacja= $dane['Likwidacja'];
                        $id_jednoski= '';
                        $data_wprowadzenia= $dane['data wprowadzenia'];
                        $zrodlo_finansowania= $dane['Żródło finansowania'];
                        $notatki= addslashes($dane['NOTATKI']);
                        $rodzaj_ewidencyjny= $dane['Rodzaj ewidencyjny'];
                        $sposob_likwidacji= $dane['Sposób likwidacji'];
                        $Podstawa= $dane['Podstawa'];
                        $nr_dokmentu= $dane['nr_dokmentu'];

                        $zapytanie_przenies_dane = "INSERT INTO baza_nowa (nr_inwentarzowy, nr_inwentarzowy_1, nr_inwentarzowy_2, nr_fabryczny, nazwa_sprzetu, nr_inwentarzowy_klasyfikacja, 
                        nr_inwentarzowy_rodzaj, nr_inwentarzowy_4_id, wartosc, jed_miary, jed_uzytkujaca, uwagi, likwidacja, id_jednoski,
                        data_wprowadzenia, zrodlo_finansowania, notatki, rodzaj_ewidencyjny, sposob_likwidacji, Podstawa, nr_dokmentu) 
                        VALUES ('$nr_inwentarzowy','$nr_inwentarzowy_1','$nr_inwentarzowy_2','$nr_fabryczny','$nazwa_sprzetu','$nr_inwentarzowy_klasyfikacja','$nr_inwentarzowy_rodzaj',
                        '$nr_inwentarzowy_4_id','$wartosc','$jed_miary','$jed_uzytkujaca','$uwagi','$likwidacja','$id_jednoski','$data_wprowadzenia','$zrodlo_finansowania','$notatki','$rodzaj_ewidencyjny','$sposob_likwidacji','$Podstawa','$nr_dokmentu')" ;

                        $wykonaj_zapytanie_przenies_dane = mysqli_query($polaczenie_drugie, $zapytanie_przenies_dane) or die("Blad przy wykonaj_zapytanie_przenies_dane".mysqli_error($polaczenie_drugie));

                    }
                }
                echo"Przeniesiono wszystkie dane";
            }
            elseif ($a=='jednostki')
            {
                $pobierz_dane_z_bazy = mysqli_query($polaczenie,"SELECT lp, jed_uzytkujaca FROM baza WHERE id_jednoski IS NULL ") or die("Blad przy pobierz_dane_z_bazy");
                if(mysqli_num_rows($pobierz_dane_z_bazy)>0)
                {
                    while ($dane = mysqli_fetch_array($pobierz_dane_z_bazy))
                    {
                        $jednostka_id='';
                        $jednostka_nazwa = $dane['jed_uzytkujaca'];
                        $id_rekordu = $dane['lp'];
                        $polaczenie2 = polaczenie_z_baza();
                        $polaczenie3 = polaczenie_z_baza();
                        //wyszukanie wartosci w bazie
                        $wyszukaj_jednostke = mysqli_query($polaczenie2,"SELECT id FROM jednostki WHERE nazwa LIKE '$jednostka_nazwa'") or die(mysqli_error($polaczenie2));
                        if(mysqli_num_rows($wyszukaj_jednostke)>0)
                        {
                            while ($jed = mysqli_fetch_array($wyszukaj_jednostke))
                            {
                                $jednostka_id = $jed['id'];
                                $zaktualizuj_rekord = mysqli_query($polaczenie3,"UPDATE baza SET id_jednoski = '$jednostka_id' WHERE lp = '$id_rekordu'") or die(mysqli_error($polaczenie3));
                            }
                        }

                    }
                }
            }
            else
            {
                echo "<p>Menu:</p>";
                echo "<p>1. Import danych z Serwis 1.0 do Serwis 2.0 <a href='import_danych.php?a=baza_przeniesienie' class='btn btn-danger'>Wykonaj</a></p>";
                echo "<p>2. Zamiana jedostek na kody (id_jednostki) wq tabeli jednostki <a href='import_danych.php?a=jednostki' class='btn btn-danger'>Wykonaj</a></p> ";
                echo "<p>3. Import z tabeli seriws do Historia <a href='aktualizacja_tabeli_serwis.php' class='btn btn-danger'>Wykonaj</a></p> ";
            }


            ?>
            <!-- /.box-footer-->
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include'dol.php'; ?>
