<?php

/**
 * Created by PhpStorm.
 * User: mario
 * Date: 2016-09-08
 * Time: 12:11
 */
class Logowanie
{
    public $logowanie_login;
    public $logowanie_haslo;
    public $logowanie_data;
    public $logowanie_ip;
    public $logowanie_niepoprawnie;
    public $logowanie_niepoprawnie_data;
    public $logowanie_reset_hasla;
    public $logowanie_aktywny;

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



// funkcja na pobranie danych usera

}