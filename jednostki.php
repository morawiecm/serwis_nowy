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
include 'menu.php';
?>


<?php

if($a=='edycja')
{
    echo '
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Jednostki
            <small>Lista jednostek</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Jednostki</a></li>
            <li class="active">Lista jednostek</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista jednostek w garnizonie - edycja rekordu</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';
    $pobierz_JednostkaDane=mysqli_query($polaczenie,"SELECT * FROM jednostki WHERE id='$nrID'") or die("Blad przy pobierz_JednostkaDane".mysqli_error($polaczenie));
    if(mysqli_num_rows($pobierz_JednostkaDane)>0)
    {
        while ($JednostkaDane=mysqli_fetch_array($pobierz_JednostkaDane))
        {
            echo"<table class='table table-striped'><form name='dodaj_jednostke' method='post' action='jednostki.php?a=aktualizuj'>";
            echo"<tr><th>Nazwa jednostki</th><td><input type='text' name='nazwa_jednostki' class='form-control' value='$JednostkaDane[nazwa]'></td></tr>";
            echo"<tr><th>Kod jednostki</th><td><input type='text' name='kod_jednostki' value='$JednostkaDane[kod_jednostki]' class='form-control'></td></tr>";
            echo"<tr><th>Aktywna</th><td><input type='checkbox' value='0' name='aktywny' class='checkbox' checked></td></tr>";
            echo"<tr><td colspan='2'><input type='hidden' name='nr_rekordu' value='$nrID'><input type='submit' name='przycisk_aktualizuj' value='Zapisz zmiany' class='btn btn-warning form-control'></td></tr>";
            echo"</form></table>";
        }

    }
    echo '
            </div><!-- /.box-body -->
            
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->';
}
elseif ($a=='aktualizuj')
{
    if(isset($_POST['przycisk_aktualizuj']))
    {
        
        echo'<div class="alert alert-success alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Sukces!</h4>';
    }
    else
    {
        echo"Błąd";
    }
}
elseif ($a=='dodaj')
{
    echo '
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Jednostki
            <small>Lista jednostek</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Jednostki</a></li>
            <li class="active">Lista jednostek</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista jednostek w garnizonie - dodanie nowej</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';
    echo"<table class='table table-striped'><form name='dodaj_jednostke' method='post' action='jednostki.php?a=zapisz'>";
    echo"<tr><th>Nazwa jednostki</th><td><input type='text' name='nazwa_jednostki' class='form-control'></td></tr>";
    echo"<tr><th>Kod jednostki</th><td><input type='text' name='kod_jednostki' class='form-control'></td></tr>";
    echo"<tr><td colspan='2'><input type='submit' name='przyscik_zapisz' value='Dodaj' class='btn btn-success form-control'></td></tr>";
    echo"</form></table>";
    echo '
            </div><!-- /.box-body -->
            
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->';

}
elseif ($a=='zapisz')
{
    if(isset($_POST['przyscik_zapisz'])) {


        echo '<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
Jednostki
            <small>Lista jednostek</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Jednostki</a></li>
            <li class="active">Lista jednostek-> Zapis</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista jednostek w garnizonie -zapisywanie</h3>
               
            </div>
            <div class="box-body">';
            $nazwa_jednostki=$_POST['nazwa_jednostki'];
            $kod_jednostki=$_POST['kod_jednostki'];
            $zapisz_Jednostke=mysqli_query($polaczenie,"INSERT INTO jednostki (id, nazwa, kod_jednostki, aktywny) VALUES ('','$nazwa_jednostki','$kod_jednostki','0')") or die("Blad przy zapisz_Jednostke".mysqli_error($polaczenie));
        echo'<div class="alert alert-success alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Sukces!</h4>';


        echo"Zapisano pomyślnie jednostkę: $nazwa_jednostki <a href='jednostki.php'>Powrót</a>";

        echo '
            </div><!-- /.box-body -->
            
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->';
    }
    else
    {
        echo '<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">

        <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Bład!</h4>';


        echo"Bład. Brak danych z formularza do zapisu...spróbuj jeszcze raz <a href='jednostki.php'>Powrót</a>";

        echo '
            </div><!-- /.box-body -->
            
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->';
    }
}
elseif ($a=='usun')
{

}
else {


    echo '
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Jednostki
            <small>Lista jednostek</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Jednostki</a></li>
            <li class="active">Lista jednostek</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista jednostek w garnizonie</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';

    $pobierz_listeJednostek = mysqli_query($polaczenie, "SELECT id, nazwa, kod_jednostki FROM jednostki WHERE kod_jednostki!='666' order BY nazwa ASC ") or die("Blad przy pobierz_listeJednostek" . mysqli_error($polaczenie));
    $licznik_listaJednostek = mysqli_num_rows($pobierz_listeJednostek);
    if ($licznik_listaJednostek > 0) {
        echo"<p><a href='jednostki.php?a=dodaj' class='btn btn-success'>Dodaj jednostke</a></p>";
        echo "<table class='table table-striped'>";
        echo "<tr><th>Nazwa jednostki</th><th>Kod jednostki</th><th>Akcja</th></tr>";
        while ($listaJednostek = mysqli_fetch_array($pobierz_listeJednostek)) {
            echo "<tr><td>$listaJednostek[nazwa]</td><td>$listaJednostek[kod_jednostki]</td><td><a href='jednostki.php?a=edycja&id=$listaJednostek[id]' class='btn-sm btn-warning'>Edytuj</a><a href='jednostki.php?a=usun' class='btn-sm btn-danger'>Usuń</a> </td></tr>";
        }
        echo "</table>";
    }
    echo '
            </div><!-- /.box-body -->
            <div class="box-footer">';
    echo "Liczba wpisów ($licznik_listaJednostek)";
    echo '</div><!-- /.box-footer-->
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->';
}
include 'dol.php';?>