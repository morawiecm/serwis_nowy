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


$data_backupu=date("Y-m-d H:i:s");
$baza_nazwa='baza_nowa';
$baza_host='localhost';

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

echo'
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kopia zapasowa
            <small></small>
        </h1>
        <ol class="breadcrumb">

        </ol>
    </section>

    <!-- Main content -->
    <section class="content">';

if($a=='wykonaj_kopie') {


    $backupsDir = 'kopia_bazy';
    try {
        $pdo = new PDO("mysql:host=$baza_host;dbname=$baza_nazwa", DBUSER, DBPASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlResult = $pdo->query("SHOW tables FROM $baza_nazwa");


        $sqlData = "-- Data wykonania kopii: " . date('d.m.Y') . " r. o godzinie " . date('H:i') ."
        -- Baza: $dbName
        SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";";

        while ($queryTable = $sqlResult->fetch(PDO::FETCH_ASSOC)) {
            $sqlTable = $queryTable['Tables_in_' . $baza_nazwa];
            $sqlResultB = $pdo->query("SHOW CREATE TABLE $sqlTable");
            $queryTableInfo = $sqlResultB->fetch(PDO::FETCH_ASSOC);


            $sqlData .= "\n\n--
        -- Struktura dla tabeli `$sqlTable`
        --\n\n";
            $sqlData .= $queryTableInfo['Create Table'] . ";\n";
            $sqlData .= "\n\n--
        -- Wartości tabeli `$sqlTable`
        --\n\n";

            $sqlResultC = $pdo->query("SELECT * FROM $sqlTable");


            while ($queryRecord = $sqlResultC->fetch(PDO::FETCH_ASSOC)) {
                $sqlData .= "INSERT INTO `$sqlTable` VALUES (";
                $sqlRecord = '';
                foreach ($queryRecord as $sqlField => $sqlValue) {
                    $sqlRecord .= "'$sqlValue',";
                }
                $sqlData .= substr($sqlRecord, 0, -1);
                $sqlData .= ");\n";
            }
        }

        $naza_pliku = 'kopia_' . $baza_nazwa . '_' . date('d_m_Y_H_i_s') . '.sql';
        $pelna_sciezka = $backupsDir . '/' . $naza_pliku;
        file_put_contents($pelna_sciezka, $sqlData);
        $zapisz_do_bazy=mysqli_query($polaczenie,"INSERT INTO backup (id, dataBackupu, nazwaBackupu, ktoUtworzyl) VALUES ('','$data_backupu','$pelna_sciezka','$użytkownik_imie_nazwisko')") or die("blad przy zapisz_do_bazy".mysqli_error($polaczenie));
        echo"<!-- Page Content -->
        <div id='page-wrapper'>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-lg-12'>";
        echo'
        <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>	<i class="icon fa fa-check"></i> Alert!</h4>';
        echo "Backup został zapisany. Nazwa pliku : $naza_pliku <a href='backup.php'>POWRÓT</a>" ;
                  echo'</div>';
    } catch (PDOException $e) {
        echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    }
}
elseif($a=='usun')
{
    if($uzytkownik_uprawnienia='1')
    {
        if(isset($_REQUEST['plik']))
        {

            $pelna_sciezka=$_SERVER['DOCUMENT_ROOT'];
            $pelna_sciezka.="/serwis/".$_REQUEST['plik'];


            if(unlink($pelna_sciezka))
            {
                echo "Usunieto plik $pelna_sciezka ";
                $usun_wpis=mysqli_query($polaczenie,"DELETE FROM backup WHERE id='$nrID'") or die("blad przy usun_wpis");
                echo"i wpis z bazy";
            }
            else
            {
                echo'<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Blad przy usuwaniu pliku <a href="backup.php" class="btn btn-success">Powrót</a>
                  </div>';
            }

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

else{
       echo' <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Kopia zapasowa - lista</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';

                echo"<p><a href='backup.php?a=wykonaj_kopie' class='btn btn-success'>WYKONAJ KOPIE ZAPASOWĄ BAZY</a></p>";
                echo"<table class='table table-striped table-bordered table-hover'>";
                echo"<tr><th>DATA</th><th>UTWORZYŁ</th><th>ROZMIAR</th><th>AKCJA</th></tr>";
                $pobierzBackup_z_bazy=mysqli_query($polaczenie,"SELECT * FROM backup") or die("Blad przy pobierzBackup_z_bazy");
                $licznik_kopia=mysqli_num_rows($pobierzBackup_z_bazy);
                if($licznik_kopia>0)
                {

                    while($daneBackup=mysqli_fetch_array($pobierzBackup_z_bazy))
                    {

                        $pelna_sciezka_pliku=$_SERVER['DOCUMENT_ROOT'].'/serwis/'.$daneBackup[2];
                        //echo $pelna_sciezka_pliku;
                        $wielkosc_pliku=filesize($pelna_sciezka_pliku);
                        $wielkosc_pliku=$wielkosc_pliku/1024;
                        $wielkosc_pliku=number_format($wielkosc_pliku,0,'.','');
                        echo "<tr><td>$daneBackup[1]</td><td>$daneBackup[3]</td><td>$wielkosc_pliku KB </td><td><a href='$daneBackup[2]' class='btn-sm btn-dropbox'>POBIERZ</a> <a href='backup.php?a=usun&id=$daneBackup[0]&plik=$daneBackup[2]' class='btn-sm btn-danger'>USUŃ</a> </td></tr>";
                    }
                }
                echo '</table>

            </div><!-- /.box-body -->
            <div class="box-footer">';
                echo"Dostępnych kopii: ($licznik_kopia)";
            echo'</div><!-- /.box-footer-->
        </div><!-- /.box -->';
}
?>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include 'dol.php';?>