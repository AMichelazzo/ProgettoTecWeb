<?php
session_start();

$template = file_get_contents("HTML/prodotto.html");

require_once "PHP/connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();

if (isset($_GET["prod"])) { 
    $result = $nome = $descrizione = $replace ="";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->getProduct($_GET["prod"]);
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
            <img src=\"".$result[$i]["path"]."\" alt=\"".$result[$i]["alt_img"]."\" width=\"300\" height=\"300\"\">
            </div>";
        }
        if(isset($_SESSION["username"])){
            $connessioneRiuscita = $connessione->openDBConnection();
            $result=$connessione->isInWishList($idprod,$idcat,$_SESSION["username"]);
            $connessione->closeConnection();
            ($result) ? $testoButton="Togli dalla WishList" : $testoButton="Aggiungi a WishList"; 
            $isLogged="<button type=\"button\" id=\"button\" class=\"button\">
                                                <span class=\"button__text\" id=\"buttonid\">".$testoButton."</span>
                                                </button>";
        }
        
        $replace = array("Titolo" =>$nome,
                            "Nome Prodotto" =>$nome,
                            "Descrizione Prodotto" =>$desc,
                            "<div>img</div>" => $slideshow,
                            "product-ID" => $idprod,
                            "categ_id" => $idcat,
                            "<!--Wish-->" => $isLogged);
    }
    else{
        header("Location: categorie.php");
    }
}
foreach($replace as $key => $value) 
        $template = str_replace($key, $value, $template);
echo $template;
?>