<?php
require_once 'SessionHandling/Session.php';
include_once 'Framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';include_once 'SessionHandling';
include_once 'SessionHandling/Session.php';

$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';

if(array_key_exists('gebruikersnaam',$_SESSION)&&array_key_exists('Rol',$_SESSION)){
   if($_SESSION['Rol'] == 'Koper'){
       $email = getEmailadres();
       stuurVerkopersEmail($email,$_SESSION['gebruikersnaam']);
       $mainContent = <<<HTML
<p>Er is een email verstuurt naar $email met instructies.</p>
HTML;
   }
   else {
       $mainContent = <<<HTML
<p><a href="AdvertentiePlaatsen.php">U bent al een verkoper.</a></p>
HTML;
   }
}
else{
    $mainContent = <<<HTML
<p><a href="AdvertentiePlaatsen.php">Ga terug</a> om door te gaan.</p>
HTML;
}
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
<?php include_once 'Header.php'; ?>
<main>
    <br>
    <?php echo $mainContent; ?>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
