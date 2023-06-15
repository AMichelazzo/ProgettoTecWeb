<?php 
    require_once "class.php";

class Catalogo {

    public static function show_allProducts() {     // viene mostrato il catalogo con tutti i prodotti

        $result = "<form action=\"catalogo.php\" method=\"POST\"><p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"new_product\" name=\"new_product\" value=\"Aggiungi nuovo prodotto\" /></p>"
                . "<p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"category_list\" name=\"category_list\" value=\"Vai a lista delle Categorie\" /></p></form>";

        $products = Access::getAllProducts();  

        for($i=0; $i<count($products); $i++) {  // funzione per la creazione dell'inline

            $result .= "<form action=\"catalogo.php\" method=\"POST\">"
                    . "<p class=\"inline\"><input type=\"hidden\" name=\"product_id\" value=\"" . $products[$i]["id_prodotto"] . "\"/></p>"     // mi salvo l'id_prodotto
                    . "<p class=\"inline\"><input type=\"hidden\" name=\"category_id\" value=\"" . $products[$i]["id_categoria"] . "\"/></p>";  // e l'id_categoria

            $result .= "<p class=\"inline\"> Nome prodotto: " . $products[$i]["Prod_Nome"] . " |</p>"    
                    . "<p class=\"inline\"> Categoria: " . $products[$i]["Cat_Nome"] . "|</p>"
                    . "<p class=\"inline\"> Descrizione: " . $products[$i]["Descrizione"] . "</p>"
                    . "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"elimina_prod\" name=\"elimina_prod\" value=\"Elimina\" /></p>"
                    . "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"modifica_prod\" name=\"modifica_prod\" value=\"Modifica\" /></p></form>";
    }
    return $result;
}

    public static function show_modifyProduct($product_id) {  // viene mostrata la pagina di modifica di un prodotto

        $product= Access::getProduct($_POST["product_id"]); 
        $categories = Access::getCategories();

        $result = "<form action=\"catalogo.php\" method=\"POST\">"
                . "<div><input type=\"hidden\" name=\"prod_id\" value=\"" . $product_id . "\"/></div>"
                . "<div><label for=\"nome_prod\">Nome prodotto:</label></div>" 
                . "<div><input type=\"text\" id=\"nome_prod\" name=\"nome_prod\" value=\"" . $product[0]["Nome"] . "\"/></div>"
                . "<div><label for=\"cat_prod\">Categoria prodotto:</label></div><select name=\"category_id\" id=\"categories\">"
                . "<option value=\"" . $_POST["category_id"] . "\">" . Access::getCategoryName($_POST["category_id"]) . "</option>"; // mostra come selezionata la categoria del prodotto
       
        for($i=0; $i<count($categories); $i++) { // creazione del menu a tendina delle varie categorie
            if($categories[$i]["id_categoria"] != $_POST["category_id"]) 
                $result .= "<option value=\"" . $categories[$i]["id_categoria"] . "\">" . $categories[$i]["Nome"] . "</option>";
        }   
        
        $result .= "</select><div><label for=\"desc_prod\">Descrizione prodotto:</label></div>"
                .  "<div><textarea id=\"desc_prod\" name=\"desc_prod\" rows=\"10\" cols=\"40\" maxlength=\"500\">" . $product[0]["Descrizione"]. "</textarea></div>"
                . "<input type=\"submit\" class=\"invio\" id=\"annulla_modifica_prod\" name=\"annulla_modifica_prod\" value=\"Annulla modifiche\"/>"
                . "<input type=\"submit\" class=\"invio\" id=\"submit_modifica_prod\" name=\"submit_modifica_prod\" value=\"Conferma modifiche\"/></form>"; 

        return $result;
    }

