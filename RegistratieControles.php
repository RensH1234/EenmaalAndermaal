<?php
if(isset($_POST["registreren"])) {
    if (array_key_exists("gebruikersnaam", $_POST)) {
        $gebruikersnaam = $_POST["gebruikersnaam"];
        if (strlen($_POST["gebruikersnaam"]) > 30) {
            $error .= "<p class='text-white'>Error: gebruikersnaam is te lang</p>";
        }
        if (strlen($_POST["gebruikersnaam"]) < 5) {
            $error .= "<p class='text-white'>Error: gebruikersnaam is te kort</p>";
        }
        if (preg_match('/[^A-Za-z0-9]/', $gebruikersnaam)) {
            $error .= "<p class='text-white'>Error: gebruikersnaam mag geen vreemde tekens of witruimte bevatten</p>";
        }
    }
    if (array_key_exists("wachtwoord", $_POST)) {
        $wachtoord1 = $_POST["wachtwoord"];
        if (strlen($_POST["wachtwoord"]) < 5) {
            $error .= "<p class='text-white'>Error: wachtwoord is te kort</p>";
        }
        if (strlen($_POST["wachtwoord"]) > 50) {
            $error .= "<p class='text-white'>Error: wachtwoord is te lang</p>";
        }
    }
    if (array_key_exists("wachtwoord_herhaling", $_POST)) {
        $wachtwoord2 = $_POST["wachtwoord_herhaling"];
        if (array_key_exists("wachtwoord", $_POST)) {
            if ($_POST["wachtwoord"] != $_POST["wachtwoord_herhaling"]) {
                $error .= "<p class='text-white'>Error: herhaling wachtwoord komt niet overeen met het wachtwoord</p>";
            }
        }
    }
    if (array_key_exists("voornaam", $_POST)) {
        $voornaam = $_POST["voornaam"];
        if (strlen($_POST["voornaam"]) < 2) {
            $error .= "<p class='text-white'>Error: voornaam is te kort</p>";
        }
        if (strlen($_POST["voornaam"]) > 50) {
            $error .= "<p class='text-white'>Error: voornaam is te lang</p>";
        }
        if (preg_match('/[^A-Za-z]+""/', $voornaam)) {
            $error .= "<p class='text-white'>Error: voornaam mag geen vreemde tekens of cijfers bevatten</p>";
        }
    }
    if (array_key_exists("achternaam", $_POST)) {
        $achternaam = $_POST["achternaam"];
        if (strlen($_POST["achternaam"]) < 2) {
            $error .= "<p class='text-white'>Error: achternaam is te kort</p>";
        }
        if (strlen($_POST["achternaam"]) > 50) {
            $error .= "<p class='text-white'>Error: achternaam is te lang</p>";
        }
        if (preg_match('/[^A-Za-z]+""/', $achternaam)) {
            $error .= "<p class='text-white'>Error: Achternaam mag geen vreemde tekens of cijfers bevatten</p>";
        }
    }
    if (array_key_exists("straatnaam", $_POST)) {
        $straatnaam = $_POST["straatnaam"];
        if (strlen($_POST["straatnaam"]) < 1) {
            $error .= "<p class='text-white'>Error: straatnaam is te kort</p>";
        }
        if (strlen($_POST["straatnaam"]) > 20) {
            $error .= "<p class='text-white'>Error: straatnaam is te lang</p>";
        }
        if (preg_match('/[^A-Za-z]+""/', $straatnaam)) {
            $error .= "<p class='text-white'>Error: straatnaam mag geen vreemde tekens of cijfers bevatten</p>";
        }
    }
    if (array_key_exists("tussenvoegsel", $_POST) && $_POST["tussenvoegsel"] != null) {
        $tussenvoegsel = $_POST["tussenvoegsel"];
        if (strlen($_POST["tussenvoegsel"]) < 1) {
            $error .= "<p class='text-white'>Error: tussenvoegsel is te kort</p>";
        }
        if (strlen($_POST["tussenvoegsel"]) > 5) {
            $error .= "<p class='text-white'>Error: tussenvoegsel is te lang</p>";
        }
        if (preg_match('/[^A-Za-z0-9]/', $tussenvoegsel)) {
            $error .= "<p class='text-white'>Error: tussenvoegsel mag geen vreemde tekens of witruimte bevatten</p>";
        }
    }
    if (array_key_exists("huisnummer", $_POST)) {
        $huisnummer = $_POST["huisnummer"];
        if (strlen($_POST["huisnummer"]) < 1) {
            $error .= "<p class='text-white'>Error: huisnummer is te kort</p>";
        }
        if (strlen($_POST["huisnummer"]) > 5) {
            $error .= "<p class='text-white'>Error: huisnummer is te lang</p>";
        }
        if (preg_match('/[^A-Za-z0-9]/', $huisnummer)) {
            $error .= "<p class='text-white'>Error: huisnummer mag geen vreemde tekens of witruimte bevatten</p>";
        }
    }
    if (array_key_exists("postcode", $_POST)) {
        $postcode = $_POST["postcode"];
        if (strlen($_POST["postcode"]) < 1) {
            $error .= "<p class='text-white'>Error: postcode is te kort</p>";
        }
        if (strlen($_POST["postcode"]) > 10) {
            $error .= "<p class='text-white'>Error: postcode is te lang, maximaal 10 karakters</p>";
        }
        if (preg_match('/[^A-Z0-9]/', $postcode)) {
            $error .= "<p class='text-white'>Error: pstcode mag geen vreemde tekens, kleine letters of witruimte bevatten</p>";
        }
    }
    if (array_key_exists("plaatsnaam", $_POST)) {
        $plaatsnaam = $_POST["plaatsnaam"];
        if (strlen($_POST["plaatsnaam"]) < 3) {
            $error .= "<p class='text-white'>Error: plaatsnaam is te kort</p>";
        }
        if (strlen($_POST["plaatsnaam"]) > 30) {
            $error .= "<p class='text-white'>Error: plaatsnaam is te lang, maximaal 30 karakters</p>";
        }
        if (preg_match('/[^A-Za-z]+""/', $plaatsnaam)) {
            $error .= "<p class='text-white'>Error: plaatsnaam mag geen vreemde tekens of cijfers bevatten</p>";
        }
    }
    if (array_key_exists("land", $_POST)) {
        $land = $_POST["land"];
        if (strlen($_POST["land"]) < 3) {
            $error .= "<p class='text-white'>Error: land is te kort</p>";
        }
        if (strlen($_POST["land"]) > 30) {
            $error .= "<p class='text-white'>Error: land is te lang, maximaal 30 karakters</p>";
        }
        if (preg_match('/[^A-Za-z]+""/', $land)) {
            $error .= "<p class='text-white'>Error: land mag geen vreemde tekens of cijfers bevatten</p>";
        }
    }
    if (array_key_exists("email", $_POST)) {
        $email = $_POST["email"];
        if (strlen($_POST["email"]) < 3) {
            $error .= "<p class='text-white'>Error: email is te kort</p>";
        }
        if (strlen($_POST["email"]) > 50) {
            $error .= "<p class='text-white'>Error: email is te lang, maximaal 50 karakters</p>";
        }
    }
    if (array_key_exists("telefoonnummer", $_POST) && $_POST["telefoonnummer"] != null) {
        $telefoonnummer = $_POST["telefoonnummer"];
        if (strlen($_POST["telefoonnummer"]) != 10) {
            $error .= "<p class='text-white'>Error: telfoonnummer moet 10 karakters lang zijn</p>";
        }
    }
    if (array_key_exists("geboortedatum", $_POST)) {
        $geboortedatum = $_POST["geboortedatum"];
        $diff = abs(strtotime($geboortedatum) - strtotime(date('m/d/Y h:i:s a', time())));
        $diff = floor($diff / (365 * 60 * 60 * 24));
        if ($diff < 18) {
            $error .= "<p class='text-white'>Error: Alleen klanten van 18 jaar of ouder kunnen zich opgeven.</p>";
        }
    }
    if (array_key_exists("antwoord", $_POST)) {
        $aBeveiligingsvraag = $_POST["antwoord"];
        if (preg_match('/[^A-Za-z0-9]+""/', $land)) {
            $error .= "<p class='text-white'>Error: antwoord beveiligingsvraag mag geen vreemde tekens bevatten</p>";
        }
    }
    if (array_key_exists("beveiligingsvraag", $_POST)) {
        $beveiligingsvraag = $_POST["beveiligingsvraag"];
    }
    if (array_key_exists("rol", $_POST)) {
        $rol = $_POST["rol"];
    }
    if ($error == null && array_key_exists("gebruikersnaam", $_POST)) {
        _registreerGebruiker();
    }
}
