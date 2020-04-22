<?php
    $title = 'Eenmaal Andermaal!';
    $siteNaam = 'Welkom!';
    $huidigeJaar = 2019;
    include 'php classes/veilingArtikel.php';
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
            $artikel = new VeilingArtikel();
            $artikel->_construct();
            echo $artikel->printArtikel();
            $artikel2 = new VeilingArtikel();
            $artikel2->_construct();
            echo $artikel2->printArtikel();?>
        </main>
        <footer>&copy; <?= $huidigeJaar ?></footer>
    </body>
</html>
