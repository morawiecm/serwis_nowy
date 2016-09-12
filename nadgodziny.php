<?php
include 'config.php';
include 'funkcje/funkcje_nadgodziny.php';
include 'funkcje/funkcje_uzytkownicy.php';

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
            Nadgodziny
            <small>Ewidencja</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Nadgodziny</a></li>
            <li class="active">Ewidencja</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->

        <?php
        if($a=='rejestracja')
        {
            echo'<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Rejestracja</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="nadgodziny.php?a=zapisz" method="post">
                <table class="table table-striped">
                <tr>
                    <th>Typ wyjscia/wejscia</th>
                <td>
                    <select name="typ" class="form-control">
                        <option value="0">Służbowe</option>
                        <option value="1">Osobiste</option>
                    </select>
                </td>
                </tr>
                <tr>
                <th>OD:</th><td>
                
                    <input type="text" class="form-control timepicker" id="nadgodziny-od" name="od"/>
                    
               </td></tr>
                <tr><th>DO:</th><td><input type="text" class="form-control timepicker2" name="do" id="nadgodziny-do"></td></tr>
                <tr><th>UWAGA:</th><td><input type="text" class="form-control" name="uwaga"></td></tr>
                <tr><td colspan="2"><input type="submit" name="zapisz_godziny" value="Dodaj wpis" class="btn btn-success form-control"></td></tr>
</table></form>
            </div>
            <!-- /.box-body -->
           
        </div>
        <!-- /.box -->';
        }
        elseif ($a=='zapisz')
        {
            if(isset($_POST['zapisz_godziny']))
            {
                //dane z POST
                $typ=$_POST['typ'];
                $od = $_POST['od'];
                $do= $_POST['do'];
                $waznosc_do= $data = date('Y-m-d', strtotime($do.' +1 month'));
                $data= date("Y-m-d H:i:s");
                $uwaga = $_POST['uwaga'];
                $obliczCzas=ZnacznikCzasowy($od,$do);
                $minuty = ZnacznikCzasowyNaCzas($obliczCzas);
                $zarestruj_czas=mysqli_query($polaczenie,"INSERT INTO nadgodziny (id_usera, typ_wyjscia, od, do, minut, data_rejestracji, uwagi, wazne_do)
                VALUES ('$uzytkownik_id','$typ','$od','$do','$minuty[3]','$data','$uwaga','$waznosc_do')")
                    or die("Bład przy zarestruj_czas".mysqli_error($polaczenie));


                echo "Zapisano poprawnie czas : {$minuty[3]} minut. Ważne do $waznosc_do";

            }
            else
            {
                echo"Nastąpił bład";
            }
        }
        elseif($a=='przeglad')
        {

            echo'<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Przeglad</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';
            $minuty_status = PoliczMinuty($nrID);
            $imie_nazwisko = PobierzImieNazwisko($nrID);
            echo "<p>Użytkownik: $imie_nazwisko  ma: $minuty_status minut</p>";
            echo'<table id="example1" class="table table-bordered table-striped">';
            echo "<thead><tr><th>ID</th><th>DATA</th><th>TYP</th><th>DZIEŃ</th><th>OD</th><th>DO</th><th>MINUT</th><th>UWAGI</th><th>WAŻNE DO</th><th>AKCEPTACJA</th></tr></thead>";
            $pobierz_godziny_uzytkownika=mysqli_query($polaczenie,"SELECT id, data_rejestracji, typ_wyjscia, od, do, minut, uwagi,akceptacja, wazne_do
            FROM nadgodziny WHERE id_usera='$nrID'")
            or die("Bład przy pobierz_godziny_uzytkownika");
            if(mysqli_num_rows($pobierz_godziny_uzytkownika)>0)
            {

                while ($godziny_uzytkownika=mysqli_fetch_array($pobierz_godziny_uzytkownika))
                {
                    $od_format=date_create($godziny_uzytkownika['od']);
                    $dzien=date_format($od_format,'Y-m-d');
                    $od_format=date_format($od_format,'H:i');

                    $do_format=date_create($godziny_uzytkownika['do']);
                    $do_format=date_format($do_format,'H:i');
                    echo"<tr>";
                    echo"<td>$godziny_uzytkownika[id]</td>";
                    echo"<td>$godziny_uzytkownika[data_rejestracji]</td>";
                    if($godziny_uzytkownika['typ_wyjscia']==0)
                    {
                        echo"<td><a class='btn-sm btn-info'>SŁUŻBOWE</a></td>";
                        echo "<td>$dzien</td>";
                        echo"<td>$od_format</td>";
                        echo"<td>$do_format</td>";
                        echo"<td class='text-success text-bold'><i class='fa fa-plus'></i> $godziny_uzytkownika[minut]</td>";
                    }
                    else
                    {
                        echo"<td><a href='#' class='btn-sm btn-primary'>OSOBISTE</a> </td>";
                        echo "<td>$dzien</td>";
                        echo"<td>$od_format</td>";
                        echo"<td>$do_format</td>";
                        echo"<td class='text-red text-bold'><i class='fa fa-minus text-red'> </i> $godziny_uzytkownika[minut]</td>";
                    }

                    echo"<td>$godziny_uzytkownika[uwagi]</td>";
                    echo"<td>$godziny_uzytkownika[wazne_do]</td>";
                    if($godziny_uzytkownika['akceptacja']==0)
                    {
                        echo"<td><a class='btn-sm btn-danger'>BRAK AKCEPTACJI</a></td>";
                    }
                    else
                    {
                        echo"<td><a class='btn-sm btn-success'>ZAKCEPTOWANO</a></td>";
                    }
                    echo"</tr>";
                }
            }
            echo"</table>";

            echo'</div>
            <!-- /.box-body -->
            
        </div>
        <!-- /.box -->';
        }
        else
        {
            echo'<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Przeglad</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';
            $minuty_status = PoliczMinuty($uzytkownik_id);
            echo "<p>$użytkownik_imie_nazwisko ma: $minuty_status minut</p>";
            echo'<table id="example1" class="table table-bordered table-striped">';
            echo "<thead><tr><th>ID</th><th>DATA</th><th>TYP</th><th>DZIEŃ</th><th>OD</th><th>DO</th><th>MINUT</th><th>UWAGI</th><th>WAŻNE DO</th><th>AKCEPTACJA</th></tr></thead>";
            $pobierz_godziny_uzytkownika=mysqli_query($polaczenie,"SELECT id, data_rejestracji, typ_wyjscia, od, do, minut, uwagi,akceptacja, wazne_do
            FROM nadgodziny WHERE id_usera='$uzytkownik_id'")
                or die("Bład przy pobierz_godziny_uzytkownika");
            if(mysqli_num_rows($pobierz_godziny_uzytkownika)>0)
            {

                while ($godziny_uzytkownika=mysqli_fetch_array($pobierz_godziny_uzytkownika))
                {
                    $od_format=date_create($godziny_uzytkownika['od']);
                    $dzien=date_format($od_format,'Y-m-d');
                    $od_format=date_format($od_format,'H:i');

                    $do_format=date_create($godziny_uzytkownika['do']);
                    $do_format=date_format($do_format,'H:i');
                    echo"<tr>";
                    echo"<td>$godziny_uzytkownika[id]</td>";
                    echo"<td>$godziny_uzytkownika[data_rejestracji]</td>";
                    if($godziny_uzytkownika['typ_wyjscia']==0)
                    {
                        echo"<td><a class='btn-sm btn-info'>SŁUŻBOWE</a></td>";
                        echo "<td>$dzien</td>";
                        echo"<td>$od_format</td>";
                        echo"<td>$do_format</td>";
                        echo"<td class='text-success text-bold'><i class='fa fa-plus'></i> $godziny_uzytkownika[minut]</td>";
                    }
                    else
                    {
                        echo"<td><a href='#' class='btn-sm btn-primary'>OSOBISTE</a> </td>";
                        echo "<td>$dzien</td>";
                        echo"<td>$od_format</td>";
                        echo"<td>$do_format</td>";
                        echo"<td class='text-red text-bold'><i class='fa fa-minus text-red'> </i> $godziny_uzytkownika[minut]</td>";
                    }

                    echo"<td>$godziny_uzytkownika[uwagi]</td>";
                    echo"<td>$godziny_uzytkownika[wazne_do]</td>";
                    if($godziny_uzytkownika['akceptacja']==0)
                    {
                        echo"<td><a class='btn-sm btn-danger'>BRAK AKCEPTACJI</a></td>";
                    }
                    else
                    {
                        echo"<td><a class='btn-sm btn-success'>ZAKCEPTOWANO</a></td>";
                    }
                    echo"</tr>";
                }
            }
            echo"</table>";

            echo'</div>
            <!-- /.box-body -->
            
        </div>
        <!-- /.box -->';
        }
        ?>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include'dol.php'; ?>
