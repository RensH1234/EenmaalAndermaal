<?php
include_once 'DatabaseConn.php';
include_once 'SessionHandling/Session.php';

/**
 *  * Class HeaderClass maakt een object aan die de categorieenlijst in de header genereert
 * @author Yasin Tavsan
 */
class HeaderClass
{
    /**
     * Functie de de rubriekgegevens van de database ophaalt en retourneert
     * @author Yasin Tavsan
     * @return array[]
     */
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

    /**
     * Functie die de rubriekenlijst genereert
     * @author Yasin Tavsan
     * @param $SuperID integer RubriekID van wiens child-elementen een lijst wordt aangemaakt
     * @param $menuData array[] array met parent- en child-elementen van RubriekID's
     * @param $Depth integer Aantal niveau's van de rubriek die wordt aangemaakt
     * @return string
     */
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

    /**
     * @author Yasin Tavsan & Rens Harinck
     * @param $SuperID
     * @param $menuData
     * @param $Depth
     * @return string
     */
    function _generateRubriekListVeilingenOverzicht($SuperID, $menuData, $Depth)
    {
        $html = '';

        if (isset($menuData['parents'][$SuperID])) {
            foreach ($menuData['parents'][$SuperID] as $itemId) {
                $html .= "<a class='text-black-50' href='VeilingenOverzicht.php?rubriekID={$menuData['items'][$itemId]['RubriekID']}'>" . $menuData['items'][$itemId]['Rubrieknaam'] . "</a><br>";
                if ($Depth > 1) {
                    $html .= $this->_generateRubriekListVeilingenOverzicht($itemId, $menuData, $Depth - 1);
                }
            }
        }
        return $html;
    }

    /**
     * @author Yasin Tavsan & Rens harinck
     * @param $SuperID
     * @param $menuData
     * @param $Depth
     * @return string
     */
    function _generateRubriekFilter($SuperID, $menuData, $Depth)
    {
        $html = '';

        if (isset($menuData['parents'][$SuperID])) {
            foreach ($menuData['parents'][$SuperID] as $itemId) {
                $html .= "OR R.RubriekID = {$menuData['items'][$itemId]['RubriekID']} ";
                if ($Depth > 1) {
                    $html .= $this->_generateRubriekFilter($itemId, $menuData, $Depth - 1);
                }
            }
        }
        return $html;
    }

    /**
     * Functie die de huidige pagina actief maakt in de header
     * @author Yasin Tavsan
     * @param $page_cur
     */
    function _activeHeader($page_cur)
    {
        $url_array = explode('/', $_SERVER['REQUEST_URI']);
        $url = end($url_array);
        if ($page_cur == $url) {
            echo 'active';
        }
    }

    /**
     * Functie die of LOGIN of LOGUIT weergeeft in de navigatiebalk afhankelijk van of er is ingelogd of niet
     * @author Yasin Tavsan
     * @return array[]
     */
    function sessionLink(){
        if(is_logged_in()){
            $session["href_log"] = "Loguit_Redir.php";
            $session["name_log"] = "Loguit";
            $session["username"] = "Welkom " . $_SESSION['gebruikersnaam'] . "!";
            $session["href_reg"] = "";
            $session["name_reg"] = "";
        }
        else {
            $session["href_log"] = "Inloggen.php";
            $session["name_log"] = "Login";
            $session["username"] = "";
            $session["href_reg"] = "RegistratieOpgeven.php";
            $session["name_reg"] = "Registreren";
        }
        return $session;
    }

    /**
     * @param $rubriekID
     * @return string
     */
    function titleToSuperID($rubriekID){

        $conn = getConn();
        $sql = "SELECT RubriekID as SuperRubriekID , Rubrieknaam as SuperRubrieknaam FROM Rubriek WHERE RubriekID = 
(SELECT SuperRubriekID FROM Rubriek WHERE RubriekID = ?) ";
        $stmt = sqlsrv_prepare($conn, $sql, array($rubriekID));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row= sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $superID = $row['SuperRubriekID'];
                $superNaam = $row['SuperRubrieknaam'];
            }
            if(isset($superNaam)) {
                if ($superNaam == 'Root') {
                    $superNaam = 'Hoofdrubrieken';
                }
            }
            else{
                $superID=-1;
                $superNaam= 'Rubrieken';
            }
        }
        return <<<HTML
<a class="h2" href="VeilingenOverzicht.php?rubriekID=$superID">
<h2>$superNaam</h2></a>
HTML;
    }
}
