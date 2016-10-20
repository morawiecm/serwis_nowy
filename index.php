<?php
include 'config.php';
include './funkcje/funkcje_index.php';


check_login();

// dane uzytkownika z sesji
$user_data = get_user_data();
$uzytkownik_imie = $user_data['imie'];
$uzytkownik_nazwisko = $user_data['nazwisko'];
$uzytkownik_nazwa = $user_data['user_name'];
$uzytkownik_id = $user_data['user_id'];
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
            Strona Główna
            <small>Wyszukiwarka</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <?php

        if ($a == 'wyszukaj') {

            $typ = $_POST['numer'];
            //$dokument = $_POST['dokument'];
            if ($typ != '') {

                //kombinacje numerow inwentarzowych
                $numer_inwent = trim($_POST["wyszukiwarka"]);
                $num22 = $_POST['wyszukiwarka'];
                $n20 = "4491$numer_inwent";
                $n200 = "4-491-$numer_inwent";
                $n21 = "2629$numer_inwent";
                $n22 = "1629$numer_inwent";
                $n23 = "2491$numer_inwent";
                $n24 = "2800$numer_inwent";
                $n25 = "2626$numer_inwent";
                $n26 = "2-629-$numer_inwent";
                $n27 = "1-629-$numer_inwent";
                $n28 = "2-491-$numer_inwent";
                $n29 = "2-800-$numer_inwent";
                $n30 = "2-626-$numer_inwent";
                $n31 = "2-WYP-$numer_inwent";
                $n32 = "2WYP$numer_inwent";
                $n33 = "2-622-$numer_inwent";
                $n34 = "2622$numer_inwent";
                $n35 = "2631$numer_inwent";
                $n36 = "2-631-$numer_inwent";
                $n37 = "0-000-$numer_inwent";
                $n38 = "4-629-$numer_inwent";
                $n39 = "4629$numer_inwent";
                $n40 = "1-491-$numer_inwent";
                $n41 = "1491$numer_inwent";
                $n42 = "$numer_inwent";

                $wyszukaj_numer = mysqli_query($polaczenie, "SELECT lp, nr_inwentarzowy, nr_inwentarzowy_1, nr_inwentarzowy_2, nr_fabryczny, nazwa_sprzetu, likwidacja FROM baza Where `lp`='$nrID' or (`nr_inwentarzowy`='$num22' or `nr_inwentarzowy_1`='$num22' or `nr_inwentarzowy_2`='$num22'
                        or `nr_inwentarzowy`='$n20' or `nr_inwentarzowy_1`='$n20' or `nr_inwentarzowy_2`='$n20'
                        or `nr_inwentarzowy`='$n200' or `nr_inwentarzowy_1`='$n200' or `nr_inwentarzowy_2`='$n200'
                        or `nr_inwentarzowy`='$n21' or `nr_inwentarzowy_1`='$n21' or `nr_inwentarzowy_2`='$n21'
                        or `nr_inwentarzowy`='$n22' or `nr_inwentarzowy_1`='$n22' or `nr_inwentarzowy_2`='$n22'
                        or `nr_inwentarzowy`='$n23' or `nr_inwentarzowy_1`='$n23' or `nr_inwentarzowy_2`='$n23'
                        or `nr_inwentarzowy`='$n24' or `nr_inwentarzowy_1`='$n24' or `nr_inwentarzowy_2`='$n24'
                        or `nr_inwentarzowy`='$n25' or `nr_inwentarzowy_1`='$n25' or `nr_inwentarzowy_2`='$n25'
                        or `nr_inwentarzowy`='$n26' or `nr_inwentarzowy_1`='$n26' or `nr_inwentarzowy_2`='$n26'
                        or `nr_inwentarzowy`='$n27' or `nr_inwentarzowy_1`='$n27' or `nr_inwentarzowy_2`='$n27'
                        or `nr_inwentarzowy`='$n28' or `nr_inwentarzowy_1`='$n28' or `nr_inwentarzowy_2`='$n28'
                        or `nr_inwentarzowy`='$n29' or `nr_inwentarzowy_1`='$n29' or `nr_inwentarzowy_2`='$n29'
                        or `nr_inwentarzowy`='$n30' or `nr_inwentarzowy_1`='$n30' or `nr_inwentarzowy_2`='$n30'
                        or `nr_inwentarzowy`='$n31' or `nr_inwentarzowy_1`='$n31' or `nr_inwentarzowy_2`='$n31'
                        or `nr_inwentarzowy`='$n32' or `nr_inwentarzowy_1`='$n32' or `nr_inwentarzowy_2`='$n32'
                        or `nr_inwentarzowy`='$n33' or `nr_inwentarzowy_1`='$n33' or `nr_inwentarzowy_2`='$n33'
                        or `nr_inwentarzowy`='$n34' or `nr_inwentarzowy_1`='$n34' or `nr_inwentarzowy_2`='$n34'
                        or `nr_inwentarzowy`='$n35' or `nr_inwentarzowy_1`='$n35' or `nr_inwentarzowy_2`='$n35'
                        or `nr_inwentarzowy`='$n36' or `nr_inwentarzowy_1`='$n36' or `nr_inwentarzowy_2`='$n36'
                        or `nr_inwentarzowy`='$n37' or `nr_inwentarzowy_1`='$n37' or `nr_inwentarzowy_2`='$n37'
                        or `nr_inwentarzowy`='$n38' or `nr_inwentarzowy_1`='$n38' or `nr_inwentarzowy_2`='$n38'
                        or `nr_inwentarzowy`='$n39' or `nr_inwentarzowy_1`='$n39' or `nr_inwentarzowy_2`='$n39'
                        or `nr_inwentarzowy`='$n40' or `nr_inwentarzowy_1`='$n40' or `nr_inwentarzowy_2`='$n40'
                        or `nr_inwentarzowy`='$n41' or `nr_inwentarzowy_1`='$n41' or `nr_inwentarzowy_2`='$n41'
                        or `nr_inwentarzowy`='$n42' or `nr_inwentarzowy_1`='$n42' or `nr_inwentarzowy_2`='$n42'
                        )")
                or die('Błąd zapytania - nie podano numeru inwentarzowego !' . mysqli_error($polaczenie));

                $licznik_numer = mysqli_num_rows($wyszukaj_numer);
                if ($licznik_numer > 0) {
                    echo '
                        <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Wyszukiwanie - numer inwentarzowy';
                    if ($licznik_numer == 0) {
                        $liczba_wyszukanych_numer = 0;
                        echo " ($liczba_wyszukanych_numer)";
                    } else {
                        $liczba_wyszukanych_numer = $licznik_numer;
                        echo " ($liczba_wyszukanych_numer)";
                    }
                    echo '</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">';
                    echo "<table class='table table-striped table-responsive'><tr><th>Status</th><th>Nr inwentarzowy</th><th>Nr seryjny</th><th>Nazwa</th><th>Akcja</th></tr>";
                    while ($NrInwentarzowy = mysqli_fetch_array($wyszukaj_numer)) {
                        echo "<tr><td>";
                        if ($NrInwentarzowy[6] > '1900-01-01') {
                            echo '<div class="form-group has-error"><label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i></div>';
                        } else {
                            echo '<i class="fa fa-check"></i>';
                        }
                        if ($NrInwentarzowy[2] != '') {
                            $ciag = $NrInwentarzowy[2];
                            $podziel = substr($ciag, 0, 1);
                            $podziel2 = substr($ciag, 1, 3);
                            $podziel3 = substr($ciag, 4 - 8);
                            $nr_stary_format = $podziel . '-' . $podziel2 . '-' . $podziel3;
                        }

                        if ($NrInwentarzowy[1] != 'NULL') {
                            $aktualny_nr = $NrInwentarzowy[1];
                        } else {
                            $aktualny_nr = '';
                        }
                        if(isset($nr_stary_format))
                        {
                            echo "</td><td>$aktualny_nr $nr_stary_format</td><td>$NrInwentarzowy[4]</td><td>$NrInwentarzowy[5]</td><td><a href='index.php?a=wyswietl&id=$NrInwentarzowy[0]' class='btn btn-info'>Wybierz</a></td><td>";
                        }
                        else
                        {
                            echo "</td><td>$aktualny_nr</td><td>$NrInwentarzowy[4]</td><td>$NrInwentarzowy[5]</td><td><a href='index.php?a=wyswietl&id=$NrInwentarzowy[0]' class='btn btn-info'>Wybierz</a></td><td>";
                        }

                        echo "</td></tr>";
                    }
                    echo "</table>";
                    echo '</div><!-- /.box-body -->

            </div><!-- /.box -->';
                }
                /*else {
                        echo '
                 <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <h4><i class="icon fa fa-ban"></i> Komunikat!</h4>
                     Nic nie znaleziono...
                   </div>';

                    }
    */

                /// wyszukiwanie po nr seryjnym
                $wyszukaj_seryjny = mysqli_query($polaczenie, "SELECT lp, nr_inwentarzowy, nr_inwentarzowy_1, nr_inwentarzowy_2, nr_fabryczny, nazwa_sprzetu, likwidacja FROM baza WHERE nr_fabryczny='$numer_inwent' OR nr_fabryczny LIKE '$numer_inwent%' OR nr_fabryczny LIKE '%$numer_inwent%' OR nr_fabryczny LIKE '%$numer_inwent'") or die("Blad przy wyszukaj_seryjny" . mysqli_error($polaczenie));
                $licznik_seryjny = mysqli_num_rows($wyszukaj_seryjny);
                if ($licznik_seryjny > 0) {
                    echo ' <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Wyszukiwanie - numer seryjny';
                    if ($licznik_seryjny == 0) {
                        $liczba_wyszukanych_seryjny = 0;
                        echo " ($liczba_wyszukanych_seryjny)";
                    } else {
                        $liczba_wyszukanych_seryjny = $licznik_seryjny;
                        echo " ($liczba_wyszukanych_seryjny)";
                    }
                    echo '</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">';

                    echo "<table class='table table-striped'><tr><th></th><th>Nr inwentarzowy</th><th>Nr seryjny</th><th>Nazwa</th><th>Akcja</th></tr>";
                    while ($NrSeryjny = mysqli_fetch_array($wyszukaj_seryjny)) {
                        echo "<tr><td>";
                        if ($NrSeryjny[6] > '1900-01-01') {
                            echo '<div class="form-group has-error"><label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i></div>';
                        } else {
                            echo '<i class="fa fa-circle-o text-green"></i>';
                        }

                        if ($NrSeryjny[2] != '') {
                            $ciag = $NrSeryjny[2];
                            $podziel = substr($ciag, 0, 1);
                            $podziel2 = substr($ciag, 1, 3);
                            $podziel3 = substr($ciag, 4 - 8);
                            $seryjny_stary_format = $podziel . '-' . $podziel2 . '-' . $podziel3;
                        }

                        if ($NrSeryjny[1] != 'NULL') {
                            $aktualny_nr = $NrSeryjny[1];
                        } else {
                            $aktualny_nr = '';
                        }

                        echo "</td><td>$aktualny_nr $seryjny_stary_format</td><td>$NrSeryjny[4]</td><td>$NrSeryjny[5]</td><td><a href='index.php?a=wyswietl&id=$NrSeryjny[0]' class='btn btn-info'>Wybierz</a></td><td>";

                        echo "</td></tr>";
                    }
                    echo "</table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->";
                }
                /// wyszukanie po polu notatki - uwagi
                $wyszukaj_uwaga = mysqli_query($polaczenie, "SELECT lp, nr_inwentarzowy, nr_inwentarzowy_1, nr_inwentarzowy_2, nr_fabryczny, nazwa_sprzetu, likwidacja FROM baza WHERE uwagi='$numer_inwent' OR uwagi LIKE '%$numer_inwent' OR uwagi LIKE '%$numer_inwent%' OR uwagi LIKE '$numer_inwent%' OR notatki='$numer_inwent' OR notatki LIKE '%$numer_inwent' OR notatki LIKE '%$numer_inwent%' OR notatki
LIKE '$numer_inwent%'") or die("Blad przy wyszukaj_uwagi" . mysqli_error($polaczenie));
                $licznik_uwagi = mysqli_num_rows($wyszukaj_uwaga);
                if ($licznik_uwagi > 0) {


                    echo '<div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Wyszukiwanie - Pole uwaga / notatki';
                    if ($licznik_uwagi == 0) {
                        $liczba_wyszukanych_uwagi = 0;
                        echo " ($liczba_wyszukanych_uwagi)";
                    } else {
                        $liczba_wyszukanych_uwagi = $licznik_uwagi;
                        echo " ($liczba_wyszukanych_uwagi)";
                    }
                    echo '</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
               <div class="box-body">';
                    echo "<table class='table table-striped'><tr><th></th><th>Nr inwentarzowy</th><th>Nr seryjny</th><th>Nazwa</th><th>Akcja</th></tr>";
                    while ($NotatkiUwagi = mysqli_fetch_array($wyszukaj_uwaga)) {
                        echo "<tr><td>";
                        if ($NotatkiUwagi[6] > '1900-01-01') {
                            echo '<div class="form-group has-error"><label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i></div>';
                        } else {
                            echo '<i class="fa fa-circle-o text-green"></i>';
                        }

                        if ($NotatkiUwagi[2] != '') {
                            $ciag = $NotatkiUwagi[2];
                            $podziel = substr($ciag, 0, 1);
                            $podziel2 = substr($ciag, 1, 3);
                            $podziel3 = substr($ciag, 4 - 8);
                            $seryjny_stary_format = $podziel . '-' . $podziel2 . '-' . $podziel3;
                        }

                        if ($NrSeryjny[1] != 'NULL') {
                            $aktualny_nr = $NotatkiUwagi[1];
                        } else {
                            $aktualny_nr = '';
                        }

                        echo "</td><td>$aktualny_nr $seryjny_stary_format</td><td>$NotatkiUwagi[4]</td><td>$NotatkiUwagi[5]</td><td><a href='index.php?a=wyswietl&id=$NotatkiUwagi[0]' class='btn btn-info'>Wybierz</a></td><td>";

                        echo "</td></tr>";
                    }
                    echo '</table>
                </div><!-- /.box-body -->

            </div><!-- /.box -->';
                }
            }


        } elseif ($dokument != '') {
            echo '

                    <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Wyszukiwanie - Pole uwaga / notatki</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">';
            echo "<table class='table table-striped'><tr><th></th><th>Nr inwentarzowy</th><th>Nr seryjny</th><th>Nazwa</th><th>Akcja</th></tr>";
            while ($NrSeryjny = mysqli_fetch_array($wyszukaj_seryjny)) {
                echo "<tr><td>";
                if ($NrSeryjny[6] > '1900-01-01') {
                    echo '<div class="form-group has-error"><label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i></div>';
                } else {
                    echo '<i class="fa fa-circle-o text-green"></i>';
                }

                if ($NrSeryjny[2] != '') {
                    $ciag = $NrSeryjny[2];
                    $podziel = substr($ciag, 0, 1);
                    $podziel2 = substr($ciag, 1, 3);
                    $podziel3 = substr($ciag, 4 - 8);
                    $seryjny_stary_format = $podziel . '-' . $podziel2 . '-' . $podziel3;
                }

                if ($NrSeryjny[1] != 'NULL') {
                    $aktualny_nr = $NrSeryjny[1];
                } else {
                    $aktualny_nr = '';
                }

                echo "</td><td>$aktualny_nr $seryjny_stary_format</td><td>$NrSeryjny[4]</td><td>$NrSeryjny[5]</td><td><a href='index.php?a=wyswietl&id=$NrSeryjny[0]' class='btn btn-info'>Wybierz</a></td><td>";

                echo "</td></tr>";
            }
            echo '</table>
                </div><!-- /.box-body -->

            </div><!-- /.box -->';
        } elseif ($a == 'wyswietl') {
            $pobierzDaneOsprzecie = mysqli_query($polaczenie, "SELECT baza.lp, baza.nr_inwentarzowy,
                baza.nr_inwentarzowy_1,
                baza.nr_inwentarzowy_2,
                baza.nr_fabryczny,
                baza.nazwa_sprzetu,
                jednostki.nazwa,
                baza.data_wprowadzenia,
                baza.zrodlo_finansowania,
                baza.wartosc,
                baza.uwagi,
                baza.likwidacja,
                baza.rodzaj_ewidencyjny
                FROM baza INNER JOIN jednostki ON baza.jed_uzytkujaca=jednostki.id WHERE baza.lp='$nrID'")
            or die("Blad przy pobierzDaneOsprzecie" . mysqli_error($polaczenie));
            $licznik_dane = mysqli_num_rows($pobierzDaneOsprzecie);
            if ($licznik_dane == 1) {
                while ($dane = mysqli_fetch_array($pobierzDaneOsprzecie)) {
                    $nazwa_naklejka=$dane[5];
                    echo "<div class='box box-warning'>
                    
                            <div class='box-header with-border''>";
                    if ($dane[2] != '') {
                        $ciag = $dane[2];
                        $podziel = substr($ciag, 0, 1);
                        $podziel2 = substr($ciag, 1, 3);
                        $podziel3 = substr($ciag, 4 - 8);
                        $seryjny_stary_format = $podziel . '-' . $podziel2 . '-' . $podziel3;
                    }
                    if ($dane[11] != '') {
                        echo "<h4 class='text-center text-danger'><span class='fa fa-exclamation-circle'></span> $dane[5] ($dane[12]) - Sprzęt wybrakowano dnia: $dane[11]";
                        $poszukajProtokolu = mysqli_query($polaczenie, "SELECT id, id_protokol FROM protokol_skladniki WHERE nr_ewidencyjny='$dane[1]' or nr_ewidencyjny='$seryjny_stary_format'") or die("Blad przy poszukajProtokol" . mysqli_error($polacznie));
                        if (mysqli_num_rows($poszukajProtokolu) > 0) {
                            while ($protokol = mysqli_fetch_array($poszukajProtokolu)) {
                                echo " Protokół nr: $protokol[1]";
                            }
                        }
                    } else {
                        echo "<h4 class='text-center text-green'><span class='fa fa-check-circle'></span> $dane[5] [$dane[12]]";
                    }
                    echo "</h4>
                                <div class='box-tools pull-right'>
                                <button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->";

                    $formatowanie_wartosc = number_format($dane[9], 2, '.', ' ');
                    $formatowanie_daty = date("d/m/Y", strtotime($dane[7]));


              echo"</div><!-- /.box -->";
                    //oprogramowanie
                    $wyszukaj_oprogramowanie = mysqli_query($polaczenie, "SELECT nazwa, typ, klucz FROM oprogramowanie WHERE numer_in='$dane[1]'") or die("blad przy wyszukaj_oprogamowanie" . mysqli_error($polaczenie));
                    $licznik_wyszukajOprogramowanie = mysqli_num_rows($wyszukaj_oprogramowanie);
                    //dokumenty
                    $wyszukaj_dokumenty = mysqli_query($polaczenie, "SELECT * FROM historia WHERE nr_inwentarzowy='$dane[1]' AND (kod='1' OR kod='2') ") or die("blad przy wyszukaj_dokumenty" . mysqli_error($polaczenie));
                    $licznik_dokumenty = mysqli_num_rows($wyszukaj_dokumenty);
                    //raporty
                    $wyszukaj_raporty = mysqli_query($polaczenie, "SELECT * FROM historia WHERE nr_inwentarzowy='$dane[1]' AND kod='5'");
                    $licznik_raporty = mysqli_num_rows($wyszukaj_raporty);
                    //spis
                    $wyszukaj_spis = mysqli_query($polaczenie, "SELECT * FROM spis WHERE (nr_inwent_1='$dane[1]' AND nr_inwent_2='$dane[2]') or spis.nr_seryjny='$dane[4]'") or die("blad przy wyszukaj_spis" . mysqli_error($polaczeni));
                    $licznik_spis = mysqli_num_rows($wyszukaj_spis);
                    //suma licznikow spis + raport
                    $liczniki_spis_raport = $licznik_spis + $licznik_raporty;
                    //historia
                    $wyszukaj_historia = mysqli_query($polaczenie, "SELECT * FROM historia WHERE nr_inwentarzowy='$dane[1]' OR nr_inwentarzowy='$dane[2]'") or die("blad przy wyszukaj_historia" . mysqli_error($polaczenie));
                    $licznik_wyszukajHistoria = mysqli_num_rows($wyszukaj_historia);
                    // materialy ekspoloatacyjne - drukarki
                    $wyszukaj_wymiane_materialow = mysqli_query($polaczenie, "SELECT * FROM historia WHERE nr_inwentarzowy='$dane[1]' AND kod='6'") or die(mysqli_error($polaczenie));
                    $licznik_drukarki = mysqli_num_rows($wyszukaj_wymiane_materialow);
                    $wyszkuja_wymiane = mysqli_query($polaczenie, "SELECT * FROM historia WHERE nr_inwentarzowy='$dane[1]' AND kod='6'") or die(mysqli_error($polaczenie));
                    $wyszukaj_wymiane_materialow_eksploatacyjnych2 = mysqli_query($polaczenie, "SELECT * FROM tonery WHERE numer_in='$dane[1]' ") or die ("blad przy wyszukaj_wymiane_materialow_eksploatacyjnych2" . mysqli_error($polaczenie));
                    $licznik_drukarki2 = mysqli_num_rows($wyszukaj_wymiane_materialow_eksploatacyjnych2);
                    $liczniki_drukarki = $licznik_drukarki + $licznik_drukarki2;
                    //magazyn
                    $wyszukaj_magazyn = mysqli_query($polaczenie, "SELECT * FROM historia WHERE nr_inwentarzowy='$dane[1]' AND kod='4'") or die("bladz przy wyszukaj_magazyn" . mysqli_error($polaczenie));
                    $licznik_magazyn = mysqli_num_rows($wyszukaj_magazyn);
                    echo '<div class="nav-tabs-custom">
                <ul class="nav nav-tabs">';
                        echo "<li class='active'><a href='#tab_1' data-toggle='tab'>Informacje o Środku Trwałym</a></li>";
                        echo "<li><a href='#tab_zdarzenia' data-toggle='tab'>Zdarzenia</a></li>";
                    if ($licznik_wyszukajHistoria > 0) {
                        //zakladka historia
                        echo "<li><a href='#tab_2' data-toggle='tab'>Historia ($licznik_wyszukajHistoria)</a></li>";

                    }
                    if ($licznik_wyszukajOprogramowanie > 0) {
                        //zakladka  oprogramowanie
                        echo "<li><a href='#tab_3' data-toggle='tab'>Oprogramowanie ($licznik_wyszukajOprogramowanie)</a></li>";
                    }

                    if ($licznik_dokumenty > 0) {
                        //zakadka dokumenty
                        echo "<li><a href='#tab_4' data-toggle='tab'>Dokumenty ($licznik_dokumenty)</a></li>";
                    }
                    if ($liczniki_spis_raport > 0) {
                        //zakladka raporty
                        echo "<li><a href='#tab_5' data-toggle='tab' >Raport ($liczniki_spis_raport)</a></li>";
                    }
                    if ($liczniki_drukarki > 0) {
                        //zakladka drukarki
                        echo "<li><a href='#tab_6' data-toggle='tab' >Materiały Ekspolatacyjne ($liczniki_drukarki)</a></li>";
                    }
                    echo '</ul>
                <div class="tab-content">
               
                  <div class="tab-pane active" id="tab_1">';
                    echo "<table class='table table-responsive table-bordered'>";
                    if(isset($seryjny_stary_format))
                    {
                        echo "<tr><th>Nr inwentarzowy</th><td>$dane[1] $seryjny_stary_format $dane[3]</td><th>Nr fabryczny</th><td>$dane[4]</tr>";
                    }
                    $nr_inwent_naklejka = $dane[1];
                    if(!isset($nr_inwent_naklejka))
                    {
                        $nr_inwent_naklejka =$dane[3];
                    }
                    echo "<tr><th>Nr inwentarzowy</th><td>$dane[1]  $dane[3]</td><th>Nr fabryczny</th><td>$dane[4]</tr>";
                    echo "<tr><th>Na stanie:</th><td>$dane[6]</td><th>Data wprowadzenia:</th><td>$formatowanie_daty</td></tr>";
                    echo "<tr><th>Źródło finansowania:</th><td>$dane[8]</td><th>Wartość:</th><td>$formatowanie_wartosc zł</td></tr>";
                    echo "<tr><th>Gwarancja / UMOWA:</th><td></td><th>Gwarancja do:</th><td></td></tr>";
                    echo "<tr><th>Uwagi</th><td colspan='3' class='text-justify'>$dane[10]</td></tr>";

                    if(isset($seryjny_stary_format))
                    {
                        $pobierzDaneOsprzecie_inveo = mysqli_query($polaczenie, "SELECT ST_OPIS, ST_ID FROM inveo WHERE ST_NR_INWENTARZOWY='$dane[1]' OR ST_NR_INWENTARZOWY='$seryjny_stary_format'") or die("Bład przy pobierzDaneOsprzecie_inveo" . mysqli_error($polaczenie));
                    }
                    else
                    {
                        $pobierzDaneOsprzecie_inveo = mysqli_query($polaczenie, "SELECT ST_OPIS, ST_ID FROM inveo WHERE ST_NR_INWENTARZOWY='$dane[1]'") or die("Bład przy pobierzDaneOsprzecie_inveo" . mysqli_error($polaczenie));
                    }
                    // DANE BAZA INVEO
                    if (mysqli_num_rows($pobierzDaneOsprzecie_inveo) > 0) {
                        while ($inveo = mysqli_fetch_array($pobierzDaneOsprzecie_inveo)) {
                            echo "<tr><th colspan='4' class='text-center'>Baza INVEO:</th> </tr>";
                            echo "<tr><th>Opis:</th><td colspan='3' class='text-justify'>$inveo[0]</td></tr>";
                            $id_inveo = $inveo[1];
                        }
                    }
                    // KONIEC - DANA BAZA INVEO

                    // SKŁADNIKI INVEO

                    $pobierzDaneOskladniki_inveo = mysqli_query($polaczenie, "SELECT id, STS_LP, STS_OPIS FROM `inveo_skladniki` WHERE STS_ST_ID='$id_inveo'")
                    or die("blad przy pobierzDaneSkladnik_inveo" . mysqli_error($polaczenie));
                    if (mysqli_num_rows($pobierzDaneOskladniki_inveo)) {
                        echo "<tr><th colspan='4' class='text-center'>Składniki z INVEO</th></tr>";
                        echo "<tr><th>LP</th><th colspan='2'>SKŁADNIK</th><th>AKCJA</th></tr>";
                        while ($skladnikiInveo = mysqli_fetch_array($pobierzDaneOskladniki_inveo)) {
                            echo "<tr><td>$skladnikiInveo[STS_LP]</td><td colspan='2'>$skladnikiInveo[STS_OPIS]</td><td>
                            <a class='btn-sm btn-info' href='naklejka.php?a=skladnik_inveo&id=$skladnikiInveo[id]&nr_inwentarzowy=$nr_inwent_naklejka'>NAKLEJKA</a> 
                            <a class='btn-sm bg-purple'>ROZKOMPLETOWANIE</a>
                            <a class='btn-sm btn-danger'>USUŃ</a>
                            </td></tr>";
                        }
                    }
                    echo "</table>";

                    // KONIEC - SKŁADNIKI INVEO
                        echo'</div>';


                    echo '<div class="tab-pane" id="tab_zdarzenia">';
                    echo "<table class='table'>";
                    echo "<tr><th class='text-bold text-center'>Utwórz protokół:</th></tr>";
                    echo"<tr><td><a href='#' class='btn btn-info form-control'>Stanu technicznego</a></td></tr>";
                    echo"<tr><td><a href='#' class='btn btn-primary form-control'>Rozkompletowania</a></td></tr>";
                    echo"<tr><td><a href='#' class='btn btn-warning form-control'>Skompletowania</a></td></tr>";
                    echo "<tr><th class='text-bold text-center'>Utwórz Dokument:</th></tr>";
                    echo"<tr><td><a href='#' class='btn btn-success form-control'>Asygnata</a></td></tr>";
                    echo"<tr><td><a href='naklejka.php?a=srodek_trwaly&nr_inwentarzowy=$nr_inwent_naklejka&nazwa_srtw=$nazwa_naklejka' class='btn btn-danger form-control'>Naklejka</a></td></tr>";
                    echo "<tr><th class='text-bold text-center'>Magazyn:</th></tr>";
                    echo"<tr><td><a href='#' class='btn btn-info form-control'><span class='fa fa-truck'> Wyślij na Magazyn</span></a></td></tr>";
                    echo"<tr><td><a href='#' class='btn btn-info form-control'>Wyślij na Magazyn</a></td></tr>";
                    echo "</table>";
                    echo '</div>';
                  echo'<div class="tab-pane" id="tab_2">';
                    if ($licznik_wyszukajHistoria > 0) {
                            echo"<table class='table table-bordered'>";
                            echo "<thead><tr><th>Data</th><th>Zdarzenie</th></tr></thead>";
                        while ($historia = mysqli_fetch_array($wyszukaj_historia)) {
                            if ($historia[4] == '1') {
                                //Rozkompletowanie
                                echo "<tr><td>$historia[3]</td><td>Utworzono protokół Rozkompletowania nr: $historia[9] Protokół stworzył : $historia[1] dnia: $historia[7]</td></tr>";
                            } elseif ($historia[4] == '2') {
                                //Protokół Stanu technicznego
                                echo "$historia[3] - Utworzono protokół Stanu Technicznego nr: $historia[9] Protokół stworzył : $historia[1] dnia: $historia[7]</td></tr>";
                            } elseif ($historia[4] == '3') {
                                //Serwis
                                echo "<div class='bg-yellow disabled color-palette'>";
                                echo "$historia[3]- Zdarzenie Serwisowe </br>";
                                echo "<b>Problem:</b> $historia[7]</br>";
                                echo "<b>Rozwiązanie:</b> $historia[8]</br>";
                                if ($historia[9] != '') {
                                    echo "<b>Dokument:</b> $historia[9]</br>";
                                }
                                echo "<b>Wpisu dokonał:</b> $historia[1], <b>Wydział:</b> $historia[2]</td></tr>";
                                echo "</div>";

                            } elseif ($historia[4] == '4') {
                                //Magazyn
                                while ($magazyn = mysqli_fetch_array($wyszukaj_magazyn)) {
                                    echo "<tr><td>$magazyn[3] </td><td> Przeniesiono na magazyn: $magazyn[7] Opis: $magazyn[8]</td></tr>";
                                }

                            } elseif ($historia[4] == '5') {
                                //Spis
                                while ($spis = mysqli_fetch_array($wyszukaj_spis)) {
                                    echo "$spis[3] - Utworzył raport: $spis[1]";
                                }

                            } elseif ($historia[4] == '6') {
                                //Drukarki
                                while ($drukarki33 = mysqli_fetch_array($wyszkuja_wymiane)) {

                                    echo "$drukarki33[3] - Wymieniony: $drukarki33[7] przez: $drukarki33[1]. Stan licznika: $drukarki33[10]</td></tr>";
                                }
                            } elseif ($historia[4] == '7') {
                                //tu cos bedzie
                            }

                        }
                        echo "</table>";
                    }
                    echo '</div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_3">';
                    //oprogramowanie
                    if ($licznik_wyszukajOprogramowanie > 0) {
                        while ($oprogramowanie = mysqli_fetch_array($wyszukaj_oprogramowanie)) {
                            echo "$oprogramowanie[0] $oprogramowanie[1] $oprogramowanie[2] </br>";
                        }
                    }
                    echo '</div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_4">';
                    //dokumenty

                    echo "<p class='text-center text-bold'>Historia dokumentów: </p>";
                    echo"<table class='table table-bordered'>";
                    echo "<thead><tr><th>Data</th><th>Zdarzenie</th></tr></thead>";
                    while ($dokumenty = mysqli_fetch_array($wyszukaj_dokumenty)) {
                        if ($dokumenty[4] == '1') {
                            //Rozkompletowanie
                            echo "<tr><td>$dokumenty[3]</td><td>Utworzono protokół Rozkompletowania nr: $dokumenty[9] Protokół stworzył : $dokumenty[1] dnia: $dokumenty[7]</td></tr>";
                        } elseif ($dokumenty[4] == '2') {
                            //Protokół Stanu technicznego
                            echo "<tr><td>$dokumenty[3]</td><td>Uworzono protokół Stanu Technicznego nr: $dokumenty[9] Protokół stworzył : $dokumenty[1] dnia: $dokumenty[7]</td></tr>";
                        }
                    }
                    echo "</table>";
                    echo '</div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_5">';
                    //raport + spis
                    while ($raporty = mysqli_fetch_array($wyszukaj_raporty)) {

                        echo "Wpis posiada raport z dnia: $raporty[3] utworzony przez: $raporty[1]. Wyswietl</br>";
                    }
                    while ($spis = mysqli_fetch_array($wyszukaj_spis)) {
                        echo "Wpis posiada raport z dnia: $spis[23] utworzony przez: $spis[24]. Wyswietl</br>";
                    }

                    echo '</div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_6">';
                    //drukarki
                    if ($liczniki_drukarki > 0) {
                        while ($druk = mysqli_fetch_array($wyszukaj_wymiane_materialow)) {

                            echo "$druk[3] - Wymieniony: $druk[7] przez: $druk[1]. Stan licznika: $druk[10] </br>";
                        }
                    }
                    if ($licznik_drukarki2 > 0) {


                        while ($drukarki = mysqli_fetch_array($wyszukaj_wymiane_materialow_eksploatacyjnych2)) {
                            echo "$drukarki[5] - Wymieniony: Toner przez: $drukarki[6]. Stan licznika: $drukarki[4] </br>";
                        }
                    }
                    echo '</div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->';

                }

            }
        }
        else {

            echo '
                <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Wyszukiwarka</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                <form name="wyszukiwarka" method="post" action="index.php?a=wyszukaj">
            <input type="text" name="wyszukiwarka" class="form-control">
            <table><tr>
            <th><input type="submit" class="form-control btn btn-warning" name="numer" value="Numer"></th>
            <td><input type="submit" class="form-control btn btn-danger" name="dokument" value="Dokument"></td>
            </tr></table>
            </form>
            </div><!-- /.box-body -->
              </div><!-- /.box -->';

            echo '
                <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Lista Zmian</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
            <table class="table table-striped">
            <tr><th>Data</th><th>Opis</th></tr>';
            $pobierz_listeZmian=mysqli_query($polaczenie,"SELECT data, opis FROM lista_zmian")or die("Blad przy pobierz_listeZmian".mysqli_error($polaczenie));
            if(mysqli_num_rows($pobierz_listeZmian))
            {
                while ($listaZmian=mysqli_fetch_array($pobierz_listeZmian)){
                    echo "<tr><td>$listaZmian[data]</td><td>$listaZmian[opis]</td></tr>";
                }
            }

            echo'</table>
            
            </div><!-- /.box-body -->
              </div><!-- /.box -->';
        }
        ?>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include'dol.php'; ?>
