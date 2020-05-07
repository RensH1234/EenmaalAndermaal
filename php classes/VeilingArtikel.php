<?php
include_once 'includes/DatabaseConn.php';
include_once 'includes/sqlsrvPHPFuncties.php';

class VeilingArtikel
{
    private $titel;
    private $afbeeldingURL;
    private $afstand;
    private $prijs;
    private $eindtijd;



    //constructor default
    function _construct($id)
    {
        $conn = getConn();
        $sql = "SELECT * FROM Voorwerp v INNER JOIN Bestand b On v.Voorwerpnummer = b.Voorwerpnummer WHERE 
v.Voorwerpnummer = ?;";
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_execute($stmt);
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $this->titel = $row['Titel'];
                $this->afbeeldingURL = $row['AfbeeldingURL'];
                $this->afstand = $row['Plaatsnaam'];
                $this->prijs = $row['Verkoopprijs'];
                $this->eindtijd = $row['MaximaleLooptijd'];
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    function printArtikel()
    {
        return <<<HTML
    <article class="VeilingArtikel_article">
    <h2 class="VeilingArtikel_titel">$this->titel</h2>
    <img class="VeilingArtikel_img img-fluid" src=$this->afbeeldingURL alt="">
    <p class="VeilingArtikel_afstand">Op  $this->afstand afstand</p>
    <p class="VeilingArtikel_prijs">€ $this->prijs</p>
    <p class="VeilingArtikel_eindtijd">Eindigt om $this->eindtijd</p>
</article>
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
    private $LooptijdEinde;
    private $VeilingGesloten;
    private $Verkoopprijs;

    private $Aantalbiedingen;
    private $Minimumprijs;

    private $AfbeeldingURL;

    //Constructor
    public function _getFromVoorwerp($id)
    {
        $conn = getConn();
        $sql = "SELECT * FROM Voorwerp v INNER JOIN Bestand b On v.Voorwerpnummer = b.Voorwerpnummer WHERE 
v.Voorwerpnummer = ?;";
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
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
                $this->Looptijdbegin= $row['Looptijdbegin'];
                $this->Verzendkosten = $row['Verzendkosten'];
                $this->Verzendinstructies = $row['Verzendinstructies'];
                $this->Verkoper = $row['Verkoper'];
                $this->Koper = $row['Koper'];
                $this->LooptijdEinde = $row['LooptijdEinde'];
                $this->VeilingGesloten = $row['VeilingGesloten'];
                $this->MaximaleLooptijd =$row['MaximaleLooptijd'];
                $this->Verkoopprijs=$row['Verkoopprijs'];
                $this->AfbeeldingURL = $row['AfbeeldingURL'];
                $this->VeilingGesloten = $this->_isGesloten("Sample Text");
                $this->Aantalbiedingen = "Sample Text";
                $this->Minimumprijs = "Sample Text";
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    //Functie die op basis van geldigheid van veiling een andere string returnt
    function _isGesloten($bool)
    {
        if ($bool) {
            return "Deze Veiling is Gesloten!";
        }
        return "Sluit in";
    }

    //functie die de gehele veilingpagina inhoud genereert
    function _printArtikel()
    {
        $artikel = "<div class='container mt-2'><div class='container'><div class='row'>";
        $artikel .= "<div class='col border'><img src=$this->AfbeeldingURL class='rounded' alt=$this->Titel width='480' height='360'></div>";
        $artikel .= "<div class='col border'><h1 class='text-center font-weight-bold'>$this->Titel</h1><div class='row'>";
        $artikel .= "<div class='col border text-center alert-danger rounded mt-2'>$this->VeilingGesloten</div></div>";
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
