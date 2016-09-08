<?php
/*
// definiujemy dane do połączenia z bazą danych
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', 'em');
define('DBNAME', 'baza_nowa');
//Polaczenie MySQLi
//error_reporting(2);
$polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
mysqli_set_charset($polaczenie, "utf8");
*/
$a='';
if(isset($_REQUEST['a']))
{
    $a = trim($_REQUEST['a']);
}
if (isset($_REQUEST['id']))
{
    $nrID=trim($_REQUEST['id']);
}

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

// funkcja na sprawdzanie czy user jest zalogowany, jeśli nie to wyświetlamy komunikat

// startujemy sesje
session_start();

 
// jeśli nie ma jeszcze sesji "logged" i "user_id" to wypełniamy je domyślnymi danymi
if(!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = false;
    $_SESSION['user_id'] = -1;
}
?>