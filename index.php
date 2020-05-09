<?php
include 'php classes/Veilinglijst.php';
include_once 'includes/htmlTerugkomendeFuncties/Functions.php';
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
    <?php include 'includes/phpIncludes/frameworkIncludes.php' ?>
    <?php include 'includes/phpIncludes/framework.php' ?>
    <link rel="stylesheet" href="custom%20stylesheet.css">
</head>

<body>
<?php include 'includes/htmlTerugkomendeElementen/header.php'?>
<main>
    <?php include 'includes/htmlTerugkomendeElementen/slides.php'?>
    <div class="uitgelichteadvertenties col-lg-12">

        <?php
        $lijstComputers = new Veilinglijst();
        $lijstComputers->_construct([1,3,1,2],"Computers","lijstComputers");
        $lijstComputers->printVeilinglijst();
        $lijstAuto = new Veilinglijst();
        $lijstAuto->_construct([1,2,2,3],"Auto's","lijstAuto");
        $lijstAuto->printVeilinglijst();
        $lijstAanbevolen = new Veilinglijst();
        $lijstAanbevolen->_construct([4,3,2,1],"Aanbevolen","lijstAanbevolen");
        $lijstAanbevolen->printVeilinglijst();
        ?>
    </div>
</main>
<?= _generateFooter(date('Y')) ?>
</body>
</html>
