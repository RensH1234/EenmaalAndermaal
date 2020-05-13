<?php
function getConn()
{
    static $connection;

    if(!isset($connection)){
        $config = parse_ini_file('private/config.ini');
        $connectionInfo = array("Database" => $config['dbname'], "UID" => $config['username'], "PWD" => $config['password']);
        $connection = sqlsrv_connect($config['servername'], $connectionInfo);
    }

    if($connection){
        return $connection;
    }
    else {
        die( print_r( sqlsrv_errors(), true));
    }
}
