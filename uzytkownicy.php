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
            Użytkownicy
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Administracja</a></li>
            <li class="active">Użytkownicy</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php if($uprawienia=='Administrator') {

                if($a=='dodaj_nowego')
                {
                    echo'<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Utworz nowe konto</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="zwiń"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Usuń"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';
                    echo"<table class='table table-striped'><form name='rejestracja' method='post' action='uzytkownicy.php?a=zapisz'>
                    <tr><th>Login:</th><td><input type='text' name='login' class='form-control'></td></tr>
                    <tr><th>Hasło:</th><td><input type='password' name='haslo1' class='form-control'></td></tr>
                    <tr><th>Powtórz hasło:</th><td><input type='password' name='haslo2' class='form-control'></td></tr>
                    <tr><th>Imię</th><td><input type='text' name='imie' class='form-control'></td></tr>
                    <tr><th>Nazwisko</th><td><input type='text' name='nazwisko' class='form-control'></td></tr>
                    <tr><th>Email:</th><td><input type='email' class='form-control' name='email'></td></tr>
                    <tr><th>Jednostka</th><td><input type='text' name='jednostka' class='form-control'></td></tr>
                    <tr><th>Wydzial</th><td><input type='text' name='wydzial' class='form-control'></td></tr>
                    <tr><th>Sekcja</th><td><input type='text' name='sekcja' class='form-control'></td></tr>
                    <tr><th>Specjalne</th><th><input type='number' name='specjalne' class='form-control'></th></tr>
                    <tr><td colspan='2'><input type='submit' name='zapisz' value='Dodaj użytkownika' class='btn btn-success form-control'></td></tr>
                    </form></table>";
                    echo' </div><!-- /.box-body -->

        </div><!-- /.box -->

    </section><!-- /.content -->';

                }

                elseif($a=='zapisz')
                {
                    echo'<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Utworz nowe konto</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="zwiń"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Usuń"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';
                    if(isset($_POST[zapisz]))
                    {
                    //wartosci bledow
                    $kontrola_bledow=0;
                    $blad_login=0;
                    $blad_login_duplikat=0;
                    $blad_haslo=0;
                    $blad_haslo_puste=0;
                    $blad_imie=0;
                    $blad_nazwisko=0;
                    $blad_email=0;
                    $blad_jednostka=0;
                    $blad_wydzial=0;


                        if($_POST[login]=='')
                        {
                            $kontrola_bledow++;
                            $blad_login++;
                        }
                        if($_POST[login]!='')
                        {
                            $login=clear($_POST[login]);
                            $sprawdz_login=mysqli_query($polaczenie,"SELECT user_name FROM users WHERE user_name='$login'") or die(mysqli_error($polaczenie));
                            if(mysqli_num_rows($sprawdz_login)>0)
                            {
                                $kontrola_bledow++;
                                $blad_login_duplikat++;
                            }
                        }
                        if($_POST[haslo1]=='' || $_POST[haslo2]=='')
                        {
                            $kontrola_bledow++;
                            $blad_haslo_puste++;
                        }
                        if($_POST[haslo1]!='' && $_POST[haslo2]!='')
                        {
                            if($_POST[haslo1] != $_POST[haslo2])
                            {
                                $kontrola_bledow++;
                                $blad_haslo++;
                            }
                        }
                        if($_POST[imie]=='')
                        {
                            $kontrola_bledow++;
                            $blad_imie++;
                        }
                        if($_POST[nazwisko]=='')
                        {
                            $kontrola_bledow++;
                            $blad_nazwisko++;
                        }
                        if($_POST[email]=='')
                        {
                            $kontrola_bledow++;
                            $blad_email++;
                        }
                        if($_POST[jednostka]=='')
                        {
                            $kontrola_bledow++;
                            $blad_jednostka++;
                        }
                        if($_POST[wydzial]=='')
                        {
                            $kontrola_bledow++;
                            $blad_wydzial++;
                        }

                        if($kontrola_bledow>0)
                        {
                            echo"<table class='table table-striped'><form name='rejestracja' method='post' action='uzytkownicy.php?a=zapisz'>
                    <tr><th>Login:</th><td><input type='text' name='login' class='form-control' value='$_POST[login]'>";
                            if($blad_login==1)
                            {
                                echo"<p class='text-red'>Nie podano loginu !</p>";
                            }
                            if($blad_login_duplikat>0)
                            {
                                echo"<p class='text-red'>Podany login istnieje juz w bazie !</p>";
                            }
                            echo"</td></tr>
                    <tr><th>Hasło:</th><td><input type='password' name='haslo1' class='form-control' value='$_POST[haslo1]'>";
                            if($blad_haslo_puste==1)
                            {
                                echo"<p class='text-red'>Pole Hasło nie może być puste !</p>";
                            }
                            if($blad_haslo==1 ||$blad_haslo_puste==1)
                            {
                                echo"<p class='text-red'>Hasła muszą być identyczne !</p>";
                            }
                            echo"</td></tr>
                    <tr><th>Powtórz hasło:</th><td><input type='password' name='haslo2' class='form-control' value='$_POST[haslo2]'></td></tr>
                    <tr><th>Imię</th><td><input type='text' name='imie' class='form-control' value='$_POST[imie]'>";
                            if($blad_imie==1)
                            {
                                echo"<p class='text-red'>Nie podano imienia !</p>";
                            }
                            echo"</td></tr>
                    <tr><th>Nazwisko</th><td><input type='text' name='nazwisko' class='form-control'>";
                            if($blad_nazwisko>0)
                            {
                                echo"<p class='text-red'>Nie podano nazwiska !</p>";
                            }
                            echo"</td></tr>
                    <tr><th>Email:</th><td><input type='email' class='form-control' name='email'>";
                            if($blad_email>0)
                            {
                                echo "<p class='text-red'>Nie podano adresu email</p>";
                            }
                            echo"</td></tr>
                    <tr><th>Jednostka</th><td><input type='text' name='jednostka' class='form-control'>";
                            if($blad_jednostka>0)
                            {
                                echo"<p class='text-red'>Nie podano jednostki np. KWP</p>";
                            }
                            echo"</td></tr>
                    <tr><th>Wydzial</th><td><input type='text' name='wydzial' class='form-control'>";
                            if($blad_wydzial>0){
                                echo "<p class='text-red'>Nie podano wydziału !</p>";
                            }
                            echo "</td></tr>
                    <tr><th>Sekcja</th><td><input type='text' name='sekcja' class='form-control'></td></tr>
                    <tr><th>Specjalne</th><th><input type='number' name='specjalne' class='form-control'></th></tr>
                    <tr><td colspan='2'><input type='submit' name='zapisz' value='Dodaj użytkownika' class='btn btn-success form-control'></td></tr>
                    </form></table>";
                        }
                        else
                        {
                            $login=clear($_POST[login]);
                            $haslo=clear($_POST[haslo1]);
                            $email=clear($_POST[email]);
                            $imie=clear($_POST[imie]);
                            $nazwisko=clear($_POST[nazwisko]);
                            $jednostka=clear($_POST[jednostka]);
                            $wydzial=clear($_POST[wydzial]);
                            $sekcja=clear($_POST[sekcja]);
                            $specjalne=clear($_POST[specjalne]);
                            $data=time();

                            $haslo=codepass($haslo);



                            $zapisz_uzytkownikaDoBazy=mysqli_query($polaczenie,"INSERT INTO users (user_id, user_name, user_password, user_email, user_regdate, wydzial, uprawienia, specialne, imie, nazwisko, sekcja)
                            VALUES ('','$login', '$haslo','$email', '$data', '$wydzial','$specjalne','$specjalne','$imie','$nazwisko','$sekcja')") or die("blad przy zapisz_uzytkownikaDoBazy".mysqli_error($polaczenie));
                            echo "Utworzono konto dla użytkownika: $login  <a href='uzytkownicy.php' class='btn btn-success'>Powrót</a>";

                        }

                    }
                    else
                    {
                        echo"Nie przesłano danych z formularza...<a href='uzytkownicy.php' class='btn btn-success'>Powrót</a>";
                    }
                    echo' </div><!-- /.box-body -->

        </div><!-- /.box -->

    </section><!-- /.content -->';

                }
                elseif($a=='edytuj_uzytkownika')

                {
                    if($uzytkownik_uprawnienia==1)
                    {
                        $blad_imie=0;
                        $pobierz_daneUzytkownika=mysqli_query($polaczenie,"SELECT imie, nazwisko, user_email, sekcja, specialne, wydzial, user_name, funkcja, typ_osoby, aktywny FROM users WHERE user_id='$nrID'") or die("Blad przy pobierz_daneUzytkownika".mysqli_error($polaczenie));
                        if(mysqli_num_rows($pobierz_daneUzytkownika)==1)
                        {
                            while($daneUzytkownika=mysqli_fetch_array($pobierz_daneUzytkownika))
                            {
                        echo"<table class='table table-striped'><form name='edycja_danych' method='post' action='uzytkownicy.php?a=aktualizacja'>
                    <tr><th>Login:</th><td><input type='text' class='form-control' value='$daneUzytkownika[user_name]' disabled>";

                        echo"</td></tr>
                    <tr><th>Imię</th><td><input type='text' name='imie' class='form-control' value='$daneUzytkownika[imie]'>";
                        if($blad_imie==1)
                        {
                            echo"<p class='text-red'>Nie podano imienia !</p>";
                        }
                        echo"</td></tr>

                    <tr><th>Nazwisko</th><td><input type='text' name='nazwisko' class='form-control' value='$daneUzytkownika[nazwisko]'>";
                        if($blad_nazwisko>0)
                        {
                            echo"<p class='text-red'>Nie podano nazwiska !</p>";
                        }
                        echo"</td></tr>
                    <tr><th>Typ osoby:</th><td><select name='typ_osoby' class='form-control'>";
                                if($daneUzytkownika['typ_osoby']==0)
                                {
                                    echo"<option value='0'>Cywil</option>";
                                }
                                else{
                                    echo "<option value='1'>Policjant</option>";
                                }
                                echo"<option value='0'>Cywil</option><option value='1'>Policjant</option></select>
                    <tr><th>Email:</th><td><input type='email' class='form-control' name='email' value='$daneUzytkownika[user_email]'>";
                        if($blad_email>0)
                        {
                            echo "<p class='text-red'>Nie podano adresu email</p>";
                        }
                        echo"</td></tr>
                    <tr><th>Wydzial</th><td><input type='text' name='wydzial' class='form-control' value='$daneUzytkownika[wydzial]'>";
                        if($blad_wydzial>0){
                            echo "<p class='text-red'>Nie podano wydziału !</p>";
                        }
                        echo "</td></tr>
                    <tr><th>Sekcja</th><td><select name='sekcja' class='form-control'><option value='$daneUzytkownika[sekcja]'>$daneUzytkownika[sekcja]</option>";
                                echo pobierz_sekcje();
                                echo"</select></td></tr>
                    <tr><th>Specjalne</th><th><input type='number' name='specjalne' class='form-control' value='$daneUzytkownika[specialne]'></th></tr>
                    <tr><th>Funkcja</th><td><select class='form-control' name='funkcja'>";
                                echo wyswietl_pelniona_funkcje_lista($nrID);
                                echo "</select></td></tr>
                    <tr><td colspan='2'><input type='hidden' name='id_usera' value='$nrID'><input type='submit' name='aktualizuj' value='Aktualizuj dane użytkownika' class='btn btn-warning form-control'></td></tr>
                    </form>";
                         if($daneUzytkownika['aktywny']==0)
                         {

                            echo"<tr><td colspan='2'><a href='uzytkownicy.php?a=zablokuj&id=$nrID' class='btn btn-danger form-control'>Zablokuj użytkownika</a> </td></tr></table>";
                         }
                         elseif($daneUzytkownika['aktywny']==1)
                         {
                            echo"<tr><td colspan='2'><a href='uzytkownicy.php?a=odblokuj&id=$nrID' class='btn btn-success form-control'>Odblokuj użytkownika</a> </td></tr></table>";
                         }
                            }
                        }
                        else
                        {
                            echo'<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Blad nie znaleziono użytkownika o podanym id..
                  </div>';
                        }
                    }
                    else
                    {
                        echo'<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Brak dostepu! <a href="uzytkownicy.php" class="btn btn-success">Powrót</a>
                  </div>';
                    }

                }

        elseif ($a=='zablokuj')
        {
            if(isset($nrID)!='')
            {
                zablokuj_uzytkownika($nrID);
                echo "Zablokowano użytkownika pomyślnie";
                echo "<a href='uzytkownicy.php?a=edytuj_uzytkownika&id=$nrID'>Powrót</a>";
            }
            else
            {
                echo'<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Blad nie znaleziono użytkownika o podanym id..
                  </div>';
            }
        }
        elseif ($a=='odblokuj')
        {
            if(isset($nrID)!='')
            {
                odblokuj_uzytkownika($nrID);
                echo "odblokowano użytkownika pomyślnie";
                echo "<a href='uzytkownicy.php?a=edytuj_uzytkownika&id=$nrID'>Powrót</a>";
            }
            else
            {
                echo'<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Blad nie znaleziono użytkownika o podanym id..
                  </div>';
            }
        }

        elseif ($a=='aktualizacja')
        {
            if(isset($_POST['aktualizuj']))
            {
                if(isset($_POST['id_usera']))
                {
                    $id_usera=$_POST['id_usera'];
                    $nr_grupy = $_POST['sekcja'];
                    $grupa=sprawdz_nr_grupy($nr_grupy);


                    $aktualizacja_uzytkownika=mysqli_query($polaczenie,"UPDATE users SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', 
                    user_email='$_POST[email]', sekcja='$_POST[sekcja]', grupa = '$grupa', specialne='$_POST[specjalne]', wydzial='$_POST[wydzial]', 
                    funkcja='$_POST[funkcja]', typ_osoby='$_POST[typ_osoby]' WHERE user_id='$id_usera'")
                        or die("Blad przy aktualizacja_uzytkownika".mysqli_error($polaczenie));

                    echo"Zaktualizowano pomyślnie <a href='uzytkownicy.php?a=edytuj_uzytkownika&id=$id_usera'>Powrót</a>";

                }
                else
                {
                    echo"Błedny ID";
                }

            }
            else
            {
                echo"Nie powinno cię tu być..<a href='uzytkownicy.php'>Powrót</a>";
            }
        }

        elseif($a=='reset_hasla')

        {
            if($uzytkownik_uprawnienia==1)
            {
                $haslo_nowe='482de21110d50380a8a74cc86745dc884d9551c4'; //haslo: 1234

                $zmien_haslo=mysqli_query($polaczenie,"UPDATE users SET user_password='$haslo_nowe' WHERE user_id='$nrID'") or die("blad przy zmien_haslo".mysqli_error($polaczenie));
                echo"Zmieniono hasło <a href='uzytkownicy.php' class='btn btn-success'>Powrót</a>";
            }
            else
            {
                echo"Brak dostepu <a href='uzytkownicy.php' class='btn btn-success'>Powrót</a>";
            }

        }


                else
                {
        ?>
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista użytkowników</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="zwiń"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Usuń"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php


                /*
                $pobierz_listeUzytkownikow = mysqli_query($polaczenie,"SELECT user_id, user_name, imie, nazwisko, logowanie_ip, user_email, wydzial, ip_a, aktywny FROM `users`");
                */
                $pobierz_listaUzytkownikow=mysqli_query($polaczenie,"SELECT user_id, user_name, imie, nazwisko, logowanie_ip, logowanie_data,
                 user_email, wydzial, aktywny FROM `users`") or die("Blad przy pobierz_listaUzytkownikow".mysqli_error($polaczenie));
                $licznik_listaUzytkownikow=mysqli_num_rows($pobierz_listaUzytkownikow);
                ?>
                <p><a href="uzytkownicy.php?a=dodaj_nowego" class="btn btn-info">Dodaj Nowego Użytkownika</a> </p>
                <table id="example1" class="table table-bordered table-striped" name="uzytkownicy">
                    <thead>
                    <tr>
                        <th>Imię i Nazwisko</th>
                        <th>Login / ID</th>
                        <th>Email</th>
                        <th>Data logowania</th>
                        <th>Adres IP</th>
                        <th>Akcja</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($listaUzytkownikow=mysqli_fetch_array($pobierz_listaUzytkownikow))
                    {
                        if($listaUzytkownikow['aktywny']!=0)
                        {
                            echo"<tr><td class='text text-red'><span class='fa fa-frown-o'></span>$listaUzytkownikow[imie] $listaUzytkownikow[nazwisko]<span class='label label-danger'>Nieaktywny</span></td>";
                        }
                        else
                        {
                            echo"<tr><td></span>$listaUzytkownikow[imie] $listaUzytkownikow[nazwisko]";
                            echo "</td>";
                        }
                        echo"<td>$listaUzytkownikow[user_name] ($listaUzytkownikow[user_id])</td>
                        <td>$listaUzytkownikow[user_email]</td>
                        <td>$listaUzytkownikow[logowanie_data]</td>
                        <td>$listaUzytkownikow[logowanie_ip]</td>
                        <td><a href='uzytkownicy.php?a=reset_hasla&id=$listaUzytkownikow[user_id]' class='btn-sm btn-info'> Reset hasła</a> <a href='uzytkownicy.php?a=edytuj_uzytkownika&id=$listaUzytkownikow[user_id]' class='btn-sm btn-warning'> Zminana danych </a>";
                        if($listaUzytkownikow['user_id']!='1')
                        {
                        echo"<a href='uzytkownicy.php?a=usun&id=$listaUzytkownikow[user_id]' class='btn-sm btn-danger'>Usuń</a>";
                        }

                        echo"</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer">
               Liczba zarejestrowanych użytkowników ( <?php echo "$licznik_listaUzytkownikow )"; }?>

            </div><!-- /.box-footer-->
        </div><!-- /.box -->

    </section><!-- /.content -->
    <?php }
    else
    {
        echo'<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert zabezpieczeń!</h4>
                        Brak dostepu z powodu braku uprawnień!
                  </div>';
    }
    ?>
</div><!-- /.content-wrapper -->
<?php include 'dol.php';?>