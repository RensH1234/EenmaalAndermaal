<?php
include_once 'Framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
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
<?php include_once 'Header.php'; ?>
<main>

<div class="container">
    <br>
    <div class="row login">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 loginbackground">
            <br>
            <div class="loginLogo">
<!--            <img alt="logo" src="./images/png/EenmaalAndermaalLogo200px200px.png">-->
<!--                <a class="logo" <img alt="logo" src="./images/png/EenmaalAndermaalLogo200px200px.png" href="nu.nl"></a>-->

                <a href="./index.php">
                    <img alt="logo" src="./images/png/EenmaalAndermaalLogo200px200px.png"> </a>
            </div>
            <br>
            <br>
            <form class="mb-2">
                <h2 class="h3 mb-3 font-weight-normal ">Log hier in!</h2>
                <div class="form-group">
                    <label for="InputGebruiker" <i class="fa fa-user"></i> </i>Gebruikersnaam</label>
                    <input type="gebruikersnaam" class="form-control" id="gebruikersnaam" aria-describedby="Gebruiker" placeholder="Gebruikersnaam">
                </div>
                <div class="form-group">
                    <label for="InputPassword"<i class="fa fa-key"></i>Wachtwoord</label>
                    <input type="password" class="form-control" name="password" id="wachtwoord" placeholder="Wachtwoord">
                </div>
                <div class="form-check">
                    <br>
                    <button class="btn btn-info" type="button" name="showpassword" id="showpassword" value="Show Password">Show password</button>
                    <button type="submit" class="btn btn-primary">Inloggen</button>
                </div>
            </form>
            <br>
            <br>

    </div>

</div>
</main>
<?php _generateFooter(date('Y')) ?>
