<?php

//echo phpinfo();
// Server in the this format: <computer>\<instance name> or 
// <server>,<port> when using a non default port number
// Connect to MSSQL

/*
  Connect to the local server using Windows Authentication and specify
  the AdventureWorks database as the database in use. To connect using
  SQL Server Authentication, set values for the "UID" and "PWD"
  attributes in the $connectionInfo parameter. For example:
  $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>"AdventureWorks");
 */

function mssql_jp_connect() {

//    $serverName = "ANDYSTAR-PC\SQLEXPRESS";
//    $connectionInfo = array("UID" => "sa", "PWD" => "12345", "Database" => "excel_db", "CharacterSet" => 'utf-8');

    $serverName = "jaihojugal.mssql.somee.com";
    $connectionInfo = array("UID" => "jugalkishore", "PWD" => "8750788091", "Database" => "jaihojugal", "CharacterSet" => 'utf-8');

    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if ($conn) {
        return $conn;
    } else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($conn);
}

//-----------------------------------------------
// Perform operations with connection.
//-----------------------------------------------

/* Close the connection. */

/**
 * Common functions
 */
function pr($expression) {
    echo '<pre>';
    print_r($expression);
    echo '</pre>';
}

function pre($expression) {
    echo '<pre>';
    print_r($expression);
    echo '</pre>';
}
?>



