<?php
require 'SessionHandling/Session.php';

include 'Framework.php';
include 'Functions.php';

$title = 'Eenmaal Andermaal!';
$siteNaam = 'U bent Uitgelogd';
$huidigeJaar = date('Y');


if(isset($_SESSION['ingelogd']) && $_SESSION['ingelogd'] == true) {
    header('refresh: 1 url= Index.php');
    include_once 'Header.php';
    $message = "U bent ingelogd!";
}
else {
    header('refresh: 1 url= Inloggen.php');
    include_once 'Header.php';
    $message = "U bent nog niet ingelogd!";
}
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
<main>
    <?php include_once 'Header.php'; ?>
    <div class="container-fluid">
        <div class="row justify-content-center text-justify">
            <div class="col-xl text-center mb-n5">
                <h2><?=$message?></h2>
            </div>
        </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
