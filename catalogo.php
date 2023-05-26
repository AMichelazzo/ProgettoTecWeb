<?php

require_once "PHP/connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$Elenco_prod = "";
$target="<!--Elementi_Catalogo-->";
$result = array();
$paginaHTML = file_get_contents("HTML/catalogo.html");

// deve funzionare solo se admin!
if(!isset($_POST["modifica_prod"])) {
    $result=$connessione->getAllProducts();
    $connessione->closeConnection();

    for($i=0; $i<count($result); $i++) {  // funzione per la creazione dell'inline

        $Elenco_prod .= "<div id=\"prodotti\"><p class=\"inline\"><input type=\"checkbox\" name=\"form_id_prodotti[]\" value=" . $result[$i]["id_prodotto"] .
        "\"/></p>";
        $Elenco_prod .="<p class=\"inline\"><input type=\"hidden\" name=\"form_id_categoria[]\" value=" . $result[$i]["id_categoria"] . "\"/></p>";

        $Elenco_prod .= "<p class=\"inline\"> Nome prodotto: " . $result[$i]["Prod_Nome"] . " |</p>";
        $Elenco_prod .= "<p class=\"inline\"> Categoria: " . $result[$i]["Cat_Nome"] . "|</p>";
        $Elenco_prod .= "<p class=\"inline\"> Descrizione: " . $result[$i]["Descrizione"] . ".</p></div>";
        $Elenco_prod .= "<p align=\"right\"><input type=\"button\" class=\"invio\" id=\"modifica_prod\" name=\"modifica_prod\" value=\"Modifica\" /></p><br>";

    }
}
else { // modifica del prodotto
    
    $result = $connessione->getProduct($Id_prodotto); // da implementare, come fa a ricevere l'id del prodotto??
    $paginaHTML = str_replace("Catalogo Prodotti", "Modifica Prodotto", $paginaHTML);
    
    $Elenco_prod .= "<form action=\"catalogo.php\" method=\"POST\">";
    $Elenco_prod .= "<div><label for=\"nome_prod\">Nome prodotto:</label><br>
    <input type=\"text\" id=\"nome_prod\" name=\"nome_prod\" value=\"" . $result["Nome"] . "\"/></div><br>";
    $Elenco_prod .= "<div><label for=\"cat_prod\">Categoria prodotto:</label><br>
    <select name=\"categories\" id=\"categories\"> ";

    $categories = $connessione->getCategories();
    
    for($i=0; $i<count($categories); $i++) {  // creazione delle varie categorie
        $name =  $categories[$i]["Nome"];
        $Elenco_prod .= "<option value=\"" . $name . "\">" . $name . "</option>";
    }

    $Elenco_prod .= "</select><div><label for=\"desc_prod\">Descrizione prodotto:</label><br>
    <input type=\"text\" id=\"desc_prod\" name=\"desc_prod\" value=\"" . $result["Descrizione"] . "\"/></div><br>";

    $Elenco_prod= "<input type=\"button\" id=\"submit_modifca_prod\" name=\"submit_modifica_prod\" value=\"Conferma modifiche\"/></form>"; 
}   

$paginaHTML = str_replace($target, $Elenco_prod, $paginaHTML);
echo $paginaHTML;
?>
