<?php

include_once 'DatabaseConn.php';
include_once 'SessionHandling/Session.php';

/**
 *  * Class Advertentie maakt het object aan die het genereren van de rubriekselectie en invoercontrole op de Advertentieverkoop pagina uitvoert
 * @author Yasin Tavsan
 */
class Advertentie
{
    /**
     * Functie die rubriekgegevens uit de database haalt en de resultaten ordent in een tweedimensionaal array
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
     * Functie die de formulier rubriekenlijst in html aanmaakt en retourneert
     * @author Yasin Tavsan
     * @param $SuperID integer RubriekID wiens rubriekenlijst van de childelementen wordt aangemaakt
     * @param $menuData array tweedimensionaal array met de parent en child elementen
     * @param $naam string Name waarde die de select lijst meekrijgt. Bv. 'Hoofdrubriek' en 'Subrubriek1'
     * @return string
     */
    function _generateRubriekVerkoopList($SuperID, $menuData, $naam)
    {
        $html = "<select name=$naam id=$naam onchange=submitForm('Verkopen.php') required>";
        $html .= "<option disabled value='' selected hidden >Selecteer Rubriek</option>";
        if (isset($menuData['parents'][$SuperID])) {
            foreach ($menuData['parents'][$SuperID] as $itemId) {
                $html .= "<option value={$menuData['items'][$itemId]['RubriekID']}>
{$menuData['items'][$itemId]['Rubrieknaam']} </option>";
            }
        }
        $html .= "</select>";
        return $html;
    }

    /**
     * Functie die controleert of een RubriekID child-elementen bevat in de array met parent en child ID's
     * @author Yasin Tavsan
     * @param $SuperID integer RubriekID van wie er wordt gecontroleerd of er child-elementen bestaan
     * @param $menuData array tweedimensionaal array met de parent en child elementen
     * @return boolean
     */
    function _childexists($SuperID, $menuData){
        if (isset($menuData['parents'][$SuperID])) {
            return true;
        }
        return false;
    }

    /**
     * Functie die de selectielijst van de subrubrieken aanmaakt en met JS elk vorige selectielijst vergrendeld
     * @author Yasin Tavsan
     */
    function _generateSelection()
    {
        $i = 0;
        foreach ($_POST as $key=>$value) {
            echo "<input type='hidden' name=$key value=$value required>";
            echo "<div class='form-group'>";
            if (isset($value) && $this->
                _childexists($value, $this->_getRubriekFromDb())) {
                echo $this->_generateRubriekVerkoopList($value, $this->_getRubriekFromDb(), "subrubriek" . $i);
                echo "<script type='text/javascript'>
            document.getElementById('$key').disabled = true;
            </script>";
            }
            echo "</div>";
            echo "<script type='text/javascript'>
            document.getElementById('$key').value= $value 
            </script>";
            $i++;
        }
    }

    /**
     * Functie die controleert of een meegegeven RubriekID in de database bestaat
     * @author Yasin Tavsan
     * @param $id integer RubriekID wiens bestaan in de database wordt gecontroleerd
     * @return boolean
     */
    function _existsInDatabase($id)
    {
        $conn = getConn();
        $sql = "SELECT RubriekID FROM Rubriek WHERE RubriekID = ?";
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            $row = sqlsrv_has_rows( $stmt );
            if ($row === true){
                return true;
            }
        }
        return false;
    }

    /**
     * Functie die controleert of de verder knop is geklikt en de verificatiefunctie geen fouten aangeeft
     * @author Yasin tavsan
     * @return boolean
     */
    function _inputCheck(){
        if (isset($_POST['verder']) && $this->_verify() == "") {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Functie die alle POST variabelen opschoont en het resultaat controleert voor aanwezigheid in de Database
     * @author Yasin Tavsan.
     * @return string
     */
    function _verify(){
        $e = "";
        if (isset($_POST['verder'])) {
            foreach($_POST as $key=>$value){
                if($key== 'verder') continue;
                $value = validate($value);
                if(!$this->_existsInDatabase($value)){
                    $e = "ID komt niet voor in Database";
                }
            }
        }
        return $e;
    }
}