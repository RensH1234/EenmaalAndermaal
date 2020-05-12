<?php
include_once 'DatabaseConn.php';

class Biedingmachine
{
    public $voorwerpnummer;
    private $sessionlogin;
    private $stringBiedingenArray = array();

    public function _construct($voorwerpnummer){
        $this->voorwerpnummer = $voorwerpnummer;
        $conn = getConn();
        $sql = "SELECT * FROM Bod  WHERE 
Voorwerpnummer = ? ORDER BY Boddatum DESC;";
        $stmt = sqlsrv_prepare($conn, $sql, array($voorwerpnummer));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            if(sqlsrv_num_rows($stmt)>0) {
                //de min() zorgt ervoor dat er nooit meer dan 10 biedingen worden geselecteerd.
                for($i = 0; $i < min(sqlsrv_num_rows($stmt),10); $i++) {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC,$i)) {
                        $this->createDBString($row["Bodbedrag"],$row["Boddatum"],$row["Gebruikersnaam"]);
                    }
                }
            }
        }
        else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    private function createDBString($bedrag, $datumtijd, $gebruikersnaam){
        $explode = array();
        array_push($explode,$bedrag);
        array_push($explode,$datumtijd);
        array_push($explode,$gebruikersnaam);
        $implode = implode(".",$explode);

        array_push($this->stringBiedingenArray, $implode);
    }

    public function printBod(){

    }
}