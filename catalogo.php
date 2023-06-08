<?php

require_once "PHP/connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$Elenco_prod = "";
$target="<!--Elementi_Catalogo-->";
$paginaHTML = file_get_contents("HTML/catalogo.html");

if(isset($_POST["submit_modifica_prod"], $_POST["nome_prod"], $_POST["category_id"], $_POST["desc_prod"]))   // chiamata al DB per modifica del prodotto
    $connessione->modifyProduct($_POST["prod_id"], $_POST["category_id"], $_POST["nome_prod"], $_POST["desc_prod"]);

if(isset($_POST["elimina_prod"])) {  // funzione per l'eliminazione del prodotto
    $connessione->deleteProduct($_POST["product_id"]);
    // da implementare messaggio di conferma
    }

if(isset($_POST["submit_new_prod"], $_POST["new_nome_prod"], $_POST["new_category_id"], $_POST["new_desc_prod"])) {
    $connessione->newProduct($_POST["new_nome_prod"], $_POST["new_category_id"], $_POST["new_desc_prod"]);
    // da implementare messaggio di conferma
}
else {} // da implementare errore in caso di omissione dei campi del prodotto
    
if(isset($_POST["submit_new_cat"], $_POST["new_nome_cat"], $_POST["new_desc_cat"])) {
    $connessione->newCategory($_POST["new_nome_cat"], $_POST["new_desc_cat"]);
}

// da implementare aggiunta immagini?

// deve funzionare solo se admin!
/* if(user is admin) { !! fare controllo */
    $result=$connessione->getAllProducts();   // parte del codice che mostra il catalogo

    $Elenco_prod .= "<form action=\"catalogo.php\" method=\"POST\"><p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"new_product\" name=\"new_product\" value=\"Aggiungi nuovo prodotto\" /></p>";
    $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"new_category\" name=\"new_category\" value=\"Aggiungi nuova categoria\" /></p>";
    $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"modify_category\" name=\"modify_category\" value=\"Modifica categoria esistente\" /></p></form><br>";

    for($i=0; $i<count($result); $i++) {  // funzione per la creazione dell'inline

        $Elenco_prod .= "<form action=\"catalogo.php\" method=\"POST\">"; // un form per ogni prodotto
        $Elenco_prod .= "<p class=\"inline\"><input type=\"hidden\" name=\"product_id\" value=\"" . $result[$i]["id_prodotto"] . "\"/></p>" . // mi salvo l'id_prodotto
        "<p class=\"inline\"><input type=\"hidden\" name=\"category_id\" value=\"" . $result[$i]["id_categoria"] . "\"/></p>";    // e l'id_categoria

        $Elenco_prod .= "<p class=\"inline\"> Nome prodotto: " . $result[$i]["Prod_Nome"] . " |</p>";       // informazioni dei prodotti
        $Elenco_prod .= "<p class=\"inline\"> Categoria: " . $result[$i]["Cat_Nome"] . "|</p>";
        $Elenco_prod .= "<p class=\"inline\"> Descrizione: " . $result[$i]["Descrizione"] . ".</p>";
        
        $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"modifica_prod\" name=\"modifica_prod\" value=\"Modifica\" /></p>";
        $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"elimina_prod\" name=\"elimina_prod\" value=\"Elimina\" /></p><br> </form>";
    }
/*}
else // user non è admin
{
    header("Location : index.php");
} */

