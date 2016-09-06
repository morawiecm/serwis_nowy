<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>S</b>2.0</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Serwis</b>2.0</span>
        </a>
<?php include 'pasek.php'; ?>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="dist/img/programista.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php


                        echo"$użytkownik_imie_nazwisko";  ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form -->
            <form action="index.php?a=wyszukaj" method="post" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="wyszukiwarka" class="form-control" placeholder="Wyszukaj...">
              <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat" name="numer" value="Numer"><i class="fa fa-search"></i></button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MENU</li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-tasks"></i>
                        <span>Protokoły</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> Stanu technicznego</a></li>
                        <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Rozkompletowanie</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Naklejki</a></li>
                    </ul>
                </li>
                <li><a href="logout.php"><i class="fa fa-laptop"></i> <span>Oprogramowanie</span></a></li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-truck"></i>
                        <span>Magazyn</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Do odebrania</a></li>
                        <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> 015A</a></li>
                        <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Główny</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Przyjęć</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Wybrakowania</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>Ewidencja</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="wartosci.php"><i class="fa fa-circle-o"></i> Wartości</a></li>
                        <li><a href="jednostki.php"><i class="fa fa-circle-o"></i> Jednostki</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pencil"></i>
                        <span>Spis</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Sprzęt KWP</a></li>
                        <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> Drukarki KWP</a></li>
                        <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Wersja CPG</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Wersja Firmware</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Tonery</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Weryfikacja</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Interwencja</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>Administracja</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="uzytkownicy.php"><i class="fa fa-circle-o"></i> Użytkownicy</a></li>
                        <li><a href="uzytkownicy_grupa.php"><i class="fa fa-circle-o"></i>Grupy </a> </li>
                        <li><a href="backup.php"><i class="fa fa-circle-o"></i> Backup</a></li>
                        <li><a href="lista_zmian.php"><i class="fa fa-circle-o"></i> Lista zmian</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Aktualizacja bazy</a></li>
                    </ul>
                </li>
                <li>
                    <a href="pages/mailbox/mailbox.html">
                        <i class="fa fa-envelope"></i> <span>Wiadomości</span>
                        <?php
                        $id_uzytkowanika2=$user_data['user_id'];
                        $pobierzLiczbeWiadomosciSkrzynkaOdbiorcza_Nowe2=mysqli_query($polaczenie,"SELECT `id` FROM `wiadomosci` WHERE `id_odbiorcy`='$id_uzytkowanika2' AND `stan`=1") or die(mysqli_error($polaczenie));
                        $LiczbeWiadomosciSkrzynkaOdbiorcza_Nowe2=mysqli_num_rows($pobierzLiczbeWiadomosciSkrzynkaOdbiorcza_Nowe2);
                        if($LiczbeWiadomosciSkrzynkaOdbiorcza_Nowe2>0) {
                            echo "<small class='label pull-right bg-yellow'>$LiczbeWiadomosciSkrzynkaOdbiorcza_Nowe2 </small>";
                        }
                        ?>
                    </a>
                </li>
                <li><a href="nagroda.php"><i class="fa fa-money"></i> <span>Nagroda</span></a></li>
                <li><a href="logout.php"><i class="fa fa-coffee"></i> <span>Wyloguj</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>