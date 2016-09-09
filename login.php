<?php

include 'config.php';
//include 'Polaczenie.php';
//include 'Logowanie.php';
////include 'Uzytkownik.php';
//db_connect();
$data_godz=date("Y-m-d, H:i");
$blad=0;
// sprawdzamy czy user nie jest przypadkiem zalogowany
if(!$_SESSION['logged']) {
    // jeśli zostanie naciśnięty przycisk "Zaloguj"
    if (isset($_POST['name'])) {
        //$logowanie = new Logowanie();
        // filtrujemy dane...
        $_POST['name'] = clear($_POST['name']);
        $_POST['password'] = clear($_POST['password']);
        // i kodujemy hasło
        $_POST['password'] = codepass($_POST['password']);


        //$polaczenie = new Polaczenie();
       // $db = $polaczenie->polaczenie_z_baza;
        // sprawdzamy prostym zapytaniem sql czy podane dane są prawidłowe
       // $zapytanie = $db->query("SELECT `user_id` FROM `users` WHERE `user_name` = '{$_POST['name']}' AND `user_password` = '{$_POST['password']}' LIMIT 1");
        $result = mysqli_query($polaczenie,"SELECT `user_id` FROM `users` WHERE `user_name` = '{$_POST['name']}' AND `user_password` = '{$_POST['password']}' LIMIT 1");
        //$wynik = $zapytanie->num_rows;
        /*if($wynik>0)
        {
            $dane = $zapytanie->fetch_assoc();
            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $dane['user_id'];
            header('Location: index.php');

        }

        */
        if (mysqli_num_rows($result) > 0) {
            // jeśli tak to ustawiamy sesje "logged" na true oraz do sesji "user_id" wstawiamy id usera
            $row = mysqli_fetch_assoc($result);
            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $user = $row['user_id'];
            $ip = $_SERVER['REMOTE_ADDR'];

            $data_logowania = mysqli_query($polaczenie,"UPDATE `users` SET `user_website`='$data_godz', `ip_a`='$ip' WHERE `user_id`='$user'");
            echo("$ip  $data_godz $user");
            header('Location: index.php');
        } else {
            $blad=1;
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Serwis 2.0 | Logowanie</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/font-awesome/css/font-awesome.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="./plugins/ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="./plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="./plugins/html5shiv/html5shiv.min.js"></script>
    <script src="./plugins/respond/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="login.php"><b>Serwis</b>2.0</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Zaloguj się by rozpocząć pracę</p>
        <form action="login.php" method="post">
            <div class="form-group has-feedback">
                <?php
                if(isset($_POST['name']))
                {
                    echo'<input type="text" class="form-control" placeholder="Login" name="name" value="'.$_POST['name'].'">';
                }
                else
                {
                    echo'<input type="text" class="form-control" placeholder="Login" name="name"/>';
                }
                echo'
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">

                <input type="password" class="form-control" placeholder="Hasło" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span> ';
?>
                <p></p>
                <?php
                if($blad!=0){

    echo'
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i>Błąd logowania!</h4>
                    Podano zły login lub hasło !
                </div>';
                }
    ?>
            </div>
            <div class="row">
                <div class="col-xs-8">

                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Zaloguj</button>
                </div><!-- /.col -->
            </div>
        </form>



        <a href="#" title="Zadzwoń na 79 11614 ">Nie pamiętam hasła</a><br>


    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="./plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="./bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="./plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
<?php

} else {
    header('Location: index.php');
}


?>