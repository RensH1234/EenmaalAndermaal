<?php
include_once 'DatabaseConn.php';
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function _generateFooter($jaar){
    echo <<< FOOTER
<!-- Footer -->
<footer class='page-footer font-small unique-color-dark bg-dark'>

  <!-- Footer Links -->
  <div class='container text-center text-md-left mt-5'>

    <!-- Grid row -->
    <div class='row mt-3'>

      <!-- Grid column -->
      <div class='col-md-3 col-lg-4 col-xl-3 mx-auto mb-4'>
        <!-- Content -->
        <h6 class='text-uppercase font-weight-bold'>Eenmaal Andermaal</h6>
        <hr class='deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto' style='width: 60px;'>
        <p>Welkom, Leuk dat u rondkijkt op de website van Eenmaal Andermaal. <br> 
        Betrouwbaarheid, eenvoudigheid en veilgheid staan hoog in ons vaandel. <br></p>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class='col-md-2 col-lg-2 col-xl-2 mx-auto mb-4'>

        <!-- Links -->
        <h6 class='text-uppercase font-weight-bold'>Account</h6>
        <hr class='deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto' style='width: 60px;'>
        <p>
          <a href='inloggen.php'>Inloggen</a>
        </p>
        <p>
          <a href='#!'>Help</a>
        </p>
        <p>
          <a href='#!'></a>
        </p>
        <p>
          <a href='#!'></a>
        </p>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class='col-md-3 col-lg-2 col-xl-2 mx-auto mb-4'>

        <!-- Links -->
        <h6 class='text-uppercase font-weight-bold'>Links</h6>
        <hr class='deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto' style='width: 60px;'>
        <p>
          <a href='#!'>Privacy Statement</a>
        </p>
        <p>
          <a href='#!'>Algemene voorwaarden</a>
        </p>
        <p>
          <a href='#!'>Help</a>
        </p>
        <p>
          <a href='#!'></a>
        </p>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class='col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4'>

        <!-- Links -->
        <h6 class='text-uppercase font-weight-bold'>Vestiging</h6>
        <hr class='deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto' style='width: 60px;'>
        <p>
          <i class='fa fa-home mr-3'></i> Ruitenberglaan 26 Arnhem</p>
        <p>
          <i class='fa fa-envelope mr-3'></i> info@example.com</p>
        <p>
          <i class='fa fa-phone mr-3'></i> +31 026 345 6789</p>
        

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class='footer-copyright text-center py-3'>© $jaar Copyright:
    <a href='https://iproject12.icasites.nl/'> Eenmaal Andermaal</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
FOOTER;
}

function _activeHeader($page_cur)
{
    $url_array = explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if ($page_cur == $url) {
        echo 'active';
    }
}

/**
 * Functie die de registratiemail stuurt
 * @author Rens Harinck
 * @author Liander van Bergen
 * @uses generateCode()
 * @param string $email ontvanger van email
 */
