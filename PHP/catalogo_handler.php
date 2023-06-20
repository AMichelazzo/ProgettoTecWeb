<?php 
    require_once "class.php";

class Catalogo {

    public static function show_allProducts() {     // viene mostrato il catalogo con tutti i prodotti

        $result = "<form action=\"catalogo.php\" method=\"POST\"><p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"new_product\" name=\"new_product\" value=\"Aggiungi nuovo prodotto\" /></p>"
                . "<p class=\"inline\"><input type=\"submit\" class=\"invio\" id=\"category_list\" name=\"category_list\" value=\"Vai a lista delle Categorie\" /></p></form>";

        $products = Access::getAllProducts();  

        if(empty($products))
            $result .= "<p>Non sono presenti prodotti</p>";
        else
        {
            for($i=0; $i<count($products); $i++) {  // funzione per la creazione dell'inline

                $result .= "<form action=\"catalogo.php\" method=\"POST\" role=\"group\">"
                        . "<p class=\"inline\"><input type=\"hidden\" name=\"product_id\" value=\"" . $products[$i]["id_prodotto"] . "\"/></p>"     // mi salvo l'id_prodotto
                        . "<p class=\"inline\"><input type=\"hidden\" name=\"category_id\" value=\"" . $products[$i]["id_categoria"] . "\"/></p>";  // e l'id_categoria

                $result .= "<p class=\"inline\"> Nome prodotto: " . $products[$i]["Prod_Nome"] . " |</p>"    
                        . "<p class=\"inline\"> Categoria: " . $products[$i]["Cat_Nome"] . "|</p>"
                        . "<p class=\"inline\"> Descrizione: " . $products[$i]["Descrizione"] . "</p>"
                        . "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"elimina_prod\" name=\"elimina_prod\" value=\"Elimina\" /></p>"
                        . "<p class=\"inline\"><input type=\"submit\" class=\"modifica\" id=\"modifica_prod\" name=\"modifica_prod\" value=\"Modifica\" /></p></form>";
        }
    }
    return $result;
}

    public static function show_modifyProduct($product_id) {  // viene mostrata la pagina di modifica di un prodotto

        $product= Access::getProduct($product_id); 
        $categories = Access::getCategories();

        $result = "<form action=\"catalogo.php\" method=\"POST\" enctype=\"multipart/form-data\">"
                . "<div><input type=\"hidden\" name=\"prod_id\" value=\"" . $product_id . "\"/></div>"
                . "<div><label for=\"nome_prod\">Nome prodotto:</label></div>" 
                . "<div><input type=\"text\" id=\"nome_prod\" name=\"nome_prod\" value=\"" . $product[0]["Nome"] . "\"/></div>"
                . "<div><label for=\"cat_prod\">Categoria prodotto:</label></div><select name=\"category_id\" id=\"categories\">"
                . "<option value=\"" . $product[0]["id_categoria"] . "\">" . Access::getCategoryName($product[0]["id_categoria"] ) . "</option>"; // mostra come selezionata la categoria del prodotto
       
        for($i=0; $i<count($categories); $i++) { // creazione del menu a tendina delle varie categorie
            if($categories[$i]["id_categoria"] != $product[0]["id_categoria"] ) 
                $result .= "<option value=\"" . $categories[$i]["id_categoria"] . "\">" . $categories[$i]["Nome"] . "</option>";
        }   
        
        $result .= "</select><div><label for=\"desc_prod\">Descrizione prodotto:</label></div>"
                .  "<div><textarea id=\"desc_prod\" name=\"desc_prod\" rows=\"10\" cols=\"40\" maxlength=\"500\">" . $product[0]["Descrizione"]. "</textarea></div>"
                . "<div id=\"img_products\"><legend>Aggiungi o elimina immagini del prodotto</legend>";

        if($product[0]["path"] == null)
            $result .= "<p>Non sono presenti immagini per questo prodotto.</p>";
        else
            for ($i = 0; $i < count($product); $i++) {
                $result .= "<div class=\"images\">"
                . "<input type=\"checkbox\" name=\"check_img[]\" value=\"". $product[$i]["path"] . "\"/>"
                . "<img src=\"".$product[$i]["path"]."\" alt=\"". $product[$i]["alt_img"]."\" width=\"100\" height=\"100\"/></div>"
                . "<input type=\"hidden\" name=\"path_img[]\" value=\"" . $product[$i]["path"] . "\"/>"
                . "<div><label for=\"alt_img\">Alt immagine:</label></div>"
                . "<textarea id=\"alt_img\" name=\"alt_img[]\" rows=\"4\" cols=\"30\" placeholder=\"Inserisci alt per immagine\">" . $product[$i]["alt_img"] . "</textarea></div>";
            }

        $result .= "<label>Carica una o più immagini per il prodotto (jpg o jpeg). "
                . "<input type=\"hidden\" name=\"product_id_img\" value=\"" . $product_id . "\"/>"
                . "<input type=\"hidden\" name=\"category_id_img\" value=\"" . $product[0]["id_categoria"] . "\"/>"
                . "<input type=\"file\" name=\"img[]\" multiple>"
                . "<input type=\"submit\" class=\"modifica\" name=\"upload_img\" value=\"Carica\"></div>"
                . "<div><input type=\"submit\" class= \"invio\" id=\"elimina_img\" name=\"elimina_img\" value=\"Elimina immagini selezionate\"/>"
                . "<div><input type=\"submit\" class=\"invio\" id=\"annulla_modifica_prod\" name=\"annulla_modifica_prod\" value=\"Annulla modifiche\"/>"
                . "<input type=\"submit\" class=\"invio\" id=\"submit_modifica_prod\" name=\"submit_modifica_prod\" value=\"Conferma modifiche\"/></div></form>";
        
        return $result;
    }

