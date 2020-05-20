<?php
require 'SessionHandling/Session.php';

include 'Framework.php';
include 'Functions.php';

$title = 'Eenmaal Andermaal!';
$siteNaam = 'U bent Uitgelogd';
$huidigeJaar = date('Y');

$_SESSION['ingelogd'] = false;
unset($_SESSION['ingelogd']);
header('refresh: 1 url= Inloggen.php');
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
    <?php include_once 'Header.php'; ?>
    <div class="container-fluid">
        <div class="row justify-content-center text-justify">
            <div class="col-xl text-center mb-n5">
                <h2>U bent Uitgelogd!</h2>
            </div>
        </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
