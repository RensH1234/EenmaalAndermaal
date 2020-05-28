<?php
require_once 'SessionHandling/Session.php';

include_once 'Framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Over Ons';
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
    <h1>Over ons</h1>
    <p>Wij zijn natuurlijk way cool, blah blah blah, et cetera.</p>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
