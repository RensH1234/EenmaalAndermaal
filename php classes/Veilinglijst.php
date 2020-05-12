<?php
require 'VeilingArtikel.php';
class Veilinglijst
{
    private $veilingArtikelen = array();
    private $voorwerpnummers = array();
    private $naam;

    // worden bij intregratie database gebruikt
//    private $huidigeTijd = date("d/m/Y");
//    private $huidigeDatum = date("h:i:sa");

    //constructor voor veilinglijst
    public function _construct($voorwerpnummers,$naam,$cssID){
        $this->maakArtikelen();
        $this->voorwerpnummers=$voorwerpnummers;
        $this->naam=<<<HTML
<div class="row" id="$cssID"><h2>$naam</h2>
HTML;

    }

    //maak artikelen aan
    private function maakArtikelen(){
        for($i = 0; $i < sizeof($this->voorwerpnummers); $i++){
            $this->veilingArtikelen= new VeilingArtikel();
            $this->veilingArtikelen[$i]->_construct($this->voorwerpnummers[$i]);
        }
    }

    public function printVeilinglijst(){
        echo $this->naam;
        echo "<div class='scrolllist'>";
        for($i = 0; $i < sizeof($this->voorwerpnummers); $i++){
            $a = new VeilingArtikel();
            $a->_construct($this->voorwerpnummers[$i]);
            echo $a->printArtikel();
        }
        echo "</div></div>";
    }
    public function printVeilingen(){
        echo $this->naam;
        echo "<div class='col-sm'>";
        for($i = 0; $i < sizeof($this->voorwerpnummers); $i++){
            $a = new VeilingArtikel();
            $a->_construct($this->voorwerpnummers[$i]);
            echo $a->printArtikel();
        }
        echo "</div></div>";
    }
}
