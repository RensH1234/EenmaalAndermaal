<?php
$title = 'Veiling';
$siteNaam = 'Veiling';
require_once 'SessionHandling/Session.php';
include_once 'php classes/VeilingArtikel.php';
include_once 'Functions.php';
include 'Framework.php';
$artikel = new Artikel();
$artikel->_getVeilingGegevens($_GET['id']);
$artikel->_getAantalBiedingen();

if (array_key_exists("bedrag", $_POST)) {

    //de gebruiker en of er is ingelogd wordt afgehandeld in 'Artikel->setBiedingen'
    $artikel->setBiedingen(1, $_POST["bedrag"]);

    //refresh om het bod te laten zien
    header("Refresh:0");
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,
    minimum-scale=1.0" charset="UTF-8">
    <title><?= $title ?> | <?= $siteNaam ?></title>
</head>
<body>
<main>
    <?php include_once 'Header.php'; ?>
    <div class="container mt-2">
        <div class="row">
            <div class="row justify-content-between">
                <div class="col">
                    <form action='Veiling.php' method="get">
                        <input name="id" type="hidden" value=<?php $artikel->_gotoVeiling(false); ?>>
                        <button class="btn btn-light border" type="submit">Vorige</button>
                    </form>
                </div>
                <div class="col">
                    <form action='Veiling.php' method="get">
                        <input name="id" type="hidden" value=<?php $artikel->_gotoVeiling(true); ?>>
                        <button class="btn btn-light border" type="submit">Volgende</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    $artikel->_printArtikel();
    ?>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
