<?php
include_once 'framework.php';
include_once 'Functions.php';
include_once 'php classes/Header.php';
$menu = new Header();
?>
<header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php"><img src="images/png/logov1.png" alt="logo"> Eenmaal Andermaal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarNavDropdown" class="navbar-collapse collapse justify-content-end">
            <ul class="navbar-nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link <?php _activeHeader('index.php');?>" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="testpagina.php" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Categoriën</a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <?php $menu->_getRubriekFromDb(-1, 1);?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active-dark" href="">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php _activeHeader('over-ons.php');?>" href="over-ons.php">Ons</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="get" action="VeilingenOverzicht.php">
                <input class="form-control mr-sm-2" type="search" placeholder="Typ hier uw zoekopdracht"
                       aria-label="Search" name="zoekopdracht">
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Zoeken</button>
            </form>
        </div>
    </nav>
</header>