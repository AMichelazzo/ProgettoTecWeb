<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();

    $target="Elementi_Messaggi";

    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->getMessages();
    $connessione->closeConnection();
    
    $paginaHTML = file_get_contents("../HTML/messaggi.html");
    $paginaHTML = str_replace("Elementi_Messaggi", $result, $paginaHTML);

    echo $paginaHTML;
    
?>