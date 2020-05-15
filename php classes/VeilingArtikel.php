<?php
include_once 'DatabaseConn.php';
include_once 'Biedingmachine.php';

class VeilingArtikel
{
    private $titel;
    private $afbeeldingURL;
    private $afstand;
    private $prijs;
    private $eindtijd;
    private $id;

    //constructor default
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
                $this->eindtijd = ($row['LoopTijdEinde']->format('Y-m-d H:i:s'));
                $this->id = $row['Voorwerpnummer'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
        $sql = "SELECT * FROM Bestand WHERE Voorwerpnummer = ?;";
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

    function printArtikel()
    {
        return <<<HTML
<div class="card">
  <img class="card-img-top" src=$this->afbeeldingURL alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">$this->titel</h5>
    <p class="card-text">Locatie: $this->afstand</p>
    <p class="card-text">Prijs: $this->prijs</p>
    <p class="card-text">Eindigt op: $this->eindtijd</p>
    <form action="Veiling.php" method="get">
    <input name="id" type="hidden" value="$this->id">
    <button class="btn-dark"  type="submit"> Informatie Veiling </button>
</form>
  </div>
</div>

HTML;
    }
}

//Constructor voor Enkele Artikel in Veilingpagina
class Artikel
{
    //Lokale variabelen
    //Database variabelen worden hierin verwerkt
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

    private $AfbeeldingURL;
    private $AantalVoorwerpen;

    private $biedingenHTML;

    //Constructor
    public function _getVeilingGegevens($id)
    {
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
                $this->AfbeeldingURL = $row['AfbeeldingURL'];
                $this->VeilingStatus = $this->_isGesloten();
                $this->Minimumprijs = "Sample Text";

            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
        $this->setBiedingen(0,0,0);
    }

    //Functie die op basis van geldigheid van de veiling een bericht meegeeft.
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

    //Functie die alle biedingen op het veilingartikel telt
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

    //Functie die het aantal veilingvoorwerpen retourneert
    function _getAantalVoorwerpen()
    {
        $conn = getConn();
        $sql = "SELECT COUNT(Voorwerpnummer) AS AantalVoorwerpen FROM Voorwerp";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->AantalVoorwerpen = $row['AantalVoorwerpen'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    //Functie die op basis van de vorige en volgende artikelknoppen gegevens ervan ophaalt
    function _gotoVeiling($hdg)
    {
        $this->_getAantalVoorwerpen();
        if ($hdg) {
            if ($_GET['id'] < $this->AantalVoorwerpen) {
                echo $_GET['id'] + 1;
            } else {
                echo $_GET['id'];
            }
        } else {
            if ($_GET['id'] > 1) {
                echo $_GET['id'] - 1;
            } else {
                echo $_GET['id'];
            }
        }
    }

    //functie die de printBiedingmachine uit Biedingmachine.php uitprint
    public function setBiedingen($optie,$bedrag,$gebruiker){
        $biedingen = new Biedingmachine();
        //de boolean waarde moet controleren of er is ingelogd. Met het maken van de inlogfunctie moet dit worden gemaakt.
        $biedingen->_construct($this->Id,true,$gebruiker);
        if($optie == 1&&$gebruiker !== 0){
            $biedingen->submitBod($bedrag);
        }
        $this->biedingenHTML = $biedingen->printBiedingmachine();
    }


    //functie die de gehele veilingpagina inhoud genereert
    function _printArtikel()
    {
        echo <<< ARTIKEL
<div class='container mt-2'><div class='container'>
<div class='row'>
<div class='col '><img src=$this->AfbeeldingURL class='rounded' alt=$this->Titel>
<div class='row'><div class='col'>
         <h5 class="font-weight-bold">Beschrijving:</h5></div><div class="col"></div></div>
         <div class="row"><div class="col">
         <h5 class="text-muted">$this->Beschrijving</h5></div><div class="col"></div></div>
         
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
         
         
         </div>
         
         
         </div></div></div>
ARTIKEL;
    }
}
