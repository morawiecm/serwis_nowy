<?php
include 'config.php';
include 'funkcje/funkcje_ewidencja.php';
include 'funkcje/funkcje_historia.php';
check_login();
// dane uzytkownika z sesji
$user_data = get_user_data();
$uzytkownik_imie = $user_data['imie'];
$uzytkownik_nazwisko = $user_data['nazwisko'];
$uzytkownik_nazwa = $user_data['user_name'];
$uzytkownik_id = $user_data['user_id'];
$uzytkownik_wydzial = $user_data['wydzial'];
$uzytkownik_sekcja = $user_data['sekcja'];
$uzytkownik_uprawnienia = $user_data['specialne'];
$użytkownik_imie_nazwisko = $uzytkownik_imie . " " . $uzytkownik_nazwisko;
$data_pelana  = date("Y-m-d H:i:s");
$data_skrocona = date("Y-m-d");
//dane z POST


if ($uzytkownik_uprawnienia == 1) {
    $uprawienia = 'Administrator';
} else {
    $uprawienia = 'Użytkownik';
}

//print_r($_POST);

include 'gora.php';
include 'pasek.php';
include 'menu.php';



if($a=='dodaj')
{
    echo NaglowekStrony("Asygnaty","Lista","Lista asygnat");

}
elseif ($a=='edycja')
{
    echo NaglowekStrony("Protokół rozkompletowania","Edycja dokumentu","Edycja dokumentów");
    //var_dump($_POST);
    $pobierz_dane_rozkompletowanie = mysqli_query($polaczenie,"SELECT nr_protokolu,id,data_protokolu,czlonek_komisji_1,czlonek_komisji_2,czlonek_komisji_3,nr_ewidencyjny,nazwa_srodka_trwalego  FROM rozkompletowanie WHERE id='$nrID'")
        or die("Blad przy pobierz_dane_rozkompletowanie".mysqli_error($polaczenie));
    while ($protokol_glowny = mysqli_fetch_array($pobierz_dane_rozkompletowanie))
    {
        echo"<table class='table table-bordered'><form method='post' action='protokol_rozkompletowania.php?a=aktualizuj_protokol'>";
        echo"<tr><td>Nr protokolu:</ts><td><input type='text' name='nr_protokolu' value='$protokol_glowny[nr_protokolu]' class='form-control'><input type='hidden' name='id_protokolu' value='$protokol_glowny[id]'></td></tr>";
        echo"<tr><td>Data protokolu:</td><td><input type='text' name='data_protokolu' class='form-control' id='datepicker' value='$protokol_glowny[data_protokolu]'/></td></tr>";
        echo"<tr><td colspan='2' class='text-bold text-center'>KOMISJA</td></tr>";
        echo"<tr><td>Przewodniczący:</td><td><select name='czlonek_komisji_1' class='form-control'><option value='$protokol_glowny[czlonek_komisji_1]'>$protokol_glowny[czlonek_komisji_1]</option></select>";
        echo"<tr><td>Członek 1:</td><td><select name='czlonek_komisji_2' class='form-control'><option value='$protokol_glowny[czlonek_komisji_2]'>$protokol_glowny[czlonek_komisji_2]</option></select>";
        echo"<tr><td>Członek 2:</td><td><select name='czlonek_komisji_3' class='form-control'><option value='$protokol_glowny[czlonek_komisji_3]'>$protokol_glowny[czlonek_komisji_3]</option></select>";
        echo"<tr><td colspan='2'><input type='submit' value='Aktualizuj dane protokolu' class='btn btn-primary form-control'></td></tr>";
        echo"</form></table>";
        echo"<table class='table table-bordered'>";
        echo"<tr><td colspan='5' class='text-bold text-center'> ROZKOMPLETOWANIE:$protokol_glowny[nr_ewidencyjny] - $protokol_glowny[nazwa_srodka_trwalego] </td></tr>";
        $pobierz_skladniki_rozkompletowania($polaczenie,"SELECT nazwa_wykomplet_sprzetu,wartosc_wykomplet_sprzetu,nr_inwentarzowy_nowy FROM rozkompletowanie_skladniki WHERE id_protokolu = '$protokol_glowny[id]'")
            or die("Blad przy pobierz_skladniki_rozkompletowania".mysqli_error($polaczenie));
        $liczba_skladnikow_rozkompletowania = mysqli_num_rows($pobierz_skladniki_rozkompletowania);
        echo"<tr><td colspan='5' class='text-center'>SKŁADNIKI PROTOKOŁU($liczba_skladnikow_rozkompletowania):</td></tr>";
        if($liczba_skladnikow_rozkompletowania>0)
        {
            echo "<tr><th>Nr iwnetarzowy</th><th>Nazwa sprzetu</th><th>Wartośc</th><th>Akcja</th></tr>";
            while ($skladnik_rozkompletowania = mysqli_fetch_array($pobierz_skladniki_rozkompletowania))
            {
                echo"<tr><td></td><td></td><td></td><td></td></tr>";
            }
        }
        echo"</table>";

    }

}




