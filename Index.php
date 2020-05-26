<?php
require_once 'SessionHandling/Session.php';

include_once 'Framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
$huidigeJaar = date('Y');
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="images/icon/logo.ico" />
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
</head>
<body>
<?php include_once 'Header.php'; ?>
<main>
    <br>
    <?php include_once 'Slides.php' ?>
    <div class="container rubrieken col-lg-12 col-md-4">
<!--        <div class="row mt-4 text-center">-->
<!--            <div class="col">-->
<!--                <h1 class="text-body">Hot Veilingen!</h1>-->
<!--            </div>-->
<!--        </div>-->
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
