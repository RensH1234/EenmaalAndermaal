<?php
include_once 'DatabaseConn.php';
include_once 'Biedingmachine.php';

/**
 *  Class VeilingArtikel genereert een weergave voor een artikel uit de database
 * @author Rens Harinck
 * @uses file('DatabaseConn.php')
 */
class VeilingArtikel
{
    private $titel;
    private $afbeeldingURL;
    private $afstand;
    private $prijs;
    private $eindtijd;
    private $id;

    //constructor default
    /**
     * Constructor VeilingArtikel die gegevens uit database haalt
     * @author Rens Harinck
     * @uses file('DatabaseConn.php')
     * @param int $id voorwerpnummer van voorwerp uit database
     */
    function _construct($id)
    {
        $conn = getConn();
        $sql = "SELECT * FROM Voorwerp  WHERE 
Voorwerpnummer = ?;";
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->titel = $row['Titel'];
                $this->afstand = $row['Plaatsnaam'];
                $this->prijs = $row['Verkoopprijs'];
                if ($row['LoopTijdEinde'] != null) {
                    $this->eindtijd = ($row['LoopTijdEinde']->format('Y-m-d H:i:s'));
                } elseif ($row["MaximaleLooptijd"] != null && $row["Looptijdbegin"]) {
                    $date = $row["Looptijdbegin"]->format('Y-m-d H:i:s');
                    $this->eindtijd = date('Y-m-d H:i:s', strtotime($date . " + {$row["MaximaleLooptijd"]} days"));
                }
                $this->id = $row['Voorwerpnummer'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
        $sql = "SELECT top(1) * FROM Bestand WHERE Voorwerpnummer = ?;";
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);

        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->afbeeldingURL = $row['AfbeeldingURL'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($this->afbeeldingURL == null) {
            $this->afbeeldingURL = "images/png/logov1.png";
        }
    }
    /**
     * Constructor VeilingArtikel die gegevens uit opgegeven array haalt
     * @author Rens Harinck
     * @param int $arrayVoorwerp array met gegevens artikel
     */
    function _constructArray($arrayVoorwerp)
    {
        $this->titel = $arrayVoorwerp[1];
        $this->afstand = $arrayVoorwerp[2];
        $this->prijs = $arrayVoorwerp[3];
        if ($arrayVoorwerp[4] != null) {
            $this->eindtijd = ($arrayVoorwerp[4]->format('Y-m-d H:i:s'));
        } elseif ($arrayVoorwerp[5] != null && $arrayVoorwerp[6]) {
            $date = $arrayVoorwerp[6]->format('Y-m-d H:i:s');
            $this->eindtijd = date('Y-m-d H:i:s', strtotime($date . " + {$arrayVoorwerp[5]} days"));
        }
        $this->afbeeldingURL = $arrayVoorwerp[7];
        $this->id = $arrayVoorwerp[0];
        if ($this->afbeeldingURL == null) {
            $this->afbeeldingURL = "images/png/logov1.png";
        }
    }

    /**
     * Functie die het artikel returned
     * @author Rens Harinck
     * @return string html van VeilingArtikel.php
     */
    function printArtikel()
    {
        if(strpos($this->afbeeldingURL,'dt_')===0) {
            $url = 'http://iproject12.icasites.nl/pics/';
        }
        else{
            $url= null;
        }
        return <<<HTML
<div class="card text-center" style="width: 18rem;">
  <img class="card-img-top" src=$url$this->afbeeldingURL alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">$this->titel</h5>
    <p class="card-text">Locatie: $this->afstand</p>
    <p class="card-text">Prijs: $this->prijs</p>
    <p class="card-text">Einde veiling: <span id="$this->id"></span></p>
    <form action="Veiling.php" method="get">
    <input name="id" type="hidden" value="$this->id">
    <button class="btn-dark"  type="submit"> Informatie Veiling </button>
</form>
  </div>
</div>
<script>
var countDownDate$this->id = new Date("$this->eindtijd").getTime();
var x$this->id = setInterval(function() {
  var now$this->id = new Date().getTime();
  var distance$this->id = countDownDate$this->id - now$this->id;
  var days$this->id = Math.floor(distance$this->id / (1000 * 60 * 60 * 24));
  var hours$this->id = Math.floor((distance$this->id % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes$this->id = Math.floor((distance$this->id % (1000 * 60 * 60)) / (1000 * 60));
  var seconds$this->id = Math.floor((distance$this->id % (1000 * 60)) / 1000);
  document.getElementById("$this->id").innerHTML = days$this->id + "d " + hours$this->id + "h "
  + minutes$this->id + "m " + seconds$this->id + "s ";
  if (distance$this->id < 0) {
    clearInterval(x$this->id);
    document.getElementById("$this->id").innerHTML = "Veiling is afgelopen";
  }
}, 1000);
</script>

HTML;
    }

}

/**
 *  * Class Artikel Maakt een object aan die een veilingartikel aanmaakt en beheert
 * @author Yasin Tavsan
 */
class Artikel
{
    private $Id;
    private $Titel;
    private $Beschrijving;
    private $startprijs;
    private $Betalingswijze;
    private $Betalingsinstructie;
    private $Plaatsnaam;
    private $Land;
    private $MaximaleLooptijd;
    private $Looptijdbegin;
    private $Verzendkosten;
    private $Verzendinstructies;
    private $Verkoper;
    private $Koper;
    private $LoopTijdEinde;
    private $VeilingGesloten;
    private $Verkoopprijs;
    private $VeilingStatus;

    private $Aantalbiedingen;
    private $Minimumprijs;

    private $AfbeeldingURL = array();

    private $biedingenHTML;
    private $url = 'http://iproject12.icasites.nl/pics/';
    private $aantalAfbeeldingen;

    /**
     * Functie die de veilinggegevens ophaalt van de database
     * @author Yasin Tavsan
     * @param $id integer Voorwerpnummer wiens veilinggegevens worden opgehaald
     */
    public function _getVeilingGegevens($id)
    {
        $conn = getConn();
        $sql1 = "SELECT count(b.voorwerpnummer) as aantalAfbeeldingen FROM Voorwerp v INNER JOIN Bestand b On v.Voorwerpnummer = b.Voorwerpnummer where v.voorwerpnummer=?;";
        $stmt = sqlsrv_prepare($conn, $sql1, array($id));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->aantalAfbeeldingen = $row['aantalAfbeeldingen'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
        if($this->aantalAfbeeldingen > 4) {
            $this->aantalAfbeeldingen = 4;
        }

        $conn = getConn();
        $sql1 = "SELECT * FROM Voorwerp v INNER JOIN Bestand b On v.Voorwerpnummer = b.Voorwerpnummer WHERE v.Voorwerpnummer = ?;";
        $stmt = sqlsrv_prepare($conn, $sql1, array($id));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->Id = $row['Voorwerpnummer'];
                $this->Titel = $row['Titel'];
                $this->Beschrijving = $row['Beschrijving'];
                $this->startprijs = $row['Startprijs'];
                $this->Betalingswijze = $row['Betalingswijze'];
                $this->Betalingsinstructie = $row['Betalingsinstructie'];
                $this->Plaatsnaam = $row['Plaatsnaam'];
                $this->Land = $row['Land'];
                $this->Looptijdbegin = $row['Looptijdbegin'];
                $this->Verzendkosten = $row['Verzendkosten'];
                $this->Verzendinstructies = $row['Verzendinstructies'];
                $this->Verkoper = $row['Verkoper'];
                $this->Koper = $row['Koper'];
                $this->LoopTijdEinde = $row['LoopTijdEinde'];
                $this->VeilingGesloten = $row['VeilingGesloten'];
                $this->MaximaleLooptijd = $row['MaximaleLooptijd'];
                $this->Verkoopprijs = $row['Verkoopprijs'];
                $this->VeilingStatus = $this->_isGesloten();
                $this->Minimumprijs = "Sample Text";
            }
        }
        for($i=0; $i<$this->aantalAfbeeldingen; $i++){
        $conn = getConn();
        $sql1 = "SELECT top($i+1) b.AfbeeldingURL FROM Voorwerp v INNER JOIN Bestand b On v.Voorwerpnummer = b.Voorwerpnummer WHERE v.Voorwerpnummer = ?;";
        $stmt = sqlsrv_prepare($conn, $sql1, array($id));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->AfbeeldingURL[$i] = $row['AfbeeldingURL'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
        $this->setBiedingen(0, 0);
        }
    }

    /**
     * Functie die op basis van geldigheid van de veiling een bericht meegeeft.
     * @author Yasin Tavsan
     * @return string
     */
    function _isGesloten()
    {
        $datum = date_format($this->LoopTijdEinde, "Y/m/d");
        $tijd = date_format($this->LoopTijdEinde, "H:i:s");
        if ($this->VeilingGesloten) {
            $str = "<div class='col border text-center alert-danger rounded mt-2'><h4>";
            $str .= "Deze Veiling is Gesloten!";
            return $str;

        }
        $str = "<div class='col border text-center alert-info rounded mt-2'><h4>";
        $str .= "Deze veiling sluit op $datum om $tijd";
        return $str;
    }

    /**
     * Functie die alle biedingen op het veilingartikel telt
     * @author Yasin Tavsan
     */
    function _getAantalBiedingen()
    {
        $conn = getConn();
        $sql = "SELECT COUNT(Voorwerpnummer) AS AantalBiedingen FROM Bod WHERE Voorwerpnummer = ?;";
        $stmt = sqlsrv_prepare($conn, $sql, array($this->Id));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->Aantalbiedingen = $row['AantalBiedingen'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    /**
     * Functie die op basis van de vorige en volgende knoppen daar de desbetreffende veiling gaat
     * @author Yasin Tavsan
     * @param $hdg boolean geeft aan of de vorige of volgende item moet worden opgehaald
     */
    function _gotoVeiling($hdg)
    {
        $conn = getConn();
        if ($hdg) {
            $sql = "SELECT Voorwerpnummer FROM Voorwerp where Voorwerpnummer = 
                                          (SELECT min(Voorwerpnummer) from Voorwerp where Voorwerpnummer > ?)";
        } else {
            $sql = "SELECT Voorwerpnummer FROM Voorwerp where Voorwerpnummer = 
                                          (SELECT max(Voorwerpnummer) from Voorwerp where Voorwerpnummer < ?)";
        }
        $stmt = sqlsrv_prepare($conn, $sql, array($_GET['id']));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo $row['Voorwerpnummer'];
            }
        } else {
            echo $_GET['id'];
        }
    }

    public function setBiedingen($optie, $bedrag)
    {
        $biedingen = new Biedingmachine();
        //de boolean waarde moet controleren of er is ingelogd. Met het maken van de inlogfunctie moet dit worden gemaakt.
        if (array_key_exists('ingelogd', $_SESSION)) {
            $biedingen->_construct($this->Id, $_SESSION['ingelogd'], $_SESSION['gebruikersnaam']);
        } else {
            $biedingen->_construct($this->Id, false, null);
        }
        if ($optie == 1) {
            $biedingen->submitBod($bedrag);
        }
        $this->biedingenHTML = $biedingen->printBiedingmachine();
    }

    /**
     * Functie die de gehele veilingpagina inhoud genereert
     * @author Yasin Tavsan & Rens harinck & Bas Ruijs
     */
    function _printArtikel()
    {
        $foto=array();
        $beschrijvingNoHtmlTag = $this->Beschrijving;
        $beschrijvingNoHtmlTag = strip_tags($beschrijvingNoHtmlTag);
        for($i=0; $i<$this->aantalAfbeeldingen; $i++) {
            if(strpos($this->AfbeeldingURL[$i],'dt_')===0) {
                $foto[$i] = $this->url . $this->AfbeeldingURL[$i];
            }
            else{
                $foto[$i] = $this->AfbeeldingURL[$i];
            }
        }
        echo <<< ARTIKEL
<div class='container mt-2'><div class='container'>
<div class='row'>
<div class='container col '>
<div id="images" class="carousel slide " data-ride="carousel">
<ol class="carousel-indicators">
<li data-target="#images" data-slide-to="0" class="active"></li>
ARTIKEL;
    for($i=1; $i<$this->aantalAfbeeldingen; $i++) {
        echo "<li data-target=\"#images\" data-slide-to=\"$i\"></li>";
        }
echo <<<ARTIKEL
  </ol>
        <div class="carousel-inner">
             <div class="carousel-item active ">            
                <img class="d-block mx-auto mw-100 mh-100" src=$foto[0] alt="foto 1 ">
            </div>
ARTIKEL;
        for($i=1; $i<$this->aantalAfbeeldingen; $i++) {
            echo "<div class=\"carousel-item\" >
                <img class=\"d-block mx-auto mw-100 mh-100\" src = $foto[$i] alt = \"foto $i+1\" >
            </div >";
            }
    echo <<< ARTIKEL
        </div>
    <a class="carousel-control-prev" href="#images" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#images" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class='row'><div class='col'>
         </div><div class="col"></div></div>  
         <div class='row mt-2'><div class='col-1 '><h5 class='text-muted'>✓</h5></div>
         <div class='col '><h5 class='text-muted'>Georganiseerd door $this->Verkoper</h5></div></div>
         <div class='row'><div class='col-1 '><h5 class='text-muted'>⮙</h5></div>
         <div class='col '><h5 class='text-muted'>$this->Plaatsnaam, $this->Land</h5></div></div>
         <div class='row'><div class='col-1 '><h5 class='text-muted'>€</h5></div>
         <div class='col '><h5 class='text-muted'>Betalingswijze: $this->Betalingswijze</h5></div></div>
         <div class='row'><div class='col-1 '><h5 class='text-muted'>🛈</h5></div>
         <div class='col '><h5 class='text-muted'>BetalingInstructie: $this->Betalingsinstructie</h5></div></div>
         <div class='row'><div class='col-1 '><h5 class='text-muted'>€</h5></div>
         <div class='col '><h5 class='text-muted'>Verzendkosten: $this->Verzendkosten</h5></div></div>
         <div class='row'><div class='col-1 '><h5 class='text-muted'>✄</h5></div>
         <div class='col '><h5 class='text-muted'>Verzendwijze: $this->Verzendinstructies</h5></div></div>
         <div class='row'><div class='col-1 '><h5 class='text-muted'>▪</h5></div>
         <div class='col '><h5 class='text-muted'>Kavelnummer: $this->Id</h5></div></div>
</div> 
         <div class='col '><h1 class='text-center font-weight-bold'>$this->Titel</h1><div class='row'>
         $this->VeilingStatus
         </h4></div></div>
         <div class='row'><div class='col border text-muted mt-2'>Huidige Bod</div>
         <div class='col border text-muted mt-2'>Aantal Biedingen</div></div>
         <div class='row'><div class='col border font-weight-bold mb-2'>€ $this->Verkoopprijs</div>
         <div class='col border font-weight-bold mb-2'>$this->Aantalbiedingen</div></div>
         <div class='row justify-content-center'><div class='col'>
         $this->biedingenHTML</div></div>     
         </div>
         </div>
         <div class="row">
         <div class="row"><div class="col">
         <h5 class="font-weight-bold">Beschrijving:</h5>
         <h5 class="text-muted">$beschrijvingNoHtmlTag</h5></div><div class="col"></div></div>
                  </div>
         </div>  
         </div></div></div>
ARTIKEL;
    }
}