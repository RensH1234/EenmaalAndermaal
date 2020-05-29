<?php
require 'php classes/Login.php';

require 'SessionHandling/Session.php';

include_once 'Framework.php';
include_once 'Functions.php';

$title = 'Eenmaal Andermaal!';
$siteNaam = 'Inloggen!';
$huidigeJaar = date('Y');

$login = new Login();
$login->_genlogin();
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
<?php include_once 'Header.php';
?>
<main>
    <div class="container-fluid">
        <div class="row justify-content-center text-justify">
            <div class="col-xl text-center mb-n5">
                <?php
                echo $login->_verify();
                ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row login">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 loginbackground">
                <div class="loginLogo mt-4 mb-4">
                    <a href="Index.php">
                        <img alt="logo" src="./images/png/EenmaalAndermaalLogo200px200px.png"></a>
                </div>
                <form class="mb-2 mt-4" action="Inloggen.php" method="POST">
                    <h2 class="h3 mb-3 font-weight-normal ">Log hier in!</h2>
                    <div class="form-group">
                        <label for="gebruikersnaam"><i class="fa fa-user"></i>Gebruikersnaam</label>
                        <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam"
                               placeholder="Gebruikersnaam">
                    </div>
                    <div class="form-group">
                        <label for="wachtwoord"><i class="fa fa-key"></i>Wachtwoord</label>
                        <input type="password" class="form-control" id=wachtwoord name="wachtwoord"
                               placeholder="Wachtwoord">
                    </div>
                    <div class="form-check mt-4 mb-4">
                        <button class="btn btn-info" type="button" id="showpassword">Wachtwoord vergeten</button>
                        <button type="submit" name="login" class="btn btn-primary">Inloggen</button>
                    </div>
                </form>
            </div>
        </div>
</main>
<?php _generateFooter(date('Y')) ?>
