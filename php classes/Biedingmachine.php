<?php
include_once 'DatabaseConn.php';

class Biedingmachine
{
    private $voorwerpnummer;
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

            $html = <<<HTML
<div class="row">
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
</div>
HTML;
            for ($i = 0; $i < sizeof($this->stringBiedingenArray); $i++) {
                $array = explode("|||||||||", $this->stringBiedingenArray[$i]);

                $html .= <<<HTML
        <tr>
          <td>&euro; $array[0]</td>
          <td>$array[1]</td>
          <td>$array[2]</td>
        </tr>
HTML;

            }

            $html .= <<<HTML
            </tbody> 
        </table> 
    </div> 
</div>
</div>
HTML;
        } else {

            $html = <<<HTML
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p>Wees de eerste bieder!</p>
         </div>
    </div>
HTML;

        }
        return $html;
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
            <div class="col text-center">
                <a class="btn btn-dark" href="#">Log in</a>
            </div>
            <div class="col text-center">
                <a class="btn btn-primary" href="#">Registreer</a>
            </div>
        </div>
<br>
HTML;
            $html_alt .= $this->printBodinfo();
            return $html_alt;
        } else {
            $html_alt = <<<HTML
    <div class="container-fluid">    
        <div class="row">
            <div class="col">
            <p>Bieden:</p>
        </div>
        </div>
        <div class="row">
        <form action="Veiling.php" class="form-inline">
               <input type="hidden" value="$this->voorwerpnummer" name="id">
               <div class="input-group mr-sm-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">€</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Bodbedrag">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                <button class="btn btn-primary mb-2" type="submit">Plaats Bieding</button>
            
        </form>
        </div>
<br>
HTML;
            $html_alt .= $this->printBodinfo();
            return $html_alt;
        }



    }
}