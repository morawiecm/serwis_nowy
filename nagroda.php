<?php
include 'config.php';


check_login();

// dane uzytkownika z sesji
$user_data = get_user_data();
$uzytkownik_imie=$user_data['imie'];
$uzytkownik_nazwisko=$user_data['nazwisko'];
$uzytkownik_nazwa=$user_data['user_name'];
$uzytkownik_id=$user_data['user_id'];
$uzytkownik_sekcja=$user_data['sekcja'];
$uzytkownik_uprawnienia=$user_data['specialne'];
$uzytkownik_funkcja=$user_data['funkcja'];
$użytkownik_imie_nazwisko=$uzytkownik_imie." ".$uzytkownik_nazwisko;
//dane z POST

include 'nagroda_funkcje.php';

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
include 'menu.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pusta
            <small>Wyszukiwarka</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Title</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                    if($a=='dodaj_grupe')
                    {
                        echo"<table class='table table-hover table-bordered'><form method='post' action='nagroda.php?a=zapisz' ";
                        echo"<tr><th>Nazwa grupy:</th><td><input type='text' name='nazwa_grupy' class='form-control'></td></tr>";
                        echo"<tr><th>Wartość grupy:</th><td><input type='text' name='wartosc_grupy' class='form-control'></td></tr>";
                        echo "<tr><th colspan='2'><input type='submit' name='zapisz_grupe' class='btn btn-success form-control' value='Dodaj grupe'></th></tr>";
                        echo"</form></table>";
                    }
                    elseif ($a=='zapisz')
                    {
                        if(isset($_POST['zapisz_grupe']))
                        {
                            //dane z post
                            $nazwa_grupy=$_POST['nazwa_grupy'];
                            $wartosc_grupy=$_POST['wartosc_grupy'];
                            $zapisz_grupe=mysqli_query($polaczenie,"INSERT INTO nagroda_poziomy (nazwa_grupy, wartosc_procetowa) VALUES ('$nazwa_grupy','$wartosc_grupy')")
                                or die("Blad przy zapisz_grupe".mysqli_error($polaczenie));
                            echo"<p class='alert-success'>Dodano pomyślnie grupę: $nazwa_grupy <a href='nagroda.php'>Powrót</a> </p>";
                        }
                        else
                        {
                            echo"Nie przekazano danych. Dodaj jeszcze raz...";
                        }
                    }
                    elseif ($a=='dodaj_osoby_do_nagrody')
                    {
                        $pobierz_uzytkownikow_grupy=mysqli_query($polaczenie, "SELECT users.user_id, users.imie, users.nazwisko FROM users WHERE users.grupa='$nrID' AND (users.funkcja=0 OR users.funkcja=1 OR users.funkcja=2)")
                        or die("blad przy pobierz_uzytkownikow_grupy".mysqli_error($polaczenie));
                        {
                            if(mysqli_num_rows($pobierz_uzytkownikow_grupy)>0)
                            {
                                echo"<table class='table'><form method='post' action='nagroda.php?a=dodaj_osobe_zapis'> ";
                                echo "<tr><th>Imie i Nazwisko:</th><td><select name='grupa'>";
                                while ($uzytkownicy_grupy=mysqli_fetch_array($pobierz_uzytkownikow_grupy))
                                {
                                    echo"<option value='$uzytkownicy_grupy[user_id]'>$uzytkownicy_grupy[imie] $uzytkownicy_grupy[nazwisko]</option>";
                                }
                                echo"</select><input type='hidden' name='nr_id_grupy' value='$nrID'> </td></tr>";
                                echo"<tr><th colspan='2'><input type='submit' name='dodaj_osobe_nagroda' value='Dodaj osobę' class='btn btn-info form-control'></th></tr>";
                                echo"</form></table>";
                            }
                        }
                    }
                    elseif ($a=='dodaj_osobe_zapis')
                    {
                        if(isset($_POST['dodaj_osobe_nagroda']))
                        {
                            $kwartal=kwartal();
                            $grupa_pracownik=$_POST['nr_id_grupy'];
                            $pracownik=$_POST['grupa'];

                            $pobierz_pelniona_funkcje=mysqli_query($polaczenie,"SELECT funkcja FROM users WHERE user_id='$pracownik'");
                            while ($pelniona_funkcja=mysqli_fetch_array($pobierz_pelniona_funkcje))
                            {
                                $funkcja=$pelniona_funkcja[0];
                            }

                            $sprawdz_duplikat=mysqli_query($polaczenie,"SELECT id FROM nagroda_osoby WHERE id_osoby='$pracownik' AND kwartal='$kwartal'");
                            $duplikat=mysqli_num_rows($sprawdz_duplikat);
                            if ($duplikat==0)
                            {
                                //przypisanie kierownikow do grupy Kierownicy id=1 , brak - id=5
                                if($funkcja>0)
                                {
                                    $funkcja=1;
                                }
                                else
                                {
                                    $funkcja=5;
                                }


                        $zapisz_do_nagrody=mysqli_query($polaczenie,"INSERT INTO nagroda_osoby (id_osoby, id_grupy, kwartal, id_nagrody) VALUES ('$pracownik','$grupa_pracownik','$kwartal','$funkcja')")
                            or die("Blad przy zapisz_do_nagrody".mysqli_error($polaczenie));
                            echo"<p>Zapisano pomyslnie <a href='nagroda.php'>Powrót</a></p>";
                            }
                            else
                            {
                                echo"Pracownik jest już na liście nagród w danym okresie";
                            }

                        }
                        else
                        {
                            echo "<p>Bład. Nie przekazano danych. Spróbuj jeszcze raz</p>";
                        }
                    }
                    elseif ($a=='aktualizuj_nagrode')
                    {
                        //var_dump($_POST);
                        $grupa_id=$_POST['grupa'];
                        $uzytkownik_id=$_POST['id_uzytkownika'];
                        $wykonaj=aktualizacja_grupy_nagroda($uzytkownik_id, $grupa_id);
                        echo $wykonaj;
                    }

                    elseif ($a=='zmien_wartosc_grupy')
                    {
                        $waga_grupy=pobierz_wage_grupy($nrID);
                        $nazwa_grupy=pobierz_nazwe_grupy($nrID);
                        echo"<table class='table'><form method='post' action='nagroda.php?a=zapisz_wartosc_grupy'>";
                        echo"<tr><th>$nazwa_grupy</th><td><input type='text' name='waga_grupy' class='form-control' value='$waga_grupy'></td></tr>";
                        echo"<tr><th colspan='2'><input type='hidden' name='nr_id_grupy' value='$nrID'><input type='submit' name='aktualizacja_grupy' value='Aktualizuj wartosc procentową grupy' class='btn btn-warning form-control'></th></tr>";
                        echo "</form></table>";
                    }
                    
                    elseif ($a=='zapisz_wartosc_grupy')
                    {
                        if(isset($_POST['aktualizacja_grupy']))
                        {
                            $wartosc_grupy=$_POST['waga_grupy'];
                            $nr_id_grupy=$_POST['nr_id_grupy'];
                            $aktualizacja=aktualizacja_wagi_grupy($nr_id_grupy,$wartosc_grupy);
                            echo $aktualizacja;
                        }
                        else
                        {
                            echo"Bład. nie przesłano danych. Spróbuj jeszcze raz.. <a href='nagroda.php'>Powrót</a>";
                        }

                    }

                    //dodaje uzasadneinie dla danego uzytkownika
                    elseif ($a=='dodaj_uzadadnienie')
                    {
                        echo "<table class='table'><form method='post' action='nagroda.php?a=dodaj_uzasadnienie_zapis'> ";
                        echo"<tr><th>Uzasadnienie:</th><td><textarea name='uzasadnienie' class='form-control'></textarea></td></tr>";
                        echo "<tr><th colspan='2'><input type='hidden' name='nr_rekordu' value='$nrID'><input type='submit' name='dodaj_uzasadnienie' class='btn btn-success form-control' value='Dodaj uzasadnienie'></th></tr> ";
                        echo "</form></table>";
                    }
                    // zapis uzasadnienia dla danego uzytkownika
                    elseif ($a=='dodaj_uzasadnienie_zapis')
                    {
                        if(isset($_POST['dodaj_uzasadnienie']))
                        {
                            //dane z POST
                            $uzasadnienie=$_POST['uzasadnienie'];
                            $nr_id_rekordu=$_POST['nr_rekordu'];
                            //zapis do bazy
                            $aktualizacja_rekordu_uzasadnienienie=mysqli_query($polaczenie,"UPDATE nagroda_osoby SET uzasadnienie='$uzasadnienie' WHERE id='$nr_id_rekordu'");
                            //komunikat o powodzeniu
                            echo "Zapisano. <a href='nagroda.php'>Powrót</a>";
                        }
                        else{
                            echo "Blad. Nie przekazano danych. Sprobój jeszzce raz. <a href='nagroda.php'>Powrót</a>";
                        }
                    }

                    else {

                        if (isset($_POST['aktualizuj_parametry'])) {
                            $aktualizuj_kwote_do_podzialu = mysqli_query($polaczenie, "UPDATE ustawienia SET tresc='$_POST[kwota_do_podzialu]' WHERE id='2'");
                            $aktualizuj_nie_mniej = mysqli_query($polaczenie, "UPDATE ustawienia SET tresc='$_POST[nie_mniej]' WHERE id='3'");
                        }
                        $pobierz_kwote_do_podzialu = mysqli_query($polaczenie, "SELECT tresc FROM ustawienia WHERE id='2'") or die("Blad przy pobierz_kwote_do powdzialu" . mysqli_error($polaczenie));
                        while ($kwota_do_podzialu = mysqli_fetch_array($pobierz_kwote_do_podzialu)) {
                            $kwotaDoPodzialu = $kwota_do_podzialu['tresc'];
                        }
                        $pobierz_nie_mniej = mysqli_query($polaczenie, "SELECT tresc FROM ustawienia WHERE id='3'") or die("Blad przy pobierz_nie_mniej" . mysqli_error($polaczenie));
                        while ($nie_mniej = mysqli_fetch_array($pobierz_nie_mniej)) {
                            $nieMniej = $nie_mniej['tresc'];
                        }
                        $liczba_osob = policz_uzytkownikow_w_grupach();

                        echo "<table><form method='post' action='nagroda.php'>";
                        echo "<tr><th>Kwota do podzialu:</th><td><input type='text' name='kwota_do_podzialu' value='$kwotaDoPodzialu' class='form-control text-right'></td></tr>";
                        echo "<tr><th>Nie mniej niż na osobę:</th><td><input type='text' name='nie_mniej' value='$nieMniej' class='form-control text-right'></td></tr>";
                        echo "<tr><th>Liczba osób do podziału:</th><td class='text text-bold text-right'>$liczba_osob</td></tr>";
                        echo "<tr><th colspan='2'><input type='submit' name='aktualizuj_parametry' value='Aktualizuj' class='btn btn-info form-control'></th></tr>";
                        echo "</form></table>";

                        echo "<p>Grupy:</p>";
                        echo "<p><a href='nagroda.php?a=dodaj_grupe' class='btn btn-success'>Dodaj grupe</a> </p>";
                        $pobierz_grupyNagrody = mysqli_query($polaczenie, "
                        SELECT nagroda_poziomy.id, 
                        nagroda_poziomy.nazwa_grupy, 
                        nagroda_poziomy.wartosc_procetowa
                        FROM nagroda_poziomy")
                        or die ("Blad przy pobierz_grupyNagrody" . mysqli_error($polaczenie));
                        if (mysqli_num_rows($pobierz_grupyNagrody) > 0) {
                            echo "<table class='table'><form name='grupy' method='post' action='nagroda.php'";
                            echo "<tr><th>Grupa</th><th>Wartość %</th><th>Liczba osób w grupie / na osobę </th><th>Akcja</th></tr>";
                            while ($grupyNagrody = mysqli_fetch_array($pobierz_grupyNagrody)) {
                                $nagroda_wartosc = wylicz_wartosc_grupy($grupyNagrody[0]);
                                $osob_w_grupie = policz_uzytkownikow_w_grupie($grupyNagrody[0]);
                                echo "<tr><td>$grupyNagrody[nazwa_grupy]</td><td>$grupyNagrody[wartosc_procetowa] %</td><td> $osob_w_grupie os. / $nagroda_wartosc zł</td><td><a href='nagroda.php?a=zmien_wartosc_grupy&id=$grupyNagrody[id]' class='btn-sm btn-info'>       
                            Edytuj</a>";
                                if ($grupyNagrody[0] == 5 || $grupyNagrody[0] == 1 || $grupyNagrody[0]==6) {

                                } else {
                                    echo "<a href='nagroda.php?a=usun&id=$grupyNagrody[id]' class='btn-sm btn-danger'>Usuń</a>";
                                }

                                echo "</td></tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p class='text text-danger'> Brak utworzonych grup. Dodaj nową</p>";
                        }
                        // widok dla kierownika i koordynatora
                        if ($uzytkownik_funkcja == 1 || $uzytkownik_funkcja == 2) {

                            echo "<p class='text text-center text-red'>Moja grupa:</p></br>";

                            $pobierz_grupe_kierownika = mysqli_query($polaczenie, "SELECT grupa FROM users WHERE user_id='$uzytkownik_id'") or die("blad przy pobierz_grupe_kierownika" . mysqli_error($polaczenie));
                            while ($grupa_kierownika = mysqli_fetch_array($pobierz_grupe_kierownika)) {
                                $grupaKierownika = $grupa_kierownika[0];
                                echo "<p><a href='nagroda.php?a=dodaj_osoby_do_nagrody&id=$grupaKierownika' class='btn btn-info'>Dodaj osoby do nagrody</a> </p>";
                            }
                            $kwartal = kwartal();
                            $pobierz_uzytkownikow_grupy = mysqli_query($polaczenie, "
                             SELECT nagroda_osoby.id_osoby, 
                            nagroda_osoby.id_nagrody, 
                            nagroda_osoby.akceptacja, 
                            nagroda_osoby.kwartal,
                            nagroda_osoby.id,
                            nagroda_osoby.uzasadnienie as uzasadnienie,
                            users.imie as imie,
                            users.nazwisko as nazwisko
                            FROM nagroda_osoby 
                            INNER JOIN users ON nagroda_osoby.id_osoby=users.user_id
                            WHERE nagroda_osoby.id_grupy='$grupaKierownika' AND nagroda_osoby.kwartal='$kwartal'
                            ") or die ("Blad przy pobierz_uzytkownikow_grupy" . mysqli_error($polaczenie));

                                if (mysqli_num_rows($pobierz_uzytkownikow_grupy) > 0) {
                                    $lista = lista_grup();
                                    echo "<table class='table'>";
                                    echo "<tr><th>Imie i nazwisko</th><th>Grupa nagrody</th><th>Uzasadnienie</th><th>Przypisanie</th></tr>";
                                    while ($uzytkownicy_grupy = mysqli_fetch_array($pobierz_uzytkownikow_grupy)) {

                                        $nazwa_grupy = pobierz_nazwe_grupy($uzytkownicy_grupy['id_nagrody']);
                                        $wartoscGrupy = wylicz_wartosc_grupy($uzytkownicy_grupy['id_nagrody']);

                                        echo "<tr><td>$uzytkownicy_grupy[imie] $uzytkownicy_grupy[nazwisko] </td><td>$nazwa_grupy - $wartoscGrupy zł</td><td>$uzytkownicy_grupy[uzasadnienie]</td><td><form name='formularz_$grupyNagrody[id]' method='post' action='nagroda.php?a=aktualizuj_nagrode'><input type='hidden' name='id_uzytkownika' value='$uzytkownicy_grupy[id_osoby]'> <select name='grupa'>$lista</select><input type='submit' class='btn-sm btn-warning' value='Aktualizuj'> </form><a href='nagroda.php?a=dodaj_uzadadnienie&id=$uzytkownicy_grupy[id]' class='btn-sm btn-success'>Dodaj uzasadnienie</a> </td></tr>";
                                    }
                                    echo "</table>";
                                }

                        }
                        // widok dla naczelnika i admina
                        elseif ($uzytkownik_funkcja == 3 || $uzytkownik_uprawnienia == 1) {
                            echo "<p class='text text-center text-red'>Moja grupa:</p></br>";
                            
                                echo "<p><a href='nagroda_export.php' class='btn btn-info'>Export listy do Excela</a> </p>";
                            $kwartal = kwartal();
                            $pobierz_uzytkownikow_grupy = mysqli_query($polaczenie, "
                                 SELECT nagroda_osoby.id_osoby, 
                                nagroda_osoby.id_nagrody, 
                                nagroda_osoby.akceptacja, 
                                nagroda_osoby.kwartal,
                                nagroda_osoby.uzasadnienie as uzasadninie,
                                users.imie as imie,
                                users.nazwisko as nazwisko
                                FROM nagroda_osoby 
                                INNER JOIN users ON nagroda_osoby.id_osoby=users.user_id
                                WHERE nagroda_osoby.kwartal='$kwartal'
        
                               ") or die ("Blad przy pobierz_uzytkownikow_grupy" . mysqli_error($polaczenie));

                            if (mysqli_num_rows($pobierz_uzytkownikow_grupy) > 0) {
                                $lista = lista_grup();
                                echo "<table class='table'>";
                                echo "<tr><th>Imie i nazwisko</th><th>Grupa nagrody</th><th>Uzasadnienie</th><th>Przypisanie</th></tr>";
                                while ($uzytkownicy_grupy = mysqli_fetch_array($pobierz_uzytkownikow_grupy)) {

                                    $nazwa_grupy = pobierz_nazwe_grupy($uzytkownicy_grupy['id_nagrody']);
                                    $wartoscGrupy = wylicz_wartosc_grupy($uzytkownicy_grupy['id_nagrody']);

                                    echo "<tr><td>$uzytkownicy_grupy[imie] $uzytkownicy_grupy[nazwisko] </td><td>$nazwa_grupy - $wartoscGrupy zł</td><td>$uzytkownicy_grupy[uzasadninie]</td><td><form name='formularz_$grupyNagrody[id]' method='post' action='nagroda.php?a=aktualizuj_nagrode'><input type='hidden' name='id_uzytkownika' value='$uzytkownicy_grupy[id_osoby]'> <select name='grupa'>$lista</select><input type='submit' class='btn-sm btn-warning' value='Aktualizuj'> </form></td></tr>";
                                }
                                echo "</table>";
                            }
                        }
                    }
                ?>

            </div><!-- /.box-body -->

        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include 'dol.php';?>