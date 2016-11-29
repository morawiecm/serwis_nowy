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
                    //Formularz dodawania do listy zmian
                    echo NaglowekStrony("Lista zmian","zmiany","Dodanie wpisów do listy");
                    echo"<table class='table table-bordered'><form name='dodawanie_zmian' method='POST' action='lista_zmian.php?a=dodaj_zapisz' >";
                    echo"<tr><td>Data</td><td><input type='text' name='data' class='form-control' value='$data_skrocona' id='datepicker'/></td></tr>";
                    echo"<tr><td>Opis</td><td><textarea name='opis' class='ckeditor form-control'></textarea></td></tr>";
                    echo"<tr><td colspan='2'><input type='submit' value='Dodaj'  class='btn btn-primary form-control'/></td></tr> ";
                    echo"</form></table>";
                }
                elseif ($a=='dodaj_zapisz')
                {
                    echo NaglowekStrony("Lista zmian","zmiany","Dodanie wpisów do listy");
                    //Zrzut z POSTA
                    $data=$_POST['data'];
                    $opis=addslashes($_POST['opis']);

                    $zapisBaza_lista_zmian=mysqli_query($polaczenie,"INSERT INTO lista_zmian (data,opis) VALUES ('$data','$opis')")or die('Bład przy zapisBaza_lista_zmian'.mysqli_error($polaczenie));
                    echo"Dodano pomyślnie wpis <a href='lista_zmian.php'>Powrót</a>";
                }
                elseif($a=='edytuj')
                {
                    echo NaglowekStrony("Lista zmian","zmiany","Dodanie wpisów do listy");
                    $pobierz_dane_rekordu_z_bazy_lista_zmian=mysqli_query($polaczenie,"SELECT * FROM `lista_zmian` WHERE `id`='$nrID'") or die('Bład przy pobierz_dane_rekordu_z_bazy_lista_zmian'.mysqli_error($polaczenie));
                    if(mysqli_num_rows($pobierz_dane_rekordu_z_bazy_lista_zmian)>0)
                    {
                        while($edycja_lista_zmian=mysqli_fetch_array($pobierz_dane_rekordu_z_bazy_lista_zmian))
                        {
                            echo"<table><form name='edycja_lista_zmian' method='post' action='lista_zmian.php?a=zapisz_zmiany'> ";
                            echo"<tr><th>Data</th><td><input type='text' class='datepicker' name='e_data' value='$edycja_lista_zmian[1]'></td></tr>";
                            echo"<tr><th>Opis</th><td><textarea class='textarea' id='editor1' style='width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;' name='e_opis'>$edycja_lista_zmian[2]</textarea> </td></tr>";
                            echo"<tr><td colspan='2'><input type='hidden' name='e_id' value='$edycja_lista_zmian[0]'> <input type='submit' value='Zapisz zmiany' /></td></tr> ";
                            echo"</form></table>";
                        }
                    }
                }
                elseif($a=='zapisz_zmiany')
                {
                    echo NaglowekStrony("Lista zmian","zmiany","Dodanie wpisów do listy");
                    //dane z POST
                    $e_id=$_POST['e_id'];
                    $e_data=$_POST['e_data'];
                    $e_opis=$_POST['e_opis'];

                    $aktualizacja_listy_zmian=mysqli_query($polaczenie,"UPDATE `lista_zmian` SET `data`='$e_data', `opis`='$e_opis' WHERE `id`='$e_id'") or die('Bład przy aktualizacja_listy_zmian'.mysqli_error($polaczenie));
                    echo"Pomyslnie zaktualizowano <a href='lista_zmian.php' class='button plain'>Powrót</a>";

                }
                else
                {
                    echo NaglowekStrony("Lista zmian","zmiany","Dodanie wpisów do listy");


                    echo"<a href='lista_zmian.php?a=dodaj' class='btn btn-success'>Dodaj nowy wpis</a>";
                    echo "<table class='table table-striped table-bordered table-hover'>";
                    echo "<thead><tr><th>Data</th><th>Opis</th><th>Akcja</th></tr></thead>";
                    $pobierz_dane_lista_zmian = mysqli_query($polaczenie,"SELECT * FROM `lista_zmian` ORDER BY `data` ASC") or die('Blad przy pobierz_dane_lista_zmian' . mysqli_error($polaczenie));
                    $licznik_listaZmian=mysqli_num_rows($pobierz_dane_lista_zmian);
                    if($licznik_listaZmian>0)
                    {
                        while($listaZmian=mysqli_fetch_array($pobierz_dane_lista_zmian))
                        {
                            echo "<tr><td>$listaZmian[1]</td><td>$listaZmian[2]</td><td><a href='lista_zmian.php?a=edytuj&id=$listaZmian[0]' class='btn-sm btn-info'>EDYTUJ</a>
                        <a href='lista_zmian.php?a=usun&id=$listaZmian[0]' class='btn-sm btn-danger'>USUŃ</a> </td></tr>";
                        }
                    }

                    echo "</table>";
                    echo'</div><!-- /.box-body -->
            <div class="box-footer">';
                echo"Wpisów: ($licznik_listaZmian)";
                    echo'</div><!-- /.box-footer-->
                    </div><!-- /.box -->';
                }
                ?>


    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include 'dol.php';?>