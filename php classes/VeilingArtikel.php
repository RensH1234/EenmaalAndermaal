<?php
include_once 'DatabaseConn.php';

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
                $this->eindtijd=($row['LoopTijdEinde']->format('Y-m-d H:i:s'));
                $this->id = $row['Voorwerpnummer'];
            }
        }
        else {
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
        }

        else {
            die(print_r(sqlsrv_errors(), true));
        }

        if($this->afbeeldingURL==null){
            $this->afbeeldingURL="images/png/logov1.png";
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

    private $Aantalbiedingen;
    private $Minimumprijs;

    private $AfbeeldingURL;

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
                $this->Minimumprijs = "Sample Text";

            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    //Functie die op basis van geldigheid van veiling een andere string returnt
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
    function _telAantalBiedingen()
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

    function _volgende(){

    }

    //functie die de gehele veilingpagina inhoud genereert
    function _printArtikel()
    {
        $artikel = "<div class='container mt-2'><div class='container'><div class='row'>";
        $artikel .= "<div class='col border'><img src=$this->AfbeeldingURL class='rounded' alt=$this->Titel width='480' height='360'></div>";
        $artikel .= "<div class='col border'><h1 class='text-center font-weight-bold'>$this->Titel</h1><div class='row'>";
        $artikel .= $this->_isGesloten();
        $artikel .= "</h4></div></div>";
        $artikel .= "<div class='row'><div class='col border text-muted mt-2'>Huidige Bod</div>";
        $artikel .= "<div class='col border text-muted mt-2'>Aantal Biedingen</div></div>";
        $artikel .= "<div class='row'><div class='col border font-weight-bold mb-2'>€ $this->Verkoopprijs</div>";
        $artikel .= "<div class='col border font-weight-bold mb-2'>$this->Aantalbiedingen</div></div>";
        $artikel .= "<div class='row'><div class='col border mt-2'>";
        $artikel .= "<h6 class='text-muted'>Minimum volgend bod: € $this->Minimumprijs</h6></div></div>";
        $artikel .= "<div class='row justify-content-center'><div class='col border'>";
        $artikel .= "<input type='button' class='btn btn-primary btn-lg btn-block' value='Plaats Bod'></div></div>";
        $artikel .= "<div class='row mt-2'><div class='col-1 border'><h5 class='text-muted'>✓</h5></div>";
        $artikel .= "<div class='col border'><h5 class='text-muted'>Georganiseerd door $this->Verkoper</h5></div></div>";
        $artikel .= "<div class='row'><div class='col-1 border'><h5 class='text-muted'>⮙</h5></div>";
        $artikel .= "<div class='col border'><h5 class='text-muted'>$this->Plaatsnaam, $this->Land</h5></div></div>";
        $artikel .= "<div class='row'><div class='col-1 border'><h5 class='text-muted'>€</h5></div>";
        $artikel .= "<div class='col border'><h5 class='text-muted'>Betalingswijze: $this->Betalingswijze</h5></div></div>";
        $artikel .= "<div class='row'><div class='col-1 border'><h5 class='text-muted'>🛈</h5></div>";
        $artikel .= "<div class='col border'><h5 class='text-muted'>BetalingInstructie: $this->Betalingsinstructie</h5></div></div>";
        $artikel .= "<div class='row'><div class='col-1 border'><h5 class='text-muted'>€</h5></div>";
        $artikel .= "<div class='col border'><h5 class='text-muted'>Verzendkosten: $this->Verzendkosten</h5></div></div>";
        $artikel .= "<div class='row'><div class='col-1 border'><h5 class='text-muted'>✄</h5></div>";
        $artikel .= "<div class='col border'><h5 class='text-muted'>Verzendwijze: $this->Verzendinstructies</h5></div></div>";
        $artikel .= "<div class='row'><div class='col-1 border'><h5 class='text-muted'>▪</h5></div>";
        $artikel .= "<div class='col border'><h5 class='text-muted'>Kavelnummer: $this->Id</h5></div></div>";
        $artikel .= "</div ></div>";
        $artikel .= "<div class='row'><div class='col border'>";
        $artikel .= "<h5 class='font-weight-bold'>Beschrijving:</h5></div><div class='col'></div></div>";
        $artikel .= "<div class='row'><div class='col border'>$this->Beschrijving</div>";
        $artikel .= "<div class='col border'></div></div></div></div></div>";
        echo $artikel;
    }
}
