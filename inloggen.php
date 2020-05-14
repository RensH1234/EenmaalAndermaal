<?php
include_once 'framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
//include 'active.js';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
$huidigeJaar = date('Y');
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="images/icon/logo.ico" />

    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
</head>
<body>
<?php include_once 'h_test.php'; ?>
<main>

<div class="container">
    <br>
    <div class="row login">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <!-- Start form -->
            <form>
                <div class="form-group">
                    <label for="InputGebruiker" <i class="fa fa-user"></i> </i> Gebruikersnaam</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="Gebruiker" placeholder="Gebruikersnaam">
                </div>
                <div class="form-group">
                    <label for="InputPassword"<i class="fa fa-key"></i>Wachtwoord</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Wachtwoord">
                </div>
                <div class="form-check">
                    <button class="btn btn-info" type="button" name="showpassword" id="showpassword" value="Show Password">Show password</button>
                    <button type="submit" class="btn btn-primary">Inloggen</button>
                </div>

            </form>


    </div>

</div>





</main>
<?= _generateFooter(date('Y')) ?>
