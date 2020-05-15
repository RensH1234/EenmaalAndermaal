<?php
include_once 'DatabaseConn.php';

class Header
{
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
                    echo "<li class='dropdown-submenu'><a class='dropdown-item' href=''>" . $row['Rubrieknaam'] . "</a>";
                    echo "<ul class='dropdown-menu'>";
                    $this->_getRubriekFromDb($row['RubriekID'], $RubriekNiveau + 1);
                    echo "</ul>";
                    echo "</li>";
                } elseif ($row['Count'] == 0) {
                    echo "<li class='dropdown-submenu'><a class='dropdown-item' href=''>" . $row['Rubrieknaam'] . "</a></li>";
                }
            }
        }
    }
}
