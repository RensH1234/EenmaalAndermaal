<?php
session_start();

function is_logged_in()
{
    if (isset($_SESSION['ingelogd']) && $_SESSION['ingelogd'] == true) {
        return true;
    }
    return false;
}