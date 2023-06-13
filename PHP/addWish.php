<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$response = array();
session_start();
if (isset($_GET["product_id"],$_GET["categ_id"],$_SESSION["username"])) {
    if(!isset($_GET["remove"])||$_GET["remove"]!=1){
        $connessioneRiuscita = $connessione->openDBConnection();
        $result=$connessione->addtoWishList($_GET["product_id"], $_GET["categ_id"], $_SESSION["username"]);
        $connessione->closeConnection();
        
        if (!$result) {
            $response["success"] = false;
            $response["message"] = "Errore aggiunta prodotto alla wishlist.";
        }
        else
        {
            $response["success"] = true;
            $response["message"] = "Prodotto aggiunto correttamente alla tua lista dei desideri.";
        }
    }
    else
    {
        if($_GET["remove"]==1){
            $result="";
            $connessioneRiuscita = $connessione->openDBConnection();
            $result=$connessione->removeFromWishList($_GET["product_id"],$_GET["categ_id"],$_SESSION["username"]);
            $connessione->closeConnection();
            
            if ($result) {
                $response["success"] = true;
                $response["message"] = "Prodotto rimosso correttamente dalla tua lista dei desideri.";
            }
            else
            {
                $response["success"] = false;
                $response["message"] = "Errore cancellazione prodotto dalla wishlist.";
            }
        }
    }
    
    echo json_encode($response);
}
?>
