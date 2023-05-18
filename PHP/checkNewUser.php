<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$response = array();
session_start();
if (isset($_GET["email"])) {
    $result="";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->checkEmail($_GET["email"]);
    $connessione->closeConnection();
    
    if (isset($result)) {
        $response["trovato"] = true;
    }
    else
    {
        $response["trovato"] = false;
    }
}
if (isset($_GET["user"])) {
    $result="";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->checkUsern($_GET["user"]);
    $connessione->closeConnection();
    
    if (isset($result)) {
        $response["trovato"] = true;
    }
    else
    {
        $response["trovato"] = false;
    }
}
echo json_encode($response);
?>
