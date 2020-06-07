<?php
require 'SessionHandling/Session.php';
require 'php classes/Advertentie.php';

include 'Functions.php';

$title = 'Eenmaal Andermaal!';
$siteNaam = 'Selecteer verkooprubriek';
$huidigeJaar = date('Y');

$rubriekSelectie = new Advertentie();

if(!is_logged_in() || !is_verkoper()){
    header('location: inloggen.php');
}

print_r($_SESSION);

if ($rubriekSelectie->_inputCheck()) {
    unset($_SESSION['verkooprubriek']);
    end($_POST);
    $_SESSION['verkooprubriek'] = prev($_POST);
    header('location: GegevensAdvertentie.php');
}
include_once 'Header.php';
?>
<!doctype html>
<html lang="nl">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,
    minimum-scale=1.0" charset="UTF-8">
    <title><?= $title ?> | <?= $siteNaam ?></title>
    <link rel="stylesheet" href="Custom_css/custom%20stylesheet.css">
    <script type="text/javascript">
        function submitForm(action) {
            var form = document.getElementById('form1');
            form.action = action;
            form.submit();
        }
        function resetForm() {
            document.getElementById('hoofdrubriek').disabled = false;
            document.location.href = 'Verkopen.php';
        }
    </script>
    <?php include 'Framework.php';?>
</head>
<body>
<main>
    <?php include_once 'Header.php'; ?>
    <div class="container-fluid">
        <div class="row-sm justify-content-center">
            <div class="col text-center">
                <form action="Verkopen.php" method="POST" id="form1">
                    <div class="form-text">
                        <h2>Selecteer Rubriek</h2>
                    </div>
                    <div class="form-group">
                        <?php echo $rubriekSelectie->_generateRubriekVerkoopList(-1, $rubriekSelectie->_getRubriekFromDb(),
                            "hoofdrubriek");
                        ?>
                    </div>
                    <script type="text/javascript">
                        document.getElementById('hoofdrubriek').value = "<?php echo $_POST['hoofdrubriek'];?>";
                    </script>
                    <?php $rubriekSelectie->_generateSelection(); ?>
                    <div class="form-group">
                        <button type="reset" onclick="resetForm()">Reset</button>
                        <button type="submit" name="verder" id="verder" <?php
                        if ($rubriekSelectie->_childexists(end($_POST),
                                $rubriekSelectie->_getRubriekFromDb()) || !isset($_POST['hoofdrubriek'])) { ?> disabled <?php } ?>
                                onclick="submitForm('Verkopen.php')">Verder
                        </button>
                        <button onclick="location.href='Index.php'">Annuleren</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php _generateFooter(date('Y')) ?>
</body>
</html>


