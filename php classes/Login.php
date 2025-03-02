<?php
include_once 'DatabaseConn.php';

/**
 *  * Class Login Object dat inloggegevens controleert en de session afhandelt
 * @author Yasin Tavsan
 */
class Login
{
    private $name_db;
    private $pass_db;
    private $role_db;
    private $name_post;
    private $pass_post;
    private $mismatch;

    /**
     * Functie die de gebruikersnaam en wachtwoord ophaalt vanuit de Database
     * @author Yasin Tavsan
     * @param $user string gebruikersnaam dat opgehaald moet worden
     */
    function _getFromGebruikersDb($user)
    {
        $conn = getConn();
        $sql = "SELECT Gebruikersnaam, Wachtwoord, Rol FROM Gebruiker WHERE 
Gebruikersnaam = ?;";
        $stmt = sqlsrv_prepare($conn, $sql, array($user));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->name_db = $row['Gebruikersnaam'];
                $this->pass_db = $row['Wachtwoord'];
                $this->role_db = $row['Rol'];
            }
        }
    }

    /**
     * Functie die het inloggen afhandelt. Invoer wordt eerst via de _verify() functie gecontroleerd en dan pas
     * vergeleken met het resultaat vanuit de database.
     * @author Yasin Tavsam
     */
    function _genLogin()
    {
        $this->mismatch = false;
        if (isset($_POST['login']) && $this->_verify() == "") {
            $this->name_post = $_POST['gebruikersnaam'];
            $this->pass_post = $_POST['wachtwoord'];

            $this->_getFromGebruikersDb($this->name_post);
            if ($this->_isMatch()) {
                $_SESSION['ingelogd'] = true;
                //toegevoegd door rens om een gebruikersnaam en rol te krijgen
                $_SESSION['gebruikersnaam'] = $this->name_post;
                $_SESSION['Rol'] = $this->role_db;
                header('location: Login_Redir.php');
            }
        }
    }

    /**
     * Boolean functie die controleert of de invoer en de database gegevens een match zijn
     * @author Yasin Tavsan
     * @return boolean
     */
    function _isMatch()
    {
        if (isset($_POST['login'])) {
            if ($this->name_post == $this->name_db && password_verify($this->pass_post, $this->pass_db)) {
                return true;
            }
            $this->mismatch = true;
        }
        return false;
    }

    /**
     * Functie die de invoer van de gebruiker opschoont en bij foutieve invoer een foutmelding weergeeft
     * @author Yasin Tavsan
     * @return string
     */
    function _verify()
    {
        $e = "";
        if (isset($_POST['login'])) {
            $user = validate($_POST['gebruikersnaam']);
            $pass = validate($_POST['wachtwoord']);

            if (strlen($user) < 3 || strlen($user) > 20) {
                $e .= '<p class="text-danger mb-n1">Voer een geldige gebruikersnaam in!</p>';
            }
            if (strlen($pass) < 3 || strlen($pass) > 20) {
                $e .= '<p class="text-danger mb-n1">Voer een geldige wachtwoord in!</p>';
            } else if ($this->mismatch) {
                $e .= '<p class="text-danger mb-n1">Gebruikersnaam en/of wachtwoord komen niet overeen!</p>';
            }
            return $e;
        }
        return $e;
    }
}
