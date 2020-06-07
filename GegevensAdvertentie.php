<?php
require_once 'SessionHandling/Session.php';

include_once 'php classes/Veilinglijst.php';
include_once 'php classes/Rubriekenlijst.php';
include_once 'Functions.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
$error = '';
include_once 'AdvertentieControles.php';

if(!is_logged_in() || !is_verkoper()){
    header('location: inloggen.php');
}

$rubriekID=$_SESSION['verkooprubriek'];

$newVoorwerpnummer = getNewVoorwerpnummer();
if($error =="" && (array_key_exists('plaatsen',$_GET))){
    maakAdvertentieAan($titel,$afbeeldingURL,$beschrijving,$betalingswijze,$plaatsnaam,$betalingsinstructies,$land
    , $looptijd, $startprijs, $verzendinstructies, $verzendkosten,$rubriekID, $newVoorwerpnummer);
    header("Location: http://iproject12.icasites.nl/Veiling.php?id={$newVoorwerpnummer}");
}
?>

<!doctype html>
<html lang="nl">
<head>
    <?php include_once 'Framework.php';?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,
    minimum-scale=1.0" charset="UTF-8">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
</head>
<body>
<?php include_once 'Header.php'; ?>
<main>
    <br>
    <?php echo $error; ?>
    <div class="container-fluid mt-2 ">
        <div class="row text-center">
            <div class="col">
                <h2>Vul de gegevens van uw veiling in:</h2>
            </div>
        </div>
        <form class="form-group" action="GegevensAdvertentie.php">
        <div class="row justify-content-center">
                <div class="col-sm-4 col-xs-1">
                    <div class="form-group">
                        <label class="control-label">Titel</label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <input  required name="titel" placeholder="Titel" class="form-control"  type="text" value="<?php echo $titel; ?>">*
                            </div>
                        </div>
                    </div>
                </div>
        </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Afbeelding</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  required name="AfbeeldingURL" placeholder="link naar afbeelding" class="form-control"  type="text"
                                            value="<?php echo $afbeeldingURL; ?>">*
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Beschrijving</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  name="beschrijving" placeholder="Beschrijving" class="form-control"  type="text"
                                            value="<?php echo $beschrijving; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Betalingswijze</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  required name="betalingswijze" placeholder="Betalingswijze" class="form-control"  type="text"
                                            value="<?php echo $betalingswijze; ?>">*
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Betalingsinstructies</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  required name="betalingsinstructies" placeholder="betalingsinstructies" class="form-control"  type="text"
                                            value="<?php echo $betalingsinstructies; ?>">*
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Plaatsnaam</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  required name="Plaatsnaam" placeholder="Plaatsnaam" class="form-control"  type="text"
                                            value="<?php echo $plaatsnaam; ?>">*
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Land</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  required name="land" placeholder="Land" class="form-control"  type="text"
                                            value="<?php echo $land; ?>">*
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Looptijd in dagen</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  required name="looptijd" placeholder="Looptijd" class="form-control"  type="number"
                                            value="<?php echo $looptijd; ?>">*
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Startprijs</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  step="0.01" required name="startprijs" placeholder="Startprijs" class="form-control"  type="number"
                                            value="<?php echo $startprijs; ?>">*
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Verzendinstructies</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  name="verzendinstructies" placeholder="Verzendinstructies" class="form-control"  type="text"
                                            value="<?php echo $verzendinstructies; ?>">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Verzendkosten</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input  step=".01"  name="verzendkosten" placeholder="Verzendkosten" class="form-control"  type="number"
                                            value="<?php echo $verzendkosten; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-xs-1">
                    <div class="form-group">
                        <label class="col-md-4 control-label"></label>
                        <div class="col-md-4"><br>
                            <button type="submit" name ="plaatsen" class="btn btn-dark" >Veiling plaatsen</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-xs-1">
                    <p> De velden met * zijn verplicht.</p>
                </div>
            </div>
        </form>
    </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
