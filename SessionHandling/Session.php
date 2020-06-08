<?php
session_start();

/**
 * Functie die controleert of een gebruiker is ingelogd
 * @author Yasin Tavsam
 * @return bool
 */
function is_logged_in()
{
    if (isset($_SESSION['ingelogd']) && $_SESSION['ingelogd'] == true) {
        return true;
    }
    return false;
}

function is_verkoper(){
    if (array_key_exists('gebruikersnaam', $_SESSION) && $_SESSION['Rol'] == 'Verkoper') {
        return true;
    }
    return false;
}

function log_out(){
    unset($_SESSION);
    session_destroy();
}
