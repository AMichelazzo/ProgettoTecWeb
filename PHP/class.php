<?php

require_once "connessione2.php";
//use DBAccess;


class Access
{
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

    public static function getAllCategories()
    {
        return DBAccess::dbQuery("SELECT * FROM categoria");
    }

    public static function getCategories()
    {
        return DBAccess::dbQuery("SELECT c.id_categoria, c.Nome, c.Descrizione, c.img_path
                                    FROM categoria c
                                    WHERE EXISTS (
                                        SELECT *
                                        FROM prodotti p
                                        WHERE c.id_categoria = p.id_categoria
                                    );
                                    ");
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
        // aggiungere catch exception per prodotti con quella categoria
    }

    public static function getProductsbyCategory($id_categoria)
    {
        return DBAccess::dbQuery("SELECT * FROM prodotti WHERE id_categoria = ?", $id_categoria);
    }

    public static function getProduct($id_prodotto)
    {
        return DBAccess::dbQuery("SELECT prodotti.id_prodotto, prodotti.id_categoria, prodotti.Nome, prodotti.Descrizione, immagini.path, immagini.alt_img FROM prodotti LEFT JOIN immagini on prodotti.id_prodotto = immagini.id_prodotto WHERE prodotti.id_prodotto = ?", $id_prodotto);
    }

    public static function getAllProducts()
    {
        return DBAccess::dbQuery("SELECT id_prodotto, prodotti.id_categoria, prodotti.Descrizione, categoria.Nome AS Cat_Nome, prodotti.Nome AS Prod_Nome FROM prodotti JOIN categoria on prodotti.id_categoria = categoria.id_categoria");
    }

    public static function newProduct($nome, $id_categoria, $descrizione)
    {
        return DBAccess::dbQuery("INSERT INTO prodotti(id_categoria, Nome, Descrizione) VALUES (?,?,?)", $id_categoria, $nome, $descrizione);
    }

    public static function modifyProduct($id_prodotto, $id_categoria, $nome, $descrizione)
    {
        return DBAccess::dbQuery("UPDATE prodotti SET id_categoria = ?, Nome = ?, Descrizione = ? WHERE id_prodotto = ?", $id_categoria, $nome, $descrizione, $id_prodotto);
    }

    public static function deleteProduct($id_prodotto)
    {
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
        $pagina = str_replace('<!-- noindex -->', '<meta name="robots" content="noindex">', $pagina);

        // inserisce title
        $pagina = str_replace('<title></title>', '<title>' . Access::deletelang($title) . ' - Véro</title>', $pagina);

        // inserisce description
        $pagina = str_replace('<meta name="description" content="" />', '<meta name="description" content="' . Access::deletelang($description) . '" />', $pagina);

        // inserisce keywords
        $pagina = str_replace('<meta name="keywords" content="" />', '<meta name="keywords" content="' . Access::deletelang($keywords) . '" />', $pagina);

        if ($uppercategory !== null) {
            $breadcrumb = '<p>Ti trovi in 1: <a href="index.php" lang="en">Home</a> >> <a href="' . $linkuppercategory . '">' . $uppercategory . '</a> >>' . '<a href="' . $linkcategory . '">' . $category . '</a> >> ' . $title . '</p>';
        } elseif ($category !== null) {
            $breadcrumb = '<p>Ti trovi in 2: <a href="index.php" lang="en">Home</a> >> ' . '<a href="' . $linkcategory . '">' . $category . '</a> >> ' . $title . '</p>';
        } elseif ($title != "index") {
            $breadcrumb = '<p>Ti trovi in 3: <a href="index.php" lang="en">Home</a> >> ' . $title . '</p>';
        } else {
            $breadcrumb = '<p>Ti trovi in: <span lang="en">Home</span></p>';
        }
        $pagina = str_replace('<p>Ti trovi in: <span lang="en">Home</span></p>', $breadcrumb, $pagina);

        // attiva il link corrente
        switch ($title) {
            case "index":
                $pagina = str_replace('<li><a href="index.php" lang="en">Home</a></li>', '<li id="currentLink" lang="en">Home</li>', $pagina);
                break;

            case "Prodotti":
                $pagina = str_replace('<li><a href="categorie.php">Prodotti</a></li>', '<li id="currentLink">Prodotti</li>', $pagina);
                break;

            case "Contatti":
                $pagina = str_replace('<li><a href="contatti.php">Contatti</a></li>', '<li id="currentLink">Contatti</li>', $pagina);
                break;
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

    public static function deletelang($str) {
        $pattern = "#\[(.+?)\]#";
        preg_match_all($pattern, $str, $match);
        $match = $match[0];
        $match = array_unique($match);
        foreach ($match as $n => $l) {
            $str = str_replace($match[$n], '', $str);
        }
        return $str;
    }

    public static function getCategoryIdfromProduct($id_prodotto)
    {
        return DBAccess::dbQuery("SELECT id_categoria FROM prodotti WHERE id_prodotto = ?", $id_prodotto);
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
        return DBAccess::dbQuery("INSERT INTO `utente` (`username`, `password`, `email`, `ruolo`, `data_creazione`) VALUES (?, ?, ?, 'user', current_timestamp())", $username_reg, $password, $email_reg);
    }

    public static function getKeyWordsProdotto($id_prodott)
    {
        return DBAccess::dbQuery("SELECT `Nome` FROM `tags` WHERE `prodotto` = ?", $id_prodott);
    }

    public static function getProductsOnWishlist($username)
    {
        $result = DBAccess::dbQuery("SELECT `wishlist`.`id_prodotto` FROM `wishlist` JOIN `utente` on `wishlist`.`username`=`utente`.`username` WHERE `wishlist`.`username` = ?", $username);
        if (empty($result))
            return null;
        return $result;
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
}