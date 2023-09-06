<?php

require_once "catalogo_handler.php";
session_start();
$user = (isset($_SESSION["username"])) ? $_SESSION["username"] : null;
$ruolo = (isset($_SESSION["ruolo"])) ? $_SESSION["ruolo"] : null;

$paginaHTML = "";
$Elenco_prod = "";
$target = "<!--Elementi_Catalogo-->";

if ($user && $ruolo == "admin") {

    $paginaHTML = Access::getHeader("Catalogo", "Catalogo prodotti e categorie di prodotti", "catalogo, prodotti, categorie", $ruolo, null, null, null, null, true);
    $paginaHTML .= file_get_contents("HTML/catalogo.html");

    // se nessun pulsante è stato premuto
    $Elenco_prod = Catalogo::show_allProducts();

    // chiamate alle varie funzioni di "catalogo_handler"

    // modifica del prodotto
    if (isset($_POST["submit_modifica_prod"])) {
        if (isset($_POST["nome_prod"], $_POST["category_id"], $_POST["desc_prod"]) && Access::is_not_null($_POST["nome_prod"]) && Access::is_not_null($_POST["desc_prod"])) {

            Access::modifyProduct($_POST["prod_id"], $_POST["category_id"], $_POST["nome_prod"], $_POST["desc_prod"]);
            $Elenco_prod = Catalogo::show_allProducts();

            $paginaHTML = Catalogo::sendError("success", "Modifica riuscita", "Prodotto modificato correttamente", $paginaHTML);
            // messaggio di riuscita della modifica
        } else {
            // messaggio di errore omissione campi prodotto
            $paginaHTML = Catalogo::sendError("error", "Modifica non riuscita", "Alcuni campi di prodotto non sono stati inseriti!", $paginaHTML);
            $Elenco_prod = Catalogo::show_modifyProduct($_POST["prod_id"]);
            $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML);
            $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica prodotto", $paginaHTML);
        }
    }

    if (isset($_POST["salva_alt_img"])) {

        if (isset($_POST["alt_img"])) {
            $alt = $_POST["alt_img"];
            if (!empty($alt)) {
                for ($i = 0; $i < count($alt); $i++)
                    Access::update_altImg($alt[$i], $_POST["path_img"][$i]);
            }
        }

        $paginaHTML = Catalogo::sendError("success", "Modifica riuscita", "Alt modificati correttamente", $paginaHTML);
        $Element_prod = Catalogo::show_modifyProduct($_POST["prod_id_2"]);
        $paginaHTML = str_replace("Catalogo prodotti", "Modificalo Prodotto", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica prodotto", $paginaHTML);
    }

    // creazione di un nuovo prodotto
    if (isset($_POST["submit_new_prod"])) {
        if (isset($_POST["new_nome_prod"], $_POST["new_category_id"], $_POST["new_desc_prod"]) && Access::is_not_null($_POST["new_nome_prod"]) && Access::is_not_null($_POST["new_desc_prod"])) {

            $result = Access::newProduct($_POST["new_nome_prod"], $_POST["new_category_id"], $_POST["new_desc_prod"]);
            $Elenco_prod = Catalogo::show_allProducts();

            if ($result)
                $paginaHTML = Catalogo::sendError("success", "Creazione prodotto riuscita", "Prodotto creato correttamente", $paginaHTML);
            else
                $paginaHTML = Catalogo::sendError("error", "Creazione prodotto non riuscita", "Errore nella creazione del prodotto", $paginaHTML);
        } else {

            $paginaHTML = Catalogo::sendError("error", "Creazione prodotto non riuscita", "Alcuni campi di prodotto non sono stati inseriti!", $paginaHTML);
            $Elenco_prod = Catalogo::show_newProduct();
            $paginaHTML = str_replace("Catalogo prodotti", "Creazione nuovo prodotto", $paginaHTML);
            $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Creazione nuovo prodotto", $paginaHTML);
        }

    }

    // eliminazione di immagini di un prodotto

    if (isset($_POST["si_elimina_img"])) {
        // eliminazione di una o più immagini
        if (isset($_POST["check_img"])) {
            $path = $_POST["check_img"];
            if (!empty($path)) {
                for ($i = 0; $i < count($path); $i++)
                    Access::deleteImg($path[$i]);
                $paginaHTML = Catalogo::sendError("success", "Eliminazione immagine riuscita", "Immagini eliminate", $paginaHTML);
            }

            $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML);
            $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica prodotto", $paginaHTML);
            $Elenco_prod = Catalogo::show_modifyProduct($_POST["prod_id_2"]);
        } else {
            $paginaHTML = Catalogo::sendError("error", "Eliminazione immagine non riuscita", "Non hai selezionato nessuna immagine!", $paginaHTML);

            $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML);
            $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica prodotto", $paginaHTML);
            $Elenco_prod = Catalogo::show_modifyProduct($_POST["prod_id_2"]);
        }
    }
    if (isset($_POST["no_elimina_img"])) {
        $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica prodotto", $paginaHTML);
        $Elenco_prod = Catalogo::show_modifyProduct($_POST["prod_id_2"]);
    }


    // eliminazione di un prodotto


    if (isset($_POST["si_elimina_prod"])) {
        $result = Access::deleteProduct($_POST["prod_id_2"]);
        $Elenco_prod = Catalogo::show_allProducts();

        if ($result)
            $paginaHTML = Catalogo::sendError("success", "Eliminazione prodotto riuscita", "Prodotto eliminato correttamente", $paginaHTML);
        else
            $paginaHTML = Catalogo::sendError("error", "Eliminazione prodotto non riuscita", "Errore nell'eliminazione del prodotto", $paginaHTML);
    }
    if (isset($_POST["no_elimina_prod"])) {
        $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica prodotto", $paginaHTML);
        $Elenco_prod = Catalogo::show_modifyProduct($_POST["prod_id_2"]);
    }



    // modifica di una categoria
    if (isset($_POST["submit_modifica_cat"])) {
        if (isset($_POST["nome_cat"], $_POST["desc_cat"]) && Access::is_not_null($_POST["nome_cat"]) && Access::is_not_null($_POST["desc_cat"])) {

            Access::modifyCategory($_POST["cat_id"], $_POST["nome_cat"], $_POST["desc_cat"]);

            // messaggio di riuscita della modifica
            $paginaHTML = Catalogo::sendError("success", "Modifica riuscita", "Categoria modificata correttamente", $paginaHTML);
        } else {
            $paginaHTML = Catalogo::sendError("error", "Modifica non riuscita", "Alcuni campi di categoria non sono stati inseriti!", $paginaHTML);
            $Elenco_prod = Catalogo::show_modifyCategory($_POST["cat_id"]);
            $paginaHTML = str_replace("Catalogo prodotti", "Modifica Categoria", $paginaHTML);
            $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / <a href=\"catalogo.php?lista_categorie=Lista+delle+Categorie\">Categorie</a> / Modifica categoria", $paginaHTML);
        }
    }

    // creazione di una nuova categoria
    if (isset($_POST["submit_new_cat"])) {
        if (isset($_POST["new_nome_cat"], $_POST["new_desc_cat"]) && Access::is_not_null($_POST["new_nome_cat"]) && Access::is_not_null($_POST["new_desc_cat"])) {

            $result = Access::newCategory($_POST["new_nome_cat"], $_POST["new_desc_cat"]);
            $Elenco_prod = Catalogo::show_allCategories();

            if ($result)
                $paginaHTML = Catalogo::sendError("success", "Creazione categoria riuscita", "Categoria creata correttamente", $paginaHTML);
            else
                $paginaHTML = Catalogo::sendError("error", "Creazione categoria non riuscita", "Errore nella creazione della categoria", $paginaHTML);
        } else {
            $paginaHTML = Catalogo::sendError("error", "Creazione categoria non riuscita", "Alcuni campi di categoria non sono stati inseriti!", $paginaHTML);
            $Elenco_prod = Catalogo::show_newCategory();
            $paginaHTML = str_replace("Catalogo prodotti", "Creazione nuova categoria", $paginaHTML);
            $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / <a href=\"catalogo.php?lista_categorie=Lista+delle+Categorie\">Categorie</a> / Creazione nuova categoria", $paginaHTML);
        }
    }


    // eliminazione di una categoria
    if (isset($_POST["si_elimina_cat"])) {

        // controllo che non ci siano ancora prodotti con questa categoria
        if (Access::getProductsbyCategory($_POST["cat_id_2"])) {
            $paginaHTML = Catalogo::sendError("error", "Eliminazione categoria non riuscita", "Errore nell'eliminazione della categoria, sono presenti prodotti con questa categoria", $paginaHTML);
            $Elenco_prod = Catalogo::show_modifyCategory($_POST["cat_id_2"]);
        } else {
            Access::deleteCategory($_POST["cat_id_2"]);
            $paginaHTML = Catalogo::sendError("success", "Eliminazione categoria riuscita", "Categoria eliminata correttamente", $paginaHTML);
        }

        $paginaHTML = str_replace("Catalogo prodotti", "Lista Categorie", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Categorie", $paginaHTML);
        $Elenco_prod = Catalogo::show_allCategories();
    }


    if (isset($_POST["no_elimina_cat"])) {
        $paginaHTML = str_replace("Catalogo prodotti", "Modifica Categoria", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica categoria", $paginaHTML);
        $Elenco_prod = Catalogo::show_modifyCategory($_POST["cat_id_2"]);
    }


    // upload di una o più immagini
    if (isset($_POST["upload_img"])) {

        $result = Catalogo::uploadImg($_POST["product_id_img"], $_POST["category_id_img"]);
        $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica prodotto", $paginaHTML);
        $Elenco_prod = Catalogo::show_modifyProduct($_POST["product_id_img"]);

        $paginaHTML = Catalogo::sendError($result[0], $result[1], $result[2], $paginaHTML);
    }

    // Funzioni che ritornano l'HTML da mostrare a video
    // inizio catalogo prodotti

    if (isset($_POST["modifica_prod"])) { // funzione che mostra la pagina di modifica del prodotto selezionato
        $paginaHTML = str_replace("Catalogo prodotti", "Modifica Prodotto", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Modifica prodotto", $paginaHTML);
        $Elenco_prod = Catalogo::show_modifyProduct($_POST["product_id"]);
    }

    if (isset($_GET["new_product"])) { // pagina per la creazione di un nuovo prodotto
        $paginaHTML = str_replace("Catalogo prodotti", "Creazione nuovo prodotto", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Creazione nuovo prodotto", $paginaHTML);
        $Elenco_prod = Catalogo::show_newProduct();

        if ($Elenco_prod == 0)
            Catalogo::sendError("error", "Errore:", "Devi prima creare una categoria!", $paginaHTML);
    }
    // fine catalogo prodotti

    // inizio catalogo categorie
    if (
        isset($_GET["lista_categorie"]) || isset($_POST["annulla_modifica_cat"]) || isset($_POST["annulla_new_cat"])
    ) { // mostra lista delle categorie

        $paginaHTML = str_replace("Catalogo prodotti", "Lista Categorie", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / Categorie", $paginaHTML);
        $Elenco_prod = Catalogo::show_allCategories();
    }

    if (isset($_POST["new_category"])) { // pagina per la creazione di nuova categoria
        $paginaHTML = str_replace("Catalogo prodotti", "Creazione nuova categoria", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / <a href=\"catalogo.php?lista_categorie=Lista+delle+Categorie\">Categorie</a> / Creazione nuova categoria", $paginaHTML);
        $Elenco_prod = Catalogo::show_newCategory();
    }

    if (isset($_POST["modifica_cat"])) { // pagina per la modifica della categoria
        $paginaHTML = str_replace("Catalogo prodotti", "Modifica Categoria", $paginaHTML);
        $paginaHTML = Catalogo::getBreadCrumb(" / <a href=\"catalogo.php\">Catalogo</a> / <a href=\"catalogo.php?lista_categorie=Lista+delle+Categorie\">Categorie</a> / Modifica categoria", $paginaHTML);
        $Elenco_prod = Catalogo::show_modifyCategory($_POST["category_id"]);
    }
    // fine catalogo categorie

    $paginaHTML = str_replace($target, $Elenco_prod, $paginaHTML);
    echo $paginaHTML;
} else // utente non è admin o non loggato
    header("Location: index.php");

?>