<?php
include_once 'Framework.php';
include_once 'Functions.php';
include_once 'DatabaseConn.php';
$title = 'Voer uw code in';
$siteNaam = 'Welkom!';
$huidigeJaar = date('Y');
$error = '';
if(array_key_exists('verified',$_POST)){
    $mainContent = <<<HTML

HTML;

}
else{
    if(array_key_exists('origin', $_GET)&&array_key_exists('mode', $_GET)){
        $email = $_GET['origin'];
        $mode = $_GET['mode'];
        $mainContent = <<<HTML
<br>
    <h1 class="h1">Code controleren</h1>
    <p class="text">Voer uw emailadres en code in om verder te gaan.</p>
    <div class="container-fluid">
        <form class="form-group" action="RegistratieVerifeer.php" method="post">
        <input name="email"  type="hidden" value=$email>
        <input name="email"  type="hidden" value=$mode>
            <div class="row">
                <div class="col-sm-4 col-xs-1">
                    <div class="form-group">
                        <label class="control-label">Emailadres</label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <input required name="email" placeholder="iemand@example.com" class="form-control" type="text" >
                            </div>
                        </div>
                    </div>
                </div>
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
            <div class="row">
                <div class="col-sm-4 col-xs-1">
                    <button type="submit" class="btn btn-dark"> Controleer code</button>
                </div>
            </div>
        </form>
    </div>
HTML;
    }
    else{
        $mainContent = <<<HTML
<p>Er ging iets mis. Controleer uw email om te registreren.</p>
HTML;

    }


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
