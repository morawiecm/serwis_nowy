<?php
include 'config.php';
include 'funkcje/funkcje_uzytkownicy.php';
check_login();


// dane uzytkownika z sesji
$user_data = get_user_data();
$uzytkownik_imie=$user_data['imie'];
$uzytkownik_nazwisko=$user_data['nazwisko'];
$uzytkownik_nazwa=$user_data['user_name'];
$uzytkownik_id=$user_data['user_id'];
$uzytkownik_wydzial = $user_data['wydzial'];
$uzytkownik_sekcja = $user_data['sekcja'];
$uzytkownik_uprawnienia=$user_data['specialne'];
$użytkownik_imie_nazwisko=$uzytkownik_imie." ".$uzytkownik_nazwisko;
//dane z POST


if($uzytkownik_uprawnienia==1)
{
    $uprawienia='Administrator';
}
else
{
    $uprawienia='Użytkownik';
}


?>
<?php include 'gora.php';?>
<?php
include 'pasek.php';
include 'menu.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Zgłoś błąd
            <!--<small>Wyszukiwarka</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Zgłoś błąd</a></li>
            <li class="active">Formularz zgloszeniowy</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Formularz zgłoszeniowy</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                if($a=='pokaz_zgloszenia')
                {
                    if($uzytkownik_uprawnienia==1)
                    {
                    $zapytaniePobierzZgloszenia="
                    SELECT bledy.id,
                    bledy.ranga,
                     bledy.data_utworzenia,
                     bledy.data_zakonczenia,
                      bledy.tytul,
                       bledy.zakonczone,
                        users.imie,
                         users.nazwisko
                          FROM bledy
                           INNER JOIN users ON bledy.uzytkownik_id = users.user_id";
                    echo "<table class='table table-striped table-hover'>";
                    echo "<thead><tr><th>ID ZGŁOSZENIA</th><th>PIORYTET</th><th>ZGŁASZAJĄCY</th><th>DATA ZGŁOSZENIA / ZAKOŃCZENIA</th><th>TYTUŁ</th><th>STATUS</th><th>AKCJA</th></tr></thead>";
                    $pobierzZgloszenia=mysqli_query($polaczenie,$zapytaniePobierzZgloszenia)
                        or die("Blad przy pobierzZgloszenia".mysqli_error($polaczenie));
                    if(mysqli_num_rows($pobierzZgloszenia)>0)
                    {
                        while ($zglosznie=mysqli_fetch_array($pobierzZgloszenia))
                        {
                            echo"<tr>";
                            echo"<td>$zglosznie[id]</td>";
                            echo"<td>$zglosznie[ranga]</td>";
                            echo"<td>$zglosznie[imie] $zglosznie[nazwisko]</td>";
                            echo"<td>$zglosznie[data_utworzenia] / $zglosznie[data_zakonczenia]</td>";
                            echo"<td>$zglosznie[tytul]</td>";
                            echo"<td>";
                            if($zglosznie['zakonczone']==0)
                            {
                                echo "<a href='#' class='btn-sm btn-success'>NOWE</a>";
                            }
                            else
                            {
                                echo "<a href='#' class='btn-sm btn-danger'>ZAKOŃCZONE</a>";
                            }
                            echo"</td>";
                            echo"<td><a href='zglos_blad.php?a=pokaz_zgloszenie&id=$zglosznie[id]'>Pokaz zgloszenie</a></td>";
                            echo"</tr>";
                        }
                    }
                    else
                    {
                        echo"<tr><th colspan='6'>Brak zgloszeń...oczekuj na jakieś.....</th></tr>";
                    }
                    echo"</table>";
                    }
                    else{
                        echo "Brak uprawnień do przegladania strony. <a href='index.php'>POWRÓT</a>";
                    }
                }
                elseif ($a=='pokaz_zgloszenie')
                {
                    if($uzytkownik_uprawnienia==1 && $nrID!='')
                    {
                        $zapytaniePobierzZgloszenia="
                    SELECT bledy.id,
                    bledy.ranga,
                     bledy.data_utworzenia,
                      bledy.tytul,
                       bledy.zakonczone,
                        users.imie,
                         users.nazwisko,
                          bledy.odpowiedz,
                           bledy.data_zakonczenia,
                           bledy.ranga,
                            bledy.opis
                          FROM bledy
                           INNER JOIN users ON bledy.uzytkownik_id = users.user_id
                           WHERE bledy.id='$nrID'";
                        echo "<table class='table table-striped table-hover'>";
                        $pobierzZgloszenia=mysqli_query($polaczenie,$zapytaniePobierzZgloszenia)
                        or die("Blad przy pobierzZgloszenia".mysqli_error($polaczenie));
                        if(mysqli_num_rows($pobierzZgloszenia)>0)
                        {
                            while ($zglosznie=mysqli_fetch_array($pobierzZgloszenia))
                            {
                                echo"<tr><th>ID ZGŁOSZENIA:</th><td>$zglosznie[id]</td><th>STATUS</th><td> ";
                                if($zglosznie['zakonczone']==0)
                                {
                                    echo "<a href='#' class='btn btn-success form-control text-center'>NOWE</a>";
                                }
                                else
                                {
                                    echo "<a href='#' class='btn btn-danger form-control text-center'>ZAKOŃCZONE</a>";
                                }
                                echo"</td></tr>";
                                echo"<tr><th>RANGA:</th><td>$zglosznie[ranga]</td>";
                                echo"<th>ZGŁASZAJĄCY</th><td>$zglosznie[imie] $zglosznie[nazwisko]</td></tr>";
                                echo"<tr><th>DATA ZGŁOSZENIA</th><td>$zglosznie[data_utworzenia]</td>";
                                echo"<th>DATA ZAKOŃCZENIA</th><td>$zglosznie[data_zakonczenia]</td></tr>";
                                echo "<tr><th colspan='4'></br><br></th></tr>";
                                echo"<tr><th>TYTUŁ</th><td colspan='3'>$zglosznie[tytul]</td></tr>";
                                echo "<tr><th colspan='4' class='text-center'>OPIS</th></tr>";
                                echo "<tr><td colspan='4'>$zglosznie[opis]</td></tr>";
                                echo "<tr><form method='post' action='zglos_blad.php?a=zapisz_odpowiedz'><th colspan='4' class='text-center'>ODPOWIEDŹ / ROZWIĄZANIE PROBLEMU:</th></tr>";
                                echo "<tr><td colspan='4'><textarea class='form-control' name='blad_odpowiedz'>$zglosznie[odpowiedz]</textarea></td></tr>";
                                echo "<tr><th>Ranga problemu:</th><td colspan='3'><select name='blad_ranga' class='form-control'><option selected='selected'>$zglosznie[ranga]</option><option>Krytyczny</option><option>Poważny</option><option>Niski</option><option>Rozszerzenie</option></select> </td></tr>";
                                echo "<tr><th colspan='4'><input type='submit' name='przycisk_dodaj_odpowiedz' class='btn btn-info form-control' value='Zapisz odpowiedz'></th></tr>";
                                echo "<input type='hidden' name='blad_nr_zgloszenia' value='$nrID'></form></table>";
                                echo "<p><a href='zglos_blad.php?a=zakoncz_zlecenie&id=$nrID' class='btn bg-purple form-control'>Zakończ zgłoszenie</a></p>";
                            }
                        }
                        else
                        {
                            echo"<tr><th colspan='6'>Brak zgloszeń...oczekuj na jakieś.....</th></tr>";
                        }
                        echo"</table>";
                    }
                    else{
                        echo "Brak uprawnień do przegladania strony. <a href='index.php'>POWRÓT</a>";
                    }
                }
                elseif ($a=='pokaz_zgloszenie_opis')
                {
                    if($uzytkownik_uprawnienia==1 && $nrID!='')
                    {
                        $zapytaniePobierzZgloszenia="
                    SELECT bledy.id,
                    bledy.ranga,
                     bledy.data_utworzenia,
                      bledy.tytul,
                       bledy.zakonczone,
                        users.imie,
                         users.nazwisko,
                          bledy.odpowiedz,
                           bledy.data_zakonczenia,
                            bledy.opis
                          FROM bledy
                           INNER JOIN users ON bledy.uzytkownik_id = users.user_id
                           WHERE bledy.id='$nrID'";
                        echo "<table class='table table-striped table-hover'>";
                        $pobierzZgloszenia=mysqli_query($polaczenie,$zapytaniePobierzZgloszenia)
                        or die("Blad przy pobierzZgloszenia".mysqli_error($polaczenie));
                        if(mysqli_num_rows($pobierzZgloszenia)>0)
                        {
                            while ($zglosznie=mysqli_fetch_array($pobierzZgloszenia))
                            {
                                echo"<tr><th>ID ZGŁOSZENIA:</th><td>$zglosznie[id] ";
                                if($zglosznie['zakonczone']==0)
                                {
                                    echo "<a href='#' class='btn-sm btn-success'>NOWE</a>";
                                }
                                else
                                {
                                    echo "<a href='#' class='btn-sm btn-danger'>ZAKOŃCZONE</a>";
                                }
                                echo" RANGA: $zglosznie[ranga]</td></tr>";
                                echo"<tr><th>ZGŁASZAJĄCY</th><td>$zglosznie[imie] $zglosznie[nazwisko]</td></tr>";
                                echo"<tr><th>DATA ZGŁOSZENIA</th><td>$zglosznie[data_utworzenia]</td></tr>";
                                echo"<tr><th>TYTUŁ</th><td>$zglosznie[tytul]</td></tr>";
                                echo "<tr><th colspan='2'>OPIS</th></tr>";
                                echo "<tr><td colspan='2'>$zglosznie[opis]</td></tr>";
                                echo "<tr><th colspan='2' class='text-center'>ODPOWIEDŹ / ROZWIĄZANIE PROBLEMU:</th></tr>";
                                echo "<tr><td colspan='2'>$zglosznie[odpowiedz]</td></tr>";
                            }
                        }
                        else
                        {
                            echo"<tr><th colspan='7'>Brak zgloszeń...oczekuj na jakieś.....</th></tr>";
                        }
                        echo"</table>";
                    }
                    else{
                        echo "Brak uprawnień do przegladania strony. <a href='index.php'>POWRÓT</a>";
                    }
                }
                elseif ($a=='pokaz_zgloszenia_status')
                {
                    if($uzytkownik_uprawnienia==1)
                    {
                        $zapytaniePobierzZgloszenia="
                    SELECT bledy.id,
                    bledy.ranga,
                     bledy.data_utworzenia,
                      bledy.tytul,
                       bledy.zakonczone,
                        users.imie,
                         users.nazwisko
                          FROM bledy
                           INNER JOIN users ON bledy.uzytkownik_id = users.user_id";
                        echo "<table class='table table-striped table-hover'>";
                        echo "<thead><tr><th>ID ZGŁOSZENIA</th><th>PIORYTET</th><th>ZGŁASZAJĄCY</th><th>DATA ZGŁOSZENIA</th><th>TYTUŁ</th><th>STATUS</th><th>AKCJA</th></tr></thead>";
                        $pobierzZgloszenia=mysqli_query($polaczenie,$zapytaniePobierzZgloszenia)
                        or die("Blad przy pobierzZgloszenia".mysqli_error($polaczenie));
                        if(mysqli_num_rows($pobierzZgloszenia)>0)
                        {
                            while ($zglosznie=mysqli_fetch_array($pobierzZgloszenia))
                            {
                                echo"<tr>";
                                echo"<td>$zglosznie[id]</td>";
                                echo"<td>$zglosznie[ranga]</td>";
                                echo"<td>$zglosznie[imie] $zglosznie[nazwisko]</td>";
                                echo"<td>$zglosznie[data_utworzenia]</td>";
                                echo"<td>$zglosznie[tytul]</td>";
                                echo"<td>";
                                if($zglosznie['zakonczone']==0)
                                {
                                    echo "<a href='#' class='btn-sm btn-success'>NOWE</a>";
                                }
                                else
                                {
                                    echo "<a href='#' class='btn-sm btn-danger'>ZAKOŃCZONE</a>";
                                }
                                echo"</td>";
                                echo"<td><a href='zglos_blad.php?a=pokaz_zgloszenie_opis&id=$zglosznie[id]'>Pokaz zgloszenie</a></td>";
                                echo"</tr>";
                            }
                        }
                        else
                        {
                            echo"<tr><th colspan='6'>Brak zgloszeń...oczekuj na jakieś.....</th></tr>";
                        }
                        echo"</table>";
                    }
                    else{
                        echo "Brak uprawnień do przegladania strony. <a href='index.php'>POWRÓT</a>";
                    }
                }


                elseif ($a=='zapisz_odpowiedz')
                {
                    if($uzytkownik_uprawnienia==1)
                    {
                        if(isset($_POST['przycisk_dodaj_odpowiedz']))
                        {
                            $blad_odpowiedz=clear($_POST['blad_odpowiedz']);
                            $blad_nr_bledu=$_POST['blad_nr_zgloszenia'];
                            $blad_ranga=$_POST['blad_ranga'];

                            $dodaj_odpowiedz=mysqli_query($polaczenie,"UPDATE bledy SET odpowiedz='$blad_odpowiedz', ranga='$blad_ranga' WHERE id='$blad_nr_bledu'")
                                or die("Blad przy dodaj_odpowiedz".mysqli_error($polaczenie));
                            echo"Doddano odpowiedz do zlecnia nr: $blad_nr_bledu <a href='zglos_blad.php?a=pokaz_zgloszenia'>POWRÓT</a>";
                        }
                        else
                        {

                            echo "Wystąpił bład ! <a href='zglos_blad.php?a=pokaz_zgloszenia'>POWRÓT</a>";
                        }
                    }
                    else
                    {
                        echo "Brak uprawnień do przegladania strony. <a href='index.php'>POWRÓT</a>";
                    }
                }

                elseif ($a=='zakoncz_zlecenie')
                {
                    if($uzytkownik_uprawnienia==1 && $nrID!='')
                    {

                            $zamknij_zlecenie=mysqli_query($polaczenie,"UPDATE bledy SET zakonczone='1', data_zakonczenia='$data_aktualna' WHERE id='$nrID'")
                                or die("Blad przy zamknij_zlecenie".mysqli_error($polaczenie));
                            echo"Zamknięto zlecnie nr: $nrID <a href='zglos_blad.php?a=pokaz_zgloszenia'>POWRÓT</a>";
                    }
                    else
                    {
                        echo "Brak uprawnień do przegladania strony. <a href='index.php'>POWRÓT</a>";
                    }
                }


                elseif ($a=='wyslij')
                {
                    if (isset($_POST['przycisk_zglos_blad']))
                    {
                        //Dane z POST
                        $blad_tytul = clear($_POST['blad_tytul']);
                        $blad_opis  = clear($_POST['blad_opis']);

                        //zapisanie do bazy
                        $zapiszZglosBlad = mysqli_query($polaczenie, "INSERT INTO bledy (data_utworzenia, uzytkownik_id, tytul, opis) 
                        VALUES ('$data_aktualna','$uzytkownik_id','$blad_tytul','$blad_opis')")
                        or die("Blad przy zapiszZglosBlad" . mysqli_error($polaczenie));
                        $nr_zgloszenia = mysqli_insert_id($polaczenie);
                        //komunikat o powodzeniu wraz z numerem zgloszenia
                        echo "Zgłoszenie zostało przyjęte.Nr zgłoszenia: $nr_zgloszenia <a href='index.php'>Powrót</a>";
                        ?>
                        <script>
                            setTimeout(function () {
                                window.location.href= 'index.php'; // the redirect goes here

                            },3000);
                        </script><?php
                    }
                    else
                    {
                        echo "Wystąpił bład przy przesyłaniu danych.. Spróbuj jeszcze raz . <a href='zglos_blad.php'>Powrót</a>";
                    }
                }
                else
                { 
                    echo "<table class='table'><form name='utworz_zgloszenie' method='post' action='zglos_blad.php?a=wyslij'>";
                    echo "<tr><th>Tytuł</th><td><input type='text' class='form-control' name='blad_tytul' placeholder='krótki opis blędu np. nie wyświetla się wpis...'></td></tr>";
                    echo "<tr><th>Opis błedu:</th><td><textarea class='form-control' placeholder='Cos się stało, gdzie i jak do tego doszło...' name='blad_opis'></textarea> </td></tr>";
                    echo "<tr><th colspan='2'><input type='submit' name='przycisk_zglos_blad' value='Zgłoś błąd' class='btn btn-primary form-control'></th></tr>";
                    echo"</form></table>";
                }
                ?>
            </div><!-- /.box-body -->

        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include 'dol.php';?>