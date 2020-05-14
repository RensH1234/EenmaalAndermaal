<?php
$title = 'Veiling';
$siteNaam = 'Veiling!';
include_once 'php classes/VeilingArtikel.php';
include_once 'Functions.php';
include 'framework.php';
$artikel = new Artikel();
$artikel->_getVeilingGegevens($_GET['id']);
$artikel->_getAantalBiedingen();

if(array_key_exists("bedrag",$_GET)){
    //de gebruiker moet een officiele zijn. Met het maken van het inlogsysteem kan dit worden voltooid.
    $artikel->setBiedingen(1,$_GET["bedrag"],'picklerick');
}
//function _gotoVeiling($hdg)
//{
//    if($hdg)
//    if ($_GET['id'] > 1) {
//        echo $_GET['id'] - 1;
////        echo $var;
//    } else {
//        echo $_GET['id'];
////        echo $var;
//    }
//    else {
//
//    }
//}

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
    <?php include_once 'h_test.php'; ?>
    <div class="container mt-2">
        <div class="row justify-content-between">
            <div class="col-4">
                <a href="#" class="btn btn-light border" role="button">&ltKavelLijst&gt</a>
            </div>
            <div class="row justify-content-between">
                <div class="col">
                    <form action='Veiling.php' method="get">
                        <input name="id" type="hidden" value=<?php $artikel->_gotoVeiling(false); ?>>
                        <button class="btn btn-light border" type="submit">Vorige</button>
                    </form>
                </div>
                <div class="col">
                    <form action='Veiling.php' method="get">
                        <input name="id" type="hidden" value=<?php $artikel->_gotoVeiling(true); ?>>
                        <button class="btn btn-light border" type="submit">Volgende</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    $artikel->_printArtikel();
    ?>
</main>
<?= _generateFooter(date('Y')) ?>
</body>
</html>
