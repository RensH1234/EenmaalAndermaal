<?php
include_once 'DatabaseConn.php';
include_once 'SessionHandling/Session.php';


class Advertentie
{
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

    function _generateRubriekVerkoopList($SuperID, $menuData, $niveau)
    {
        $html = "<select name=$niveau id=$niveau onchange=submitForm('Verkopen.php') required>";
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

    function _childexists($SuperID, $menuData){
        if (isset($menuData['parents'][$SuperID])) {
            return true;
        }
        return false;
    }

    function _generateSelection($rubriekSelectie)
    {
        $i = 0;
        foreach ($_POST as $key=>$value) {
            echo "<input type='hidden' name=$key value=$value required>";
            echo "<div class='form-group'>";
            if (isset($value) && $rubriekSelectie->
                _childexists($value, $rubriekSelectie->_getRubriekFromDb())) {
                echo $rubriekSelectie->_generateRubriekVerkoopList($value, $rubriekSelectie->_getRubriekFromDb(), "subrubriek" . $i);
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

    function _inputCheck(){
        if (isset($_POST['verder']) && $this->_verify() == "") {
            return true;
        }
        else {
            return false;
        }
    }

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