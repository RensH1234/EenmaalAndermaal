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
                for($i = 0; $i < 10; $i++) {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC,$i)) {
                        $this->createDBString($row["Bodbedrag"],$row["Boddatum"],$row["Gebruikersnaam"]);
                    }
                }
        }
        else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    //functie vult de array met de drie data in de vorm van een string die er zo uit ziet: "$bedrag.$datumtijd.$gebruikersnaam"
    private function createDBString($bedrag, $datumtijd, $gebruikersnaam){
        $explode = array();
        array_push($explode,$bedrag);
        array_push($explode,date_format($datumtijd,"Y-m-d h-m-s"));
        array_push($explode,$gebruikersnaam);
        $implode = implode("|||||||||",$explode);
        array_push($this->stringBiedingenArray, $implode);
    }

    public function printBod(){
        $htmla= <<<HTML
<div class="container-fluid">
HTML;
        echo $htmla;
        $head = <<<HTML
<table class="table table-sm table-dark">
  <thead>
    <tr>
      <th scope="col">Bodbedrag</th>
      <th scope="col">Datum bod</th>
      <th scope="col">Bieder</th>
    </tr>
  </thead>
  <tbody>

HTML;
        echo $head;
        for($i=0;$i<sizeof($this->stringBiedingenArray);$i++){
            $array = explode("|||||||||",$this->stringBiedingenArray[$i]);

            $row2 = <<<HTML
<tr>
      <td>&euro; $array[0]</td>
      <td>$array[1]</td>
      <td>$array[2]</td>
    </tr>
HTML;
            echo $row2;
        }

        echo '</tbody> </table>';
    }
}