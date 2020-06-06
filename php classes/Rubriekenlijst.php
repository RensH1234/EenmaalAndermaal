<?php
include_once 'DatabaseConn.php';

class Rubriekenlijst
{
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