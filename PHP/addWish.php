<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$response = array();

/// SISTEMARE CON SESSIONE PER IL LOGIN
if (isset($_GET["product-ID"],$_GET["categoria"],$_GET["username"])) {
    if(!isset($_GET["remove"])||$_GET["remove"]!=1){ 
        $result="";
        $connessioneRiuscita = $connessione->openDBConnection();
        $result=$connessione->addtoWishList($_GET["product-ID"],$_GET["categoria"],$_GET["username"]);
        $connessione->closeConnection();
        
        if ($result) {
            $response["success"] = true;
            $response["message"] = "Prodotto aggiunto correttamente alla tua lista dei desideri.";
        }
        else
        {
            $response["success"] = false;
            $response["message"] = "Errore aggiungimento prodotto dalla wishlist.";
        }
    }
    else
    {
        if($_GET["remove"]==1){
            $result="";
            $connessioneRiuscita = $connessione->openDBConnection();
            $result=$connessione->removeFromWishList($_GET["product-ID"],$_GET["categoria"],$_GET["username"]);
            $connessione->closeConnection();
            
            if ($result) {
                $response["success"] = true;
                $response["message"] = "Prodotto Rimosso correttamente alla tua lista dei desideri.";
            }
            else
            {
                $response["success"] = false;
                $response["message"] = "Errore cancellamento prodotto dalla wishlist.";
            }
        }
    }
    
    echo json_encode($response);
}
?>
