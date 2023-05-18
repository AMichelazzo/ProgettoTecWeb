<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();

session_start();
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
        $slideshow = "";
        for ($i = 0; $i < count($result); $i++) {
            $slideshow .= "<div class=\"mySlides fade\">
            <img src=\"".$result[$i]["path"]."\" alt=\"".$result[$i]["alt_img"]."\" width=\"300\" height=\"300\"\">
            </div>";
        }
        $connessioneRiuscita = $connessione->openDBConnection();
        $result=$connessione->isInWishList($idprod,$idcat,$_SESSION["username"]);
        $connessione->closeConnection();
        ($result) ? $testoButton="Togli dalla WishList" : $testoButton="Aggiungi a WishList";; 
        $replace = array("Titolo" =>$nome,
                            "Nome Prodotto" =>$nome,
                            "Descrizione Prodotto" =>$desc,
                            "<div>img</div>" => $slideshow,
                            "product-ID" => $idprod,
                            "categ_id" => $idcat,
                            "Aggiungi a WishList" => $testoButton);
    }
    else{
        header("Location: ../PHP/categorie.php");
    }

    $paginaHTML = file_get_contents("../HTML/prodotto.html");
        foreach($replace as $key => $value)
                $paginaHTML = str_replace($key, $value, $paginaHTML);
        echo $paginaHTML;
}
?>