if(isset($_POST["modifica_prod"])) {  // funzione che mostra la pagina di modifica del prodotto selezionato

    $result = $connessione->getProduct($_POST["product_id"]); 
    $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML); 

    $Elenco_prod = "<form action=\"catalogo.php\" method=\"POST\">";
    $Elenco_prod .= "<div><input type=\"hidden\" name=\"prod_id\" value=\"" . $_POST["product_id"] . "\"/></div>";
    $Elenco_prod .= "<div><label for=\"nome_prod\">Nome prodotto:</label><br></div>
    <div><input type=\"text\" id=\"nome_prod\" name=\"nome_prod\" value=\"" . $result[0]["Nome"] . "\"/></div>";
    $Elenco_prod .= "<div><label for=\"cat_prod\">Categoria prodotto:</label><br></div><select name=\"category_id\" id=\"categories\">";

    $Elenco_prod .= "<option value=\"" . $_POST["category_id"] . "\">" . $connessione->getCategoryName($_POST["category_id"]) . "</option>"; // mostra come selezionata la categoria del prodotto
    $categories = $connessione->getCategories();
    $x = $_POST["category_id"] ;
    echo $x;

    for($i=0; $i<count($categories); $i++) { // creazione delle varie categorie
        if($categories[$i]["id_categoria"] != $_POST["category_id"]) 
            $Elenco_prod .= "<option value=\"" . $categories[$i]["id_categoria"] . "\">" . $categories[$i]["Nome"] . "</option>";
    }   
    
    $Elenco_prod .= "</select><div><label for=\"desc_prod\">Descrizione prodotto:</label><br>
    <textarea id=\"desc_prod\" name=\"desc_prod\" rows=\"10\" cols=\"40\" maxlength=\"500\">" . $result[0]["Descrizione"]. "</textarea></div><br>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"annulla_modifica_prod\" name=\"annulla_modifica_prod\" value=\"Annulla modifiche\"/>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"submit_modifica_prod\" name=\"submit_modifica_prod\" value=\"Conferma modifiche\"/></form><br>"; 
}

if(isset($_POST["new_product"])) {  // pagina per la creazione di un nuovo prodotto

    $paginaHTML = str_replace("Catalogo prodotti", "Aggiunta nuovo prodotto", $paginaHTML); 

    $Elenco_prod = "<form action=\"catalogo.php\" method=\"POST\">";
    $Elenco_prod .= "<div><label for=\"new_nome_prod\">Nome prodotto:</label><br></div>
    <div><input type=\"text\" id=\"nome_prod\" name=\"new_nome_prod\" value=\"\"/></div>";
    $Elenco_prod .= "<div><label for=\"new_category_id\">Categoria prodotto:</label><br></div>
    <select name=\"new_category_id\" id=\"new_category_id\"> ";

    $categories = $connessione->getCategories();
    
    for($i=0; $i<count($categories); $i++)   // creazione delle varie categorie ,  da sistemare, deve mostrare come selezionata la categoria del prodotto
        $Elenco_prod .= "<option value=\"" . $categories[$i]["id_categoria"] . "\">" . $categories[$i]["Nome"] . "</option>";
    
    $Elenco_prod .= "</select><div><label for=\"new_desc_prod\">Descrizione prodotto:</label><br>
    <textarea id=\"new_desc_prod\" name=\"new_desc_prod\" rows=\"10\" cols=\"40\" maxlength=\"500\"></textarea></div><br>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"annulla_new_prod\" name=\"annulla_new_prod\" value=\"Annulla creazione prodotto\"/>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"submit_new_prod\" name=\"submit_new_prod\" value=\"Conferma nuovo prodotto\"/></form><br>"; 
}

if(isset($_POST["new_category"])) {  // pagina per la creazione di nuova categoria

    $paginaHTML = str_replace("Catalogo prodotti", "Aggiunta nuova categoria", $paginaHTML); 

    $Elenco_prod = "<form action=\"catalogo.php\" method=\"POST\">";
    $Elenco_prod .= "<div><label for=\"nome_cat\">Nome categoria:</label><br></div>
    <div><input type=\"text\" id=\"new_nome_cat\" name=\"new_nome_cat\" value=\"\"/></div>" . "<div><label for=\"desc_prod\">Descrizione categoria:</label><br>";
    $Elenco_prod .= "<textarea id=\"new_desc_cat\" name=\"new_desc_cat\" rows=\"10\" cols=\"30\" maxlength=\"500\"></textarea></div><br>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"annulla_new_cat\" name=\"annulla_new_cat\" value=\"Annulla creazione categoria\"/>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"submit_new_cat\" name=\"submit_new_cat\" value=\"Conferma nuova categoria\"/></form><br>"; 
}

$connessione->closeConnection();
$paginaHTML = str_replace($target, $Elenco_prod, $paginaHTML);
echo $paginaHTML;
?>