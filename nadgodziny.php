<?php
include 'config.php';
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
                Start creating your amazing application!
            </div>
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
            echo'<table id="example1" class="table table-bordered table-striped">';
            echo "<thead><tr><th>ID</th><th>DATA</th><th>TYP</th><th>OD</th><th>DO</th><th>MINUT</th><th>UWAGI</th><th>AKCEPTACJA</th></tr></thead>";
            $pobierz_godziny_uzytkownika=mysqli_query($polaczenie,"SELECT id, data_rejestracji, typ_wyjscia, od, do, minut, uwagi,akceptacja
            FROM nadgodziny WHERE id_usera='$uzytkownik_id'")
                or die("Bład przy pobierz_godziny_uzytkownika");
            if(mysqli_num_rows($pobierz_godziny_uzytkownika)>0)
            {
                while ($godziny_uzytkownika=mysqli_fetch_array($pobierz_godziny_uzytkownika))
                {
                    echo"<tr>";
                    echo"<td>$godziny_uzytkownika[id]</td>";
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
