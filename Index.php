<?php
require_once 'SessionHandling/Session.php';

include_once 'Framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
?>

<!doctype html>
<html lang="nl">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,
    minimum-scale=1.0" charset="UTF-8">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
</head>
<body>
<?php include_once 'Header.php'; ?>
<main>
    <br>
    <?php include_once 'Slides.php' ?>
    <div class="container rubrieken col-lg-12 col-md-4">
        <?php
        $lijstComputers = new Veilinglijst();
        $lijstComputers->_maakVeilingen($lijstComputers->_fetchHotveilingen(6));
        echo $lijstComputers->_genereerContainer("Hot Veilingen!");
        ?>
    </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
