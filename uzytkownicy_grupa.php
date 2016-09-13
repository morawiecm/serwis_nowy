<?php
include 'config.php';
include 'funkcje/funkcje_uzytkownicy.php';
include 'funkcje/funkcje_nadgodziny.php';

check_login();

// dane uzytkownika z sesji
$user_data = get_user_data();
$uzytkownik_imie=$user_data['imie'];
$uzytkownik_nazwisko=$user_data['nazwisko'];
$uzytkownik_nazwa=$user_data['user_name'];
$uzytkownik_id=$user_data['user_id'];
$uzytkownik_sekcja=$user_data['sekcja'];
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
            Grupy
            <small>Użytkownicy</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Grupy</a></li>
            <li class="active">Użytkownicy</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista Grup</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                if($a=='dodaj_grupe')
                {
                    echo"<table class='table table-striped'><form method='post' action='uzytkownicy_grupa.php?a=zapisz'>";
                    echo"<tr><th>Nazwa Grupy:</th><td><input type='text' class='form-control' name='nazwa_grupy'></td></tr>";
                    echo"<tr><th>Kierownik/Koordynator</th><td><select name='kierownik' class='form-control'>";
                    echo PobierzKierownikow();
                    echo"</select></td></tr>";
                    echo"<tr><th colspan='2' ><input type='submit' name='zapisz_grupe' value='Zapisz' class='btn btn-warning form-control'></th> </tr>";
                    echo"</form></table>";
                }
                elseif ($a=='zapisz')
                {
                    if(isset($_POST['zapisz_grupe']))
                    {
                        // wyzerowanie bledow
                        $blad_kierownik=0;
                        $blad_nazwa_grupy=0;
                        //dane z POST
                        $nazwaGrupy=$_POST['nazwa_grupy'];
                        $kierownik=$_POST['kierownik'];
                        //sprawdzamy czy nie sa puste
                        if($kierownik=='')
                        {
                            $blad_kierownik++;

                        }
                        if ($nazwaGrupy=='')
                        {
                            $blad_nazwa_grupy++;
                        }
                        // jak nie ma bledow w formularzu to zapisujemy
                        if($blad_kierownik==0 && $blad_nazwa_grupy==0)
                        {
                            $zapis_Grupa=mysqli_query($polaczenie,"INSERT INTO uzytkownicy_grupy (id, nazwa_grupy, id_kierownika) VALUES ('','$nazwaGrupy','$kierownik') ")
                                or die("Blad przy zapis_Grupa".mysqli_error($polaczenie));
                            echo'<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                             Zapisano pomyśnie grupe. <a href="uzytkownicy_grupa.php">Powrót</a>
                            </div>';
                        }
                        //jezeli bledy w formularzu
                        else
                        {
                            echo"<table class='table table-striped'><form method='post' action='uzytkownicy_grupa.php?a=zapisz'>";
                            echo"<tr><th>Nazwa Grupy:</th><td><input type='text' class='form-control' name='nazwa_grupy' value='$nazwaGrupy'>";
                            if($blad_nazwa_grupy>0)
                            {
                             echo"<p class='text-danger'>Puste pole Nazwa grupy</p>";
                            }
                            echo"</td></tr>";
                            echo"<tr><th>Kierownik/Koordynator</th><td><select name='kierownik' class='form-control'>";
                            $pobierz_listeKierownikow=mysqli_query($polaczenie,"SELECT user_id, imie,nazwisko FROM users WHERE funkcja=1")or die("Blad przy pobierz_listeKierownikow".mysqli_error($polaczenie));
                            if(mysqli_num_rows($pobierz_listeKierownikow)>0)
                            {
                                while ($listaKierownikow=mysqli_fetch_array($pobierz_listeKierownikow))
                                {
                                    echo "<option value='$listaKierownikow[user_id]'>$listaKierownikow[imie] $listaKierownikow[nazwisko] </option>";
                                }
                            }
                            else
                            {
                                echo"<option>Brak kierowniów. Zdefiniuj najpierw...</option>";
                            }
                            echo"</select></td></tr>";
                            echo"<tr><th colspan='2'><input type='submit' name='zapisz_grupe' value='Zapisz' class='btn btn-warning form-control'></th> </tr>";
                            echo"</form></table>";
                        }
                    }
                    else
                    {

                    }

                }
                elseif ($a=='pokaz_grupe')
                {
                        $pobierz_daneGrupy=mysqli_query($polaczenie,"SELECT uzytkownicy_grupy.id, uzytkownicy_grupy.nazwa_grupy, uzytkownicy_grupy.id_kierownika, users.imie, users.nazwisko FROM uzytkownicy_grupy INNER JOIN users ON uzytkownicy_grupy.id_kierownika=users.user_id WHERE id='$nrID' ORDER  BY users.imie ASC") or die("Blad przy pobierz_daneGrupy".mysqli_error($polaczenie));
                        while($daneGrupy=mysqli_fetch_array($pobierz_daneGrupy))
                        {
                            echo"<p>Grupa: $daneGrupy[1]</p>";
                            echo"<p>Kierownik: $daneGrupy[3] $daneGrupy[4]</p>";
                        }
                       // echo"<p><a href='uzytkownicy_grupa.php?a=dodaj_uzytkownika&id=$nrID' class='btn btn-info'>Dodaj użytkowników do grupy</a></p>";
                        echo"<table class='table table-striped table-hover'>";
                    $pobierz_uzytkownikowGrupy=mysqli_query($polaczenie,"SELECT users.imie, users.nazwisko, users.user_id FROM users WHERE users.grupa='$nrID' ORDER BY users.imie") or die("blad przy pobierz_uzytkownikowGrupy".mysqli_error($polaczenie));
                    if(mysqli_num_rows($pobierz_uzytkownikowGrupy)>0)
                    {
                        echo"<tr><th>LP</th><th>Imie i Nazwisko</th><th>Nadgodziny/Niedogodziny</th><th>Akcja</th></tr>";
                        $lp=0;
                        while ($uzytkownicyGrupy=mysqli_fetch_array($pobierz_uzytkownikowGrupy))
                        {
                            $lp++;
                            $minuty = PoliczMinuty($uzytkownicyGrupy['user_id']);
                            echo"<tr><td>$lp</td><td>$uzytkownicyGrupy[imie] $uzytkownicyGrupy[nazwisko]</td><td>$minuty minut</td><td><a href='nadgodziny.php?a=przeglad&id=$uzytkownicyGrupy[user_id]' class='btn-sm btn-danger'>
                            Pokaż ewidencje godzin</a> </td></tr>";
                        }
                        echo"</table>";
                    }
                    else
                    {
                        echo '<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Bład!</h4>
                    Brak użytkowników do wyświetlenia. Dodaj jakiś 
                    
                    </div>';
                    }
                }

                elseif ($a=='usun_uzytkownika_grupa')
                {
                    $usun_uzytkownikaGrupa=mysqli_query($polaczenie,"UPDATE users SET grupa='0' WHERE user_id=$nrID") or die("Blad przy usun_uzytkownkaGrupa".mysqli_error($polaczenie));
                    echo '<div class="alert alert-success alert-success ">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Sukces!</h4>
                    Usunieto użytkownika z grupy.
                    
                    </div>';
                }

                elseif ($a=='dodaj_uzytkownika')
                {
                    echo"<table><form method='post' action='uzytkownicy_grupa.php?a=zapisz_uzytkownika'> ";
                    echo"<tr><th>Użytkownik</th><td><input type='hidden' name='id_grupy' value='$nrID'><select name='uzytkownik' class='form-control'> ";
                    $pobierz_listeUzytkownikow=mysqli_query($polaczenie,"SELECT user_id, imie, nazwisko, user_name FROM users WHERE aktywny='0' AND grupa='0' ORDER BY nazwisko ASC") or die("blad przy pobierz_listeUzytkownikow".mysqli_error($polaczenie));
                    if(mysqli_num_rows($pobierz_listeUzytkownikow)>0)
                    {
                        while ($listaUzytkownikow=mysqli_fetch_array($pobierz_listeUzytkownikow))
                        {
                            echo"<option value='$listaUzytkownikow[user_id]'>$listaUzytkownikow[nazwisko] $listaUzytkownikow[imie] ($listaUzytkownikow[user_name])</option>";
                        }
                    }
                    else
                    {
                        echo "<option>Brak uzytkowników bez grup</option>";
                    }
                    echo"</select></td></tr>";
                    echo"<tr><th colspan='2'><input type='submit' name='dodaj_uzytkownika' value='Dodaj do grupy' class='btn btn-success form-control'></th></tr>";

                    echo"</form></table>";
                }

                elseif ($a=='zapisz_uzytkownika')
                {
                    if(isset($_POST['dodaj_uzytkownika']))
                    {
                    //dane z post
                        $id_uzytkownika=$_POST['uzytkownik'];
                        $id_grupy=$_POST['id_grupy'];
                        $aktualizacja_usersGrupa=mysqli_query($polaczenie,"UPDATE users SET grupa='$id_grupy' WHERE user_id='$id_uzytkownika'") or die("Blad przy aktualizacja_usersGrupa".mysqli_error($polaczenie));
                        echo '<div class="alert alert-success alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Sukces!</h4>';
                    echo"Dodano użytkownika do grupy <a href='uzytkownicy_grupa.php?a=pokaz_grupe&id=$id_grupy'>Powrót do grupy</a>";
                    echo'</div>';
                    }
                }

                elseif ($a=='usun')
                {

                }
                elseif ($a=='zmien_kierownika')
                {
                    if(isset($nrID))
                    {
                        echo "<table class='table table-bordered tabl-striped'><form method='post' action='uzytkownicy_grupa.php?a=aktualizuj_kierownika'>";
                        echo "<tr><th>Wybierz Kierownika/Kordynatora Sekcji</th><td><select name='id_kierownika' class='form-control'>";
                        echo PobierzKierownikow();
                        echo "</select><input type='hidden' name='id_grupy' value='$nrID'></td></tr>";
                        echo "<tr><th colspan='2'><input type='submit' name='przycisk_aktualizuj' value='Aktualiuj Grupę' class='btn btn-info form-control'></th></tr>";
                        echo "</form></table>";
                    }
                    else
                    {
                        echo "Bład. Zły ID Grupy";
                    }
                }
                elseif ($a=='aktualizuj_kierownika')
                {
                    if(isset($_POST['przycisk_aktualizuj']))
                    {
                        $id_kierownika=$_POST['id_kierownika'];
                        $id_grupy=$_POST['id_grupy'];
                        $aktulizacja_kierownika_grupy=mysqli_query($polaczenie,"UPDATE uzytkownicy_grupy SET id_kierownika='$id_kierownika' WHERE id ='$id_grupy'")
                            or die("Blad przy aktualizacja_kierownika_grupy".mysqli_error($polaczenie));
                        echo "Zmieniono pomyślnie Kierownika/Kordynatora grupy <a href='uzytkownicy_grupa.php'>Powrót</a>";
                    }
                    else
                    {
                        echo "Bład <a href='uzytkownicy_grupa.php'>Powrót</a>";
                    }
                }
                else{

                    echo "<p><a href='uzytkownicy_grupa.php?a=dodaj_grupe' class='btn btn-success'>Dodaj Grupę</a> </p>";
                    $pobierz_Grupy = mysqli_query($polaczenie, "SELECT uzytkownicy_grupy.id, uzytkownicy_grupy.nazwa_grupy, uzytkownicy_grupy.id_kierownika, users.imie, users.nazwisko FROM uzytkownicy_grupy INNER JOIN users ON uzytkownicy_grupy.id_kierownika=users.user_id") or die("Blad przy pobierz_Grupy" . mysqli_error($polaczenie));
                    if (mysqli_num_rows($pobierz_Grupy) > 0) {
                        $lp = 0;
                        echo "<table class='table table-striped'>";
                        echo "<tr><th>LP</th><th>Nazwa Grupy</th><th>Kierownik Grupy</th><th>Akcja</th></tr>";
                        while ($grupa = mysqli_fetch_array($pobierz_Grupy)) {
                            $lp++;
                            echo "<tr><td>$lp</td><td>$grupa[1]</td><td>$grupa[3] $grupa[4]</td><td><a href='uzytkownicy_grupa.php?a=pokaz_grupe&id=$grupa[0]' class='btn-sm btn-info'>POKAŻ</a><a href='uzytkownicy_grupa.php?a=zmien_kierownika&id=$grupa[0]' class='btn-sm btn-primary'>Zmień kierownika</a><a href='uzytkownicy_grupa.php?a=usun&id=$grupa[0]' class='btn-sm btn-danger'>USUŃ</a> </td></tr>";
                        }
                        echo "</table>";

                    } else {
                        echo '<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Bład!</h4>
                    Brak grup do wyświetlenia. Stwórz jakieś <a href="uzytkownicy_grupa.php?a=dodaj_grupe">Dodaj Grupe</a>
                    
                    </div>';
                    }
                       
                }
                ?>
                
            </div><!-- /.box-body -->
            
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include 'dol.php';?>