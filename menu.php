<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                if (mb_strtolower(mb_substr($uzytkownik_imie, -1)) == 'a') {
                    echo '<img src="dist/img/avatar3.png" class="img-circle" alt="User Image">';
                }
                else
                {
                    echo'<img src="dist/img/avatar5.png" class="img-circle" alt="User Image">';
                }
                ?>
            </div>
            <div class="pull-left info">
                <p><?php echo"$uzytkownik_imie $uzytkownik_nazwisko"; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> <?php $haslo_waznosc=sprawdzWazanoscHasla($uzytkownik_id);
                    echo"Hasło wygasa za: $haslo_waznosc[1] dni";?></a>
            </div>
        </div>
        <!-- search form -->
        <form action="index.php?a=wyszukaj" method="post" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="wyszukiwarka" class="form-control" placeholder="Wyszukaj..">
                <span class="input-group-btn">
                <button type="submit" name="numer" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>


        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>MENU:

                <a href="index.php">
                    <i class="fa fa-dashboard"></i><span>Strona Główna</span>
                </a>
                <a href="protokol_stanu_technicznego.php?a=koszyk">
                    <i class="glyphicon glyphicon-shopping-cart"></i><span>Koszyk PST</span>
                </a>
            </li>
                <li><a href="zglos_blad.php?a=pokaz_zgloszenia"><i class="glyphicon glyphicon-wrench"></i> <span>Zgłoszenia</span></a></li>




           <!-- <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Layout Options</span>
                    <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="./layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                    <li><a href="./layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                    <li><a href="./layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                    <li><a href="./layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                </ul>
            </li>
            <li>
                <a href="./widgets.html">
                    <i class="fa fa-th"></i> <span>Widgets</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-green">Hot</small>
            </span>
                </a>
            </li>

            <li>
                <a href="./calendar.html">
                    <i class="fa fa-calendar"></i> <span>Calendar</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
                </a>
            </li>
            <li>
                <a href="../mailbox/mailbox.html">
                    <i class="fa fa-envelope"></i> <span>Mailbox</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Multilevel</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Level One
                            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li>
                                <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
            </li>
            <li><a href="./documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>-->
            <?php
            //echo $uzytkownik_sekcja;
            if($uzytkownik_sekcja =='Zespół Ewidencji Rozliczeń i Zaopatrzenia' OR $uzytkownik_sekcja =='Sekcja Wsparcia Merytorycznego i Technologii')
            {
            echo'
            
            <li class="header">EWIDENCJA</li>
            <li><a href="asygnaty.php"><i class="glyphicon glyphicon-duplicate"></i> <span>ASYGNATY</span></a></li>
            <li><a href="naklejka.php"><i class="glyphicon glyphicon-barcode"></i> <span>Naklejki</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Protokoły</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="protokol_stanu_technicznego.php"><i class="fa fa-circle-o"></i> Stanu technicznego</a></li>
                    <li><a href="protokol_rozkompletowania.php"><i class="fa fa-circle-o"></i> Rozkompletowania</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Skompletowania</a></li>
                </ul>

            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>MAGAZYNY</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">';
                    $pobierz_magazyny = mysqli_query($polaczenie,"SELECT id,nazwa_skrocona FROM slownik_magazyn") or die("Blad przy pobierz_magazyny".mysqli_error($polaczenie));
                    if(mysqli_num_rows($pobierz_magazyny)>0)
                    {
                        while ($mag = mysqli_fetch_array($pobierz_magazyny))
                        {

                            echo " <li><a href='magazyn.php?a=wyswietl&id=$mag[id]'><i class='fa fa-circle-o'></i> $mag[nazwa_skrocona]</a></li>";
                        }
                    }


                echo'</ul>

            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Słowniki</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="slownik_zrodlo_finiansowania.php"><i class="fa fa-circle-o"></i> Źród. Finansowania</a></li>
                    <li><a href="slownik_sposob_likwidacji.php"><i class="fa fa-circle-o"></i> Sposób likwidacji</a></li>
                    <li><a href="slownik_rodzaj_ewidencji.php"><i class="fa fa-circle-o"></i> Rodzaj Ewidencji</a></li>
                    <li><a href="slownik_jednostki.php"><i class="fa fa-circle-o"></i> Jednostki</a></li>
                    <li><a href="liczniki_stan.php"><i class="fa fa-circle-o"></i> Liczniki</a></li>
                    <li><a href= "slownik_magazyn.php"><i class="fa fa-circle-o"></i> Magazyny</a></li>
                    <li><a href= "slownik_kategoria_pst.php"><i class="fa fa-circle-o"></i> Kategoria PST</a></li>
                </ul>

            </li>
            <li><a href="srodek_trwaly.php?a=wydzialy"><i class="glyphicon glyphicon-th-list"></i> <span>Stany Wydziałów</span></a></li>
            <li><a href="srodek_trwaly.php?a=dodaj"><i class="glyphicon glyphicon-plus"></i> <span>Dodaj Nowy</span></a></li>
';
            }
            if($uzytkownik_sekcja == 'Sekcja Wsparcia Merytorycznego i Technologii')
            {

            echo'
            <li class="header">ADMINISTRACJA</li>
            <li><a href="uzytkownicy.php"><i class="fa fa-circle-o text-red"></i> <span>Użytkownicy</span></a></li>';
            if($uzytkownik_id == 1)
            {
                echo'<li><a href="zglos_blad.php?a=pokaz_zgloszenia_status"><i class="glyphicon glyphicon-wrench"></i> <span>Zgłoszenia</span></a></li>
            <li><a href="uzytkownicy_grupa.php"><i class="fa fa-circle-o text-yellow"></i> <span>Użytkownicy Grupy</span></a></li>
            <li><a href="import_danych.php"><i class="fa fa-circle-o text-yellow"></i> <span>Import danych Serwis1.0</span></a></li>';
            }

        echo'</ul>';
            }

        ?>
    </section>
    <!-- /.sidebar -->
</aside>