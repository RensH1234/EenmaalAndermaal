<?php
    $title = 'Eenmaal Andermaal!';
    $siteNaam = 'Welkom!';
    $huidigeJaar = 2019;
    include 'php classes/Veilinglijst.php';
?>
<!doctype html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?= $title ?> | <?= $siteNaam ?></title>
        <link rel="stylesheet" href="custom%20stylesheet.css">
        <?php include 'includes/framework includes.php'?>
    </head>
    <body>
        <?php include 'includes/header.php'; ?>
        <main>
            <h1>Welkom!</h1>
            <?php
            $artikelLijst = new Veilinglijst();
            $artikelLijst->_construct(10,""," Aanbevolen");
            $artikelLijst->printVeilinglijst();
            $artikelLijst2 = new Veilinglijst();
            $artikelLijst2->_construct(6,""," Geschiedenis");
            $artikelLijst2->printVeilinglijst();
            ?>
        </main>
        <footer>&copy; <?= $huidigeJaar ?></footer>
    </body>
</html>
