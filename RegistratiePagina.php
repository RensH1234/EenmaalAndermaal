<?php
include_once 'DatabaseConn.php';
include_once 'framework.php';

require_once 'SessionHandling/Session.php';

//deze is voor het versturen van een email en het controleren van de code
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
$rol = "Koper";
$sizeBeveiligingsvragen = _getSizeBeveiligingsvragen();
$beveiligingsvragen = _getBeveiligingsvragen();

//Wanneer een gebruiker registreert, wordt hierin gecontroleerd of de ingevoerde gegevens correct en veilig zijn. Ook worden de waardes ingevoerd weer op de goede plek gegenereerd.
include 'RegistratieControles.php';

/**
 * Functie die het aantal beveiligingsvragen in de database returned
 * @author Rens Harinck
 * @uses file('DatabaseConn.php')
 * @return int aantal beveiligingsvragen in database
 */
function _getSizeBeveiligingsvragen(){
    $conn = getConn();
    $sql = "SELECT COUNT(*) AS AantalVragen FROM Vraag;";
    $stmt = sqlsrv_prepare($conn, $sql);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if (sqlsrv_execute($stmt)) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            return $row["AantalVragen"];
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}
/**
 * Functie die de option's genereerd met beveiligingsvragen van de database
 * @author Rens Harinck
 * @uses file('DatabaseConn.php')
 * @uses _getSizeBeveiligingsvragen()
 * @return string option's met beveiligingsvragen
 */
function _getBeveiligingsvragen(){
    $conn = getConn();
    $aantalvragen =  _getSizeBeveiligingsvragen();
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

/**
 * Functie die de gebruiker registreert in de database
 * @author Rens Harinck
 * @uses file('DatabaseConn.php')
 */
function _registreerGebruiker(){

    if(checkCode($_POST['code'], $_POST['mode'], $_POST['origin'])) {
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
        $email = $_POST['origin'];
        global $wachtoord1;
        global $beveiligingsvraag;
        global $aBeveiligingsvraag;
        global $rol;
        global $telefoonnummer;

        //De waardes in deze variabelen zijn nodig om de gegevens van php naar de goede in de sql tabel te zetten.
        $beveiligingsvraag = (int)$beveiligingsvraag;
        $huisnummer = (int)$huisnummer;

        //
        $bevestigd = 1;

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
        } //wanneer de query succesvol is uitgevoerd, wordt er een mail gestuurt waar de gebruiker de registratie kan voltooien door op een link te drukken.
        elseif ($stmt) {
            stuurConformatiemail($email);
            echo '<script type="text/javascript">';
            echo " alert('U bent geregistreerd! U wordt naar de inlogpagina gestuurt..')
            window.location.href='Inloggen.php';";
            echo '</script>';
        }
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

if(!array_key_exists('origin', $_POST)||!array_key_exists('code', $_POST)||!array_key_exists('code', $_POST)){
    $mainContent= <<<HTML
<p>Er ging iets mis. Druk op registreren om te registreren.</p>
HTML;

}
elseif(checkCode($_POST['code'], $_POST['mode'], $_POST['origin'])){
    $email=$_POST['origin'];
    $code = $_POST['code'];
    $mode = $_POST['mode'];
    $origin = $_POST['origin'];
    $mainContent = <<<HTML
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
                                            <input  required="true" name="gebruikersnaam" placeholder="Gebruikersnaam" class="form-control"  type="text" value=$gebruikersnaam>*
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Wachtwoord</label>
                                    <div class="inputGroupContainer">
                                        <div class="input-group">
                                            <input  required="true" name="wachtwoord" placeholder="Wachtwoord" class="form-control"  type="password" value= $wachtoord1>*
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Herhaal wachtwoord</label>
                                    <div class="inputGroupContainer">
                                        <div class="input-group">
                                            <input  required="true" name="wachtwoord_herhaling" placeholder="Herhaal wachtwoord" class="form-control"  type="password" value=$wachtwoord2>*
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
                                            <input  required="true" name="voornaam" placeholder="Voornaam" class="form-control"  type="text" value=$voornaam>*
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-1">
                                <div class="form-group">
                                    <label class="control-label">Achternaam</label>
                                    <div class=" inputGroupContainer">
                                        <div class="input-group">
                                            <input  required="true" name="achternaam" placeholder="Achternaam" class="form-control"  type="text"  value=$achternaam>*
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
                                        <input  required="true" name="straatnaam" placeholder="Straatnaam" class="form-control"  type="text" value=$straatnaam>*
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Tussenvoegsel</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="tussenvoegsel" placeholder="Tussenvoegsel" class="form-control"  type="text" value= $tussenvoegsel>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Huisnummer</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="huisnummer" placeholder="Huisnummer" class="form-control"  type="text" value=$huisnummer>*
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
                                        <input  required="true" name="postcode" placeholder="Postcode" class="form-control"  type="text" value=$postcode>*
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Plaatsnaam</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="plaatsnaam" placeholder="Plaatsnaam" class="form-control"  type="text" value=$plaatsnaam>*
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Land</label>
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <input  required="true" name="land" placeholder="Land" class="form-control"  type="text" value=$land>*
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
                                        <input  disabled required="true" name="email" placeholder="Email" class="form-control"  type="email" value=$email>
                                        <input name="origin" type="hidden" value=$origin>
                                        <input name="code" type="hidden" value=$code>
                                        <input name="mode" type="hidden" value=$mode>
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
                                        <input  name="telefoonnummer" placeholder="Telefoonnummer" class="form-control"  type="tel" value=$telefoonnummer>
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
                                        <input  required="true" name="geboortedatum" placeholder="Geboortedatum" class="form-control"  type="date" value=$geboortedatum>*
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
                                        <select required="true" name="beveiligingsvraag" class="form-control selectpicker" size=$sizeBeveiligingsvragen>*
                                            $beveiligingsvragen
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
                                        <input  required="true" name="antwoord" placeholder="Antwoord beveiligingsvraag" class="form-control"  type="text" value=$aBeveiligingsvraag>*
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
HTML;
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
        <?php echo $mainContent?>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>
