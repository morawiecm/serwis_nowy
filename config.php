<?php

// definiujemy dane do połączenia z bazą danych
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', 'em');
define('DBNAME', 'baza_nowa');
//Polaczenie MySQLi
//error_reporting(2);
$polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
mysqli_set_charset($polaczenie, "utf8");

$a='';
if(isset($_REQUEST['a']))
{
    $a = trim($_REQUEST['a']);
}
if (isset($_REQUEST['id']))
{
    $nrID=trim($_REQUEST['id']);
}


// funkcja na sprawdzanie czy user jest zalogowany, jeśli nie to wyświetlamy komunikat

// startujemy sesje

function polaczenie_z_baza()
{
    $polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
    mysqli_set_charset($polaczenie, "utf8");

    return $polaczenie;
}

session_start();
function clear($text) {
    // jeśli serwer automatycznie dodaje slashe to je usuwamy
    if(get_magic_quotes_gpc()) {
        $text = stripslashes($text);
    }
    $text = trim($text); // usuwamy białe znaki na początku i na końcu
    //$text = mysqli_real_escape_string($polaczenie,$text); // filtrujemy tekst aby zabezpieczyć się przed sql injection
    $text = htmlspecialchars($text); // dezaktywujemy kod html
    return $text;
}

function codepass($password) {
    // kodujemy hasło (losowe znaki można zmienić lub całkowicie usunąć
    return sha1(md5($password).'#!%Rgd64');
}

function check_login() {
    if(!$_SESSION['logged'])
    {
        die(header( 'Location: login.php' ) );
    }
}

function get_user_data($user_id = -1) {
    // jeśli nie podamy id usera to podstawiamy id aktualnie zalogowanego
    if($user_id == -1) {
        $user_id = $_SESSION['user_id'];
    }
    $polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
    mysqli_set_charset($polaczenie, "utf8");
    $result = mysqli_query($polaczenie,"SELECT * FROM `users` WHERE `user_id` = '{$user_id}' LIMIT 1");
    if(mysqli_num_rows($result) == 0) {
        return false;
    }
    return mysqli_fetch_assoc($result);
}

// jeśli nie ma jeszcze sesji "logged" i "user_id" to wypełniamy je domyślnymi danymi
if(!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = false;
    $_SESSION['user_id'] = -1;
}


?>