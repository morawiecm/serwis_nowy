<?php
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', 'em');
define('DBNAME', 'baza_nowa');
//Polaczenie MySQLi
//error_reporting(2);
$polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
mysqli_set_charset($polaczenie, "utf8");