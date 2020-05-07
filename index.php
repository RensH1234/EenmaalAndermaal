<?php
    $title = 'Eenmaal Andermaal!';
    $siteNaam = 'Welkom!';
    $huidigeJaar = date('Y');
    include 'php classes/Veilinglijst.php';
    include 'includes/DatabaseConn.php';
    include 'includes/sqlsrvPHPFuncties.php';
    include 'php classes/VeilingArtikel.php';

?>
<!doctype html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?= $title ?> | <?= $siteNaam ?></title>

<!--        <link rel="stylesheet" href="customStylesheet.css">-->
        <?php include 'includes/frameworkIncludes.php'?>

        <link rel="stylesheet" href="custom%20stylesheet.css">
        <?php include 'includes/framework.php' ?>

    </head>
    <body>
        <nav>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <a class="navbar-brand" href="#"><img src="images/png/logov1.png"> Eenmaal Andermaal</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <form class="form-inline text-center my-2 my-lg-0">
                    <input class="form-control mr-lg-3" type="search" placeholder="Typ hier uw zoekopdracht" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Zoeken</button>
                </form>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Veiling</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                                Services
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Photography</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">View Our Portfolio</a>
                            </div>
                        </li>
                    </ul>
               </div>
        </nav>
        <main>
            <h1>Welkom!</h1>
            <?php
//            $artikelLijst = new Veilinglijst();
//            $artikelLijst->_construct(10,""," Aanbevolen");
//            $artikelLijst->printVeilinglijst();
//            $artikelLijst2 = new Veilinglijst();
//            $artikelLijst2->_construct(6,""," Geschiedenis");
//            $artikelLijst2->printVeilinglijst();
            $art1 = new VeilingArtikel();
            $art1->_construct(1);
            echo $art1->printArtikel();
            $art2 = new VeilingArtikel();
            $art2->_construct(2);
            echo $art2->printArtikel();
            $art3 = new VeilingArtikel();
            $art3->_construct(3);
            echo $art3->printArtikel();
            ?>
        </main>
        <footer>&copy; <?= $huidigeJaar ?></footer>
    </body>
</html>
