<?php

// definiujemy dane do połączenia z bazą danych
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', 'em');
define('DBNAME', 'baza_nowa');
//Polaczenie MySQLi
//error_reporting(2);
$polaczenie=polaczenie_z_baza();

$a='';
if(isset($_REQUEST['a']))
{
    $a = trim($_REQUEST['a']);
}
if (isset($_REQUEST['id']))
{
    $nrID=trim($_REQUEST['id']);
}
else
{
    $nrID='';
}


function polaczenie_z_baza()
{
    $polaczenie=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Blad czy polaczniu'.mysqli_connect_error());
    mysqli_set_charset($polaczenie, "utf8");

    return $polaczenie;
}

function sprawdzHasloPolityka($text)
{
    $prawidlowe=true;
    $ilosc_znakow= mb_strlen($text, 'UTF-8');
    $wielkich_znakow=similar_text($text,strtolower($text));
    $wielkich_znakow_liczba=$ilosc_znakow-$wielkich_znakow;
    $znaki_specjalne=preg_match('/[!#@$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $text);
    if($ilosc_znakow<=7)
    {
        $prawidlowe = false;
    }
    if($wielkich_znakow_liczba==0)
    {
        $prawidlowe = false;
    }
    if($znaki_specjalne== 0)
    {
        $prawidlowe = false;
    }
    return $prawidlowe;
}

function NaglowekStrony($tytul_1_duzy,$tytul_1_maly,$tytul_ramki)
{
    $naglowek ="";

    $naglowek.='<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>';
    $naglowek.=$tytul_1_duzy;
           $naglowek.= "<small>$tytul_1_maly</small>
        </h1>

    </section>";

    $naglowek.='<!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">';
    $naglowek.=$tytul_ramki;
    $naglowek.='</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">';

    return $naglowek;
}

function Przekierowanie($komunikat,$strona)
{
    if($komunikat=='')
    {
        $komunikat= "Nie możesz tu być..zachwile zostaniesz przekierowany na strone główną";
    }
    if($strona=='')
    {
        $strona = "index.php";
    }
    echo $komunikat;
    echo "<script>
                    setTimeout(function () {
                        window.location.href= '$strona'; // the redirect goes here

                    },4500);
                        </script>";
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

function sprawdzWazanoscHasla($idus)
{
    $haslo_status=true;
    $polaczeniebaza=polaczenie_z_baza();
    $pobierzDateHaslaUzytkownika=mysqli_query($polaczeniebaza,"SELECT data_zmiany_hasla FROM users WHERE user_id='$idus'")
    or die("Blad przy pobierzDateHaslaUzytkownika".mysqli_error($polaczeniebaza));
    if(mysqli_num_rows($pobierzDateHaslaUzytkownika)>0)
    {
        while ($data_hasla_uzytkownika=mysqli_fetch_array($pobierzDateHaslaUzytkownika))
        {
            $dataWaznosci=$data_hasla_uzytkownika['data_zmiany_hasla'];
            if($dataWaznosci =='0000-00-00')
            {
                $haslo_status=false;
                $nowa_data=0;

            }
            else
            {
                $aktualna_data=date("Y-m-d");
                $jeden_dzien = strtotime(date("Y-m-d", strtotime($dataWaznosci)) . " +30 day");
                $jeden_dzien=date('Y-m-d', $jeden_dzien);
                $nowa_data=(strtotime($jeden_dzien)-strtotime($aktualna_data))/86400;
                $nowa_data=number_format($nowa_data,0);
                if ($nowa_data<0)
                {
                    $nowa_data=0;
                    $haslo_status=false;
                }

            }
        }
    }
    $status[0]=$haslo_status;
    $status[1]=$nowa_data;
    return $status;
}

function get_user_data($user_id = -1) {
    // jeśli nie podamy id usera to podstawiamy id aktualnie zalogowanego
    if($user_id == -1) {
        $user_id = $_SESSION['user_id'];
    }
    $polaczenie=polaczenie_z_baza();
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