    public static function show_newProduct() {  // viene mostrata la pagina per la creazione di un nuovo prodotto
       
        $categories = Access::getCategories();

        $result = "<form action=\"catalogo.php\" method=\"POST\" enctype=\"multipart/form-data\">"
                . "<div><label for=\"new_nome_prod\">Nome prodotto:</label></div>"
                . "<div><input type=\"text\" id=\"nome_prod\" name=\"new_nome_prod\" value=\"\"/></div>"
                . "<div><label for=\"new_category_id\">Categoria prodotto:</label></div>"
                . "<select name=\"new_category_id\" id=\"new_category_id\"> ";

        for($i=0; $i<count($categories); $i++)   // creazione del menu a tendina delle categorie
            $result .= "<option value=\"" . $categories[$i]["id_categoria"] . "\">" . $categories[$i]["Nome"] . "</option>";
        
        $result .= "</select><div><label for=\"new_desc_prod\">Descrizione prodotto:</label></div>"
                . "<div><textarea id=\"new_desc_prod\" name=\"new_desc_prod\" rows=\"10\" cols=\"40\" maxlength=\"500\"></textarea></div>"
                . "<input type=\"submit\" class=\"invio\" id=\"annulla_new_cat\" name=\"annulla_new_prod\" value=\"Annulla creazione prodotto\"/>"
                . "<input type=\"submit\" class=\"invio\" id=\"submit_new_cat\" name=\"submit_new_prod\" value=\"Conferma nuovo prodotto\"/>"; 

        $result .= "<div class=\"upload\"><input type=\"file\" name=\"immagini[]\" multiple><input type=\"submit\" class=\"invio\" name=\"upload\" value=\"Carica immagini prodotti\"></form></div>";
   
        return $result;
    }

    public static function show_allCategories() { // vengono mostrate tutte le categorie

        $categories = Access::getCategories();
        
        $result = "<form action=\"catalogo.php\" method=\"POST\"><p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"new_category\" name=\"new_category\" value=\"Aggiungi nuova categoria\" /></p>";
        $result .= "<p class=\"inline\"><input type=\"submit\" class=\"invio\" value=\"Torna al catalogo prodotti\" /></p></form>";
    
        for($i=0; $i<count($categories); $i++) {

            $result .= "<form action=\"catalogo.php\" method=\"POST\">" 
                    . "<p class=\"inline\"><input type=\"hidden\" name=\"category_id\" value=\"" . $categories[$i]["id_categoria"] . "\"/></p>"     // mi salvo l'id_categoria
                    . "<p class=\"inline\"> Nome: " . $categories[$i]["Nome"] . " |</p>"
                    . "<p class=\"inline\"> Descrizione: " . $categories[$i]["Descrizione"] . ".</p>"
                    ."<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"elimina_cat\" name=\"elimina_cat\" value=\"Elimina\" /></p>"
                    . "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"modifica_cat\" name=\"modifica_cat\" value=\"Modifica\" /></form></p>";
        }

        return $result;
    }
    public static function show_modifyCategory($category_id) {  // viene mostrata la pagina di modifica di una categoria

        $categories = Access::getCategory($category_id); 
         
        $result = "<form action=\"catalogo.php\" method=\"POST\">"
                . "<div><input type=\"hidden\" name=\"cat_id\" value=\"" . $category_id . "\"/></div>"
                . "<div><label for=\"nome_cat\">Nome categoria:</label></div>"
                . "<div><input type=\"text\" id=\"nome_cat\" name=\"nome_cat\" value=\"" . $categories[0]["Nome"] . "\"/></div>"
                . "<div><label for=\"desc_cat\">Descrizione categoria:</label></div>"
                . "<div><textarea id=\"desc_prod\" name=\"desc_cat\" rows=\"10\" cols=\"40\" maxlength=\"500\">" . $categories[0]["Descrizione"]. "</textarea></div>"
                . "<input type=\"submit\" class=\"invio\" id=\"annulla_modifica_prod\" name=\"annulla_modifica_cat\" value=\"Annulla modifiche\"/>"
                . "<input type=\"submit\" class=\"invio\" id=\"submit_modifica_prod\" name=\"submit_modifica_cat\" value=\"Conferma modifiche\"/></form>"; 

        return $result;
    }

    public static function show_newCategory() {     // viene mostrata la pagina per la creazione di un nuova categoria

        return "<form action=\"catalogo.php\" method=\"POST\">"
                    . "<div><label for=\"nome_cat\">Nome categoria:</label></div>"
                    . "<div><input type=\"text\" id=\"new_nome_cat\" name=\"new_nome_cat\" value=\"\"/></div>" 
                    . "<div><label for=\"desc_prod\">Descrizione categoria:</label></div>"
                    . "<div><textarea id=\"new_desc_cat\" name=\"new_desc_cat\" rows=\"10\" cols=\"30\" maxlength=\"500\"></textarea></div>"
                    . "<input type=\"submit\" class=\"invio\" id=\"annulla_new_cat\" name=\"annulla_new_cat\" value=\"Annulla creazione categoria\"/>"
                    . "<input type=\"submit\" class=\"invio\" id=\"submit_new_cat\" name=\"submit_new_cat\" value=\"Conferma nuova categoria\"/></form>"; 
    }

}
?>
