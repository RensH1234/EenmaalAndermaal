<?php
include '../includes/Databases.php';

class VeilingArtikel
{
    private $titel;
    private $afbeeldingURL;
    private $afstand;
    private $prijs;
    private $eindtijd;

   // constructor query
   function _constructDB($voorwerpnummer){
        $queryTitel = 'SELECT Titel FROM Voorwerp WHERE Voorwerpnummer = :p1';
        $queryAfbeelding = 'SELECT afbeeldingURL FROM Bestand WHERE Voorwerpnummer = :p1';
        $queryLocatie = 'SELECT Plaatsnaam FROM Voorwerp WHERE Voorwerpnummer = :p1';
        $queryPrijs = 'SELECT Verkoopprijs FROM Voorwerp WHERE Voorwerpnummer = :p1';
        $queryTotaleDuur = 'SELECT MaximaleLooptijd FROM Voorwerp WHERE Voorwerpnummer = :p1';
        $queryStartDatum = "SELECT DATEADD(days,:p2,)LooptijdBegin FROM Voorwerp WHERE Voorwerpnummer = :p1";
        $this->titel = getArraySelection1Par($queryTitel, $voorwerpnummer)[0];
        $this->afbeeldingURL = getArraySelection1Par($queryAfbeelding, $voorwerpnummer)[0];
        $this->afstand = getArraySelection1Par($queryLocatie, $voorwerpnummer)[0];
        $this->prijs = getArraySelection1Par($queryPrijs, $voorwerpnummer)[0];
        $this->eindtijd = getArraySelection2Par($queryStartDatum,$voorwerpnummer,getArraySelection1Par($queryTotaleDuur, $voorwerpnummer)[0])[0];
    //database moet nog worden geregeld
}

    //constructor default
    function _construct(){
        $this->titel = "Titel";
        $this->afbeeldingURL = "https://www.wplounge.nl/wp-content/uploads/2015/01/wordpress-veiling-website.png";
        $this->afstand = "21 KM";
        $this->prijs = "$69";
        $this->eindtijd = "12:00 PM";
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
