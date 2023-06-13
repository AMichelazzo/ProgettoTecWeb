<?php
session_start();
require_once "PHP/class.php";
if (isset($_SESSION["username"])) {
    $template=Access::getHeader("Prodotto", "Lista prodotti di una categoria scelta.", "Categorie, Prodotti, Oggettistica di vetro, Lista", $_SESSION["username"], $_SESSION["ruolo"]);
}
else{
    $template=Access::getHeader("Prodotto", "Lista prodotti di una categoria scelta.", "Categorie, Prodotti, Oggettistica di vetro, Lista", "guest", "guest");
}

$template .= file_get_contents("HTML/prodotto.html");

require_once "PHP/connessione.php";
use DB\DBAccess;
$connessione = new DBAccess();
if (isset($_GET["prod"])) { 
    
    $replace = $keywords ="";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->getProduct($_GET["prod"]);
    $connessione->closeConnection();
    $connessioneRiuscita = $connessione->openDBConnection();
    $result3=$connessione->getKeyWordsProdotto($_GET["prod"]);
    $connessione->closeConnection();
    if(count($result)>0){
        $nome=$result[0]['Nome'];
        $desc=$result[0]['Descrizione'];
        $idprod=$result[0]['id_prodotto'];
        $idcat=$result[0]['id_categoria'];
        $isLogged="";
        $slideshow = "";
        for ($i = 0; $i < count($result); $i++) {
            $slideshow .= "<div class=\"mySlides fade\">
            <img src=\"".$result[$i]["path"]."\" alt=\"".$result[$i]["alt_img"]."\" width=\"300\" height=\"300\"/></div>";
        }
        if(isset($_SESSION["username"])){
            /*
            $connessioneRiuscita = $connessione->openDBConnection();
            $result2=$connessione->isInWishList($idprod,$idcat,$_SESSION["username"]);
            $connessione->closeConnection();*/
            $result2 = Access::isInWishList($idprod, $idcat, $_SESSION["username"]);
            if ($result2 == null) {$result2 = false;}
            ($result2) ? $testoButton="Togli dalla WishList" : $testoButton="Aggiungi a WishList";
            $isLogged="<button type=\"button\" id=\"button\" class=\"button\">
                                                <span class=\"button__text\" id=\"buttonid\">".$testoButton."</span>
                                                </button>
                                                <div id=\"msgWish\" role=\"alert\"></div>";
        }
        
        $replace = array("Titolo" =>$nome,
                            "Nome Prodotto" =>$nome,
                            "Descrizione Prodotto" =>$desc,
                            "<div>img</div>" => $slideshow,
                            "product-ID" => "product-ID=".$idprod,
                            "categ_id" => "categoria=".$idcat,
                            "<!--Wish-->" => $isLogged);
    }
    else{
        header("Location: categorie.php");
    }
    if(count($result3)>0){
        for ($i = 0; $i < count($result3); $i++) {
            if($i == count($result3)-1){
                $keywords=$keywords.$result3[$i]["Nome"];
            }
            else{
                $keywords=$keywords.$result3[$i]["Nome"].", ";
                }
        }
        $keywords="<meta name=\"keywords\" content=\"".$keywords."\" />";
        $replace["<!--Keywords-->"] = $keywords;
    }
}
foreach($replace as $key => $value) 
        $template = str_replace($key, $value, $template);
echo $template;
?>