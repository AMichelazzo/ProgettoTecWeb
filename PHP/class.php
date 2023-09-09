<?php

require_once "connessione2.php";
//use DBAccess;


class Access
{

    /* FUNZIONI UTENTI */
    public static function getUtenti() /*solo quelli con ruolo user*/
    {
        return DBAccess::dbQuery("SELECT * FROM utente WHERE ruolo = 'user'");
    }

    public static function deleteUtente($username)
    {
        return DBAccess::dbQuery("DELETE FROM utente WHERE username = ? AND ruolo = 'user'", $username);
    }

    public static function getUserEmail($username)
    {
        $result = DBAccess::dbQuery("SELECT DISTINCT email FROM utente WHERE username = ?", $username);
        if ($result !== false && $result !== null) {
            $result = $result[0]['email'];
        }
        return $result;
    }

    public static function checkLogin($user, $pass)
    {
        $result = DBAccess::dbQuery("SELECT * FROM `utente` WHERE `username`= ?", $user);
        if ($result !== false && $result !== null && password_verify($pass, $result[0]['password'])) {
            $result = array(
                "username" => $result[0]['username'],
                "ruolo" => $result[0]['ruolo']
            );
        } else {
            $result = null; // per avere lo stesso comportamento di connessione
        }
        return $result;
    }

    public static function checkOldPassword($user, $old)
    {
        $result = DBAccess::dbQuery("SELECT `utente`.`password` FROM `utente` WHERE `username`= ?", $user);
        return (isset($result) && $result !== false && $result !== null && password_verify($old, $result[0]['password']));
    }

    public static function ChangePassword($user, $old, $new)
    {
        $password = password_hash($new, PASSWORD_DEFAULT);
        (self::checkOldPassword($user, $old)) ? $result = DBAccess::dbQuery("UPDATE utente SET password = ? WHERE username = ?", $password, $user) : $result = false;
        return $result;
    }

    public static function checkUsern($user)
    {
        $result = DBAccess::dbQuery("SELECT username FROM utente WHERE username = ?", $user);
        if (empty($result))
            return null;
        return $result;
    }

    public static function checkEmail($email)
    {
        $result = DBAccess::dbQuery("SELECT email FROM utente WHERE email = ?", $email);
        if (empty($result))
            return null;
        return $result;
    }

    public static function registraNuovoUtente($pass_reg, $username_reg, $email_reg)
    {
        $password = password_hash($pass_reg, PASSWORD_DEFAULT);
        return DBAccess::dbQuery("INSERT INTO `utente` (`username`, `password`, `email`, `ruolo`) VALUES (?, ?, ?, 'user')", $username_reg, $password, $email_reg);
    }



    /* FUNZIONI CATEGORIE */

    public static function getAllCategories()
    {
        return DBAccess::dbQuery("SELECT * FROM categoria");
    }