/*
echo"<tr><td colspan='2'><center><u><input type='submit' value='Zapisz zmiany w komisji'/></u></center></td></tr></form>";
//dane ewidencyjne srodka trwalego
echo"<tr><td colspan='2'><center><u>DANE EWIDENCYJNE:</u></center></td></tr>";
echo"<form name='edycja_protokolu_rozkompletowania' method='POST' action='rozkompetowanie.php?a=edycja_zapisz_ewidencja'>";
echo"<input type='hidden' name='id_prot' value='$epr[0]'/>";
echo"<tr><td>Nr inwentarzowy:</td><td><input type='text' name='nr_ewidencyjny' disabled='disabled' value='$epr[10]'/></td></tr>";
echo"<tr><td>Nazwa produktu:</td><td><input type='text' name='nazwa_srodka_trwalego' value='$epr[9]'/></td></tr>";
echo"<tr><td>Na stanie:</td><td><input type='text' name='jednostka_uzytkujaca_orginal' disabled='disabled' value='$epr[12]'/>";
echo"<tr><td>Wartośc orginalna sprzetu:</td><td><input type='text' name='wartosc_orginalna' value='$epr[11]'/>";
echo"<tr><td>Jednostka użytkująca składnik po rozkompletowaniu:</td><td><select name='jednostka_uzytkujaca_1'><option value='$epr[14]'>$epr[14]</option>";
$wartPomn=$epr[13];
$lista_jednostek_1=mysql_query("SELECT * FROM `jednostki` ORDER BY `id` DESC") or die("Bład przy lista_jednostek_1".mysql_error());

if(mysql_num_rows($lista_jednostek_1)>0)
{
    while($lj_1=mysql_fetch_array($lista_jednostek_1))
    {
        echo"<option value='$lj_1[1]'>$lj_1[1]</option>";
    }
}
echo"</select></td></tr>";
echo"<tr><td colspan='2'><center><u><input type='submit' value='Zapisz zmiany ewidencyjne'/></u></center></td></tr></form>";
//rozkompletowanie
echo"<tr><td colspan='2'><center><u>ROZKOMPLETOWANIE</u></center></td></tr>";
//stary protokol
if($epr[28]=='nowy')
{
//pobranie danych rozkompletowania
$pobierzRozkompletowanieSkladniki=mysql_query("SELECT * FROM `rozkompletowanie_skladniki` WHERE `id_protokolu`='$idd'") or die("Bład przy pobierzRozkompletowanieSkladniki: ".mysql_error());
if(mysql_num_rows($pobierzRozkompletowanieSkladniki)>0)
{
echo"</table><table><tr><td>Nr ewidencyjny nowy</td><td>Nazwa, model</td><td>Nr seryjny</td><td>Wartość</td><td>Jednostka użytkująca</td><td>Akcja</td></tr>";
while($rozkompletowanieSkladniki=mysql_fetch_array($pobierzRozkompletowanieSkladniki))
{
    echo"<tr><td>$rozkompletowanieSkladniki[3]</td><td>$rozkompletowanieSkladniki[4] $rozkompletowanieSkladniki[8]</td><td>$rozkompletowanieSkladniki[9]</td><td>$rozkompletowanieSkladniki[6]</td><td>$rozkompletowanieSkladniki[7]</td><td>";
    //dodanie nowego nr ewidencyjnego
    if($rozkompletowanieSkladniki[3]=='')
    {
        if($sekcja=='Zespół Ewidencji Rozliczeń i Zaopatrzenia' || $uprawienia=='1')
        {
            $nazwaPelna=$rozkompletowanieSkladniki[4].' '.$rozkompletowanieSkladniki[8];
            echo"<a href='rozkompetowanie.php?a=dodaj_nr_ewidencyjny&id=$rozkompletowanieSkladniki[0]&id2=$rozkompletowanieSkladniki[2]&nazwa=$nazwaPelna' class='button plain'>DODAJ NR EWID</a>";
        }
    }

    //dalsza czesc akcji
    echo"<a href='rozkompetowanie.php?a=edycja_skladnika&id=$rozkompletowanieSkladniki[0]' class='button plain'>EDYTUJ</a><a href='rozkompetowanie.php?a=usun_skladnik&id=$rozkompletowanieSkladniki[0]&id2=$rozkompletowanieSkladniki[1]&wart=$rozkompletowanieSkladniki[6]&wartPomn=$wartPomn' class='button plain'>USUŃ</a></td></tr>";
}

*/
elseif ($a=='aktualizuj')
{

}
elseif ($a=='usun_skladnik')
{

}
elseif ($a=='akceptacja')
{

}
else
{
    echo NaglowekStrony("Protokół rozkompletowania","Lista dokumentów","Lista dokumentów");


    $pobierz_rozkompletowania = mysqli_query($polaczenie,"SELECT id,nr_protokolu,data_protokolu,akceptacja FROM rozkompletowanie ORDER BY id ASC ")
        or die("Blad przy pobierz_rozkompletowania: ".mysqli_error($polaczenie));
    echo "<table class='table table-bordered' id='example1'>";
    echo "<thead><tr><th>Nr protokołu</th><th>Data protokolu</th><th>Akcja</th></tr></thead>";
    if(mysqli_num_rows($pobierz_rozkompletowania)>0)
    {
        while ($protokol=mysqli_fetch_array($pobierz_rozkompletowania))
        {
            echo "<tr><td>$protokol[nr_protokolu]</td><td>$protokol[data_protokolu]</td><td><a href='protokol_rozkompletowania.php?a=edycja&id=$protokol[id]' class='btn-xs btn-info'>Edycja</a><a href='fpdf17/generuj_rozkompletowanie.php?a=generuj&id=$protokol[id]' class='btn-xs btn-success'>PDF</a></td></tr>";
        }
    }
    echo "</table>";

}
?>


</div>
<!-- /.box-body -->

</div>
<!-- /.box -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include'dol.php'; ?>
