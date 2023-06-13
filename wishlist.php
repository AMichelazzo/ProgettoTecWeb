<?php
session_start();
if (isset($_SESSION["username"])) {
    require_once "PHP/class.php";
    $template=Access::getHeader("Wishlist", "Lista dei desideri", "Wishlist, lista dei desideri, prodotti piaciuti, prodotto", $_SESSION["username"], $_SESSION["ruolo"], "<span lang=\"en\">Home - Wishlist</span>");
}
else{
    header("Location: index.php");
}

$template .= file_get_contents('HTML/wishlist.html');


require_once "PHP/connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}
else{
    $replace = "";
    $productlist = ""; 
    $msg="<div id=\"msgWish\" role=\"alert\"></div>";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->getProductsOnWishlist($_SESSION["username"]);
    $connessione->closeConnection();
    if(isset($result)){
        if(count($result)>0){
            for($i=0;$i<count($result);$i++){
                $connessioneRiuscita = $connessione->openDBConnection();
                $result2=$connessione->getProduct($result[$i]["id_prodotto"]);
                $nome=$result2[0]['Nome'];
                $desc=$result2[0]['Descrizione'];
                $idprod=$result2[0]['id_prodotto'];
                $cat=$connessione->getCategory($result2[0]['id_categoria'])[0]["Nome"];
                $idcat=$result2[0]['id_categoria'];
                $img = "<img src=\"".$result2[0]["path"]."\" alt=\"".$result2[0]["alt_img"]."\" width=\"200\" height=\"200\"/>";
                $connessione->closeConnection();
                
                $productlist .= "<form action=\"contatti.php\" class=\"prodotto\" name=\"form-prodotto\" method=\"post\">";
                $productlist .= "<div class=\"image-container\">";
                $productlist .= $img;
                $productlist .= "<button class=\"open-button\" id=\"".$result2[0]["path"]."\"><img src=\"img/lente.png\" alt=\"Ingrandisci immagine.\" /></button>";
                $productlist .= "</div>";
                $productlist .= "<div class=\"contentProdotto\">";
                $productlist .= "<div class=\"nome\">Nome prodotto: ".$nome."</div>";
                $productlist .= "<div class=\"descrizione\">Descrizione: ".$desc."</div>";
                $productlist .= "<div class=\"categoria\">Categoria: <a class=\"wish-link\" href=\"categorie.php?cat=".$result2[0]['id_categoria']."\">".$cat."</a></div>";
                $productlist .= "<div class=\"button-container\">";
                $productlist .= "<input type=\"submit\" name=\"informazioni\" value=\"Richiedi Informazioni\" />";
                $productlist .= "<button id=\"".$idprod."\" class=\"vaiProdotto\" name=\"vaiProdotto\">Scheda Prodotto <span aria-hidden=\"true\">-></span></button>";
                $productlist .= "<input type=\"hidden\" class=\"product-id\" name=\"product-id\" id=\"product-ID\=".$idprod."\"/>";
                $productlist .= "<input type=\"hidden\" class=\"categoria\" name=\"categoria\" id=\"categoria\=".$idcat."\"/>";
                $productlist .= "</div>";
                $productlist .= "</div>";
                $productlist .= "<div class=\"rimuovi-container\">";
                $productlist .= "<button class=\"remove-button\" id=\"".$idprod."-".$idcat."\" name=\"rimuovi\">";
                $productlist .= "<img src=\"img/binClosed.png\" alt=\"Rimuovi prodotto dalla lista dei desideri.\" class=\"non-hover-image\" aria-hidden=\"true\"/>";
                $productlist .= "<img src=\"img/binOpened.png\" alt=\"Rimuovi prodotto dalla lista dei desideri.\" class=\"hover-image\" />";
                $productlist .= "</button>";
                $productlist .= "</div>";
                $productlist .= "</form>";
            }
        }
    }
    else
    {
        $msg="<div id=\"wish-error\" role=\"alert\">Lista dei desideri vuota!</div>";
    }
    $replace = array("Titolo" =>"Wishlist di ".$_SESSION["username"],
                        "<!--Prodotti-->" => $productlist,
                        "<div id=\"msgWish\" role=\"alert\"></div>" => $msg);
}
foreach($replace as $key => $value) 
        $template = str_replace($key, $value, $template);
echo $template;
/*try {
    if (isset($err)){
        $template = str_replace("<!-- errors -->", $err, $template);
        unset($_SESSION["error"]);
    }
    echo $template;
} catch (Exception $e) {
    //errore 500
}*/
?>