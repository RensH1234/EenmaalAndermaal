<?php

class VeilingArtikel
{
    private $titel;
    private $afbeeldingURL;
    private $afstand;
    private $prijs;
    private $eindtijd;

    //constructor query
//   function _construct(private $subQuery){
//    //database moet nog worden geregeld
//}

    //constructor default
    function _construct(){
        $this->titel = "Titel";
        $this->afbeeldingURL = "https://www.wplounge.nl/wp-content/uploads/2015/01/wordpress-veiling-website.png";
        $this->afstand = "21 KM";
        $this->prijs = "$69";
        $this->eindtijd = "12:00 PM";
    }

    function _VeilingArtikel($titel, $url, $afstand, $prijs, $eindtijd){
        $this->titel = "Titel";
        $this->afbeeldingURL = "https://www.wplounge.nl/wp-content/uploads/2015/01/wordpress-veiling-website.png";
        $this->afstand = "21 KM";
        $this->prijs = "$69";
        $this->eindtijd = "12:00 PM";
    }

    function _printArtikel($naam, $url, $huidigeBod,$huidigeTijd, $aantalBod, $minBod, $verkoperInfo, $omschrijving)
    {
        $artikel = "<div class='container mt-2'><div class='container'><div class='row'><div class='col border'>";
        $artikel .= "<img src=$url class='rounded' alt=$naam width=>$url->width height=>$url->width></div>";
        $artikel .= "<div class='col border'><h1 class='text-center'>$naam</h1><div class='row'>";
        $artikel .= "<div class='col border'><h2 class='text-center'>$huidigeTijd</h2></div></div>";
        $artikel .= "<div class='row'><div class='col border'><p class='text-center'>$huidigeBod</p></div>";
        $artikel .= "<div class='col border'><p class='text-center'>$aantalBod</p></div></div>";
        $artikel .= "<div class='row'><div class='col border'><p class='text-center'>$minBod></p></div></div>";
        $artikel .= "<div class='row'><div class='col border'><h3 class='text-center'>&ltPlaatsBod&gt</h3></div></div>";
        $artikel .= "<div class='row'><div class='col mt-2'><p></p><p>$verkoperInfo</p></div></div></div></div>";
        $artikel .= "<div class='row'><div class='col border'><p>$omschrijving</p></div>";
        $artikel .= "<div class=\"col border\"></div></div></div></div>";
        echo $artikel;
    }

    function getTitel(){
        return $this->titel;
    }

    function getURL(){
        return $this->afbeeldingURL;
    }

    function getAfstand(){
        return $this->afstand;
    }

    function getPrijs(){
        return $this->prijs;
    }

    function getEindtijd(){
        return $this->eindtijd;
    }

    //functie voor html-code
    function  printArtikel(){
        return <<<HTML
    <article class="VeilingArtikel_article">
    <h2 class="VeilingArtikel_titel">$this->titel</h2>
    <img class="VeilingArtikel_img img-fluid" src=$this->afbeeldingURL alt="">
    <p class="VeilingArtikel_afstand">Op  $this->afstand afstand</p>
    <p class="VeilingArtikel_prijs">$this->prijs</p>
    <p class="VeilingArtikel_eindtijd">Eindigt om $this->eindtijd</p>
</article>
HTML;
    }
}

//Constructor voor Enkele Artikel in Veilingpagina
class Artikel{
    //Lokale variabelen
    //Database variabelen worden hierin verwerkt
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
    public function _construct($Titel,$Beschrijving, $AfbeeldingURL, $startprijs, $Betalingswijze, $Betalingsinstructie, $Plaatsnaam,
                               $Land, $MaximaleLooptijd, $Looptijdbegin, $Verzendkosten, $Verzendinstructies, $Verkoper,
                               $Koper, $LooptijdEinde, $VeilingGesloten, $Verkoopprijs, $Aantalbiedingen, $Minimumprijs){
        $this->Titel = $Titel;
        $this->Beschrijving = $Beschrijving;
        $this->AfbeeldingURL = $AfbeeldingURL;
        $this->startprijs = $startprijs;
        $this->Betalingswijze = $Betalingswijze;
        $this->Betalingsinstructie = $Betalingsinstructie;
        $this->Plaatsnaam = $Plaatsnaam;
        $this->Land = $Land;
        $this->MaximaleLooptijd = $MaximaleLooptijd;
        $this->Looptijdbegin = $Looptijdbegin;
        $this->Verzendkosten = $Verzendkosten;
        $this->Verzendinstructies = $Verzendinstructies;
        $this->Verkoper = $Verkoper;
        $this->Koper = $Koper;
        $this->LooptijdEinde = $LooptijdEinde;
        $this->VeilingGesloten = $this->_isGesloten($VeilingGesloten);
        $this->Verkoopprijs = $Verkoopprijs;
        $this->Aantalbiedingen = $Aantalbiedingen;
        $this->Minimumprijs = $Minimumprijs;
    }
    //Functie die op basis van geldigheid van veiling een andere string returnt
    function _isGesloten($bool){
        if ($bool){
            return "Deze Veiling is Gesloten!";
        }
        return "Sluit in";
    }
    //functie die de gehele veilingpagina inhoud genereert
    function _printArtikel()
    {
        $artikel = "<div class='container mt-2'><div class='container'><div class='row'><div class='col border'>";
        $artikel .= "<img src=$this->AfbeeldingURL class='rounded' alt=$this->Titel></div>";
        $artikel .= "<div class='col border'><h1 class='text-center'>$this->Titel</h1><div class='row'>";
        $artikel .= "<div class='col border '><p class='text-center alert-danger rounded'>$this->VeilingGesloten</p></div></div>";
        $artikel .= "<div class='row'><div class='col border'><p class='text-center'>Huidige Bod: €$this->Verkoopprijs</p></div>";
        $artikel .= "<div class='col border'><p class='text-center'>Aantal Biedingen: $this->Aantalbiedingen</p></div></div>";
        $artikel .= "<div class='row'><div class='col border'><p class='text-center'>Minimum Bod: €$this->Minimumprijs</p></div></div>";
        $artikel .= "<div class='row justify-content-center'><div class='col-0 mt-2 border'><input type='button' class='btn btn-light btn-lg btn-block' value='Plaats Bod'></div></div>";
        $artikel .= "<div class='row'><div class='col'><p></p><p>Over de Verkoper: $this->Verkoper</p></div></div></div></div>";
        $artikel .= "<div class='row'><div class='col border'><p>Omschrijving: $this->Beschrijving</p></div>";
        $artikel .= "<div class=\"col border\"></div></div></div></div>";
        echo $artikel;
    }
}
