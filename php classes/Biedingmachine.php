<?php
include_once 'DatabaseConn.php';

class Biedingmachine
{
    public $voorwerpnummer;
    private $ingelogd;
    private $stringBiedingenArray = array();

    public function _construct($voorwerpnummer, $ingelogd)
    {
        $this->ingelogd = $ingelogd;
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
    private function createDBString($bedrag, $datumtijd, $gebruikersnaam)
    {
        $explode = array();
        array_push($explode, $bedrag);
        array_push($explode, date_format($datumtijd, "Y-m-d h-m-s"));
        array_push($explode, $gebruikersnaam);
        $implode = implode("|||||||||", $explode);
        array_push($this->stringBiedingenArray, $implode);
    }


    //de functie printBodinfo is een onderdeel van de functie printBiedingsmachine. Het print de tabel met info van biedingen op het product.


    private function printBodinfo()
    {
        if (sizeof($this->stringBiedingenArray) > 0) {

            $head = <<<HTML
<div class="col">
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
            for ($i = 0; $i < sizeof($this->stringBiedingenArray); $i++) {
                $array = explode("|||||||||", $this->stringBiedingenArray[$i]);

                $row2 = <<<HTML
        <tr>
          <td>&euro; $array[0]</td>
          <td>$array[1]</td>
          <td>$array[2]</td>
        </tr>
HTML;
                echo $row2;
            }

            echo '
            </tbody> 
        </table> 
    </div> 
</div>';
        } else {

            $html_alt = <<<HTML
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p>Wees de eerste bieder!</p>
         </div>
    </div>
HTML;
            echo $html_alt;
        }
    }





    public function printBiedingmachine()
    {
        if (!$this->ingelogd) {
            $html_alt = <<<HTML
    <div class="container-fluid">    
        <div class="row">
            <div class="col">
            <p>Om te kunnen bieden:</p>
        </div>
        </div>
        <div class="row">
            <div class="col-2">
                <a class="btn-dark" href="#">Log in</a>
            </div>
            <div class="col-2">
                <a class="btn-primary" href="#">Registreer</a>
            </div>
        </div>
HTML;
        }

        else{

        }
        echo $html_alt;
        $this->printBodinfo();
    }
}