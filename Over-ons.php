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
    <div class="container">
        <div class='row mt-4 '>
            <div class='col text-center'>
                <h1 class="text-center">Over ons </h1>
                <p class="text-left">Welkom op de website van Eenmaal Andermaal.</p>
                <p class="text-left">De veilingsite EenmaalAndermaal is onderdeel van bedrijf iConcepts. Op deze website kunnen gebruikers
                    voorwerpen aanbieden en andere gebruikers kunnen daarop bieden. We merken dat de tweedehans markt
                    fors groeid en willen daar graag, op een verantwoorde wijze, op inspelen. Daarnaast levert
                    EenmaalAndermaal een bijdrage aan de verduurzaming van onze maatschappij.</p>
            </div>
        </div>
    </div>

</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
