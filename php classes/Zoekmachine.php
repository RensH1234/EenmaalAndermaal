<?php
include_once 'DatabaseConn.php';

class Zoekmachine
{
    private $idArray;

    function _constructNieuw($sleutelwoord){
        if($sleutelwoord==null){
            $sleutelwoord="";
        }
        $this->idArray = array();
        $conn = getConn();
        $sql = "SELECT Voorwerpnummer FROM Voorwerp WHERE 
(Titel LIKE '%{$sleutelwoord}%') OR (Beschrijving LIKE '%{$sleutelwoord}%');";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                array_push($this->idArray,$row['Voorwerpnummer']);

            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }



    function _sorteerPrijsHL(){

    }

    function _sorteerPrijsLH(){

    }

    function _sorteerAfstandLH(){

    }

    function _selecteerRubriek(){

    }

    function _getIdArrayRes(){
        return implode('.',$this->idArray);
    }
}