<?php
require_once 'SessionHandling/Session.php';
include_once 'php classes/Veilinglijst.php';
include_once 'php classes/VeilingArtikel.php';

include_once 'php classes/Rubriekenlijst.php';
include_once 'Functions.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
?>

<!doctype html>
<html lang="nl">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,
    minimum-scale=1.0" >
    <meta charset="UTF-8">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
    <?php include_once 'Framework.php' ?>
</head>
<body>
<?php include_once 'Header.php'; ?>
<main>
    <br>
    <?php include_once 'Slides.php' ?>
    <div class="container rubrieken col-lg-12 col-md-4">
        <?php
        $lijstComputers = new Veilinglijst();
        $lijstComputers->_maakVeilingen($lijstComputers->_fetchHotveilingen(6));
        echo $lijstComputers->_genereerContainer("Hot Veilingen!");

        $lijstAflopend = new Veilinglijst();
        $lijstAflopend ->_maakVeilingen($lijstAflopend->_fetchAflopendeveilingen(6));
        echo $lijstAflopend ->_genereerContainer("Aflopende Veilingen!");


        echo "<div class='container'>";
        $lijstRubrieken = new Rubriekenlijst();
        $rubriekID= array();
            $rubriekID = $lijstRubrieken->_fetchHotRubrieken(4);
        echo "<div class='row mt-4 text-center bg-dark'><div class='col'><h1 class='text-body'>Hot categorieën</h1>";

        echo "<div class=\"list-group\">";
            for ($j = 0; $j < 4; $j++) {
                if($rubriekID[$j][0]!=-1) {
                    $rubrieknaam = $rubriekID[$j][0];
                    $url= "VeilingenOverzicht.php?rubriekID=" . $rubriekID[$j][1];
                    echo "<a href=\"";
                    echo $url;
                    echo "\" class=\"list-group-item list-group-item-action\">";
                    echo $rubrieknaam;
                    echo "</a>";
                }
                echo "<br>";
            }

            echo "</div></div></div></div>";
        ?>
    </div>


</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