    public static function getCategories() // categorie che hanno almeno un prodotto
    {
        return DBAccess::dbQuery("SELECT c.id_categoria, c.Nome, c.Descrizione, i.path, i.alt_img
                                    FROM `categoria`c join immagini i on c.id_categoria=i.id_categoria
                                    WHERE EXISTS (SELECT *
                                                FROM prodotti p
                                                WHERE c.id_categoria = p.id_categoria)
                                    GROUP BY c.id_categoria;");
    }

    public static function getCategoryById($id_categoria)
    {
        return DBAccess::dbQuery("SELECT * FROM categoria WHERE id_categoria = ?", $id_categoria);
    }

    public static function getCategoryName($id_categoria)
    {
        $result = DBAccess::dbQuery("SELECT DISTINCT Nome FROM categoria WHERE id_categoria = ?", $id_categoria);
        if ($result !== false && $result !== null) {
            $result = $result[0]['Nome'];
        }
        return $result;
    }

    public static function newCategory($nome, $descrizione)
    {
        return DBAccess::dbQuery("INSERT INTO categoria(Nome, Descrizione) VALUES (?, ?)", $nome, $descrizione);
    }

    public static function modifyCategory($id_categoria, $nome, $descrizione)
    {
        return DBAccess::dbQuery("UPDATE categoria SET Nome = ?, Descrizione = ? WHERE id_categoria = ?", $nome, $descrizione, $id_categoria);
    }

    public static function deleteCategory($id_categoria)
    {
        return DBAccess::dbQuery("DELETE FROM categoria WHERE id_categoria = ?", $id_categoria);
    }


    /* FUNZIONI PRODOTTI */

    public static function getProduct($id_prodotto)
    {
        return DBAccess::dbQuery("SELECT prodotti.id_prodotto, prodotti.id_categoria, prodotti.Nome, prodotti.Descrizione, immagini.path, immagini.alt_img 
        FROM prodotti LEFT JOIN immagini ON  prodotti.id_prodotto = immagini.id_prodotto WHERE prodotti.id_prodotto = ?", $id_prodotto);
    }

    public static function getAllProducts()
    {
        return DBAccess::dbQuery("SELECT id_prodotto, prodotti.id_categoria, prodotti.Descrizione, categoria.Nome AS Cat_Nome, prodotti.Nome AS Prod_Nome 
        FROM prodotti JOIN categoria on prodotti.id_categoria = categoria.id_categoria");
    }

    public static function newProduct($nome, $id_categoria, $descrizione)
    {
        $result2 = false;
        $result = DBAccess::dbQuery("INSERT INTO prodotti(id_categoria, Nome, Descrizione) VALUES (?,?,?)", $id_categoria, $nome, $descrizione);

        if ($result) {
            $id_prodotto = DBAccess::dbQuery("SELECT DISTINCT id_prodotto FROM prodotti 
            WHERE id_categoria = ? AND Nome = ? AND Descrizione = ? ", $id_categoria, $nome, $descrizione);

            if ($id_prodotto != false && $id_prodotto != null)
                $result2 = DBAccess::dbQuery("INSERT INTO  tags(Nome,prodotto,categoria) VALUES (?,?,?)", $nome, $id_prodotto[0]['id_prodotto'], $id_categoria);
        }

        if (!$result2)
            Access::deleteProduct($id_prodotto);

        return ($result && $result2);
    }

    public static function modifyProduct($id_prodotto, $id_categoria, $nome, $descrizione)
    {
        return DBAccess::dbQuery("UPDATE prodotti SET id_categoria = ?, Nome = ?, Descrizione = ? WHERE id_prodotto = ?", $id_categoria, $nome, $descrizione, $id_prodotto);
    }

    public static function deleteProduct($id_prodotto)
    {
        $result = DBAccess::dbQuery("SELECT * FROM immagini WHERE `id_prodotto` = ?", $id_prodotto);

        if($result != null)
            for($i = 0; $i < count($result); $i++) {
                Access::deleteImg($result[$i]['path']);
            }

        DBAccess::dbQuery("DELETE FROM `tags` WHERE `prodotto` = ?", $id_prodotto);
        return DBAccess::dbQuery("DELETE FROM `prodotti` WHERE `id_prodotto` = ?", $id_prodotto);
    }

    public static function getProductName($id_prodotto, $id_categoria)
    {
        $result = DBAccess::dbQuery("SELECT DISTINCT Nome FROM prodotti WHERE prodotti.id_prodotto = ? AND prodotti.id_categoria = ?", $id_prodotto, $id_categoria);
        if ($result !== false && $result !== null) {
            $result = $result[0]['Nome'];
        }
        return $result;
    }

    public static function getProductsbyCategory($id_categoria)
    {
        return DBAccess::dbQuery("SELECT `prodotti`.`id_prodotto`,`prodotti`.`id_categoria`,`prodotti`.`Nome`,`prodotti`.`Descrizione`, `immagini`.`path`,`immagini`.`alt_img`  
        FROM `prodotti` LEFT JOIN `immagini` ON `prodotti`.`id_prodotto`=`immagini`.`id_prodotto` AND `prodotti`.`id_categoria`=`immagini`.`id_categoria` 
        WHERE `prodotti`.`id_categoria`= ? 
        GROUP BY `prodotti`.`id_prodotto`", $id_categoria);
    }

    public static function getCategoryIdfromProduct($id_prodotto)
    {
        return DBAccess::dbQuery("SELECT id_categoria FROM prodotti WHERE id_prodotto = ?", $id_prodotto);
    }


    /* FUNZIONI MESSAGGI */

    public static function getMessages()
    {
        return DBAccess::dbQuery("SELECT messaggi.id_messaggio, messaggi.email, messaggi.data, messaggi.msg, messaggi.letto, prodotti.id_prodotto, prodotti.Nome
        FROM messaggi LEFT JOIN prodotti ON messaggi.id_prodotto = prodotti.id_prodotto
        ORDER BY messaggi.data DESC");
    }

    public static function newMessage($email, $id_prodotto, $id_categoria, $msg)
    {
        $currentDate = date("Y-m-d");
        return DBAccess::dbQuery("INSERT INTO messaggi(msg, data, id_prodotto, id_categoria, email) VALUES (?,?,?,?,?)", $msg, $currentDate, $id_prodotto, $id_categoria, $email);
    }

    public static function Message_Read($id_messaggio)
    {
        return DBAccess::dbQuery("UPDATE messaggi SET letto = '1' WHERE id_messaggio = ? AND  letto = '0'", $id_messaggio);
    }

    public static function delete_Message($id_messaggio)
    {
        return DBAccess::dbQuery("DELETE FROM messaggi WHERE id_messaggio = ?", $id_messaggio);
    }



    /* FUNZIONI WISHLIST */

    public static function addtoWishList($id_prodotto, $id_categoria, $username)
    {
        return DBAccess::dbQuery("INSERT INTO `wishlist` (`username`, `id_prodotto`, `id_categoria`) VALUES (?,?,?)", $username, $id_prodotto, $id_categoria);
    }

    public static function removeFromWishList($id_prodotto, $id_categoria, $username)
    {
        return DBAccess::dbQuery("DELETE FROM wishlist WHERE `wishlist`.`username` = ? AND `wishlist`.`id_prodotto` = ? AND `wishlist`.`id_categoria`=?", $username, $id_prodotto, $id_categoria);
    }

    public static function isInWishList($idprod, $idcat, $user) // ritorna true se vero, ritorna null se falso, ritorna false se errore
    {
        return DBAccess::dbQuery("SELECT * FROM `wishlist` WHERE `username`=? AND `id_prodotto`=? AND `id_categoria`=?", $user, $idprod, $idcat);
        // su connessione ritornava isset(row) CONTROLLARE SE FUNZIONA
    }

    public static function getProductsOnWishlist($username)
    {
        $result = DBAccess::dbQuery("SELECT `wishlist`.`id_prodotto` FROM `wishlist` JOIN `utente` on `wishlist`.`username`=`utente`.`username` WHERE `wishlist`.`username` = ?", $username);
        if (empty($result))
            return null;
        return $result;
    }


    /* FUNZIONI IMMAGINI */

    public static function getProductImages($id_prodotto)
    {
        return DBAccess::dbQuery("SELECT immagini.path, immagini.alt_img 
        FROM immagini LEFT JOIN prodotti ON immagini.id_prodotto = prodotti.id_prodotto AND immagini.id_categoria=prodotti.id_categoria 
        WHERE immagini.id_prodotto = ?", $id_prodotto);
    }

    public static function getHomeImages()
    {
        return DBAccess::dbQuery("SELECT immagini.path, immagini.alt_img, prodotti.id_prodotto
                                FROM immagini LEFT JOIN prodotti ON immagini.id_prodotto = prodotti.id_prodotto AND immagini.id_categoria = prodotti.id_categoria 
                                GROUP BY immagini.id_prodotto,immagini.id_categoria 
                                ORDER BY RAND()
                                LIMIT 5");
    }

    public static function deleteImg($path_img)
    {
        unlink($path_img);
        return DBAccess::dbQuery("DELETE FROM immagini WHERE `path` = ?", $path_img);
    }

    public static function newImg($path, $id_prodotto, $id_categoria)
    {
        return DBAccess::dbQuery("INSERT INTO immagini(id_prodotto, id_categoria, `path`) VALUES (?,?,?)", $id_prodotto, $id_categoria, $path);
    }

    public static function update_altImg($alt, $path)
    {
        return DBAccess::dbQuery("UPDATE immagini SET alt_img = ? WHERE `path` = ?", $alt, $path);
    }


    /* FUNZIONI KEYWORDS */

    public static function getKeyWordsProdotto($id_prodott)
    {
        return DBAccess::dbQuery("SELECT `Nome` FROM `tags` WHERE `prodotto` = ?", $id_prodott);
    }

    public static function getKeyWordsCategoria($id_categ)
    {
        return DBAccess::dbQuery("SELECT `Nome` FROM `tags` WHERE `categoria` = ? LIMIT 20", $id_categ);
    }


    public static function getHeader($title, $description, $keywords, $ruolo = null, $category = null, $linkcategory = null, $uppercategory = null, $linkuppercategory = null, $noindex = false)
    {
        $pagina = "";
        if ($ruolo == "user") {
            $pagina = file_get_contents("HTML/headerUtente.html");
        } elseif ($ruolo == "admin") {
            $pagina = file_get_contents("HTML/headerAmministratore.html");
        } else {
            $pagina = file_get_contents("HTML/headerSemplice.html");
        }

        // inserisce noindex
        if ($noindex)
            $pagina = str_replace('<!-- noindex -->', '<meta name="robots" content="noindex">', $pagina);

        // inserisce title
        $pagina = str_replace('<title></title>', '<title>' . Access::deletelang($title) . ' - Véro</title>', $pagina);

        // inserisce description
        $pagina = str_replace('<meta name="description" content="" />', '<meta name="description" content="' . Access::deletelang($description) . '" />', $pagina);

        // inserisce keywords
        $pagina = str_replace('<meta name="keywords" content="" />', '<meta name="keywords" content="' . Access::deletelang($keywords) . '" />', $pagina);

        if ($uppercategory !== null) {
            $breadcrumb = '<p>Ti trovi in: <a href="index.php" lang="en">Home</a> / <a href="' . $linkuppercategory . '">' . $uppercategory . '</a> / ' . '<a href="' . $linkcategory . '">' . $category . '</a> / ' . $title . '</p>';
        } elseif ($category !== null) {
            $breadcrumb = '<p>Ti trovi in: <a href="index.php" lang="en">Home</a> / ' . ' <a href="' . $linkcategory . '">' . $category . '</a> / ' . $title . '</p>';
        } elseif ($title != "Home") {
            $breadcrumb = '<p>Ti trovi in: <a href="index.php" lang="en">Home</a> / ' . $title . '</p>';
        } else {
            $breadcrumb = '<p>Ti trovi in: <span lang="en">Home</span></p>';
        }
        $pagina = str_replace('<p>Ti trovi in: <span lang="en">Home</span></p>', $breadcrumb, $pagina);

        // attiva il link corrente
        switch ($title) {
            case "Home":
                $pagina = str_replace('<li><a href="index.php" lang="en">Home</a></li>', '<li id="currentLink" lang="en">Home</li>', $pagina);
                break;

            case "Prodotti":
                $pagina = str_replace('<li><a href="categorie.php">Prodotti</a></li>', '<li id="currentLink">Prodotti</li>', $pagina);
                break;

            case "Contatti":
                $pagina = str_replace('<li><a href="contatti.php">Contatti</a></li>', '<li id="currentLink">Contatti</li>', $pagina);
                break;

            case "Utenti":
                $pagina = str_replace('<li><a href="utenti.php">Utenti</a></li>', '<li id="currentLink">Utenti</li>', $pagina);
                break;
            
            case "Messaggi":
                $pagina = str_replace('<li><a href="messaggi.php">Messaggi</a></li>', '<li id="currentLink">Messaggi</li>', $pagina);
                break;
            
            case "Profilo":
                $pagina = str_replace('<li><a href="profilo.php">Profilo</a></li>', '<li id="currentLink">Profilo</li>', $pagina);
                break;
            
            case "Lista dei Desideri":
                $pagina = str_replace('<li><a href="listaDesideri.php" >Lista dei desideri</a></li>', '<li id="currentLink">Lista dei Desideri</li>', $pagina);
                break;
            case "Catalogo":
                $pagina = str_replace('<li><a href="catalogo.php">Catalogo</a></li>', '<li id="currentLink">Catalogo</li>', $pagina);

        }
        $pagina2 = Access::lang($pagina);
        return $pagina2;
    }

    public static function lang($str, $link = false) //link verrà eliminato
    {
        $pattern = "#\[(.+?)\]#";
        preg_match_all($pattern, $str, $match);
        $match = $match[0];
        $match = array_unique($match);
        $value = array();
        foreach ($match as $n => $l) {
            if (strpos($l, '\\') === false) {
                $sub = $l;
                $sub = str_replace('[', '', $sub);
                $sub = str_replace(']', '', $sub);
                $sub = str_replace($sub, '<span lang="' . strtolower($sub) . '">', $sub);
                array_push($value, $sub);
            } else {
                array_push($value, '</span>');
            }
        }
        for ($i = 0; $i < count($value); $i++) {
            $str = str_replace($match[$i], $value[$i], $str);
        }
        return $str;
    }

    public static function reverselang($str)
    {
        $pattern = "/<span[^>]+\>/i";
        preg_match_all($pattern, $str, $match);
        $match = $match[0];
        
        $pat2 = '/<\/span>/i';
        preg_match_all($pat2, $str, $match2);
        $match2 = $match2[0];
        $value2 = array();
        
        
        $match = array_unique($match);
        $value = array();
        foreach ($match as $n => $l) {
            if (strpos($l, '</span>') === false) {
                $sub = $l;
                $tmp = $match2[$n];
                $sub = str_replace('<span lang="', '', $sub);
                $sub = str_replace('">', '', $sub);
                $tmp2 = strtoupper($sub);
                $sub = str_replace($sub, '[' . strtoupper($sub) . ']', $sub);
                $tmp = str_replace('</span>', '[\\', $tmp);
                $tmp .= $tmp2 . ']';
                
                array_push($value, $sub);
                array_push($value2, $tmp);
            } else {
                array_push($value, '</span>');
            }
        }
        for ($i = 0; $i < count($value); $i++) {
            $str = str_replace($match[$i], $value[$i], $str);
            $str = str_replace($match2[$i], $value2[$i], $str);
        }
        return $str;
    }

    public static function deletelang($str)
    {
        $pattern = "#\[(.+?)\]#";
        preg_match_all($pattern, $str, $match);
        $match = $match[0];
        $match = array_unique($match);
        foreach ($match as $n => $l) {
            $str = str_replace($match[$n], '', $str);
        }
        return $str;
    }


    public static function is_not_null($text)
    {
        return ($text != NULL && !ctype_space($text));
    }

}