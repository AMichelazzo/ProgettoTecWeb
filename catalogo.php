<?php

require_once "PHP/catalogo_handler.php";
$paginaHTML ="";
$Elenco_prod = "";
$target = "<!--Elementi_Catalogo-->";
$errors = "<!--Errors-->";

session_start();
if(/*isset($_SESSION["username"]) && $_SESSION["ruolo"] == "admin"*/1) {

    $paginaHTML = Access::getHeader("Catalogo", "Catalogo prodotti e categorie di prodotti","catalogo, prodotti, categorie", $_SESSION["username"], $_SESSION["ruolo"], "Catalogo");
    $paginaHTML .= file_get_contents("HTML/catalogo.html");
    $Elenco_prod = Catalogo::show_allProducts(); 

    if(isset($_POST["submit_modifica_prod"], $_POST["nome_prod"], $_POST["category_id"], $_POST["desc_prod"]))      // modifica del prodotto
        Access::modifyProduct($_POST["prod_id"], $_POST["category_id"], $_POST["nome_prod"], $_POST["desc_prod"]);

    if(isset($_POST["elimina_prod"])) {     // viene eliminato un prodotto
        Access::deleteProduct($_POST["product_id"]);
        // da implementare messaggio di conferma
        }

    if(isset($_POST["submit_new_prod"], $_POST["new_nome_prod"], $_POST["new_category_id"], $_POST["new_desc_prod"])) { // viene creato un nuovo prodotto
        Access::newProduct($_POST["new_nome_prod"], $_POST["new_category_id"], $_POST["new_desc_prod"]);
        // da implementare messaggio di conferma
    }
    else {} // da implementare errore in caso di omissione dei campi del prodotto
        
    if(isset($_POST["submit_modifica_cat"], $_POST["nome_cat"], $_POST["desc_cat"]))    // modifica della categoria
        Access::modifyCategory($_POST["cat_id"],$_POST["nome_cat"], $_POST["desc_cat"]);

    if(isset($_POST["submit_new_cat"], $_POST["new_nome_cat"], $_POST["new_desc_cat"])) {  // viene creata una nuova categoria
        Access::newCategory($_POST["new_nome_cat"], $_POST["new_desc_cat"]);
    }

    if(isset($_POST["elimina_cat"])) {      // viene eliminata una categoria
        $result = Access::deleteCategory($_POST["category_id"]);
        if(is_null($result))
            $paginaHTML = str_replace($errors, "Errore nell'eliminazione della categoria!", $paginaHTML); 
    }
    // da implementare aggiunta immagini?


    // inizio catalogo prodotto, queste funzioni prendoto l'html esatto
       // mostra il catalogo dei prodotti

    if(isset($_POST["modifica_prod"])) {            // funzione che mostra la pagina di modifica del prodotto selezionato
        $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML); 
        $Elenco_prod = Catalogo::show_modifyProduct($_POST["product_id"]);
    }

    if(isset($_POST["new_product"])) {              // pagina per la creazione di un nuovo prodotto
        $paginaHTML = str_replace("Catalogo prodotti", "Aggiunta nuovo prodotto", $paginaHTML); 
        $Elenco_prod = Catalogo::show_newProduct();
    }
    // fine catalogo prodotti

    // inizio catalogo categorie
    if(isset($_POST["category_list"]) || isset($_POST["annulla_modifica_cat"]) || isset($_POST["submit_modifica_cat"]) || isset($_POST["annulla_new_cat"])  
    || isset($_POST["submit_new_cat"]) || isset($_POST["elimina_cat"])) {     // mostra il "catalogo" delle categorie

        $paginaHTML = str_replace("Catalogo prodotti", "Lista Categorie", $paginaHTML); 
        $Elenco_prod = Catalogo::show_allCategories();
    }

    if(isset($_POST["new_category"])) {             // pagina per la creazione di nuova categoria
        $paginaHTML = str_replace("Catalogo prodotti", "Aggiunta nuova categoria", $paginaHTML); 
        $Elenco_prod = Catalogo::show_newCategory();
    }

    if(isset($_POST["modifica_cat"])) {             // pagina per la modifica della categoria
        $paginaHTML = str_replace("Catalogo prodotti", "Modifica Categoria", $paginaHTML);
        $Elenco_prod = Catalogo::show_modifyCategory($_POST["category_id"]);
    }
    // fine catalogo categorie

    $paginaHTML = str_replace($target, $Elenco_prod, $paginaHTML);
    echo $paginaHTML;
}
else // utente non è admin
    header("Location: prototipo.php");
?>
