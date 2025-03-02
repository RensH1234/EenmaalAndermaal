<?php
/**
 * Functie die een verbinding legt met de database
 * @author Yasin Tavsan
 * @return false|resource
 */
function getConn()
{
    static $connection;

    if(!isset($connection)){
        $config = parse_ini_file('private/config.ini');
        $connectionInfo = array("Database" => $config['dbname'], "UID" => $config['username'], "PWD" => $config['password'], "CharacterSet" => "UTF-8");
        $connection = sqlsrv_connect($config['servername'], $connectionInfo);
    }

    if($connection){
        return $connection;
    }
    else {
        die( print_r( sqlsrv_errors(), true));
    }
}
