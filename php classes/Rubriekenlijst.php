<?php
include_once 'DatabaseConn.php';

class Rubriekenlijst
{

    public function _print($openId, $opencheck){
        if(!$opencheck){
            $this->_getRubriekFromDb(-1,1);
        }
        else{
            $this->_getRubriekFromDbOpen(-1,1,$openId);
        }
    }

    function _getRubriekFromDb($SuperRubriek, $RubriekNiveau)
    {
        $conn = getConn();
        $sql = "SELECT r.RubriekID, r.Rubrieknaam, Deriv1.Count FROM Rubriek r  LEFT OUTER JOIN
(SELECT SuperRubriekID, COUNT(*) AS Count FROM Rubriek GROUP BY SuperRubriekID) Deriv1
ON r.RubriekID = Deriv1.SuperRubriekID WHERE r.SuperRubriekID= ?";
        $stmt = sqlsrv_prepare($conn, $sql, array($SuperRubriek));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                if ($row['Count'] > 0) {
                    echo "<li class='dropdown-submenu'><a class='dropdown-item' href='VeilingenOverzicht.php?rubriekId={$row['RubriekID']}'>" . $row['Rubrieknaam'] . "</a>";
                    echo "<ul class='dropdown-menu'>";
                    $this->_getRubriekFromDb($row['RubriekID'], $RubriekNiveau + 1);
                    echo "</ul>";
                    echo "</li>";
                } elseif ($row['Count'] == 0) {
                    echo "<li class='dropdown-submenu'><a class='dropdown-item' href='VeilingenOverzicht.php?rubriekId={$row['RubriekID']}'>" . $row['Rubrieknaam'] . "</a></li>";
                }
            }
        }
    }

    private function _getRubriekFromDbOpen($param,$int, $openId)
    {

    }




    public function _fetchHotRubrieken($amount)
    {
        $results = array();
        $conn = getConn();
        $sql = "SELECT TOP (?) v.RubriekID, COUNT(v.RubriekID)As Aantalbiedingen, r.Rubrieknaam FROM VoorwerpInRubriek v
INNER JOIN Bod b ON v.Voorwerpnummer = b.Voorwerpnummer INNER JOIN Rubriek r on v.RubriekID = r.RubriekID
GROUP BY r.Rubrieknaam, v.RubriekID
ORDER BY Aantalbiedingen DESC";
        $stmt = sqlsrv_prepare($conn, $sql, array($amount));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            $i=0;
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $results[$i][1] = $row['RubriekID'];
                $results[$i][0] = $row['Rubrieknaam'];
                $i++;
            }
        }
        return $results;
    }
}