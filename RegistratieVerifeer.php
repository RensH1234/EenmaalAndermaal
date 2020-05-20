<?php
include_once 'Framework.php';
include_once 'Functions.php';
include_once 'DatabaseConn.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
$huidigeJaar = date('Y');

$message = '';
$error = '';

if(!isset($_GET["gebruiker"])||!isset($_GET["vkey"])){
    $error .="<h2>Er ging iets mis.</h2>";
}
else{
    echo $_GET["gebruiker"];
    echo $_GET["vkey"];
    controleerUitDatabase($_GET["gebruiker"],$_GET["vkey"]);
}


//de gegeven waardes in de url worden gecontroleerd, en als het klopt wordt de gebruiker geregistreerd.
function controleerUitDatabase($gebruikersnaam,$vkey){
    $conn = getConn();
    $sql = "SELECT * FROM Gebruiker WHERE Gebruikersnaam = ?";
    $stmt = sqlsrv_prepare($conn, $sql,array($gebruikersnaam));
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if (sqlsrv_execute($stmt)) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

             //de vkey in de url is een brypt van email.gebruikersnaam. Daarom wordt password_verify gebruikt om dit te controleren.
            $vkeyReal = $row["Emailadres"].$row["Gebruikersnaam"];
             if(password_verify($vkeyReal,$vkey)){
                 voltooiRegistratie($gebruikersnaam);
             }
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}


//veranderdt de kolom bevestigd naar 1, en de gebruiker is officeel geregistreerd
function voltooiRegistratie($gebruikersnaam){
    $conn = getConn();
    $sql = "UPDATE Gebruiker SET Bevestigd = 1 WHERE Gebruikersnaam = ?;";
    $stmt = sqlsrv_prepare($conn, $sql, array($gebruikersnaam));
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if (sqlsrv_execute($stmt)) {
        global $message;
        $message .= '<h2>U bent succesvol geregistreert.</h2>';
    } else {
        global $error;
        $error .= '<h2>Er ging iets mis.</h2>';
        die(print_r(sqlsrv_errors(), true));
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
    <br>
    <?php echo $error;
    echo $message;?>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
