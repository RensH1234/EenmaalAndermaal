<?php
include_once 'framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
include_once 'php classes/Zoekmachine.php';
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
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
</head>

<body>
<?php include_once 'h_test.php' ?>
<main>
    <h2>Resultaten die overeen komen met "<?php echo $_GET["zoekopdracht"];?>"</h2>
    <div class="uitgelichteadvertenties col-lg-12">

        <?php
            $resultaten = new Zoekmachine();
            $resultaten->_constructNieuw($_GET["zoekopdracht"]);
            $idArray = explode(".",$resultaten->_getIdArrayRes());
            $resultaatVeilinglijst = new Veilinglijst();
            $resultaatVeilinglijst->_construct($idArray,"Resultaten", "ResultatenLijst");
            $resultaatVeilinglijst->printVeilingen();
        ?>
    </div>
</main>
<?= _generateFooter(date('Y')) ?>
</body>
</html>

