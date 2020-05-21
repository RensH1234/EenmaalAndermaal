<?php
include_once 'DatabaseConn.php';
include_once 'framework.php';

require_once 'SessionHandling/Session.php';

//deze is voor het versturen van een email
include_once 'Functions.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
$huidigeJaar = date('Y');

//deze lege variabelen worden gedeclareert met waarde null, zodat php een waarde kan printen, ook al is deze leeg.
$error = null;
$gebruikersnaam = null;
$wachtoord1 = null;
$wachtwoord2 = null;
$voornaam = null;
$achternaam = null;
$straatnaam = null;
$tussenvoegsel = null;
$huisnummer = null;
$postcode = null;
$plaatsnaam = null;
$land = null;
$email = null;
$telefoonnummer = null;
$geboortedatum = null;
$aBeveiligingsvraag = null;
$beveiligingsvraag = null;
$rol = null;
$beveiligingsvragen = _getBeveiligingsvragen();

//Wanneer een gebruiker registreert, wordt hierin gecontroleerd of de ingevoerde gegevens correct en veilig zijn. Ook worden de waardes ingevoerd weer op de goede plek gegenereerd.
include 'RegistratieControles.php';


//deze functie haalt alle beveiligingsvragen uit de database, en maakt de html van de form aan. Als er vragen worden toegevoegd, komen deze automatisch op het registratieform.
function _getBeveiligingsvragen(){
    $conn = getConn();
    $sql = "SELECT COUNT(*) AS AantalVragen FROM Vraag;";
    $stmt = sqlsrv_prepare($conn, $sql);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if (sqlsrv_execute($stmt)) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $aantalvragen = $row["AantalVragen"];
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
    $html = "";
    $sql = "SELECT * FROM Vraag;";
    $stmt = sqlsrv_prepare($conn, $sql);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if (sqlsrv_execute($stmt)) {
        for($i = 0; $i < $aantalvragen; $i++) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC,$i)) {
                $vraag = $row["Tekstvraag"];
                $vraagnummer = $row["Beveiligingsvraag"];
                $html .= <<<HTML
<option value="$vraagnummer">$vraag</option>
HTML;
            }
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
    return $html;
}

