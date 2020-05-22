<?php
require_once 'VeilingArtikel.php';
class Veilinglijst
{
    private $veilingArtikelen = array();
    private $voorwerpnummers = array();
    private $arrayVeilingen;
    private $naam;

    // worden bij intregratie database gebruikt
//    private $huidigeTijd = date("d/m/Y");
//    private $huidigeDatum = date("h:i:sa");

    //constructor voor veilinglijst
    public function _construct($voorwerpnummers,$cssID){
        $this->voorwerpnummers=$voorwerpnummers;
        $this->naam=<<<HTML
<div class="row-3" id="$cssID">
HTML;
    }

    public function _constructZoeken($array,$cssID,$voorwerpnummers){
        $this->voorwerpnummers=$voorwerpnummers;
        $this->naam=<<<HTML
<div class="row-3" id="$cssID">
HTML;
        $this->arrayVeilingen = $array;
    }



    //artikelen voor zoekquery
    private function maakArtikelenZoekQuery(){
        for($i = 0; $i < sizeof($this->voorwerpnummers); $i++){
            $this->veilingArtikelen= new VeilingArtikel();
            $this->veilingArtikelen[$i]->_construct($this->voorwerpnummers[$i]);
        }
    }

    public function printVeilinglijst(){
        echo $this->naam;
        echo "<div class='scrolllist'>";
        for($i = 0; $i < sizeof($this->voorwerpnummers); $i++){
            $a = new VeilingArtikel();
            $a->_construct($this->voorwerpnummers[$i]);
            echo $a->printArtikel();
        }
        echo "</div></div>";
    }
    public function printVeilingen(){
        echo $this->naam;
        echo "<div class='col-md' >";
        for($i = 0; $i < sizeof($this->voorwerpnummers); $i++){
            $a = new VeilingArtikel();
            $a->_construct($this->voorwerpnummers[$i]);
            echo $a->printArtikel();
        }
        echo "</div></div>";
    }

    public function printVeilingenZoeken(){
        echo $this->naam;
        echo "<div class='col-md' >";
        for($i = 0; $i < sizeof($this->arrayVeilingen); $i++){
            $a = new VeilingArtikel();
            $a->_constructArray($this->arrayVeilingen[$i]);
            echo $a->printArtikel();
        }
        echo "</div></div>";
    }

    public function _fetchHotveilingen($amount)
    {
        $results = array();
        $conn = getConn();
        $sql = "SELECT TOP (?) v.Voorwerpnummer, COUNT(v.Voorwerpnummer) As Aantalbiedingen FROM Voorwerp v
INNER JOIN Bod b ON v.Voorwerpnummer = b.Voorwerpnummer
GROUP BY v.Voorwerpnummer
ORDER BY Aantalbiedingen DESC";
        $stmt = sqlsrv_prepare($conn, $sql, array($amount));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $results[] = $row['Voorwerpnummer'];
            }
        }
        return $results;
    }
}
