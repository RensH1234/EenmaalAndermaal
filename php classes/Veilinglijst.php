<?php
include 'VeilingArtikel.php';
class Veilinglijst
{
    private $veilingArtikelen = array();
    private $selectQuery;
    private $maxVeilingArtikelen;
    private $naam;

    // worden bij intregratie database gebruikt
//    private $huidigeTijd = date("d/m/Y");
//    private $huidigeDatum = date("h:i:sa");

    //constructor voor veilinglijst
    public function _construct($maxVeilingArtikelen, $query, $naam){
        $this->maxVeilingArtikelen = $maxVeilingArtikelen;
        $this->selectQuery=$query;
        $this->maakArtikelen();
        $this->naam=<<<HTML
<h2>$naam</h2>
HTML;

    }

    //maak artikelen aan
    private function maakArtikelen(){
        for($i = 0; $i < $this->maxVeilingArtikelen; $i++){
            $this->veilingArtikelen[$i] = new VeilingArtikel();
            $this->veilingArtikelen[$i]->_construct();
        }
    }

    public function printVeilinglijst(){
        echo $this->naam;
        echo "<div class='scrolllist'>";
        for($i = 0; $i < $this->maxVeilingArtikelen; $i++){
            echo $this->veilingArtikelen[$i]->printArtikel();
        }
        echo "</div>";
    }
}
