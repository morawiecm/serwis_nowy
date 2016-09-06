<?php
include 'config.php';
//db_connect();

check_login();

// dane uzytkownika z sesji
$user_data = get_user_data();
$uzytkownik_imie = $user_data['imie'];
$uzytkownik_nazwisko = $user_data['nazwisko'];
$uzytkownik_nazwa = $user_data['user_name'];
$uzytkownik_id = $user_data['user_id'];
$uzytkownik_sekcja = $user_data['sekcja'];
$uzytkownik_uprawnienia = $user_data['specialne'];
$użytkownik_imie_nazwisko = $uzytkownik_imie . " " . $uzytkownik_nazwisko;
//dane z POST

if (isset($_REQUEST['a']))
{
$a = trim($_REQUEST['a']);
}
else{
$a='';
}
if (isset($_REQUEST['id']))
{
$nrID = trim($_REQUEST['id']);
}

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

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Serwis 2.0 | Strona Główna</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="./dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="./plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="./plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="./plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="./plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php
include 'menu.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
<?php

/**
 * @author mariusz morawiec
 * @copyright 2012
 */
 







// wyświetlamy początek prostej tabelki
 
// filtrujemy id oraz rzutujemy je na int
$_GET['id'] = (int)clear($_GET['id']);
 
// pobieramy dane usera z podanego id
$user_data = get_user_data($_GET['id']);
 
 
// sprawdzamy czy znalazło użytkownika
// jeśli nie to wyświetlamy komunikat
// a jeśli tak to wyświetlamy wszystkie jego dane
// jeśli user nie ma podanej strony www lub skąd jest to wyświetlamy "brak"
if($user_data === false) {
    echo '<p>Niestety, taki użytkownik nie istnieje.</p>
        <p>[<a href="index.php">Powrót</a>]</p>';
} else {
    echo '<h2>Profil użytkownika</h2>
        <p>Login: <b>'.$user_data['user_name'].'</b></p>
        <P>Typ konta:';
        if($user_data['specialne']!='1')
        {
            echo(' użytkownik');
        }
        else{
            echo(' administrator');
        }
        echo'</p>
        <p>Imię i nazwsko:'.$user_data['imie'].' '.$user_data['nazwisko'].'</p>
        <p>Email: '.$user_data['user_email'].'</p>
        <p>Data rejestracji: '.date("d.m.Y, H:i", $user_data['user_regdate']).'</p>
        <p>Data ostatniego logowania: '.(empty($user_data['user_website']) ? 'brak' : $user_data['user_website']).' IP: '.$user_data['ip_a'].'</p>
        <p>Wydział: '.(empty($user_data['user_from']) ? 'brak' : $user_data['user_from']).'</p>
        <p>Sekcja: '.(empty($user_data['sekcja']) ? 'brak' : $user_data['sekcja']).'</p>
        <p><a href="edit.php" class="btn btn-success">Zmiana danych</a></p>';
        
}

?>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Wersja Progamu</b> 2.0
    </div>
    <strong>Oprogramowanie stworzyl <a href="#">Mariusz Morawiec</a>.</strong> tel. 79 11614
</footer>
<?php include 'bok.php'; ?>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="./bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="./plugins/raphael/raphael-min.js"></script>
<script src="./plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="./plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="./plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="./plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="./plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="./plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
