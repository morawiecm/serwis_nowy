<?php
 
// definiujemy dane do połączenia z bazą danych
define('DBHOST', '192.168.1.252');
define('DBUSER', 'mm');
define('DBPASS', 'em');
define('DBNAME', 'otrs');
//Polaczenie MySQLi
error_reporting(2);
$polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
mysqli_set_charset($polaczenie, "utf8");



/*
// polaczenie MySQL
function db_connect() {
    // połączenie z mysql
    mysql_connect(DBHOST, DBUSER, DBPASS) or die('<h2>ERROR</h2> MySQL Server się zepsół dzwoń na 997 !!!'.mysql_error());
 
    // wybór bazy danych
    mysql_select_db(DBNAME) or die('<h2>ERROR</h2> Nie można połączyć się z bazą'.mysql_error());
    mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET collation_connection = utf8_polish_ci");
}
 
function db_close() {
    mysql_close();
}*/
 
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
 
// funkcja na sprawdzanie czy user jest zalogowany, jeśli nie to wyświetlamy komunikat
function check_login() {
    if(!$_SESSION['logged']) {
   die(header( 'Location: login.php' ) );   

    }
}
 
// funkcja na pobranie danych usera
function get_user_data($user_id = -1) {
    // jeśli nie podamy id usera to podstawiamy id aktualnie zalogowanego
    if($user_id == -1) {
        $user_id = $_SESSION['user_id'];
    }
    $polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());

    $result = mysqli_query($polaczenie,"SELECT * FROM `users` WHERE `user_id` = '{$user_id}' LIMIT 1");
    if(mysqli_num_rows($result) == 0) {
        return false;
    }
    return mysqli_fetch_assoc($result);
}
 
// startujemy sesje
session_start();
 
// jeśli nie ma jeszcze sesji "logged" i "user_id" to wypełniamy je domyślnymi danymi
if(!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = false;
    $_SESSION['user_id'] = -1;
}
?>