function _registreerGebruiker(){


    //het globaal maken van deze variabelen is nodig om ze op te halen in de functie.
    global $gebruikersnaam;
    global $voornaam;
    global $achternaam;
    global $straatnaam;
    global $tussenvoegsel;
    global $huisnummer;
    global $postcode;
    global $plaatsnaam;
    global $land;
    global $geboortedatum;
    global $email;
    global $wachtoord1;
    global $beveiligingsvraag;
    global $aBeveiligingsvraag;
    global $rol;
    global $telefoonnummer;

    //De waardes in deze variabelen zijn nodig om de gegevens van php naar de goede in de sql tabel te zetten.
    $beveiligingsvraag = (int) $beveiligingsvraag;
    $huisnummer = (int) $huisnummer;

    //bevestigd wordt nu 0, maar na de bevestiging wordt hij op 1 gezet.
    $bevestigd = 0;

    $hash = password_hash($wachtoord1,PASSWORD_DEFAULT);

    $conn = getConn();

    //De eerste sql query zet de gegevens van de gebruiker in de gebruikerstabel.
    $params = array($gebruikersnaam,$voornaam,$achternaam,$straatnaam,$huisnummer,$tussenvoegsel,$postcode,$plaatsnaam,$land,$geboortedatum,$email,$hash,$beveiligingsvraag,$aBeveiligingsvraag,$rol,$bevestigd);
    $sql = "INSERT INTO 
Gebruiker(Gebruikersnaam,Voornaam,Achternaam,Straatnaam,Huisnummer,Tussenvoegsel,Postcode,Plaatsnaam,Land,GeboorteDatum,Emailadres,Wachtwoord,Beveiligingsvraag,Antwoordtekst,Rol,Bevestigd) 
VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = sqlsrv_prepare($conn, $sql,$params);
    sqlsrv_execute($stmt);
    if (!$stmt) {
        //door het globaal maken hiervan kunnen de errorberichten worden aangemaakt.
        global $error;
        $error .= "<p>Er ging iets mis.</p>";
        die(print_r(sqlsrv_errors(), true));
    }
    //wanneer de query succesvol is uitgevoerd, wordt er een mail gestuurt waar de gebruiker de registratie kan voltooien door op een link te drukken.
    elseif($stmt){
        stuurRegistratieEmail($email,$gebruikersnaam);
        echo '<script type="text/javascript">';
        echo ' alert("Er is een email gestuurt naar het mailadres.")';  //not showing an alert box.
        echo '</script>';
    }

    //de tweede query zet het telefoonnummer in de Gebruikerstelefoon-tabel, als die gegeven is.
    if($telefoonnummer!=null) {
        $params = array($gebruikersnaam, $telefoonnummer);
        $sql = "INSERT INTO 
Gebruikerstelefoon(Volgnr,Gebruikersnaam,Telefoon)
VALUES(1,?,?);";
        $stmt = sqlsrv_prepare($conn, $sql, $params);
        sqlsrv_execute($stmt);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}

?>

<!Doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
</head>
<body>
<?php include_once 'Header.php'; ?>
<main>
    <br>


        <?php echo $error;?>
        <form class="well form-horizontal" action=" " method="post"  id="contact_form">
                <div class="container-fluid">
                        <div class="row text-center">
                            <div class="col">
                                <h2>Registreren</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Gebruikersnaam</label>
                                    <div class="inputGroupContainer">
                                        <div class="input-group">
                                            <input  required="true" name="gebruikersnaam" placeholder="Gebruikersnaam" class="form-control"  type="text" value="<?php echo $gebruikersnaam;?>">*
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Wachtwoord</label>
                                    <div class="inputGroupContainer">
                                        <div class="input-group">
                                            <input  required="true" name="wachtwoord" placeholder="Wachtwoord" class="form-control"  type="password" value="<?php echo $wachtoord1 ;?>">*
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Herhaal wachtwoord</label>
                                    <div class="inputGroupContainer">
                                        <div class="input-group">
                                            <input  required="true" name="wachtwoord_herhaling" placeholder="Herhaal wachtwoord" class="form-control"  type="password" value="<?php echo $wachtwoord2 ;?>">*
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Voornaam</label>
                                    <div class="inputGroupContainer">
                                        <div class="input-group">
                                            <input  required="true" name="voornaam" placeholder="Voornaam" class="form-control"  type="text" value="<?php echo $voornaam ;?>">*
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Achternaam</label>
                                    <div class=" inputGroupContainer">
                                        <div class="input-group">
                                            <input  required="true" name="achternaam" placeholder="Achternaam" class="form-control"  type="text"  value="<?php echo $achternaam ;?>">*
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Koper / Verkoper</label>
                                    <div class="selectContainer">
                                        <div class="input-group">
                                            <select name="rol" class="form-control selectpicker" >*
                                                <option>Koper</option>
                                                <option>Verkoper</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Straatnaam</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="straatnaam" placeholder="Straatnaam" class="form-control"  type="text" value="<?php echo $straatnaam ;?>">*
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Tussenvoegsel</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="tussenvoegsel" placeholder="Tussenvoegsel" class="form-control"  type="text" value="<?php echo $tussenvoegsel ;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Huisnummer</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  nrequired="true" name="huisnummer" placeholder="Huisnummer" class="form-control"  type="text" value="<?php echo $huisnummer ;?>">*
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Postcode</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="postcode" placeholder="Postcode" class="form-control"  type="text" value="<?php echo $postcode ;?>">*
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Plaatsnaam</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="plaatsnaam" placeholder="Plaatsnaam" class="form-control"  type="text" value="<?php echo $plaatsnaam ;?>">*
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Land</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="land" placeholder="Land" class="form-control"  type="text" value="<?php echo $land ;?>">*
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">E-mail</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="email" placeholder="Email" class="form-control"  type="email" value="<?php echo $email ;?>">*
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Telefoonnummer</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="telefoonnummer" placeholder="Telefoonnummer" class="form-control"  type="tel" value="<?php echo $telefoonnummer ;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Geboortedatum</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="geboortedatum" placeholder="Geboortedatum" class="form-control"  type="date" value="<?php echo $geboortedatum ;?>">*
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Beveilingsvraag</label>
                                <div class="selectContainer">
                                    <div class="input-group">
                                        <select required="true" name="beveiligingsvraag" class="form-control selectpicker">   *
                                            <?php echo $beveiligingsvragen; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Antwoord beveiligingsvraag</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="antwoord" placeholder="Antwoord beveiligingsvraag" class="form-control"  type="text" value="<?php echo $aBeveiligingsvraag ;?>">*
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1 text-center">
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4"><br>
                                    <button type="submit" name ="registreren" class="btn btn-dark" >Registreren</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-1">
                            <p> De velden met * zijn verplicht.</p>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
