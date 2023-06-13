<?php

require_once "PHP/class.php";

$Elenco_prod = "";
$target="<!--Elementi_Catalogo-->";
$errors = "<!--Errors-->";
$paginaHTML = file_get_contents("HTML/catalogo.html");

if(isset($_POST["submit_modifica_prod"], $_POST["nome_prod"], $_POST["category_id"], $_POST["desc_prod"]))   // chiamata al DB per modifica del prodotto
    Access::modifyProduct($_POST["prod_id"], $_POST["category_id"], $_POST["nome_prod"], $_POST["desc_prod"]);

if(isset($_POST["elimina_prod"])) {  // funzione per l'eliminazione del prodotto
    Access::deleteProduct($_POST["product_id"]);
    // da implementare messaggio di conferma
    }

if(isset($_POST["submit_new_prod"], $_POST["new_nome_prod"], $_POST["new_category_id"], $_POST["new_desc_prod"])) {
    Access::newProduct($_POST["new_nome_prod"], $_POST["new_category_id"], $_POST["new_desc_prod"]);
    // da implementare messaggio di conferma
}
else {} // da implementare errore in caso di omissione dei campi del prodotto
    
if(isset($_POST["submit_modifica_cat"], $_POST["nome_cat"], $_POST["desc_cat"]))  // funzione per la modifica della categoria
    Access::modifyCategory($_POST["cat_id"],$_POST["nome_cat"], $_POST["desc_cat"]);

if(isset($_POST["submit_new_cat"], $_POST["new_nome_cat"], $_POST["new_desc_cat"])) {  // funzione per la creazione di una nuova categoria
    Access::newCategory($_POST["new_nome_cat"], $_POST["new_desc_cat"]);
}

if(isset($_POST["elimina_cat"])) {  // funzione per l'eliminazione di una categoria
    $result = Access::deleteCategory($_POST["category_id"]);
    if(is_null($result))
        $paginaHTML = str_replace($errors, "Errore nell'eliminazione della categoria!", $paginaHTML); 
}
// da implementare aggiunta immagini?


// inizio catalogo prodotto

// deve funzionare solo se admin!
/* if(user is admin) { !! fare controllo */
    $result=Access::getAllProducts();   // parte del codice che mostra il catalogo

    $Elenco_prod .= "<form action=\"catalogo.php\" method=\"POST\"><p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"new_product\" name=\"new_product\" value=\"Aggiungi nuovo prodotto\" /></p>";
    $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"category_list\" name=\"category_list\" value=\"Vai a lista delle Categorie\" /></p></form><br>";

    for($i=0; $i<count($result); $i++) {  // funzione per la creazione dell'inline

        $Elenco_prod .= "<form action=\"catalogo.php\" method=\"POST\">"; // un form per ogni prodotto
        $Elenco_prod .= "<p class=\"inline\"><input type=\"hidden\" name=\"product_id\" value=\"" . $result[$i]["id_prodotto"] . "\"/></p>" . // mi salvo l'id_prodotto
        "<p class=\"inline\"><input type=\"hidden\" name=\"category_id\" value=\"" . $result[$i]["id_categoria"] . "\"/></p>";    // e l'id_categoria

        $Elenco_prod .= "<p class=\"inline\"> Nome prodotto: " . $result[$i]["Prod_Nome"] . " |</p>";       // informazioni dei prodotti
        $Elenco_prod .= "<p class=\"inline\"> Categoria: " . $result[$i]["Cat_Nome"] . "|</p>";
        $Elenco_prod .= "<p class=\"inline\"> Descrizione: " . $result[$i]["Descrizione"] . ".</p>";
        $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"elimina_prod\" name=\"elimina_prod\" value=\"Elimina\" /></p>";
        $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"modifica_prod\" name=\"modifica_prod\" value=\"Modifica\" /></p></form><br>";   
    }
