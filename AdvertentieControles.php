<?php
$cijfersEnLetters = '/[^A-Za-z0-9\\s]/';
$alleenLetters = '/[^A-Za-z\\s]/';
$alleenCijfers = '/[^0-9.]/';
$titel = setErrorAndValue('titel', 5, 100, $cijfersEnLetters, true, 'string');
$afbeeldingURL = setErrorAndValue('AfbeeldingURL', 5, 200, $cijfersEnLetters, true, 'url');
$beschrijving = setErrorAndValue('beschrijving', 0, 250, $cijfersEnLetters, false, 'string');
$betalingswijze = setErrorAndValue('betalingswijze', 5, 9, $alleenLetters, true, 'string');
$plaatsnaam = setErrorAndValue('Plaatsnaam', 2, 250, $alleenLetters, true, 'string');
$betalingsinstructies = setErrorAndValue('betalingsinstructies', 2, 20, $cijfersEnLetters, true, 'string');
$land = setErrorAndValue('land', 2, 20, $alleenLetters, true, 'string');
$looptijd = setErrorAndValue('looptijd', 1, 120, $alleenCijfers, true, 'float');;
$startprijs = setErrorAndValue('startprijs', 0.01, 9000, $alleenCijfers, true, 'float');
$verzendinstructies = setErrorAndValue('verzendinstructies', 0, 20, $cijfersEnLetters, false, 'string');
$verzendkosten = setErrorAndValue('verzendkosten', 2, 7, $alleenCijfers, false, 'float');

/**
 * Functie die returned of een string eindigt op een of meer substrings meegegeven in de array
 * @author Rens Harinck
 * @param string $haystack string om te controleren
 * @param array[] $needle array met substrings waar op wordt gecontroleerd
 * @return boolean
 */
function eindigtOp($haystack, $needle){
    for($i = 0; $i < sizeof($needle); $i++){
        $length = strlen($needle[$i]);
        if ($length == 0) {
            return true;
        }
        if(substr($haystack, -$length) === $needle[$i]){
            return true;
        }
    }
    return false;
}
/**
 * Functie die de ingevoerde waarde uit de $_GET superglobal haalt, ze returnt, en errorberichten aan $error plakt als de waarde uit $_GET niet voldoet aan de controles.
 * De controles worden door de parameters aangegeven.
 * @author Rens Harinck
 * @global array $_GET superglobal moet bestaan voor functie
 * @global string $error wordt door functie aangepast
 * @param string $variablename sleutel die de waarde uit $_GET haalt die wordt gecontroleerd
 * @param int $minlength minimaal aantal karakters toegestaan
 * @param int $maxlength minimaal aantal karakters toegestaan
 * @param string $chartype string in preg_match die de toegestaande tekens opgeeft
 * @param bool $required geef aan of de opgegeven waarde verplicht is
 * @param string $varType geef aan wat voor datatype $variablename heeft: 'string' of 'float'
 * @return string
 */
function setErrorAndValue($variablename, $minlength, $maxlength, $chartype, $required, $varType){
    $errorVariable = "";
    $imgEnds = array('.png','.jpg','.jpeg','.jfif','.pjepg','.pjp','.bpm','.apng','.bmp','.ico','.cur'); //een aantal afbeeldingextensions
    global $error;
    if(!array_key_exists($variablename,$_GET)){
        if($required&&array_key_exists('plaatsen',$_GET)) {
            $error .= "<p class='text-white'>Error: Vul alle verplichte velden in om door te gaan.</p>";
        }
        return null;
    }
    else{
        $variablename = $_GET[$variablename];
        if($varType=='string' || $varType=='url') {
            if (strlen($variablename) > $maxlength) {
                $errorVariable .= "<p class='text-white'>Error: '{$variablename}' mag maximaal {$maxlength} tekens lang zijn.</p>";
            }
            if (strlen($variablename) < $minlength) {
                $errorVariable .= "<p class='text-white'>Error: '{$variablename}' moet minimaal {$minlength} tekens lang zijn.</p>";
            }
            if (preg_match($chartype, $variablename)) {
                if($chartype == '/[^A-Za-z0-9]/'){
                    $errorVariable .= "<p class='text-white'>Error: '{$variablename}' mag geen vreemde tekens bevatten.</p>";
                }
                elseif($chartype == '/[^A-Za-z]/'){
                    $errorVariable .= "<p class='text-white'>Error: '{$variablename}' mag geen vreemde tekens of cijfers bevatten.</p>";
                }
            }
            if($varType=='url' && !filter_var($variablename, FILTER_VALIDATE_URL)){
                $errorVariable .= "<p class='text-white'>Error: Voer een geldige link in</p>";
                if(!eindigtOp($variablename, $imgEnds)){
                    $errorVariable .= "<p class='text-white'>Error: Afbeelding-type wordt niet ondersteunt</p>";
                }
            }
        }
        elseif($varType=='float'){
            if ($variablename > $maxlength) {
                $errorVariable .= "<p class='text-white'>Error: '{$variablename}' mag maximaal {$maxlength} groot zijn.</p>";
            }
            if ($variablename < $minlength) {
                $errorVariable .= "<p class='text-white'>Error: '{$variablename}' moet minimaal {$minlength} groot zijn.</p>";
            }
        }

        if($errorVariable != ""){
            $error .= $errorVariable;
        }

        return $variablename;
    }


}