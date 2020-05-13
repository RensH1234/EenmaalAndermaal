<?php
include_once 'framework.php';
include_once 'php classes/Header.php';
?>
<?php include 'h_test.php'; ?>
<h1>TESTPAGINA</h1>
<?php
$header= new Header();
$header->_test();

echo basename(__FILE__)
?>