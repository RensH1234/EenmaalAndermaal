<?php
include_once 'framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
//include 'active.js';
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
<?php include_once 'h_test.php'; ?>
<main>
    <br>
    <?php include_once 'slides.php' ?>
    <div class="container rubrieken col-lg-12 col-md-4">

        <?php
       echo"<div class='container col-lg-7'>
            <br>
            <h4>test</h4>
            </div>";
       
        $lijstComputers = new Veilinglijst();
        $lijstComputers->_construct([1,3,1,2],"lijstComputers");
        $lijstComputers->printveilingen();

        $lijstAuto = new Veilinglijst();
        $lijstAuto->_construct([1,2,2,3],"lijstAuto");
        $lijstAuto->printveilingen();
        $lijstAanbevolen = new Veilinglijst();
        $lijstAanbevolen->_construct([4,3,2,1],"lijstAanbevolen");
        $lijstAanbevolen->printveilingen();
        ?>
    </div>
</main>
<?= _generateFooter(date('Y')) ?>
</body>
</html>
