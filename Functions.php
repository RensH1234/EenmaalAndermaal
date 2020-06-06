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

//samen met de email en de gebruikersnaam wordt een unieke hash aangemaakt, die uniek is per gebruiker.
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

function checkCode($code, $mode, $email){
    $mode = alterMode($mode);
    if(password_verify("{$mode}{$email}",$code)){
        return true;
        }
    return false;
}

function generateCode($mode,$email){
    $mode = alterMode($mode);
    return password_hash("{$mode}{$email}",PASSWORD_DEFAULT);
}

function alterMode($mode){
    return ($mode * $mode + (int)round($mode/10));
}

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

//verander de rol van een gebruiker in de database
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