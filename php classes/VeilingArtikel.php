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
