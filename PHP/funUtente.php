<?php
require_once "connessione.php";
require_once "classUtente.php";
use DB\DBAccess;

// autenticazione
/*
if (isset($_POST["userId"], $_POST["delete"])) {
    $connessione = new DBAccess();
    $connessioneRiuscita = $connessione->openDBConnection();
    
    if ($connessioneRiuscita) {
        $connessione->deleteUtente($_POST["userId"]);
    }

    $connessione->closeConnection();
    
}*/

if (isset($_POST["userId"], $_POST["delete"])) {
    utente::get();
}

header("Location: ../utenti.php");
?>