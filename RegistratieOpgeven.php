<?php
require_once 'SessionHandling/Session.php';
include_once 'Framework.php';
include_once 'Functions.php';
include_once 'DatabaseConn.php';
$title = 'Registratie opgeven';
$siteNaam = 'Registgratie opgeven';
$huidigeJaar = date('Y');
$error = '';

function _registreerCodeInGebruiker()
{

//De waardes in deze variabelen zijn nodig om de gegevens van php naar de goede in de sql tabel te zetten.
//bevestigd wordt nu 0, maar na de bevestiging wordt hij op 1 gezet.
    $bevestigd = 0;

    $hash = password_hash($wachtoord1, PASSWORD_DEFAULT);

    $conn = getConn();

//De eerste sql query zet de gegevens van de gebruiker in de gebruikerstabel.
    $params = array($gebruikersnaam, $voornaam, $achternaam, $straatnaam, $huisnummer, $tussenvoegsel, $postcode, $plaatsnaam, $land, $geboortedatum, $email, $hash, $beveiligingsvraag, $aBeveiligingsvraag, $rol, $bevestigd);
    $sql = "INSERT INTO 
Gebruiker(Gebruikersnaam,Voornaam,Achternaam,Straatnaam,Huisnummer,Tussenvoegsel,Postcode,Plaatsnaam,Land,GeboorteDatum,Emailadres,Wachtwoord,Beveiligingsvraag,Antwoordtekst,Rol,Bevestigd) 
VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    sqlsrv_execute($stmt);
    if (!$stmt) {
        //door het globaal maken hiervan kunnen de errorberichten worden aangemaakt.
        global $error;
        $error .= "<p>Er ging iets mis.</p>";
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
    <link rel="shortcut icon" type="image/x-icon" href="images/icon/logo.ico"/>
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
</head>
<body>
<?php include_once 'Header.php'; ?>
<main><br>
    <?php
    $valueEmail = "";
    if(array_key_exists('email',$_POST)){
        $valueEmail = $_POST['email'];
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            _registreerCodeInGebruiker();
            stuurRegistratieEmail($_POST['email']);
            $string = "<p class='text-white'>Er is een mail met instructies naar {$_POST['email']} gestuurt.</p>";
            echo $string;
        }
        else{
            $string = "<p class='text-white'>{$_POST['email']} is geen geldig emailadres.</p>";
            echo $string;
        }
    }
    ?>
    <h1 class="h1">Registreren</h1>
    <p class="text">Wilt u kunnen bieden? Geef uw email op. Er wordt een email gestuurt met de benodigde stappen.</p>
    <div class="container-fluid">
        <form class="form-group" action="#" method="post">
            <div class="row">
                <div class="col-sm-4 col-xs-1">
                        <div class="form-group">
                            <label class="control-label">Emailadres</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <input required="true" name="email" placeholder="iemand@example.com" class="form-control" type="text" value=<?php echo $valueEmail; ?>>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-xs-1">
                    <button type="submit" class="btn btn-dark"> Email versturen </button>
                </div>
            </div>
        </form>
    </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>