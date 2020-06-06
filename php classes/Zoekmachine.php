<?php
include_once 'DatabaseConn.php';
include_once 'Veilinglijst.php';

class Zoekmachine
{
    private $idArray;
    private $filterprijs = "";
    private $voorwerpgegevens = array();
    private $nVoorwerpen = 0;

    /**
     * Constructor voor Zoekmachine
     * @author Rens Harinck
     * @uses $this->getRubrieken()
     * @uses $this->setFilter()
     * @uses $this->getAfbeelding()
     * @param string $sleutelwoord waar naar wordt gezocht
     * @param int $filterindex alle filters
     * @param array $subrubrieken alle subrubrieken die moeten worden laten zien
     * @param int $hoofdrubriek de parent rubriek van de subrubrieken
     */
    function _constructNieuw($sleutelwoord, $filterindex,$subrubrieken,$hoofdrubriek)
    {
        if($hoofdrubriek != null) {
            $rubrieken = $this->getRubrieken($subrubrieken, $hoofdrubriek);
        }
        else{
            $rubrieken = null;
        }
        $nVoorwerpen = 0;
        $filteroptie = $this->setFilter($filterindex);
        if ($sleutelwoord == null) {
            $sleutelwoord = "";
        }
        $this->idArray = array();
        $conn = getConn();
        $sql = "SELECT distinct TOP 20 V.Voorwerpnummer, V.Titel, V.Plaatsnaam, 
V.Verkoopprijs, V.LoopTijdEinde, V.MaximaleLooptijd, V.Looptijdbegin 
FROM Voorwerp V INNER JOIN Bestand B ON V.Voorwerpnummer = B.Voorwerpnummer INNER JOIN VoorwerpInRubriek R ON V.Voorwerpnummer = R.Voorwerpnummer WHERE
(V.Titel LIKE '%{$sleutelwoord}%' ) {$rubrieken} {$this->filterprijs} ORDER BY {$filteroptie};";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                array_push($this->voorwerpgegevens, array($row['Voorwerpnummer'],
                    $row['Titel'], $row['Plaatsnaam'], $row['Verkoopprijs'], $row['LoopTijdEinde'], $row['MaximaleLooptijd'],
                    $row['Looptijdbegin'], $this->getAfbeelding($row['Voorwerpnummer'])));
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }

        $this->nVoorwerpen = $nVoorwerpen;
    }

    function getAfbeelding($id){
        $afbeeldingURL="";
        $conn = getConn();
        $sql = "SELECT distinct TOP 1 B.AfbeeldingURL
FROM Voorwerp V INNER JOIN Bestand B ON V.Voorwerpnummer = B.Voorwerpnummer INNER JOIN VoorwerpInRubriek R ON V.Voorwerpnummer = R.Voorwerpnummer WHERE
V.Voorwerpnummer=$id";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $afbeeldingURL=$row['AfbeeldingURL'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
        return $afbeeldingURL;
    }
    /**
     * Functie die alle gezochte veilingen print
     * @author Rens Harinck
     */
    function genereerVeilingArtikelen(){
        $artikelen = new Veilinglijst();
        $artikelen->_constructZoeken($this->voorwerpgegevens,'zoekresultaten',$this->nVoorwerpen);
        $artikelen->printVeilingenZoeken();
    }
    /**
     * Functie die de filter selecteert van de resultaten, prijs hoog naar laag of laag naar hoog
     * @author Rens Harinck
     * @param int $filterindex index van de filter
     * @return string sql substring om te filteren
     */
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
    /**
     * Functie die een string van alle gezochte artikelen returned
     * @author Rens Harinck
     * @return string string van idarray
     */
    function _getIdArrayRes()
    {
        return implode('.', $this->idArray);
    }
    /**
     * Functie die de filter bepaalt van de prijs
     * @author Rens Harinck
     * @uses $this->plaatsFilter()
     * @param string $implode string van de gesselecteerde prijsranges
     */
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

    /**
     * Functie die de filter bepaalt van de prijs
     * @author Rens Harinck
     * @param string $i string van de gesselecteerde prijsranges
     */
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

    /**
     * Functie die de filter bepaalt van de prijs
     * @author Rens Harinck
     * @param array $subrubrieken subrubrieken van parent
     * @param int $hoofdrubriek parent van subrubrieken
     * @return string substring van sql query
     */
    private function getRubrieken($subrubrieken, $hoofdrubriek)
    {
        $r = "";
        $r .= "AND (R.RubriekID = {$hoofdrubriek} ";
        $r .= "{$subrubrieken}";
        $r .= ")";
        return $r;
    }
}