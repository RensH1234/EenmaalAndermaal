<?php
$dsn = "sqlsrv:Server=mssql2.iproject.icasites.nl,1433;Database=iproject12";
try
{
    $conn = new PDO($dsn, "iproject12", "NSgGF59F");
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $sql = "SELECT kolom1 FROM test1";

    foreach ($conn->query($sql) as $row)
    {
        print_r($row);
    }
    echo ('Done');
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>
