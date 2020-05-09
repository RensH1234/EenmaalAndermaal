<?php
include_once 'DatabaseConn.php';

class Header{
    private $rubriek;


    function _getFromDb(){
        $conn = getConn();
        $sql = "SELECT r.RubriekID, r.Rubrieknaam, r.SuperRubriekID, r.Volgnr, Voorwerpnummer FROM Rubriek r
INNER JOIN VoorwerpInRubriek vr on vr.RubriekID = r.RubriekID";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->rubriek = $row['RubriekID'];

            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }

    }
    
    function _printCategory($Rubrieknaam, $SuperRubriekNaam){
        $item = "<li class='dropdown-submenu'>";
//                            <a class='dropdown-item dropdown-toggle' href='#'>menu1</a>
//                            <ul class='dropdown-menu'>
//                                <li>
//                                    <a class='dropdown-item' href='#'>Submenu 1</a>
//                                </li>
//                                <li>
//                                    <a class='dropdown-item' href='#'>Submenu 2</a>
//                                </li>
//                            </ul>
//                        </li>
    }

    function _getRubriekHref($RubriekID){
        switch ($RubriekID) {
            case 0:
                return 'veiling.php';
        }
    }

}
?>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php"><img src="images/png/logov1.png" alt="logo"> Eenmaal Andermaal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarNavDropdown" class="navbar-collapse collapse justify-content-end">
            <ul class="navbar-nav nav-pills nav-fill">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categoriën</a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">menu1</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Submenu 1</a>
                                </li>
                                <a class="dropdown-item dropdown-toggle" href="#">Another</a>
                                <li>
                                    <a class="dropdown-item" href="#">Submenu 2</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">menu2</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Submenu 1</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Submenu 2</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Another</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">Submenu 1</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">Sub-submenu1</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Sub-submenu1</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">Submenu 2</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">Subsubmenu2</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Subsubmenu2</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown3</a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <li class="dropdown-submenu ">
                            <a class="dropdown-item dropdown-toggle" href="#">menu1</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Submenu 1</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Submenu 2</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Yet Another</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">Submenu 1</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">Sub1-submenu 1</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Sub1-submenu 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">Submenu 2</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">Sub2-submenu 1</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Sub2-submenu 2</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Register</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="get" action="VeilingenOverzicht.php">
                <input class="form-control mr-sm-2" type="search" placeholder="Typ hier uw zoekopdracht"
                       aria-label="Search" name="zoekopdracht">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Zoeken</button>
            </form>
        </div>
    </nav>