<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>S</b>2.0</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Serwis</b>2.0</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">


                    <!--Zakładka profil-->
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php
                            if (mb_strtolower(mb_substr($uzytkownik_imie, -1)) == 'a') {
                                echo '<img src="dist/img/avatar3.png" class="user-image" alt="User Image">';
                            }
                            else
                            {
                                echo'<img src="dist/img/avatar5.png" class="user-image" alt="User Image">';
                            }
                            ?>
                            <span class="hidden-xs"><?php echo"$uzytkownik_imie $uzytkownik_nazwisko"; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <?php
                                if (mb_strtolower(mb_substr($uzytkownik_imie, -1)) == 'a') {
                                    echo '<img src="dist/img/avatar3.png" class="img-circle" alt="User Image">';
                                }
                                else
                                {
                                    echo'<img src="dist/img/avatar5.png" class="img-circle" alt="User Image">';
                                }
                                ?>


                                <p>
                                    <?php


                                    echo"$użytkownik_imie_nazwisko   - $uprawienia
                                    <small>$uzytkownik_sekcja</small>"?>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- <li class="user-body">
                                 <div class="col-xs-4 text-center">
                                     <a href="#">Followers</a>
                                 </div>
                                 <div class="col-xs-4 text-center">
                                     <a href="#">Sales</a>
                                 </div>
                                 <div class="col-xs-4 text-center">
                                     <a href="#">Friends</a>
                                 </div>
                             </li>
                             <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="profil.php<?php echo"?id=$uzytkownik_id";?>" class="btn btn-default btn-flat">Profil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="logout.php" class="btn btn-default btn-flat">Wyloguj</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>-->
                </ul>
            </div>
        </nav>
    </header>