<?php

require_once "class.php";
$response = array();
session_start();
if (isset($_GET["product_id"],$_GET["categ_id"],$_SESSION["username"])) {
    if(!isset($_GET["remove"])||$_GET["remove"]!=1){
        
        $result=Access::addtoWishList($_GET["product_id"], $_GET["categ_id"], $_SESSION["username"]);
        
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
            $result=Access::removeFromWishList($_GET["product_id"],$_GET["categ_id"],$_SESSION["username"]);
            
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
