<?php
include_once 'DatabaseConn.php';
include_once 'framework.php';
include_once 'php classes/Veilinglijst.php';
include_once 'Functions.php';
$title = 'Eenmaal Andermaal!';
$siteNaam = 'Welkom!';
$huidigeJaar = date('Y');

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
$beveiligingsvragen = _getBeveiligingsvragen();


if(array_key_exists("gebruikersnaam",$_POST)){
    $gebruikersnaam=$_POST["gebruikersnaam"];
    if(strlen($_POST["gebruikersnaam"])>15){
        $error .= "<p class='text-white'>Error: gebruikersnaam is te lang</p>";
    }
    if(strlen($_POST["gebruikersnaam"])<5){
        $error .= "<p class='text-white'>Error: gebruikersnaam is te kort</p>";
    }
    if(preg_match('/[^A-Za-z0-9]/', $gebruikersnaam)){
        $error .= "<p class='text-white'>Error: gebruikersnaam mag geen vreemde tekens of witruimte bevatten</p>";
    }
}
if(array_key_exists("wachtwoord",$_POST)){
    $wachtoord1=$_POST["wachtwoord"];
    if(strlen($_POST["wachtwoord"])<5){
        $error .= "<p class='text-white'>Error: wachtwoord is te kort</p>";
    }
    if(strlen($_POST["wachtwoord"])>50){
        $error .= "<p class='text-white'>Error: wachtwoord is te lang</p>";
    }
    if(preg_match('/[^A-Za-z0-9]+""/', $wachtoord1)){
        $error .= "<p class='text-white'>Error: wachtwoord mag geen vreemde tekens bevatten</p>";
    }
}
if(array_key_exists("wachtwoord_herhaling",$_POST)){
    $wachtwoord2=$_POST["wachtwoord_herhaling"];
    if(array_key_exists("wachtwoord",$_POST)){
      if($_POST["wachtwoord"]!=$_POST["wachtwoord_herhaling"]){
       $error .= "<p class='text-white'>Error: herhaling wachtwoord komt niet overeen met het wachtwoord</p>";
      }
    }
}
if(array_key_exists("voornaam",$_POST)){
    $voornaam=$_POST["voornaam"];
    if(strlen($_POST["voornaam"])<2){
        $error .= "<p class='text-white'>Error: voornaam is te kort</p>";
    }
    if(strlen($_POST["voornaam"])>50){
        $error .= "<p class='text-white'>Error: voornaam is te lang</p>";
    }
    if(preg_match('/[^A-Za-z]+""/', $voornaam)){
        $error .= "<p class='text-white'>Error: voornaam mag geen vreemde tekens of cijfers bevatten</p>";
    }
}
if(array_key_exists("achternaam",$_POST)){
    $achternaam=$_POST["achternaam"];
    if(strlen($_POST["achternaam"])<2){
        $error .= "<p class='text-white'>Error: achternaam is te kort</p>";
    }
    if(strlen($_POST["achternaam"])>50){
        $error .= "<p class='text-white'>Error: achternaam is te lang</p>";
    }
    if(preg_match('/[^A-Za-z]+""/', $achternaam)){
        $error .= "<p class='text-white'>Error: Achternaam mag geen vreemde tekens of cijfers bevatten</p>";
    }
}
if(array_key_exists("straatnaam",$_POST)){
    $straatnaam=$_POST["straatnaam"];
    if(strlen($_POST["straatnaam"])<1){
        $error .= "<p class='text-white'>Error: straatnaam is te kort</p>";
    }
    if(strlen($_POST["straatnaam"])>20){
        $error .= "<p class='text-white'>Error: straatnaam is te lang</p>";
    }
    if(preg_match('/[^A-Za-z]+""/', $straatnaam)){
        $error .= "<p class='text-white'>Error: straatnaam mag geen vreemde tekens of cijfers bevatten</p>";
    }
}
if(array_key_exists("tussenvoegsel",$_POST)&&$_POST["tussenvoegsel"]!=null){
    $tussenvoegsel=$_POST["tussenvoegsel"];
    if(strlen($_POST["tussenvoegsel"])<1){
        $error .= "<p class='text-white'>Error: tussenvoegsel is te kort</p>";
    }
    if(strlen($_POST["tussenvoegsel"])>5){
        $error .= "<p class='text-white'>Error: tussenvoegsel is te lang</p>";
    }
    if(preg_match('/[^A-Za-z0-9]/', $tussenvoegsel)){
        $error .= "<p class='text-white'>Error: tussenvoegsel mag geen vreemde tekens of witruimte bevatten</p>";
    }
}
if(array_key_exists("huisnummer",$_POST)){
    $huisnummer=$_POST["huisnummer"];
    if(strlen($_POST["huisnummer"])<1){
        $error .= "<p class='text-white'>Error: huisnummer is te kort</p>";
    }
    if(strlen($_POST["huisnummer"])>5){
        $error .= "<p class='text-white'>Error: huisnummer is te lang</p>";
    }
    if(preg_match('/[^A-Za-z0-9]/', $huisnummer)){
        $error .= "<p class='text-white'>Error: huisnummer mag geen vreemde tekens of witruimte bevatten</p>";
    }
}
if(array_key_exists("postcode",$_POST)){
    $postcode=$_POST["postcode"];
    if(strlen($_POST["postcode"])<1){
        $error .= "<p class='text-white'>Error: postcode is te kort</p>";
    }
    if(strlen($_POST["postcode"])>10){
        $error .= "<p class='text-white'>Error: postcode is te lang, maximaal 10 karakters</p>";
    }
    if(preg_match('/[^A-Z0-9]/', $postcode)){
        $error .= "<p class='text-white'>Error: pstcode mag geen vreemde tekens, kleine letters of witruimte bevatten</p>";
    }
}
if(array_key_exists("plaatsnaam",$_POST)){
    $plaatsnaam=$_POST["plaatsnaam"];
    if(strlen($_POST["plaatsnaam"])<3){
        $error .= "<p class='text-white'>Error: plaatsnaam is te kort</p>";
    }
    if(strlen($_POST["plaatsnaam"])>30){
        $error .= "<p class='text-white'>Error: plaatsnaam is te lang, maximaal 30 karakters</p>";
    }
    if(preg_match('/[^A-Za-z]+""/', $plaatsnaam)){
        $error .= "<p class='text-white'>Error: plaatsnaam mag geen vreemde tekens of cijfers bevatten</p>";
    }
}
if(array_key_exists("land",$_POST)){
    $land=$_POST["land"];
    if(strlen($_POST["land"])<3){
        $error .= "<p class='text-white'>Error: land is te kort</p>";
    }
    if(strlen($_POST["land"])>30){
        $error .= "<p class='text-white'>Error: land is te lang, maximaal 30 karakters</p>";
    }
    if(preg_match('/[^A-Za-z]+""/', $land)){
        $error .= "<p class='text-white'>Error: land mag geen vreemde tekens of cijfers bevatten</p>";
    }
}
if(array_key_exists("email",$_POST)){
    $email=$_POST["email"];
    if(strlen($_POST["email"])<3){
        $error .= "<p class='text-white'>Error: email is te kort</p>";
    }
    if(strlen($_POST["email"])>50){
        $error .= "<p class='text-white'>Error: email is te lang, maximaal 50 karakters</p>";
    }
}
if(array_key_exists("telefoonnummer",$_POST)&&$_POST["telefoonnummer"]!=null){
    $telefoonnummer=$_POST["telefoonnummer"];
    if(strlen($_POST["telefoonnummer"])!=10){
        $error .= "<p class='text-white'>Error: telfoonnummer moet 10 karakters lang zijn</p>";
    }
}
if(array_key_exists("geboortedatum",$_POST)){
    $geboortedatum=$_POST["geboortedatum"];
    $diff = abs(strtotime($geboortedatum) - strtotime(date('m/d/Y h:i:s a', time())));
    $diff = floor($diff / (365*60*60*24));
    if($diff<18){
        $error .= "<p class='text-white'>Error: Alleen klanten van 18 jaar of ouder kunnen zich opgeven.</p>";
    }
}
if(array_key_exists("antwoord",$_POST)){
    $aBeveiligingsvraag=$_POST["antwoord"];
    if(preg_match('/[^A-Za-z0-9]+""/', $land)){
        $error .= "<p class='text-white'>Error: antwoord beveiligingsvraag mag geen vreemde tekens bevatten</p>";
    }
}
if($error==null&&array_key_exists("gebruikersnaam",$_POST)){
    _registreerGebruiker();
}

function _getBeveiligingsvragen(){
    return "";
}

function _registreerGebruiker(){

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
                                            <select name="rol" class="form-control selectpicker" >
                                                <option  value="<?php echo $rol ;?>">Selecteer een rol(Kan worden aangepast)</option>*
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
                                        <input  nrequired="true" ame="huisnummer" placeholder="Huisnummer" class="form-control"  type="text" value="<?php echo $huisnummer ;?>">*
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
                                            <option>Selecteer een beveiligingsvraag</option>
                                            <option>Koper</option>
                                            <option>Verkoper</option>
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
                                    <button type="submit" class="btn btn-dark" >Registreren</button>
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
