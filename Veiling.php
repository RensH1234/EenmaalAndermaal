<?php
$title = 'Veiling';
$siteNaam = 'Veiling!';
include_once 'php classes/VeilingArtikel.php';
include_once 'Functions.php';
include_once 'framework.php';

$artikel = new Artikel();
$artikel->_getVeilingGegevens(2);
$artikel->_telAantalBiedingen();

if (array_key_exists('VorigeKavel', $_POST)) {
    $artikel->_getVeilingGegevens(1);
} else if
(array_key_exists('VorigeKavel', $_POST)) {
    $artikel->_getVeilingGegevens(3);
}
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
</head>
<body>
<main>
    <?php include_once 'h_test.php'; ?>
    <div class="container mt-2">
        <div class="row justify-content-between">
            <div class="col-4">
                <a href="#" class="btn btn-light border" role="button">&ltKavelLijst&gt</a>
            </div>
            <div class="col-4">
                <a href="#" class="btn btn-light border" role="button" id="Vorigekavel">VorigeKavel</a>
                <a href="#" class="btn btn-light border" role="button" id="VolgendeKavel">VolgendeKavel</a>
            </div>
        </div>
    </div>
    <?php
    $artikel->_printArtikel();
    ?>
</main>
<?= _generateFooter(date('Y')) ?>
</body>
</html>
