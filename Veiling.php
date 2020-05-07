<?php
$title = 'Veiling';
$siteNaam = 'Veiling!';
include 'php classes/VeilingArtikel.php';
include_once 'includes/Functions.php';
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
    <?php include 'includes/navbar.php';?>
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
    <?php
    $artikel = new Artikel();
    $artikel->_construct(1,"Nintendo Entertainment System", "Zo goed als nieuw",
        "item-pics/nes.jpeg", 20.10, "IDEAL", "Doe het goed",
        "Arnhem", "Nederland", "30", "2020-05-04 00:00:00", 12.67,
    "In Doos", "PietHeijn", "", "", true, 20.20,
        1, 21.00);
    $artikel->_printArtikel();
    ?>
</main>
<?= _generateFooter(date('Y'))?>
</body>
</html>
