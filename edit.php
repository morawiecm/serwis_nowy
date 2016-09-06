<?php
include 'config.php';
db_connect();

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
<html>
<head>
    <meta charset="utf-8">
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
 

$user_data = get_user_data();
 
// jeśli zostanie naciśnięty przycisk "Edytuj profil"
if(isset($_POST['email'])) {
    // filtrujemy dane
    $_POST['sekcja'] = clear($_POST['sekcja']);
    $_POST['from'] = clear($_POST['from']);
    $_POST['new_password'] = clear($_POST['new_password']);
    $_POST['new_password2'] = clear($_POST['new_password2']);
    $_POST['password'] = clear($_POST['password']);
    $_POST['email'] = clear($_POST['email']);
 
    // zmienne tymczasowe na treść błędu
    $err = '';
    // i zapytanie sql
    $up2 = '';
 
    // jeśli zostanie podane nowe hasło lub inny email
    if(!empty($_POST['new_password']) || $_POST['email'] != $user_data['user_email']) {
        // sprawdzamy czy zostało podane aktualne hasło
        if(empty($_POST['password'])) {
            $err = '<p>Jeśli chcesz zmienić hasło lub adres email musisz podać aktualne hasło.</p>';
        // jeśli zostało podane to sprawdzamy czy jest poprawne
        } elseif(codepass($_POST['password']) != $user_data['user_password']) {
            $err = '<p>Podane aktualne hasło jest nieprawidłowe.</p>';
        } else {
            // jeśli wszystko jest ok...
 
            // sprawdzamy czy user chce zmienić hasło
            if(!empty($_POST['new_password'])) {
                // jeśli podane dwa hasła są różne to wyświetlamy błąd
                if($_POST['new_password'] != $_POST['new_password2']) {
                    $err = '<p>Podane hasła nie są takie same.</p>';
                // jeśli wszystko jest ok, dopisujemy do zmiennej tymczasowej zapytanie do zaktualizowania hasła
                } else {
                    $up2.= ", `user_password` = '".codepass($_POST['new_password'])."'";
                }
            }
            // sprawdzamy czy user chce zmienić email (czy ten podany jest różny od aktualnego)
            if($_POST['email'] != $user_data['user_email']) {
                // sprawdzamy czy podany email jest prawidłowy
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                    $err = '<p>Podany email jest nieprawidłowy.</p>';
                } else {
                    // sprawdzamy czy istnieje taki email w bazie przy czym omijamy usera który jest zalogowany
                    $result = mysql_query("SELECT Count(user_id) FROM `users` WHERE `user_id` != '{$user_data['user_id']}' AND `user_email` = '{$_POST['email']}'");
                    $row = mysql_fetch_row($result);
                    if($row[0] > 0) {
                        $err = '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                    } else {
                        // jeśli wszystko jest ok to dopisujemy zapytanie do zaktualizowania emaila
                        $up2.= ", `user_email` = '{$_POST['email']}'";
                    }
                }
            }
        }
    }
 
    // jeśli są jakieś błędy z powyższych działań to je wyświetlamy
    if(!empty($err)) {
        echo $err;
    } else {
        // jeśli nie ma błędów to wykonujemy zapytanie dopisując te na aktualizacje hasła oraz emaila - $up2
        $result = mysql_query("UPDATE `users` SET `sekcja`='{$_POST['sekcja']}', `user_from` = '{$_POST['from']}'{$up2} WHERE `user_id` = '{$user_data['user_id']}'");
        if($result) {
            // jeśli zapytanie się wykonało to wyświetlamy komunikat...
            echo '<p>Twój profil został poprawnie zaktualizowany.</p>';
            // i pobieramy od nowa dane usera aby w poniższym formularze się one zaktualizowały
            $user_data = get_user_data();
        } else {
            // jeśli zapytanie będzie błędne to wyświetlamy treść errora
            echo '<p>Niestety wystąpił błąd:<br>'.mysql_error().'</p>';
        }
    }
}
 
// wyświetlamy prosty formularz
        echo'<table>';
echo '<form method="post" action="edit.php">
    <tr>
        <th>Login:</th>
        <td><input type="text" value="'.$user_data['user_name'].'" disabled="true" class="form-control">
    </td></tr>
    
    <tr>
       <th> Wydział:</th>
        <td><input type="text" value="'.$user_data['user_from'].'" name="from" class="form-control"></td>
    </tr>
      <tr>
        <th>Sekcja:</th>
        <td>
        <input type="text" name="sekcja" class="form-control" value="'.$user_data['sekcja'].'">
        
    </td></tr>
    <tr><th>
        Nowe hasło (pozostaw puste jeśli nie chcesz zmieniać):</th>
        <td><input type="password" value="" name="new_password" autocomplete="off" class="form-control">
        </td>
    </tr>
    <tr>
       <th> Powtórz nowe hasło:</th>
        <td><input type="password" value="" name="new_password2" autocomplete="off" class="form-control"></td>
    </tr>

    <tr>
        <th>E-mail:</th>
        <td><input type="text" value="'.$user_data['user_email'].'" name="email" class="form-control"></td>
    </tr>
    <tr><td>
        Aktualne hasło (wymagane przy zmianie emaila lub hasła):</td>
        <td><input type="password" value="" name="password" autocomplete="off" class="form-control">
    </td></tr>
    <tr><td colspan ="2">
        <input type="submit" value="Edytuj profil" class="btn btn-danger form-control">
    </td></tr>
</form></table>';

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
