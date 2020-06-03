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
    public function _construct($voorwerpnummers, $cssID)
    {
        $this->voorwerpnummers = $voorwerpnummers;
        $this->naam = <<<HTML
<div class="row-3" id="$cssID">
HTML;
    }

    public function _maakVeilingen($voorwerpnummers)
    {
        $this->voorwerpnummers = $voorwerpnummers;
    }

    public function _constructZoeken($array, $cssID, $voorwerpnummers)
    {
        $this->voorwerpnummers = $voorwerpnummers;
        $this->naam = <<<HTML
<div class="row-3" id="$cssID">
HTML;
        $this->arrayVeilingen = $array;
    }

    //artikelen voor zoekquery
    private function maakArtikelenZoekQuery()
    {
        for ($i = 0; $i < sizeof($this->voorwerpnummers); $i++) {
            $this->veilingArtikelen = new VeilingArtikel();
            $this->veilingArtikelen[$i]->_construct($this->voorwerpnummers[$i]);
        }
    }

    public function _genereerContainer($name)
    {
        $container = "<div class='container'>";
        $container .= "<div class='row mt-4 text-center bg-dark'><div class='col'><h1 class='text-body'>$name</h1>";
        $container .= "</div></div>";
        $container .= "<div class='row rounded justify-content-around  bg-dark'>";
        for ($i = 0; $i < sizeof($this->voorwerpnummers); $i++) {
            $artikel = new VeilingArtikel();
            $artikel->_construct($this->voorwerpnummers[$i]);
            $container .= $artikel->printArtikel();
        }
        $container .= "</div></div>";
        return $container;
    }

    public function printVeilinglijst()
    {
        echo $this->naam;
        echo "<div class='scrolllist'>";
        for ($i = 0; $i < sizeof($this->voorwerpnummers); $i++) {
            $a = new VeilingArtikel();
            $a->_construct($this->voorwerpnummers[$i]);
            echo $a->printArtikel();
        }
        echo "</div></div>";
    }

    public function printVeilingen()
    {
        echo $this->naam;
        echo "<div class='col border border-danger' >";
        for ($i = 0; $i < sizeof($this->voorwerpnummers); $i++) {
            $a = new VeilingArtikel();
            $a->_construct($this->voorwerpnummers[$i]);
            echo $a->printArtikel();
        }
        echo "</div></div>";
    }

    public function printVeilingenZoeken()
    {
        echo $this->naam;
        echo "<div class='col-md' >";
        for ($i = 0; $i < sizeof($this->arrayVeilingen); $i++) {
            $a = new VeilingArtikel();
            $a->_constructArray($this->arrayVeilingen[$i]);
            echo $a->printArtikel();
        }
        echo "</div></div>";
    }

    public function _fetchHotVeilingen($amount)
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

    public function _fetchAflopendeVeilingen($amount)
    {
        $results = array();
        $conn = getConn();
        $sql = "SELECT TOP (?) Voorwerpnummer FROM Voorwerp
where VeilingGesloten=0
ORDER BY LoopTijdEinde ASC";
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