    public static function show_newProduct() {  // viene mostrata la pagina per la creazione di un nuovo prodotto
       
        $categories = Access::getCategories();

        $result = "<form action=\"catalogo.php\" method=\"POST\">"
                . "<div><label for=\"new_nome_prod\">Nome prodotto:</label></div>"
                . "<div><input type=\"text\" id=\"nome_prod\" name=\"new_nome_prod\" value=\"\"/></div>"
                . "<div><label for=\"new_category_id\">Categoria prodotto:</label></div>"
                . "<select name=\"new_category_id\" id=\"new_category_id\"> ";

        for($i=0; $i<count($categories); $i++)   // creazione del menu a tendina delle categorie
            $result .= "<option value=\"" . $categories[$i]["id_categoria"] . "\">" . $categories[$i]["Nome"] . "</option>";
        
        $result .= "</select><div><label for=\"new_desc_prod\">Descrizione prodotto:</label></div>"
                . "<div><textarea id=\"new_desc_prod\" name=\"new_desc_prod\" rows=\"10\" cols=\"40\" maxlength=\"500\"></textarea></div>"
                . "<div><input type=\"submit\" class=\"invio\" id=\"annulla_new_cat\" name=\"annulla_new_prod\" value=\"Annulla creazione prodotto\"/>"
                . "<input type=\"submit\" class=\"invio\" id=\"submit_new_cat\" name=\"submit_new_prod\" value=\"Conferma nuovo prodotto\"/></div></form>"; 

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

    public static function uploadImg($id_prodotto, $id_categoria) {

        if(isset($_FILES['img'])) {

            //&& $_FILES['img']['error'] == UPLOAD_ERR_OK

            $countfiles = count($_FILES['img']['name']);
            $maxsize = 2097152; // 2 MB (1 byte * 1024 * 1024 * 2)  
            $response = 0;

            for($i=0; $i<$countfiles; $i++) {

                $filename = $_FILES['img']['name'][$i];
                $filesize = $_FILES['img']['size'][$i];

                if($filesize > $maxsize) 
                    return  ["error", "Errore caricamento immagine:", "La dimensione dell'immagine è maggiore di 2MB"];

                // Location
                $location = "img/".$filename;
                $extension = pathinfo($location,PATHINFO_EXTENSION);
                $extension = strtolower($extension);

                // Estensioni consentite
                $valid_extensions = array("jpg","jpeg");

                // upload dell'immagine
                if(in_array(strtolower($extension), $valid_extensions)) {
                    if(file_exists($location))
                        return ["error", "Errore caricamento immagine:", "Immagine già presente"];
                    else 
                        if(move_uploaded_file($_FILES['img']['tmp_name'][$i], $location)) {
                            Access::newImg($location, $id_prodotto, $id_categoria); 
                            $response = 1; 
                        }
                        else
                            $response = 0;
                }
                else
                    return ["error", "Errore caricamento immagine:", "Tipo dell'immagine errato (usare jpg o jpeg)"];
            }
        
            if($response)
                return ["success", "Caricamento riuscito:", "Immagine caricata correttamente"];
            else    
                return ["error", "Errore caricamento immagine:", "Errore nel caricamento dell'immagine"];

        }
        else
            return  ["error", "Errore caricamento immagine:", "Nessuna immagina è stata selezionata"];
    }

    public static function sendError($class, $sr, $text, $pagina) {

        if($class == "success")
            $pagina = str_replace("catalogo_class", "success-message", $pagina);
        else
            $pagina = str_replace("catalogo_class", "error-message", $pagina);

        $pagina = str_replace("<!--Contenuto_sr-->", $sr, $pagina);
        $pagina = str_replace("<!--Contenuto_errors-->", $text, $pagina);

        return $pagina;
    }
       
}


?>
