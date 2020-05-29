<?php
require 'SessionHandling/Session.php';

include 'Framework.php';
include 'Functions.php';

$title = 'Eenmaal Andermaal!';
$siteNaam = 'U bent Uitgelogd';

$_SESSION['ingelogd'] = false;
unset($_SESSION);
header('refresh: 1 url= Inloggen.php');
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
                <h2>U bent Uitgelogd!</h2>
            </div>
        </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
