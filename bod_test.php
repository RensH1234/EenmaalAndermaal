<?php
include_once 'framework.php';
include_once 'Functions.php';
include_once 'php classes/Biedingmachine.php';
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
<?php include_once 'h_test.php'; ?>
<main>
        <?php
        $biedingen = new Biedingmachine();
        $biedingen->_construct(2,false);
        echo $biedingen->printBiedingmachine();
        ?>
</main>
<?= _generateFooter(date('Y')) ?>
</body>
</html>
