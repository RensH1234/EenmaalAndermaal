<?php
$cijfersEnLetters = '/[^A-Za-z0-9\\s]/';
$alleenLetters = '/[^A-Za-z\\s]/';
$alleenCijfers = '/[^0-9.]/';
$titel = setErrorAndValue('titel', 5, 20, $cijfersEnLetters, true, 'string');
$afbeeldingURL = setErrorAndValue('AfbeeldingURL', 5, 250, $cijfersEnLetters, true, 'string');
$beschrijving = setErrorAndValue('beschrijving', 0, 20, $cijfersEnLetters, false, 'string');
$betalingswijze = setErrorAndValue('betalingswijze', 5, 20, $alleenLetters, true, 'string');
$plaatsnaam = setErrorAndValue('Plaatsnaam', 5, 250, $alleenLetters, true, 'string');
$betalingsinstructies = setErrorAndValue('betalingsinstructies', 5, 20, $cijfersEnLetters, true, 'string');
$land = setErrorAndValue('land', 5, 250, $alleenLetters, true, 'string');
$looptijd = setErrorAndValue('looptijd', 1, 7, $alleenCijfers, true, 'float');;
$startprijs = setErrorAndValue('startprijs', 4, 7, $alleenCijfers, true, 'float');
$verzendinstructies = setErrorAndValue('verzendinstructies', 0, 20, $cijfersEnLetters, false, 'string');
$verzendkosten = setErrorAndValue('verzendkosten', 4, 7, $alleenCijfers, false, 'float');

function setErrorAndValue($variablename, $minlength, $maxlength, $chartype, $required, $varType){
    $errorVariable = "";
    global $error;
    if(!array_key_exists($variablename,$_GET)){
        if($required&&array_key_exists('plaatsen',$_GET)) {
            $error .= "<p class='text-white'>Error: Vul alle verplichte velden in om door te gaan.</p>";
        }
        return null;
    }
    else{
        $variablename = $_GET[$variablename];
        if($varType=='string') {
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
        }
        elseif($varType=='float'){
            if (strlen((string) $variablename) > $maxlength) {
                $errorVariable .= "<p class='text-white'>Error: '{$variablename}' mag maximaal {$maxlength} tekens lang zijn.</p>";
            }
            if (strlen((string )$variablename) < $minlength) {
                $errorVariable .= "<p class='text-white'>Error: '{$variablename}' moet minimaal {$minlength} tekens lang zijn.</p>";
            }
        }

        if($errorVariable != ""){
            $error .= $errorVariable;
        }

        return $variablename;
    }
}