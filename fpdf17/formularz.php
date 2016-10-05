<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Send-2 Logistics</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<link href="styles.css" rel="stylesheet" type="text/css" />
<script src="sorttable.js"></script>

</head>
<body>

<div id="outerWrapper">
  <div id="header">
    <div id="title"><a href="index.php">Send 2 Logistics</a> </div>
    <div id="headlinks"> <a href="mailto:mariusz@morawiec.org?subject=kontakt_serwis">Kontakt</a> | <strong> 506280099 </strong></div>
  </div>
  <div id="navcontainer">
    <div id="nav">
      <ul>
        <li><a href="index.php">Strona G³owna</a></li>
        <li><a href="dodaj.php">Dodaj nowy List</a></li>
        <li><a href="wszystkie_wpisy.php">Wszystkie wpisy</a></li>
        <li><a href="wyszukiwarka.php">Wyszukiwarka</a></li>
      </ul>
    </div>
  </div>

  <div id="twoColumnright">

    
    <div id="content">
    <table border="0" align="left"><tr><form action="b.php" method="post"><th colspan="2">Nadawca:</th><th colspan="2">Odbiorca:</th></tr>
    <tr><th>Imiê:</th><td><input type="text" name="imie_nad"/></td><th>Imiê</th><td><input type="text" name="imie_odb"/></td></tr>
    <tr><th>Nazwisko:</th><td><input type="text" name="nazwisko_nad"/></td><th>Nazwisko</th><td><input type="text" name="nazwisko_odb"/></td></tr>
   <tr><th>Ulica:</th><td><input type="text" name="ulica_nad"/></td><th>Ulica</th><td><input type="text" name="ulica_odb"/></td></tr>
    <tr><th>Kod Poczt:</th><td><input type="text" name="kod_nad"/></td><th>Kod Poczt:</th><td><input type="text" name="kod_odb"/></td></tr>
    <tr><th>Miasto:</th><td><input type="text" name="miasto_nad"/></td><th>Miasto:</th><td><input type="text" name="miasto_odb"/></td></tr>
    <tr><th>Telefon:</th><td><input type="text" name="tel_nad"></td><th>Telefon:</th><td><input type="text" name="tel_odb"/></td></tr>
    <tr><th>Email</th><td><input type="text" name="email_nad"></td><th>Email</th><td><input type="text" name="email_odb"/></td></tr>
    <tr><th colspan="4">Dane paczki:</th></tr>
    <tr><th>D³ugoœæ:</th><td><input type="text" name="dlugosc"/></td><th>Szerokoœæ</th><td><input type="text" name="szerokosc"/></td></tr>
    <tr><th>Wysokoœæ:</th><td><input type="text" name="wysokosc"/></td><th>Waga:</th><td><input type="text" name="waga"/></td></tr>
    <tr><th colspan="4">Dodatkowe us³ugi:</th></tr>
    <tr><th>Paczka</th><td><select name="typ"><option value="standard">Standardowa</option><option value="niestandardowa">Niestandardowa</option></select></td>
    <th>Ubezpieczenie:</th><td><select name="ubezpieczenie"><option value="0" selected="selected">Brak</option><option value="2000">2000</option><option value="10000">10000</option><option value="20000">20000</option><option value="50000">50000</option>
    </select></td></tr>
    <tr><th>Kwota Pobrania</th><td><input type="text" name="kwota_pobrania"/></td><th>Nazwa banku:</th><td><input type="text" /></td></tr>
    </form></table>
<?php

/**
 * @author 
 * @copyright 2012
 */



?>

 </div>
    <!-- End content -->
    <div class="clear"></div>
  </div>
  <div id="footer"><span style="float:right;padding-right:30px;"></span>Copyright &copy; 2012 Mariusz Morawiec</div>
</body>
</html>