/*}
else // user non è admin
{
    header("Location : index.php");
} */
if(isset($_POST["modifica_prod"])) {  // funzione che mostra la pagina di modifica del prodotto selezionato

    $result = Access::getProduct($_POST["product_id"]); 
    $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML); 

    $Elenco_prod = "<form action=\"catalogo.php\" method=\"POST\">";
    $Elenco_prod .= "<div><input type=\"hidden\" name=\"prod_id\" value=\"" . $_POST["product_id"] . "\"/></div>";
    $Elenco_prod .= "<div><label for=\"nome_prod\">Nome prodotto:</label><br></div>
    <div><input type=\"text\" id=\"nome_prod\" name=\"nome_prod\" value=\"" . $result[0]["Nome"] . "\"/></div>";
    $Elenco_prod .= "<div><label for=\"cat_prod\">Categoria prodotto:</label><br></div><select name=\"category_id\" id=\"categories\">";

    $Elenco_prod .= "<option value=\"" . $_POST["category_id"] . "\">" . Access::getCategoryName($_POST["category_id"]) . "</option>"; // mostra come selezionata la categoria del prodotto
    $categories = Access::getCategories();
    $x = $_POST["category_id"] ;
    echo $x;

    for($i=0; $i<count($categories); $i++) { // creazione del menu a tendina delle varie categorie
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

    $categories = Access::getCategories();
    
    for($i=0; $i<count($categories); $i++)   // creazione del menu a tendina delle categorie
        $Elenco_prod .= "<option value=\"" . $categories[$i]["id_categoria"] . "\">" . $categories[$i]["Nome"] . "</option>";
    
    $Elenco_prod .= "</select><div><label for=\"new_desc_prod\">Descrizione prodotto:</label><br>
    <textarea id=\"new_desc_prod\" name=\"new_desc_prod\" rows=\"10\" cols=\"40\" maxlength=\"500\"></textarea></div><br>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"annulla_new_cat\" name=\"annulla_new_prod\" value=\"Annulla creazione prodotto\"/>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"submit_new_cat\" name=\"submit_new_prod\" value=\"Conferma nuovo prodotto\"/></form><br>"; 
}

// fine catalogo prodotti


// inizio catalogo categorie

if(isset($_POST["category_list"]) || isset($_POST["annulla_modifica_cat"]) || isset($_POST["submit_modifica_cat"]) || isset($_POST["annulla_new_cat"])  
  || isset($_POST["submit_new_cat"]) || isset($_POST["elimina_cat"])) {     // mostra il "catalogo" delle categorie

    $result = Access::getCategories();
    $paginaHTML = str_replace("Catalogo prodotti", "Lista Categorie", $paginaHTML); 

    $Elenco_prod = "<form action=\"catalogo.php\" method=\"POST\"><p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"new_category\" name=\"new_category\" value=\"Aggiungi nuova categoria\" /></p>";
    $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"invio\" value=\"Torna al catalogo prodotti\" /></p></form><br>";
 

    for($i=0; $i<count($result); $i++) {

        $Elenco_prod .= "<form action=\"catalogo.php\" method=\"POST\">"; // un form per ogni prodotto
        $Elenco_prod .= "<p class=\"inline\"><input type=\"hidden\" name=\"category_id\" value=\"" . $result[$i]["id_categoria"] . "\"/></p>"; // mi salvo l'id_categoria
        $Elenco_prod .= "<p class=\"inline\"> Nome: " . $result[$i]["Nome"] . " |</p>";       // informazioni sulle categorie
        $Elenco_prod .= "<p class=\"inline\"> Descrizione: " . $result[$i]["Descrizione"] . ".</p>";
        $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"elimina_cat\" name=\"elimina_cat\" value=\"Elimina\" /></p>";
        $Elenco_prod .= "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"modifica_cat\" name=\"modifica_cat\" value=\"Modifica\" /></form><br></p>";
    }
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

if(isset($_POST["modifica_cat"])) {  // pagina per la modifica della categoria
    $result = Access::getCategory($_POST["category_id"]); 
    $paginaHTML = str_replace("Catalogo prodotti", "Modifica Categoria", $paginaHTML); 

    $Elenco_prod = "<form action=\"catalogo.php\" method=\"POST\">";
    $Elenco_prod .= "<div><input type=\"hidden\" name=\"cat_id\" value=\"" . $_POST["category_id"] . "\"/></div>";
    $Elenco_prod .= "<div><label for=\"nome_cat\">Nome categoria:</label><br></div>
    <div><input type=\"text\" id=\"nome_cat\" name=\"nome_cat\" value=\"" . $result[0]["Nome"] . "\"/></div>";    
    $Elenco_prod .= "</select><div><label for=\"desc_cat\">Descrizione categoria:</label><br>
    <textarea id=\"desc_prod\" name=\"desc_cat\" rows=\"10\" cols=\"40\" maxlength=\"500\">" . $result[0]["Descrizione"]. "</textarea></div><br>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"annulla_modifica_prod\" name=\"annulla_modifica_cat\" value=\"Annulla modifiche\"/>";
    $Elenco_prod .= "<input type=\"submit\" class=\"invio\" id=\"submit_modifica_prod\" name=\"submit_modifica_cat\" value=\"Conferma modifiche\"/></form><br>"; 
}

// fine catalogo categorie

$paginaHTML = str_replace($target, $Elenco_prod, $paginaHTML);
echo $paginaHTML;
?>
