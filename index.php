<?php
    $title = 'Eenmaal Andermaal!';
    $siteNaam = 'Welkom!';
    $huidigeJaar = date('Y');
    include 'php classes/Veilinglijst.php';
    include_once 'includes/Functions.php';
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
                <a class="navbar-brand" href="#"><img src="images/png/logov1.png" alt="logo"> Eenmaal Andermaal</a>
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
            <div id="slides" class="carousel slide" data-ride="carousel">
                <ul class="carousel-indicators">
                    <li data-target="#slides" data-slide-to="0" class="active"></li>
                    <li data-target="#slides" data-slide-to="1"></li>
                    <li data-target="#slides" data-slide-to="2"></li>
                </ul>
                <div class="carousel-inner ">
                    <div class="carousel-item active">
                        <img src="images/png/slider1.jpg" alt="eerste foto">
                        <div class="carousel-caption">
                            <h1 class="display-2">Welkom</h1>
                            <h3>Dé veilingsite van Nederland!</h3>
                            <button type="button" class="btn btn-outline-light btn-lg">Bekijk veilingen!</button>
                            <button type="button" class="btn btn-primary btn-lg test">Registreer nu!</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="images/png/background2.png" alt="twee foto">
                    </div>
                    <div class="carousel-item">
                        <img src="images/png/background3.png" alt="derde foto" >
                    </div>
                </div>
            </div>
            <div class="uitgelichteadvertenties col-lg-12">

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
            </div>
            <h1>Welkom!</h1>

        </main>
<?=_generateFooter(date('Y')) ?>
    </body>
</html>
