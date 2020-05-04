<?php
$title = 'Veiling';
$siteNaam = 'Veiling!';
$huidigeJaar = 2020;
?>
<!doctype html>
<html lang="nl">
<head>
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <?php include 'includes/framework.php'; ?>
</head>
<body>
<main>
    <div class="container-fluid bg-light p-5 border">
        <div class="row">
            <div class="col">
                <h1 class="text-center">&ltHeader&gt</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n2  bg-light p-2 border">
        <div class="row">
            <div class="col">
                <h2 class="text-center">&ltNavBar&gt</h2>
            </div>
        </div>
    </div>
    <div class="container mt-2">
        <div class="row justify-content-between">
            <div class="col-4">
                <a href="#" class="btn btn-light border" role="button">&ltKavelLijst&gt</a>
            </div>
            <div class="col-4">
                <a href="#" class="btn btn-light border" role="button">&ltKavelLijst&gt</a>
                <a href="#" class="btn btn-light border" role="button">&ltKavelLijst&gt</a>
            </div>
        </div>
    </div>
    <div class="container mt-2">
        <div class="container">
            <div class="row">
                <div class="col border">
                    <img src="item-pics/nes.jpeg" class="rounded" alt="nes" width="265" height="190">
                </div>
                <div class="col border">
                    <h1 class="text-center">&ltItemNaam&gt</h1>
                    <div class="row">
                        <div class="col border">
                            <h2 class="text-center">&ltBodTimer&gt</h2>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col border">
                            <p class="text-center">&ltHuidigeBod&gt</p>
                        </div>
                        <div class="col border">
                            <p class="text-center">&ltBodAantal&gt</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col border">
                            <p class="text-center">&ltMinBodHuidig&lt></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col border">
                            <h3 class="text-center">&ltPlaatsBod&gt</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-2">
                            <p>Sample Text Sample Text Sample Text Sample Text Sample Text Sample Text Sample Text
                                Sample Text Sample TextSample Text Sample Text Sample Text Sample Text Sample Text
                                Sample Text Sample Text Sample Text Sample Text Sample Text Sample Text Sample Text
                                Sample Text</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col border">
                    <p>Sample Text Sample Text Sample Text Sample Text Sample Text Sample Text Sample Text
                        Sample Text Sample Text Sample Text Sample Text Sample Text Sample Text</p>
                </div>
                <div class="col border"></div>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col border">
                <h4 class="text-center">&ltFooter&gt</h4>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
