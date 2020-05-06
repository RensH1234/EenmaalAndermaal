<?php
//om dit te laten werken, moet je 'sqlsrvConnectieGegevens' in een include zetten voordat je dit bestand in de include zet.
//De variabel $conn komt uit 'sqlsrvConnectieGegevens'. Deze roep je aan in het orginele phpbestand met getConn(). Deze functie staat in 'sqlsrvConnectieGegevens'

//retourneerd een gegeven uit de eerste rij van de $sql (selectie querie) gespecifeerd met kolomnaam
function getGegevenRij1GbOpKolomnaam($conn, string $sql, string $kolomnaam)
{
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        return $row[$kolomnaam];
    }
}

//retourneerd een gegeven uit de eerste rij van de $sql (selectie querie) gespecifeerd met kolomindex
function getGegevenRij1GbOpIndex($conn, string $sql, int $kolomindex)
{
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) {
        return $row[$kolomindex];
    }
}
