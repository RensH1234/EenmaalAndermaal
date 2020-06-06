<?php
require_once 'SessionHandling/Session.php';

include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
include_once 'SessionHandling/Session.php';

$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';

if(array_key_exists('gebruikersnaam',$_SESSION)){
    if($_SESSION['Rol']=='Verkoper'){
        //in deze if komt user story 23
    header('location: Verkopen.php');

    }
    else{
        //in deze if komt user story 16
        $mainContent = <<<HTML

<div class="container-fluid">
        <form class="form-group" action="WordtVerkoper.php" method="post">
        <div class="row justify-content-center">
                <div class="col-sm-4 col-xs-1">                  
                    <h2>Om advertenties te plaatsen moet u een verkopersaccount hebben.</h2>
                </div>
        </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-xs-1">                  
                    <button type="submit" class="btn btn-dark"> Wordt een verkoper </button>
                </div>
            </div>
        </form>
    </div>
HTML;
    }
}
else{
    $mainContent = <<<HTML
<p><a href="Inloggen.php">Log in</a> om door te gaan.</p>
HTML;
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,
    minimum-scale=1.0">
    <meta  charset="UTF-8">
    <?php include_once 'Framework.php'; ?>
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
</head>
<body>
<?php include_once 'Header.php'; ?>
<main>
    <br>
    <?php echo $mainContent; ?>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
