<?php
include_once 'Framework.php';
include_once 'Functions.php';
include_once 'DatabaseConn.php';
include_once 'SessionHandling/Session.php';
$title = 'Voer uw code in';
$siteNaam = 'Welkom!';
$huidigeJaar = date('Y');
$error = '';
$verified = false;

//de controles op de code worden uitgevoerd wanneer de _POST variabelen zijn gevuld
if(array_key_exists('code',$_POST)&&array_key_exists('email',$_POST)&&array_key_exists('mode',$_POST)){

    //gebruiker heeft correcte gegevens verstuurt
    if(checkCode($_POST['code'],$_POST['mode'],$_POST['email'])){
        veranderRol($_POST['email'],'Verkoper');
        $_SESSION['Rol'] = 'Verkoper';
        $mainContent =<<<HTML
<h2>U bent nu een Verkoper!</h2>
HTML;

        $verified = true;
    }

    //gebruiker heeft foutieve gegevens verstuurt
    else{
        $error .= "<p class='text-white'>Niet de juiste gegevens</p>";
    }
}


//controleerd of de gebruiker al succesvol de code heeft gegeven, als het foutief is wordt het wel geladen
if((array_key_exists('origin', $_GET)&&array_key_exists('mode', $_GET))||(array_key_exists('origin', $_POST)&&array_key_exists('mode', $_POST))){

    //wanneer de gebruiker foutieve gegevens heeft ingevoerd, wordt deze uitgevoerd
    if(array_key_exists('origin', $_POST)&&array_key_exists('mode', $_POST)){
        $email = $_POST['origin'];
        $mode = $_POST['mode'];
    }

    //wanneer de gebruiker direct van het emailadres komt, wordt deze uitgevoerd
    else{
        $email = $_GET['origin'];
        $mode = $_GET['mode'];
    }
    if(!$verified) {
        $mainContent = <<<HTML
<br>
    <h1 class="h1">Code controleren</h1>
    <p class="text">Voer uw emailadres en code in om een verkoper te worden.</p>
    <div class="container-fluid">
        <form class="form-group" action="VerkoperRegistreer.php" method="post">        
            <div class="row justify-content-center">
                <div class="col-sm-4 col-xs-1">
                    <div class="form-group">
                        <label class="control-label">Gebruikersnaam</label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <input required name="email" placeholder="Gebruikersnaam" class="form-control" type="text" >
                                <input name="origin"  type="hidden" value=$email>
                                <input name="mode"  type="hidden" value=$mode>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-xs-1">
                    <div class="form-group">
                        <label class="control-label">Code</label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <input required name="code" placeholder="voer uw code in" class="form-control" type="text" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-xs-1">
                    <button type="submit" class="btn btn-dark"> Controleer code</button>
                </div>
            </div>
        </form>
    </div>
HTML;
    }
}
else {
    $mainContent = <<<HTML
<p>Er ging iets mis. Controleer uw email om een verkoper te worden.</p>
HTML;
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
        <link rel="shortcut icon" type="image/x-icon" href="images/icon/logo.ico" />

        <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
    </head>
    <body>
    <?php include_once 'Header.php'; ?>
    <main>
        <?php echo $error;
        echo $mainContent; ?>

    </main>
    <?php _generateFooter(date('Y')) ?>
    </body>
    </html>
<?php
