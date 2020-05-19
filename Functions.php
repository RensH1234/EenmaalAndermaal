<?php

//Function{
//$gebruikersnaam = ($_POST ['gebruikersnaam']);
//$wachtwoord = ($_POST ['wachtwoord']);
//
//    session_start();
//
//
//    if (isset($_POST['submitbutton'])) {
//        $gebruiker = $_POST['gebruikersnaam'];
//        $db_pw = $_POST['wachtwoord'];
//
//        if ($gebruikersnaam == "" && $db_pw == "") {
//            $_SESSION['ingelogd'] = true;
//        }
//    }
//
//    if (isset($_SESSION['ingelogd'])) {
//        $ingelogd = true;
//    }
//
//    if (isset($_POST['logoutbutton'])) {
//        $ingelogd = false;
//        session_destroy();
//    }
//
//    $conn = getConn();
//    $sql = "SELECT Gebruikersnaam,Wachtwoord FROM Gebruiker";
//
//
//
//}
















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

