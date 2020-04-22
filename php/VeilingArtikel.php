<?php

class VeilingArtikel
{
    private $titel;
    private $afbeeldingURL;
    private $afstand;
    private $prijs;
    private $eindtijd;

//   function _construct(private $subQuery){
//    //database moet nog worden geregeld
//}
    function _construct(){
        $this->titel = "titel";
        $this->afbeeldingURL = "https://www.wplounge.nl/wp-content/uploads/2015/01/wordpress-veiling-website.png";
        $this->afstand = "21 KM";
        $this->prijs = "$69";
        $this->eindtijd = "12:00";
    }
    function  printArtikel(){
        return <<<HTML
    <article class="VeilingArtikel_article">
    <h2 class="VeilingArtikel_titel">$this->titel</h2>
    <img class="VeilingArtikel_img" src=$this->afbeeldingURL alt="">
    <p>$this->afstand</p>
    <p>$this->prijs</p>
    <p>$this->eindtijd</p>
</article>
HTML;
    }
}
