<?php
include 'config.php';
include './funkcje/funkcje_naklejka.php';
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
$uzytkownik_pokoj = $user_data['pomieszczenie'];
$użytkownik_imie_nazwisko = $uzytkownik_imie . " " . $uzytkownik_nazwisko;
$data_aktualna_pelna = date("Y-m-d H:i:s");
//dane z POST

if(isset($_REQUEST['nr_inwentarzowy']))
{
    $nr_inwentarzowy = $_REQUEST['nr_inwentarzowy'];
}
else
{
    $nr_inwentarzowy='';
}

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
            Naklejki
            <small>Do wydrukowania</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Naklejki</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                // KREATOR PROJEKTOWANIA NAKLEJKI
                if($a=='projekt')
                {
                    echo "<table class='table'><form action='naklejka.php?a=zapisz_projekt' method='post'>";
                    echo "<tr><th>Nr Ewidencyjny</th><td><input type='text' class='form-control' name='naklejka_nr_ewidencyjny' placeholder='tutaj wpisz nr ewidencyjny'></td></tr>";
                    echo "<tr><th>Treść (Max 70 znaków):</th><td><input type='text' class='form-control' name='naklejka_tresc' placeholder='tutaj wpisz treść / nazwę środka trwałego'></td></tr>";
                    echo "<tr><th>Naklejkę dostarczyć do: </th><td><input type='text' name='naklejka_przeznacznie' class='form-control' value='$użytkownik_imie_nazwisko pok: $uzytkownik_pokoj'></td></tr>";
                    echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapisz' class='btn btn-primary form-control' value='Zapisz naklejkę'></th></tr>";
                    echo "</form></table>";
                }
                // KONIEC PROJEKTOWANIA NAKLEJKI

                // DRUKOWANIE NAKLEJKI - SKLADNIK Z INVEO
                elseif ($a=='skladnik_inveo')
                {
                    if(isset($nrID))
                    {
                        if (isset($nr_inwentarzowy))
                        {
                            $naklejka_tresc=PobierzOpisInveo($nrID);
                            echo "<table class='table'><form action='naklejka.php?a=zapisz_projekt' method='post'>";
                            echo "<tr><th>Nr Ewidencyjny</th><td><input type='text' class='form-control'   value='$nr_inwentarzowy' disabled='disabled'><input type='hidden' name='naklejka_nr_ewidencyjny' value='$nr_inwentarzowy'></td></tr>";
                            echo "<tr><th>Treść (Max 70 znaków):</th><td><input type='text' class='form-control' name='naklejka_tresc' value='$naklejka_tresc'></td></tr>";
                            echo "<tr><th>Naklejkę dostarczyć do: </th><td><input type='text' name='naklejka_przeznacznie' class='form-control' value='$użytkownik_imie_nazwisko pok: $uzytkownik_pokoj'></td></tr>";
                            echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapisz' class='btn btn-primary form-control' value='Zapisz naklejkę'></th></tr>";
                            echo "</form></table>";
                        }
                        else
                        {
                            echo"<p>Błąd! Brak Nr inwentarzowego głownego składnika lub wybrany składnik nie istnieje. Spróbuj jeszcze raz</p>";
                        }
                    }
                    else
                    {
                        echo"<p>Błąd! Brak nr ID składnika z Inveo lub wybrany składnik nie istnieje. Spróbuj jeszcze raz</p>";
                    }
                }
                // KONIEC  NAKLEJKI - SKLADNIK Z INVEO

                // NAKLEJKI - SRODEK TRWAŁY
                elseif ($a=='srodek_trwaly')
                {
                    if (isset($nr_inwentarzowy))
                    {
                        $naklejka_tresc=$_REQUEST['nazwa_srtw'];
                        echo "<table class='table'><form action='naklejka.php?a=zapisz_projekt' method='post'>";
                        echo "<tr><th>Nr Ewidencyjny</th><td><input type='text' class='form-control'   value='$nr_inwentarzowy' disabled='disabled'><input type='hidden' name='naklejka_nr_ewidencyjny' value='$nr_inwentarzowy'></td></tr>";
                        echo "<tr><th>Treść (Max 70 znaków):</th><td><input type='text' class='form-control' name='naklejka_tresc' value='$naklejka_tresc'></td></tr>";
                        echo "<tr><th>Naklejkę dostarczyć do: </th><td><input type='text' name='naklejka_przeznacznie' class='form-control' value='$użytkownik_imie_nazwisko pok: $uzytkownik_pokoj'></td></tr>";
                        echo "<tr><th colspan='2'><input type='submit' name='przycisk_zapisz' class='btn btn-primary form-control' value='Zapisz naklejkę'></th></tr>";
                        echo "</form></table>";
                    }
                    else
                    {
                        echo"<p>Błąd! Brak Nr inwentarzowego głownego składnika lub wybrany składnik nie istnieje. Spróbuj jeszcze raz</p>";
                    }
                }
                // KONIEC NAKLEJKI - SRODEK TRWAŁY

                elseif ($a=='usun')
                {
                    $przenies_do_wydrukowanych = mysqli_query($polaczenie,"UPDATE naklejki SET status = '1', data_druku = '$data_aktualna_pelna' WHERE id = $nrID")
                        or die("Blad przy przenies_do_wydrukowanych".mysqli_query($polaczenie));
                    Przekierowanie("Przeniesiono pomyślnie, nastąpi przekierowanie","naklejka.php");
                }

                // ZAPIS PROJEKTU NAKLEJKI

                elseif ($a=='zapisz_projekt')
                {
                    if(isset($_POST['przycisk_zapisz']))
                    {
                        $zapis_nr_ewidencyjny = $_POST['naklejka_nr_ewidencyjny'];
                        $zapis_tresc = $_POST['naklejka_tresc'];
                        $zapis_przeznaczenie = $_POST['naklejka_przeznacznie'];
                        $zapiszNaklejkeDoBazy = mysqli_query($polaczenie,"INSERT INTO naklejki (nr_inwent, pokoj, kto, data_dodania, nazwa) 
                        VALUES ('$zapis_nr_ewidencyjny', '$zapis_przeznaczenie', '$użytkownik_imie_nazwisko', '$data_aktualna_pelna', '$zapis_tresc')")
                            or die("Bład przy zapiszNaklejkeDoBazy. ".mysqli_error($polaczenie));
                        $id_naklejki = mysqli_insert_id($polaczenie);
                        echo "<p>Utworzono naklejkę pomyślnie dla nr $zapis_nr_ewidencyjny. <a href='naklejka.php' class='btn'>POWRÓT</a> <a href='fpdf17/generuj_naklejka.php?a=naklejka&id=$id_naklejki'>GENERUJ NAKLEJKĘ</a></p>";
                    }
                    else
                    {
                        Przekierowanie('Bład zapisu nastąpi powrót..','naklejka.php');
                    }
                }
                // KONIEC ZAPIS PROJEKTU NAKLEJKI


                // WYŚWIETL WSZYSTKIE NIEWYDRUKOWANE NAKLEJKI
                else
                {
                    echo"<p><a href='naklejka.php?a=projekt' class='btn btn-success'>Zaprojektuj naklejkę</a></p>";
                    // POCZĄTEK ZAKŁADKA - MENU
                    echo '<div class="nav-tabs-custom">';
                    echo'<ul class="nav nav-tabs">';
                        echo "<li class='active'><a href='#zakladka_niewydrukowane' data-toggle='tab'>Naklejki niewydrukowane</a></li>";
                        echo "<li><a href='#zakladka_wydrukowane' data-toggle='tab'>Naklejki wydrukowane</a></li>";
                    echo  '</ul>';
                    // KONIEC ZAKŁADKA - MENU DEKLARACJA

                    // POCZATEK ZAKŁADEK ZAWARTOŚĆ
                    echo'<div class="tab-content">';
               
                    //ZAKŁADKA - WYDRUKOWANE
                    echo'<div class="tab-pane active" id="zakladka_niewydrukowane">';
                    echo "<table class='table' id='example1'>";
                    echo "<thead><tr><th>Nr inwentarzowy</th><th>Treść</th><th>Data zamówienia</th><th>Zamawiający</th><th>Przeznaczenie / Dostarczyć do</th><th>Akcja</th></tr></thead>";
                    $pobierz_niewydrukowane_naklejki=mysqli_query($polaczenie,"SELECT id, nr_inwent, pokoj, kto, data_dodania, nazwa FROM naklejki WHERE status = '0'")
                        or die("Bład przy pobierz_niewydrukowane_naklejki ".mysqli_error($polaczenie));
                    if(mysqli_num_rows($pobierz_niewydrukowane_naklejki)>0)
                    {
                        while ($niewydrukowane_naklejki = mysqli_fetch_array($pobierz_niewydrukowane_naklejki))
                        {
                            echo "<tr><td>$niewydrukowane_naklejki[nr_inwent]</td><td>$niewydrukowane_naklejki[nazwa]</td><td>$niewydrukowane_naklejki[data_dodania]</td>
                            <td>$niewydrukowane_naklejki[kto]</td><td>$niewydrukowane_naklejki[pokoj]</td><td>";
                            echo "<a href='fpdf17/generuj_naklejka.php?a=naklejka&id=$niewydrukowane_naklejki[id]' class='btn-sm bg-fuchsia'>DRUKUJ</a>";
                            echo "<a href='naklejka.php?a=usun&id=$niewydrukowane_naklejki[id]' class='btn-sm btn-danger'>WYDRUKOWANA</a>";
                            echo"<td></tr>";
                        }
                    }
                    echo "</table>";
                    echo"</div>";
                    // KONIEC ZAKŁADKA - WYDRUKOWANE

                    //ZAKŁADKA - WYDRUKOWANE
                    echo '<div class="tab-pane" id="zakladka_wydrukowane">';
                    echo "<table class='table table-bordered' id='example3'>";
                    echo "<thead><tr><th>Nr inwentarzowy</th><th>Treść</th><th>Data zamówienia</th><th>Zamawiający</th><th>Przeznaczenie / Dostarczyć do</th></tr></thead>";
                    $pobierz_niewydrukowane_naklejki=mysqli_query($polaczenie,"SELECT id, nr_inwent, pokoj, kto, data_dodania, nazwa FROM naklejki WHERE status = '1'")
                    or die("Bład przy pobierz_niewydrukowane_naklejki ".mysqli_error($polaczenie));
                    if(mysqli_num_rows($pobierz_niewydrukowane_naklejki)>0)
                    {
                        while ($niewydrukowane_naklejki = mysqli_fetch_array($pobierz_niewydrukowane_naklejki))
                        {
                            echo "<tr><td>$niewydrukowane_naklejki[nr_inwent]</td><td>$niewydrukowane_naklejki[nazwa]</td><td>$niewydrukowane_naklejki[data_dodania]</td>
                            <td>$niewydrukowane_naklejki[kto]</td><td>$niewydrukowane_naklejki[pokoj]</td></tr>";
                        }
                    }
                    echo "</table>";
                    echo"</div>";
                    //KONIEC ZAKŁADKA - WYDRUKOWANE
                    echo '</div>';// KONIEC ZAKŁADKA - MENU
                    echo '</div>';// KONIEC ZAKŁADEK ZAWARTOŚĆ

                }
                // KONIEC WYWIETL WSZYSTKIE NAKLEJKI

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
