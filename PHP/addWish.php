<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$response = array();

/// SISTEMARE CON SESSIONE PER IL LOGIN
if (isset($_GET["product-ID"],$_GET["categoria"],$_GET["username"])) { 
    $result="";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->addtoWishList($_GET["product-ID"],$_GET["categoria"],$_GET["username"]);
    $connessione->closeConnection();
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Prodotto aggiunto correttamente alla tua lista dei desideri.";
    } else {
        $response["success"] = false;
        $response["message"] = "Errore durante l'aggiunta del prodotto alla tua lista dei desideri.";
    }
    
    echo json_encode($response);
}
?>
