<?php
$serverName = "mssql2.iproject.icasites.nl";
$login = "iproject12";
$password = "NSgGF59F";
$connectionInfo = array("Database" => "iproject12", "UID" => $login, "PWD" => $password);
$conn = sqlsrv_connect($serverName, $connectionInfo);

function getConn()
{
    global $conn;
    echo "success";
    return $conn;
}
