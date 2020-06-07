<?php
include_once 'DatabaseConn.php';

/**
 *  Class biedingmachine genereert een biedingtabel, alle front end functies en alle back-end functies nodig voor biedingen
 * @author Rens Harinck
 * @uses file('DatabaseConn.php')
 */
class Biedingmachine
{
    private $voorwerpnummer;
    private $ingelogd;
    private $stringBiedingenArray = array();
    private $minimumVerhoging;
    private $verkoopprijs;
    private $nieuweBieder;

    /**
     * Constructor Biedingmachine
     * @author Rens Harinck
     * @uses file('DatabaseConn.php')
     * @param int $voorwerpnummer voorwerpnummer waar biedingen van moeten worden genereerd
     * @param bool $ingelogd of er een gebruiker is ingelogd
     * @param string $gebruiker naam van gebruiker als die is ingelogd, anders '0'
     */
    public function _construct($voorwerpnummer, $ingelogd, $gebruiker)
    {
        if(!$ingelogd||$ingelogd==null){
            $this->ingelogd = false;
        }
        else{
            $this->ingelogd=true;
        }

        $this->voorwerpnummer = $voorwerpnummer;
        if($gebruiker != null) {
            $this->nieuweBieder = $gebruiker;
        }
        $conn = getConn();
        $sql = "SELECT A.Voorwerpnummer, A.Bodbedrag, A.Gebruikersnaam, A.Boddatum, B.Verkoopprijs 
FROM Bod A INNER JOIN Voorwerp B ON A.Voorwerpnummer = B.Voorwerpnummer
WHERE A.Voorwerpnummer = ? ORDER BY Boddatum DESC;";
        $stmt = sqlsrv_prepare($conn, $sql, array($voorwerpnummer));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            for($i = 0; $i < 10; $i++) {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC,$i)) {
                    $this->createDBString($row["Bodbedrag"],$row["Boddatum"],$row["Gebruikersnaam"]);
                }
            }

            }
        else {
            die(print_r(sqlsrv_errors(), true));
        }
        $sql = "SELECT Verkoopprijs FROM  Voorwerp WHERE Voorwerpnummer = ?";
        $stmt = sqlsrv_prepare($conn, $sql, array($voorwerpnummer));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->verkoopprijs=$row["Verkoopprijs"];
                $this->minimumVerhoging = $this->setVerhoging();
            }
        }
        else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    //functie vult de array met de drie data in de vorm van een string die er zo uit ziet: "$bedrag.$datumtijd.$gebruikersnaam"
    /**
     * Functie die de gebruiker registreert in de database
     * @author Rens Harinck
     * @param string $bedrag bedrag bieding
     * @param DateTime $datumtijd datumtijd van bod
     * @param string $gebruikersnaam gebruikersnaam van bieder
     */
    private function createDBString($bedrag, $datumtijd, $gebruikersnaam)
    {
        $explode = array();
        array_push($explode, $bedrag);
        array_push($explode, date_format($datumtijd, "Y-m-d G:i:s"));
        array_push($explode, $gebruikersnaam);
        $implode = implode("|||||||||", $explode);
        array_push($this->stringBiedingenArray, $implode);
    }


    //de functie printBodinfo is een onderdeel van de functie printBiedingsmachine. Het print de tabel met info van biedingen op het product.

    /**
     * Functie die de biedingentabel genereert
     * @author Rens Harinck
     * @return string html van biedingentabel
     */
    private function printBodinfo()
    {
        if (sizeof($this->stringBiedingenArray) > 0) {

            $html = <<<HTML
<div class="row">
<div class="col">
    <table class="table table-sm table-dark">
      <thead>
        <tr>
          <th scope="col">Bodbedrag</th>
          <th scope="col">Datum bod</th>
          <th scope="col">Bieder</th>
        </tr>
      </thead>
      <tbody>
</div>
HTML;
            for ($i = 0; $i < sizeof($this->stringBiedingenArray); $i++) {
                $array = explode("|||||||||", $this->stringBiedingenArray[$i]);

                $html .= <<<HTML
        <tr>
          <td>&euro; $array[0]</td>
          <td>$array[1]</td>
          <td>$array[2]</td>
        </tr>
HTML;

            }

            $html .= <<<HTML
            </tbody> 
        </table> 
    </div> 
</div>
</div>
HTML;
        } else {

            $html = <<<HTML
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p>Wees de eerste bieder!</p>
         </div>
    </div>
HTML;

        }
        return $html;
    }




    /**
     * Functie die gehele biedingfunctie returned
     * @author Rens Harinck
     * @uses $this->printBodInfo()
     * @return string html van biedingen, knoppen, en biedingssfunctie
     */
    public function printBiedingmachine()
    {
        if (!$this->ingelogd) {
            $html_alt = <<<HTML
    <div class="container-fluid">    
        <div class="row">
            <div class="col">
            <p>Om te kunnen bieden:</p>
        </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <a class="btn btn-dark" href="Inloggen.php">Log in</a>
            </div>
            <div class="col text-center">
                <a class="btn btn-primary" href="RegistratieOpgeven.php">Registreer</a>
            </div>
        </div>
<br>
HTML;
            $html_alt .= $this->printBodinfo();
            return $html_alt;
        } else {
            $html_alt = <<<HTML
    <div class="container-fluid">    
        <div class="row">
            <div class="col">
            <p>Bieden:</p>
        </div>
        </div>
        <div class="row">
        <form action="Veiling.php?id=$this->voorwerpnummer" class="form-inline" method="post">
               <div class="input-group mr-sm-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">€</span>
                    </div>
                    <input value="$this->minimumVerhoging"  type="number" name="bedrag" class="form-control" step=".01" aria-label="Bodbedrag" min="$this->minimumVerhoging" max="9999.99">
                </div>
                <button class="btn btn-primary mb-2" type="submit">Plaats Bieding</button>
            
        </form>
        </div>
<br>
HTML;
            $html_alt .= $this->printBodinfo();
            return $html_alt;
        }



    }
    /**
     * Functie die de minimale verhoging returned van een veilingartikel
     * @author Rens Harinck
     * @return float de minimale verhoging
     */
    private function setVerhoging()
    {
        if($this->verkoopprijs <= 49.99 ){
            return ($this->verkoopprijs + 0.50);
        }
        if($this->verkoopprijs > 49.99 && $this->verkoopprijs <= 499.99){
            return ($this->verkoopprijs + 1.00);
        }
        if($this->verkoopprijs > 499.99 && $this->verkoopprijs <= 999.99){
            return ($this->verkoopprijs + 5.00);
        }
        if($this->verkoopprijs > 999.99){
            return ($this->verkoopprijs + 50.00);
        }
    }


    //zet bieding in de database gebaseerd op bedrag. Alleen uitvoeren als er is ingelogd
    /**
     * Functie die een bod in de database zet, en de verkoopprijs veranderd van een voorwerp
     * @author Rens Harinck
     * @uses file('DatabaseConn.php')
     * @uses $this->stuurmailNaarVorigeBieder()
     * @param float $bedrag bedrag bieding
     */
    public function submitBod($bedrag){
        if($bedrag >= $this->minimumVerhoging && $bedrag <= 9999.99) {
            $conn = getConn();
            $sql = "INSERT INTO Bod(Voorwerpnummer,Bodbedrag,Gebruikersnaam,Boddatum)
                VALUES(?,?,?,?);
                UPDATE Voorwerp
                SET Verkoopprijs = ?
                WHERE Voorwerpnummer = ?
               ";
            $params = array($this->voorwerpnummer, $bedrag, $this->nieuweBieder, date('Y/m/d G:i:s a', time()), $bedrag, $this->voorwerpnummer);
            $stmt = sqlsrv_prepare($conn, $sql, $params);
            if (!$stmt) {
                die(print_r(sqlsrv_errors(), true));
            }
            sqlsrv_execute($stmt);
            $this->stuurmailNaarVorigeBieder();
        }
    }

    /**
     * Functie die mail naar vorige bieder in de database stuurt
     * @author Rens Harinck
     * @uses file('DatabaseConn.php')
     * @uses $this->stuurMail()
     */
    private function stuurmailNaarVorigeBieder(){
        $conn = getConn();
        $sql = " SELECT G.Emailadres FROM Gebruiker G INNER JOIN Bod B ON G.Gebruikersnaam = B.Gebruikersnaam
 WHERE B.Bodbedrag = (SELECT MAX(B.Bodbedrag) FROM Bod B 
 WHERE Bodbedrag < ( SELECT MAX(B.Bodbedrag) FROM Bod b ) AND Voorwerpnummer = ?)";
        $params=array($this->voorwerpnummer);
        $stmt = sqlsrv_prepare($conn, $sql, $params);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $emailadres = $row['Emailadres'];
                $this->stuurMail($emailadres);
            }

        }
        else{
            die(print_r(sqlsrv_errors(), true));
        }

    }
    /**
     * Functie die mail naar vorige bieder in de database stuurt
     * @author Rens Harinck
     * @uses file('DatabaseConn.php')
     * @param string $email email ontvanger
     */
    private function stuurMail($email){
        $to = $email;
        $subject = "U bent overboden!";

        $message = "
<html>
<head>
<title>U bent overboden!</title>
</head>
<body>
<p>Klik 
<a href='iproject12.icasites.nl/Veiling.php?id=$this->voorwerpnummer'>
hier
</a> om naar de veiling te gaan.</p>
</body>
</html>
";

// informatie email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <registratie@eenmaalandermaal.com>' . "\r\n";

//deze functionaliteit werkt alleen op de webserver, want daar zit ook een email-server op.
        mail($to,$subject,$message,$headers);
    }
}