<?php
//om dit te laten werken, moet je 'sqlsrvConnectieGegevens' in een include zetten voordat je dit bestand in de include zet.
//De variabel $conn komt uit 'sqlsrvConnectieGegevens'. Deze wordt veel als parameter bij functies gevraagd.

//incompleet
function getEersteRijArray($conn, $sql){
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    else {
        return $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }
}
