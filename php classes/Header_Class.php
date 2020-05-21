<?php
include_once 'DatabaseConn.php';
include_once 'SessionHandling/Session.php';

class HeaderClass
{
    //Functie die all rubriek gegevens van de Database ophaalt
    function _getRubriekFromDb()
    {
        $menuData = array('items' => array(), 'parents' => array());

        $conn = getConn();
        $sql = "SELECT RubriekID, Rubrieknaam, SuperRubriekID FROM Rubriek ORDER BY SuperRubriekID, Rubrieknaam";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($menuItem = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $menuData['items'][$menuItem['RubriekID']] = $menuItem;
                $menuData['parents'][$menuItem['SuperRubriekID']][] = $menuItem['RubriekID'];
            }
        }
        return $menuData;
    }
    //Functie die een lijst genereert op basis van de OuderID, de array met gegevens, en hoe diep het menu moet gaaan
    function _generateRubriekList($SuperID, $menuData, $Depth)
    {
        $html = '';

        if (isset($menuData['parents'][$SuperID])) {
            foreach ($menuData['parents'][$SuperID] as $itemId) {
                $html .= "<li class='dropdown-submenu'><a class='dropdown-item' href='VeilingenOverzicht.php?rubriekID={$menuData['items'][$itemId]['RubriekID']}'>" . $menuData['items'][$itemId]['Rubrieknaam'] . "</a>";
                if ($Depth > 1) {
                    $html .= "<ul class='dropdown-menu'>";
                    $html .= $this->_generateRubriekList($itemId, $menuData, $Depth - 1);
                    $html .= '</li>';
                    $html .= '</ul>';
                }
            }
        }
        return $html;
    }

    function _generateRubriekListVeilingenOverzicht($SuperID, $menuData, $Depth)
    {
        $html = '';

        if (isset($menuData['parents'][$SuperID])) {
            foreach ($menuData['parents'][$SuperID] as $itemId) {
                $html .= "<li class='dropdown-submenu'><a class='dropdown-item' href='VeilingenOverzicht.php?rubriekID={$menuData['items'][$itemId]['RubriekID']}'>" . $menuData['items'][$itemId]['Rubrieknaam'] . "</a>";
                if ($Depth > 1) {
                    $html .= "<ul class='dropdown-menu'>";
                    $html .= $this->_generateRubriekList($itemId, $menuData, $Depth - 1);
                    $html .= '</li>';
                    $html .= '</ul>';
                }
            }
        }
        return $html;
    }
    //DEPRECIATED FUNCTIE NIET AAN KOMEN!
//    function __getRubriekFromDb($SuperRubriek, $RubriekNiveau)
//    {
//        $conn = getConn();
//        $sql = "SELECT r.RubriekID, r.Rubrieknaam, Deriv1.Count FROM Rubriek r  LEFT OUTER JOIN
//(SELECT SuperRubriekID, COUNT(*) AS Count FROM Rubriek GROUP BY SuperRubriekID) Deriv1
//ON r.RubriekID = Deriv1.SuperRubriekID WHERE r.SuperRubriekID= ?";
//        $stmt = sqlsrv_prepare($conn, $sql, array($SuperRubriek));
//        if (!$stmt) {
//            die(print_r(sqlsrv_errors(), true));
//        }
//        sqlsrv_execute($stmt);
//        if (sqlsrv_execute($stmt)) {
//            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
//                if ($row['Count'] > 0) {
//                    echo "<li class='dropdown-submenu'><a class='dropdown-item' href='VeilingenOverzicht.php?rubriekId={$row['RubriekID']}'>" . $row['Rubrieknaam'] . "</a>";
//                    echo "<ul class='dropdown-menu'>";
//                    $this->_getRubriekFromDb($row['RubriekID'], $RubriekNiveau + 1);
//                    echo "</ul>";
//                    echo "</li>";
//                } elseif ($row['Count'] == 0) {
//                    echo "<li class='dropdown-submenu'><a class='dropdown-item' href='VeilingenOverzicht.php?rubriekId={$row['RubriekID']}'>" . $row['Rubrieknaam'] . "</a></li>";
//                }
//            }
//        }
//    }

    //Functie die controleert of de gebruiker op de huidige pagina zit en op basis daarvan een active echoot
    function _activeHeader($page_cur)
    {
        $url_array = explode('/', $_SERVER['REQUEST_URI']);
        $url = end($url_array);
        if ($page_cur == $url) {
            echo 'active';
        }
    }

    //Functie die of LOGIN of LOGUIT weergeeft in de navigatiebalk afhankelijk van of er is ingelogd of niet
    function sessionLink(){
        $session = ["href" => "", "name" => ""];
        if(is_logged_in()){
            $session["href"] = "Loguit_Redir.php";
            $session["name"] = "Loguit";
        }
        else {
            $session["href"] = "Inloggen.php";
            $session["name"] = "Login";
        }
        return $session;
    }
}
