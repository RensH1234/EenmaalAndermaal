<?php

include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
include_once 'php classes/Zoekmachine.php';
include_once 'php classes/Rubriekenlijst.php';
include_once 'php classes/Header_Class.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Overzicht';
$huidigeJaar = date('Y');
$hiddenDataForms = "";
if (!array_key_exists("zoekopdracht", $_GET)) {
    $_GET["zoekopdracht"] = "";
} else {
    $value = $_GET["zoekopdracht"];
    $hiddenDataForms .= <<<HTML
    <input type="hidden" value="$value" name="zoekopdracht">
HTML;
}
if (!array_key_exists("filter", $_GET)) {
    $_GET["filter"] = 0;
}
$filters = array();
$resultaten = new Zoekmachine();


if (array_key_exists("prijsrange1", $_GET)) {
    array_push($filters, "1");
    $value = $_GET["prijsrange1"];
    $hiddenDataForms .= <<<HTML
                            <input type="hidden" value=$value name="prijsrange1">
HTML;

}
if (array_key_exists("prijsrange2", $_GET)) {
    array_push($filters, "2");
    $value = $_GET["prijsrange2"];
    $hiddenDataForms .= <<<HTML
                            <input type="hidden" value=$value name="prijsrange2">
HTML;
}
if (array_key_exists("prijsrange3", $_GET)) {
    array_push($filters, "3");
    $value = $_GET["prijsrange3"];
    $hiddenDataForms .= <<<HTML
                            <input type="hidden" value=$value name="prijsrange3">
HTML;
}
if (array_key_exists("prijsrange4", $_GET)) {
    array_push($filters, "4");
    $value = $_GET["prijsrange4"];
    $hiddenDataForms .= <<<HTML
                            <input type="hidden" value=$value name="prijsrange4">
HTML;
}
if (array_key_exists("rubriekID", $_GET)) {
    $value = $_GET["rubriekID"];
    $hiddenDataForms .= <<<HTML
                            <input type="hidden" value=$value name="rubriekID">
HTML;
}


$rubrieken = new HeaderClass();


$resultaten->prijsfilter(implode(".", $filters));
if (array_key_exists("rubriekID", $_GET)) {
    if (preg_match('/[^0-9]/', $_GET['rubriekID']) || strlen($_GET['rubriekID']) > 6) {
        $_GET['rubriekID'] = -1;
    }

    $subRubrieken = $rubrieken->_generateRubriekFilter($_GET['rubriekID'], $rubrieken->_getRubriekFromDb(), 6);
    $resultaten->_constructNieuw($_GET["zoekopdracht"], $_GET["filter"], $subRubrieken, $_GET['rubriekID']);
} else {
    $resultaten->_constructNieuw($_GET["zoekopdracht"], $_GET["filter"], null, null);
}

?>

<!doctype html>
<html lang="nl">

<head>
    <?php include_once 'Framework.php'; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,
    minimum-scale=1.0" >
    <meta charset="UTF-8">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">

</head>
<body>
<?php include_once 'Header.php'; ?>
<main>
    <br>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-cm-auto filtercontainer">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Prijs:
                    </button>
                    <form action="VeilingenOverzicht.php">
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="form-check">
                                <input type="hidden" value=<?php echo $_GET["rubriekID"]; ?> name="rubriekID">
                                <input type="hidden" value="<?php echo $_GET["zoekopdracht"]; ?>" name="zoekopdracht">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="prijsrange1"
                                       value="1">
                                <label class="form-check-label" for="inlineCheckbox1">&euro;0 - &euro;10</label><br>
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="prijsrange2"
                                       value="1">
                                <label class="form-check-label" for="inlineCheckbox2">&euro;10 - &euro;25</label><br>
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="prijsrange3"
                                       value="1">
                                <label class="form-check-label" for="inlineCheckbox3">&euro;25 - &euro;50</label><br>
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="prijsrange4"
                                       value="1">
                                <label class="form-check-label" for="inlineCheckbox4">&euro;50+</label><br>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary" type="submit">Submit filters</button>
                    </form>
                    <?php
                    if (array_key_exists('rubriekID', $_GET)) {
                        $superID = $_GET['rubriekID'];
                    } else {
                        $superID = -1;
                    }
                    echo $rubrieken->titleToSuperID($superID);
                    echo $rubrieken->_generateRubriekListVeilingenOverzicht($superID, $rubrieken->_getRubriekFromDb(), 1)
                    ?>
                </div>

            </div>
            <div class="col ">
                <div class="row ">
                    <div class="col">
                        <h2>Resultaten die overeen komen met <?php echo $_GET["zoekopdracht"]; ?></h2>
                    </div>

                </div>
                <div class="row text-right">
                    <div class="col ">

                        <div class="dropdown " id="sorteerdropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                Sorteer op:
                            </button>
                            <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                <form action="VeilingenOverzicht.php">
                                    <?php echo $hiddenDataForms ?>
                                    <input type="hidden" value="0" name="filter">
                                    <button type="submit" class="dropdown-item">Prijs van laag naar hoog</button>
                                </form>
                                <form action="VeilingenOverzicht.php">
                                    <?php echo $hiddenDataForms ?>
                                    <input type="hidden" value="1" name="filter">
                                    <button type="submit" class="dropdown-item">Prijs van hoog naar laag</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row  text-center" >
                    <?php

                    $resultaten->genereerVeilingArtikelen();

                    ?>
                </div>
            </div>
        </div>


    </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>

