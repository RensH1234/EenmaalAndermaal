<?php
include_once 'DatabaseConn.php';
include_once 'Veilinglijst.php';

class Zoekmachine
{
    private $idArray;
    private $filterprijs = "";
    private $voorwerpgegevens = array();
    private $nVoorwerpen = 0;

    function _constructNieuw($sleutelwoord, $filterindex, $rubriek)
    {
        $nVoorwerpen = 0;
        $filteroptie = $this->setFilter($filterindex);
        if ($sleutelwoord == null) {
            $sleutelwoord = "";
        }
        $this->idArray = array();
        $conn = getConn();
        $sql = "SELECT TOP 20 V.Voorwerpnummer, V.Titel, V.Plaatsnaam, 
V.Verkoopprijs, V.LoopTijdEinde, V.MaximaleLooptijd, V.Looptijdbegin, B.AfbeeldingURL 
FROM Voorwerp V INNER JOIN Bestand B ON V.Voorwerpnummer = B.Voorwerpnummer WHERE
(V.Titel LIKE '%{$sleutelwoord}%' )  {$rubriek} {$this->filterprijs} ORDER BY {$filteroptie};";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                array_push($this->voorwerpgegevens,array($row['Voorwerpnummer'],
                    $row['Titel'],$row['Plaatsnaam'],$row['Verkoopprijs'],$row['LoopTijdEinde'],$row['MaximaleLooptijd'],
                    $row['Looptijdbegin'],$row['AfbeeldingURL']));
                    $nVoorwerpen = $nVoorwerpen + 1;
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
        $this->nVoorwerpen = $nVoorwerpen;
    }

    function genereerVeilingArtikelen(){
        $artikelen = new Veilinglijst();
        $artikelen->_constructZoeken($this->voorwerpgegevens,'zoekresultaten',$this->nVoorwerpen);
        $artikelen->printVeilingenZoeken();
    }

    function setFilter($filterindex)
    {
        switch ($filterindex) {
            case 1:
                $a = "V.Verkoopprijs DESC";
                break;
            default:
                $a = "V.Verkoopprijs ASC";
                break;
        }
        return $a;
    }

    function _getIdArrayRes()
    {
        return implode('.', $this->idArray);
    }

    public function prijsfilter(string $implode)
    {
        $laatsteAanroep = false;
        if ($implode != null) {
            $explode = explode(".", $implode);
            $this->filterprijs .= " AND (";
            for ($i = 0; $i < sizeof($explode); $i++) {
                $this->plaatsFilter($explode[$i]);

                if($i==sizeof($explode)-1){
                    $laatsteAanroep= true;
                }

                if(!$laatsteAanroep){
                    $this->filterprijs .= " OR ";
                }
            }
            $this->filterprijs .= ")";
        }
    }

    private function plaatsFilter($i)
    {
        switch ($i) {
            case "1":
                $this->filterprijs .= " (V.Verkoopprijs < 10)";
                break;
            case "2":
                $this->filterprijs .= " (V.Verkoopprijs >= 10 AND V.Verkoopprijs < 25)";
                break;
            case "3":
                $this->filterprijs .= " (V.Verkoopprijs >= 25 AND V.Verkoopprijs < 50)";
                break;
            case "4":
                $this->filterprijs .= " (V.Verkoopprijs >= 50)";
                break;
            default:
                break;
        }
    }
}