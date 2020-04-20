<?php
    $pictureFolder = 'item-pics/';
    // TODO: Veiling items uit database halen in plaats van hier hardcoden.
    $items = [
        [ 'id' => 1, 'naam' => 'Stofzuiger', 'prijs' => '&eur; 1,20', 'prijsInCenten' => 120, 'beschrijving' => 'Splinternieuw, altijd in de garage gestaan!' ],
        [ 'id' => 2, 'naam' => 'NES 8 bit', 'prijs' => '&eur; 100,- ', 'prijsInCenten' => 10000, 'beschrijving' => 'Teh original!', 'pic' => 'nes.jpeg'],
        [ 'id' => 3, 'naam' => 'TODO', 'prijsInCenten' => 0, 'beschrijving' => 'TODO']
    ];


    function bepaalPrintPrijzen($items) {
        $resultaat = [];
        foreach($items as $item) {
            $item += ['prijs' => bepaalPrintPrijs($items['prijs'])];
            $resultaat[] = $item;
        }
        return $resultaat;
    }

    /**
     * Zet een integer prijs in centen om naar print prijs met Euroteken ervoor.
     * Bijvoorbeeld input 120 geeft terug '€ 1,20'  (of eigenlijk '&eur; 1,20' i.v.m. HTML).
     * En 200 geeft terug '€ 2,-' (of eigenlijk '&eur; 2,-')
     */
    function bepaalPrintPrijs($prijsInCenten) {
        $euros = $prijsInCenten / 100;
        if ($prijsInCenten % 100===0) {
            return $euros . ',-';
        }
        $centen = $prijsInCenten % 100;
        return $euros . ',' . $centen;
    }

/**
 * Bepaal volledige pad van plaatje op basis van bestandsnaam.
 * @param $imageName, bijvoorbeeld 'leipe-nes.jpg'
 * @return string Bijvoorbeeld 'item-pics/leipe-nes.jpg'
 */
    function imagePath($imageName) {
        global $pictureFolder;
        return $pictureFolder . $imageName;
    }
?>
<?php include 'includes/header.php'; ?>
<h1>Nieuwste veiling items</h1>
<p>Hier zie je de nieuwste veiling items</p>
<?php foreach ($items as $item) { ?>
    <article>
        <h2><?= $item['naam'] ?></h2>
        <img src="<?php echo $pictureFolder . ($item['pic'] ?? 'no-pic.png') ?>" alt="<?= $item['naam'] ?>">
        <p><?= $item['beschrijving'] ?></p>
    </article>
<?php } ?>
