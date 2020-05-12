<?php
include_once 'framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
include_once 'php classes/Zoekmachine.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
$huidigeJaar = date('Y');
if (!array_key_exists("zoekopdracht", $_GET)) {
    $_GET["zoekopdracht"] = "";
}
if (!array_key_exists("filter", $_GET)) {
    $_GET["filter"] = 0;
}
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
<?php include_once 'h_test.php';?>
<main>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filter op
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <form action="VeilingenOverzicht.php">
                <input type="hidden" value="<?php echo $_GET["zoekopdracht"];?>" name="zoekopdracht">
                <input type="hidden" value="0" name="filter">
                <button type="submit" class="dropdown-item">Prijs van laag naar hoog</button>
            </form>
            <form action="VeilingenOverzicht.php">
                <input type="hidden" value="<?php echo $_GET["zoekopdracht"];?>" name="zoekopdracht">
                <input type="hidden" value="1" name="filter">
                <button type="submit" class="dropdown-item">Prijs van hoog naar laag</button>
            </form>
            <form action="VeilingenOverzicht.php">
                <input type="hidden" value="<?php echo $_GET["zoekopdracht"];?>" name="zoekopdracht">
                <input type="hidden" value="2" name="filter">
                <button type="submit" class="dropdown-item">Afstand</button>
            </form>
        </div>
    </div>
    <h2>Resultaten die overeen komen met "<?php echo $_GET["zoekopdracht"];?>"</h2>
        <?php
            $resultaten = new Zoekmachine();
            $resultaten->_constructNieuw($_GET["zoekopdracht"],$_GET["filter"]);
            $idArray = explode(".",$resultaten->_getIdArrayRes());
            if($idArray[0]!=null) {
                $resultaatVeilinglijst = new Veilinglijst();
                $resultaatVeilinglijst->_construct($idArray, "", "ResultatenLijst");
                $resultaatVeilinglijst->printVeilingen();
            }
            else{
                echo "<p>Er komen geen producten overeen.</p>";
            }
        ?>
</main>
<?= _generateFooter(date('Y')) ?>
</body>
</html>

