<?php
include_once 'DatabaseConn.php';

class Zoekmachine
{
    private $idArray;
    private $filterprijs = "";

    function _constructNieuw($sleutelwoord, $filterindex)
    {
        $filteroptie = $this->setFilter($filterindex);
        if ($sleutelwoord == null) {
            $sleutelwoord = "";
        }
        $this->idArray = array();
        $conn = getConn();
        $sql = "SELECT TOP 20 Voorwerpnummer FROM Voorwerp WHERE
(Titel LIKE '%{$sleutelwoord}%' ) {$this->filterprijs} ORDER BY {$filteroptie};";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                array_push($this->idArray, $row['Voorwerpnummer']);

            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    function setFilter($filterindex)
    {
        switch ($filterindex) {
            case 1:
                $a = "Verkoopprijs DESC";
                break;
            default:
                $a = "Verkoopprijs ASC";
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
                $this->filterprijs .= " (Verkoopprijs < 10)";
                break;
            case "2":
                $this->filterprijs .= " (Verkoopprijs >= 10 AND Verkoopprijs < 25)";
                break;
            case "3":
                $this->filterprijs .= " (Verkoopprijs >= 25 AND Verkoopprijs < 50)";
                break;
            case "4":
                $this->filterprijs .= " (Verkoopprijs >= 50)";
                break;
            default:
                break;
        }
    }
}