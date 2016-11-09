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
                else
                {
                    $zapytanie_pobierz_elemnty_do_asygnaty = "SELECT baza.lp, baza.nazwa_sprzetu, baza.nr_inwentarzowy, baza.id_jednoski, baza.wartosc, asygnata_koszyk.uwaga
                    FROM asygnata_koszyk
                    INNER JOIN baza ON asygnata_koszyk.id_lp = baza.lp";

                    echo"<p><a href='asygnata.php' class='btn btn-success'>Generuj Asygnate</a> </p>";
                    echo "<table class='table table-responsive table-bordered'>";
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

                    echo"</table>";
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
