<?php
$title = 'Veiling';
$siteNaam = 'Veiling!';
include_once 'php classes/VeilingArtikel.php';
include_once 'Functions.php';
include 'framework.php';
$artikel = new Artikel();
$index = 2;
$artikel->_getVeilingGegevens($index);
$artikel->_telAantalBiedingen();

if (array_key_exists('VorigeKavel', $_POST)) {
    $index--;
    $artikel->_getVeilingGegevens($index);
    $artikel->_telAantalBiedingen();
} else if
(array_key_exists('VolgendeKavel', $_POST)) {
    $index++;
    $artikel->_getVeilingGegevens($index);
    $artikel->_telAantalBiedingen();
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
                <form method ='post'>
                    <input type="submit" name="VorigeKavel" class="btn btn-light border" value="Vorige">
                    <input type="submit" name="VolgendeKavel" class="btn btn-light border" value="Volgende">
                </form>
<!--                <a href="#" class="btn btn-light border" role="button" id="Vorigekavel">VorigeKavel</a>-->
<!--                <a href="#" class="btn btn-light border" role="button" id="VolgendeKavel">VolgendeKavel</a>-->
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
