<?php
include 'config.php';
include 'funkcje/funkcje_ewidencja.php';
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
            Blank page
            <small>it all starts here</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Title</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                if($a=='dodaj_do_koszyka')
                {
                    if($nrID!='')
                    {
                        $id_wydzialu_asygnata = PobierzIdJednostki($nrID);
                        $dodaj_do_koszyka_st = mysqli_query($polaczenie, "INSERT INTO asygnata_koszyk (id_lp, id_wydzialu, data_dodania, kto_dodal) VALUES 
                        ('$nrID','$id_wydzialu_asygnata','$data_pelana','$użytkownik_imie_nazwisko')")
                        or die("Blad przy dodaj_do_koszyka_st");
                        Przekierowanie("Dodano do koszyka. Nastapi przekierowanie do koszyka asygnat","asygnata_koszyk.php");
                    }
                    else
                    {
                        Przekierowanie("Bledny nr ID ! Spróbuj jeszcze raz","index.php");
                    }
                }
                elseif ($a=='generuj')
                {
                    //var_dump($_POST);
                    $id_sprzetu = $_POST['id_sprzetu'];
                    $liczba_elementow = count($id_sprzetu);


                    echo "<table class='table table-bordered'><form method='post' action='asygnata_koszyk.php?a=zapisz'>";
                    //Glowne elementy
                    echo "<tr><th>Typ Asygnaty:</th><td><select class='form-control' name='typ_asygnaty'><option value='0'>Wydania</option><option value='1'>Przyjecia</option></select></td></tr>";
                    if($liczba_elementow>0)
                    {
                        $czy_zgodne = SprawdzWydzialyAsygnata($id_sprzetu);
                        if($czy_zgodne==false)
                        {
                            echo "<tr><th>Z stanu:</th><td><select name='wydzial_od' class='form-control'>";
                            echo PobierzJednostki("");
                            echo "</select> </td></tr>";
                        }
                    }
                    echo "<tr><th>Na stan:</th><td><select name='wydzial_do' class='form-control'>";
                    echo PobierzJednostki("");
                    echo "</select> </td></tr>";
                    echo "<tr><th>Data dokumentu</th><td><input type='text' name='data_dokumentu' id='datepicker' value='$data_skrocona' class='form-control datepicker'></td></tr>";
                    echo "<tr><th>Uwagi:</th><td><textarea class='form-control' rows='6' name='uwagi'></textarea></td></tr>";
                    echo "<tr><th class='text-center' colspan='2'>Skladniki Asygnaty:</th></tr>";
                    //Elementy Asygnaty
                    for ($i=0;$i<$liczba_elementow;$i++)
                    {
                        $nazwa_sprzetu = PobierzNazweSprzetu($id_sprzetu[$i]);
                        echo "<tr><th colspan='2'>$i. $nazwa_sprzetu</th><input type='hidden' name='tablica_id[]' value='$id_sprzetu[$i]'></tr>";
                        echo "<tr><th>Uwaga:</th><td><input type='text' name='uwaga_osobno[]' class='form-control'></td></tr>";

                    }
                    echo "<tr><th colspan='2'><input type='submit' value='Zapisz Asygnate' class='btn btn-primary form-control'></th></tr>";
                    echo "</form></table>";

                }
                elseif ($a=='zapisz')
                {

                    //Dane z post
                    //Dane do głownej asygnaty
                    $asygnata_typ = $_POST['typ_asygnaty'];
                    $asygnata_nr = PobierzNrAsygnaty();
                    AktualizujNrAsygnaty((int)$asygnata_nr);
                    //format nr asygnaty
                    $asygnata_numer =$asygnata_nr."/WŁiI/".date("y");
                    $asygnata_data = $_POST['data_dokumentu'];
                    $asygnata_do = $_POST['wydzial_do'];
                    $asygnata_do_nazwa = PobierzNazweWydzialu($asygnata_do);
                    $tablica_id_lp = $_POST['tablica_id'];

                    $asygnata_uwagi = addslashes($_POST['uwagi']);
                    $liczba_elementow_tablicy = count($tablica_id_lp);
                    if($liczba_elementow_tablicy>1)
                    {
                        $asygnata_od =$_POST['wydzial_od'];
                        $asygnata_od_nazwa = PobierzNazweWydzialu($asygnata_od);
                    }
                    else
                    {
                        $id_st = $_POST['tablica_id'];
                        $asygnata_od = PobierzWydzialSprzetu($id_st[0]);
                        $asygnata_od_nazwa = PobierzNazweWydzialu($asygnata_od);
                    }

                    //Zapisz glowna asygnate
                    $zapisz_asygnate = mysqli_query($polaczenie,"INSERT INTO asygnata (nr_asygnaty, od, id_od, do, id_do, typ, kto_dodal, data_asygnaty, data_dodania, akceptacja, uwagi) 
                    VALUES ('$asygnata_numer','$asygnata_od_nazwa','$asygnata_od','$asygnata_do_nazwa','$asygnata_do','$asygnata_typ','$użytkownik_imie_nazwisko','$asygnata_data','$data_pelana',0,'$asygnata_uwagi')")
                    or die("Blad przy zapisz_asygnate".mysqli_error($polaczenie));
                    $nr_id_asygnaty = mysqli_insert_id($polaczenie);
                    //dane do skladników asygnaty
                    $tablica_uwag = $_POST['uwaga_osobno'];
                    for($ii = 0; $ii<$liczba_elementow_tablicy;$ii++)
                    {
                        $id_lp = $tablica_id_lp[$ii];
                        $od = PobierzWydzialSprzetu($id_lp);
                        $od = PobierzNazweWydzialu($od);

                        $uwaga = addslashes($tablica_uwag[$ii]);

                        $zapisz_skladnik_asygnaty = mysqli_query($polaczenie,"INSERT INTO asygnata_skladniki (id_lp, id_asygnaty, od, do, uwaga, nr_asygnaty) 
                        VALUES ('$id_lp','$nr_id_asygnaty','$od','$asygnata_do_nazwa','$uwaga','$asygnata_numer')")
                            or die("Blad przy zapisz_skladnik_asygnaty".mysqli_query($polaczenie));
                    //usun pozyje z koszyka
                        $usun_z_koszyka = mysqli_query($polaczenie,"DELETE FROM asygnata_koszyk WHERE id_lp = '$id_lp'") or die("Blad przy usun_z_koszyka".mysqli_error($polaczenie));
                    }

                    echo "Zapisano Pomyśnie asygnate $asygnata_numer. Liczba składników asygnaty $liczba_elementow_tablicy";





                }
                else
                {
                    $zapytanie_pobierz_elemnty_do_asygnaty = "SELECT baza.lp, baza.nazwa_sprzetu, baza.nr_inwentarzowy, baza.id_jednoski, baza.wartosc, asygnata_koszyk.uwaga
                    FROM asygnata_koszyk
                    INNER JOIN baza ON asygnata_koszyk.id_lp = baza.lp";

                    echo "<table class='table table-responsive table-bordered'><form action='asygnata_koszyk.php?a=generuj' method='post'>";
                    echo "<thead><tr><th>Nr ewidencyjny</th><th>Nazwa</th><th>Na stanie</th><td>Wartosc</td><th>Uwagi</th><th>Wybierz</th></tr></thead>";
                    $pobierz_skladniki_asygnaty  = mysqli_query($polaczenie, $zapytanie_pobierz_elemnty_do_asygnaty) or die("Blad przy pobierz_skladniki_asygnaty".mysqli_error($polaczenie));
                    if(mysqli_num_rows($pobierz_skladniki_asygnaty)>0)
                    {
                        while ($skladnik_asygnaty = mysqli_fetch_array($pobierz_skladniki_asygnaty))
                        {
                            $wydzial_nazwa = PobierzNazweWydzialu($skladnik_asygnaty['id_jednoski']);
                            echo "<tr><td>$skladnik_asygnaty[nr_inwentarzowy]</td><td>$skladnik_asygnaty[nazwa_sprzetu]</td>
                            <td>$wydzial_nazwa</td><td>$skladnik_asygnaty[wartosc]</td><td></td><td><input type='checkbox' name='id_sprzetu[]' value='$skladnik_asygnaty[lp]'></td></tr>";
                        }
                    }
                    else
                    {
                        echo "<tr><td colspan='6'>Koszyk pusty..dodaj składnik by stworzyć protokół</td></tr>";
                    }

                    echo"<p><input type='submit' class='btn btn-success' value='Generuj Asygnate'> </p>";
                    echo"</form></table>";
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
