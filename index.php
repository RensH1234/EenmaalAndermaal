<?php
    $title = 'Eenmaal Andermaal!';
    $siteNaam = 'Welkom!';
    $huidigeJaar = 2019;
?>
<!doctype html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?= $title ?> | <?= $siteNaam ?></title>
    </head>
    <body>
        <?php include 'includes/header.php'; ?>
        <main>
            <h1>Welkom!</h1>
        </main>
        <footer>&copy; <?= $huidigeJaar ?></footer>
    </body>
</html>