function stuurRegistratieEmail($email){
    $mode = rand(0,1000);
    $url = "http://iproject12.icasites.nl/RegistratieVerifeer.php?origin={$email}&mode={$mode}";
    $to = $email;
    $subject = "Registratie voltooien EenmaalAndermaal";
    $code = generateCode($mode,$email);
    $message = "
<!doctype html>
<html lang='nl'>
<head>
<title></title>
<meta charset='UFT-8'>
</head>
<body>
<h2>Beste klant, </h2>
<p>Onlangs heeft u een verzoek ingediend om een account bij ons te registeren.</p>
<p>Om uw registratie te voltooien <a href='$url'>klik hier </a>*.</p>
<p>Kopieer vervolgens uw persoonlijke verificatiecode en voer hem in op de website.</p>
<p>Uw persoonlijke verificatiecode is:</p>
<p>$code</p>
<br>
<p>Met vriendelijke groeten,</p>
<p>Veilingsite Eenmaal Andermaal</p>
<p>P.s. werkt de link niet? Kopieer de onderstaande link en plak hem in uw urlbalk.</p>
<p> $url </p> 
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

/**
 * Functie controleert of de opgegeven code correct is
 * @author Rens Harinck
 * @uses alterMode()
 * @param string $code code die wordt gecontroleerd
 * @param int $mode cijfer dat bepaalt hoe de code moet worden gecontroleerd
 * @param string $email email-gedeelte waaruit correcte code bestaat
 * @return bool of de code klopt
 */
function checkCode($code, $mode, $email){
    $mode = alterMode($mode);
    if(password_verify("{$mode}{$email}",$code)){
        return true;
        }
    return false;
}

/**
 * Functie de code genereert
 * @author Rens Harinck
 * @uses alterMode()
 * @param int $mode cijfer dat bepaalt hoe de code moet worden gecontroleerd
 * @param string $email email-gedeelte waaruit correcte code bestaat
 * @return string gegenereerde code
 */
function generateCode($mode,$email){
    $mode = alterMode($mode);
    return password_hash("{$mode}{$email}",PASSWORD_DEFAULT);
}

/**
 * Functie de aangepaste versie van $mode returnt
 * @author Rens Harinck
 * @param int $mode cijfer dat bepaalt hoe de code moet worden gecontroleerd
 * @return float aangepaste versie van $mode
 */
function alterMode($mode){
    return ($mode * $mode + (int)round($mode/10));
}

/**
 * Functie die de email stuurt dat een klant geregistreert is
 * @author Rens Harinck
 * @author Liander van Bergen
 * @param string $email email van ontvanger
 */
function stuurConformatiemail($email){
    $to = $email;
    $subject = "Welkom uw registratie is succesvol voltooid.";
    $message = "
<html lang='nl'>
<head>
<title></title>
<meta charset='UTF-8'>
</head>
<body>
<h2>Beste klant, </h2>
<p>Welkom op onze veilingsite. Onlangs heeft u uw registratie voltooid. U kunt nu gebruk maken van onze diensten!</p>
<p>Indien u vragen en of opmerkingen heeft, dan horen wij dat graag van u.</p>
<p>Met vriendelijke groeten,</p>
<p>Veilingsite Eenmaal Andermaal</p>
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
/**
 * Functie die het emailadres van de ingelogde gebruiker returnt
 * @author Rens Harinck
 * @global $_SESSION['gebruikersnaam']
 * @uses file('DatabaseConn.php')
 * @return string email van ingelogde gebruiker
 */
function getEmailadres(){
    if(array_key_exists('gebruikersnaam', $_SESSION)){
        $conn = getConn();
        $sql = "SELECT Emailadres FROM Gebruiker  WHERE Gebruikersnaam = ?;";
        $stmt = sqlsrv_prepare($conn, $sql, array($_SESSION['gebruikersnaam']));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                return $row['Emailadres'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }
    return '';
}

/**
 * Functie die de email stuurt wanneer een klant verkoper wilt worden
 * @author Rens Harinck
 * @uses generateCode()
 * @param string $email email van ontvanger
 * @param string $gebruikersnaam gebruiker die email stuurt
 */
function stuurVerkopersEmail($email, $gebruikersnaam){
    $mode = rand(0,1000);
    $url = "http://iproject12.icasites.nl/VerkoperRegistreer.php?origin={$gebruikersnaam}&mode={$mode}";
    $to = $email;
    $subject = "Wordt een verkoper";
    $code = generateCode($mode,$gebruikersnaam);
    $message = "
<html>
<head>
<title>Om een verkoper te worden, klik op de link</title>
</head>
<body>
<a href='$url'>Wordt een verkoper</a>
<p>Kopieer deze code en voer hem op de website in:</p>
<p>$code</p>
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

/**
 * Functie die de rol van een gebruiker in de database aanpast
 * @author Rens Harinck
 * @uses file('DatabaseConn.php')
 * @param string $gebruikersnaam gebruikersnaam van klant
 * @param string $rol Waar de rol naar veranderd
 */
function veranderRol($gebruikersnaam, $rol){
    $conn = getConn();
    $sql = "UPDATE Gebruiker SET Rol = ? WHERE Gebruikersnaam = ?;";
    $stmt = sqlsrv_prepare($conn, $sql, array($rol, $gebruikersnaam));
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if(!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    $sql = "INSERT INTO Verkoper(Gebruikersnaam, ControleOptie) VALUES(?,?);";
    $stmt = sqlsrv_prepare($conn, $sql, array($gebruikersnaam, 0));
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if(!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
}

/**
 * Functie die een nieuwe advertentie aanmaakt en in de database zet
 * @author Rens Harinck
 * @uses file('DatabaseConn.php')
 * @param string $titel titel in database
 * @param string $afbeeldingURL afbeeldingURL in database
 * @param string $beschrijving beschrijving in database
 * @param string $betalingswijze betalingswijze in database
 * @param string $plaatsnaam plaatsnaam in database
 * @param string $betalingsinstructies betalingsinstructies in database
 * @param string $land land in database
 * @param int $looptijd looptijd in database
 * @param float $startprijs startprijs in database
 * @param string $verzendinstructies verzendinstructies in database
 * @param float $verzendkosten verzendkosten in database
 * @param int $rubriekID rubriekID in database
 * @param int $voorwerpnummer voorwerpnummer in database
 */
function maakAdvertentieAan($titel,$afbeeldingURL,$beschrijving,$betalingswijze,$plaatsnaam,$betalingsinstructies,$land
    , $looptijd, $startprijs, $verzendinstructies, $verzendkosten, $rubriekID, $voorwerpnummer){
    $verkoper = $_SESSION['gebruikersnaam'];
    $looptijdBegin = date("Y-m-d G:i:s",time());
    $verkoopprijs = $startprijs;
    $veilinggesloten = 0;
    if($beschrijving == null){
        $beschrijving = " ";
    }
    $eindtijd = date('Y-m-d H:i:s', strtotime($looptijdBegin . " + {$looptijd} days"));


    $params = array($voorwerpnummer, $titel, $beschrijving, $startprijs, $betalingswijze, $betalingsinstructies,
        $plaatsnaam, $land, $looptijd, $looptijdBegin, $verzendkosten, $verzendinstructies, $verkoper,
        $veilinggesloten, $verkoopprijs, $eindtijd);

     $conn = getConn();
    $sql = "INSERT INTO Voorwerp(Voorwerpnummer, Titel, Beschrijving, Startprijs, Betalingswijze, Betalingsinstructie, 
Plaatsnaam, Land, MaximaleLooptijd, Looptijdbegin, Verzendkosten, Verzendinstructies, Verkoper,
VeilingGesloten, Verkoopprijs, LoopTijdEinde) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if(!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    else{
        $sql = "INSERT INTO Bestand(AfbeeldingURL, Voorwerpnummer) VALUES(?,?);";
        $stmt = sqlsrv_prepare($conn, $sql, array($afbeeldingURL, $voorwerpnummer));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if(!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        $sql = "INSERT INTO VoorwerpInRubriek(Voorwerpnummer, RubriekID) VALUES(?,?);";
        $stmt = sqlsrv_prepare($conn, $sql, array($voorwerpnummer, $rubriekID));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if(!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}

/**
 * Functie die een nieuw voorwerpnummer returned
 * @author Rens Harinck
 * @uses file('DatabaseConn.php')
 * @return int nieuw voorwerpnummer
 */
function getNewVoorwerpnummer(){
    $conn = getConn();
    $sql = "SELECT MAX(Voorwerpnummer)+1 as nummer FROM Voorwerp;";
    $stmt = sqlsrv_prepare($conn, $sql);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_execute($stmt);
    if($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            return $row['nummer'];
        }
    }
    else{
        die(print_r(sqlsrv_errors(), true));
    }
    return "a";
}