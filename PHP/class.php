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

    public static function getCategories()
    {
        return DBAccess::dbQuery("SELECT * FROM 'categoria'");
    }

    public static function getCategory($id_categoria)
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

    public static function getProductsbyCategory($id_categoria) //getProductListANDCheckCategory
    {
        return DBAccess::dbQuery("SELECT * FROM prodotti WHERE id_categoria = ?", $id_categoria);
    }

    public static function getProduct($id_prodotto)
    {
        return DBAccess::dbQuery("SELECT prodotti.id_prodotto, prodotti.id_categoria, prodotti.Nome, prodotti.Descrizione, immagini.path, immagini.alt_img FROM prodotti LEFT JOIN immagini on prodotti.id_prodotto = immagini.id_prodotto WHERE prodotti.id_prodotto = ?", $id_prodotto);
    }

    public static function getAllProducts()
    {
        return DBAccess::dbQuery("SELECT `id_prodotto`, `prodotti`.`id_categoria`, `prodotti`.`Descrizione`, `categoria`.`Nome` AS Cat_Nome, `prodotti`.`Nome` AS Prod_Nome FROM `prodotti` JOIN `categoria` on `prodotti`.`id_categoria` = `categoria`.`id_categoria`");
    }

    public static function newProduct($nome, $id_categoria, $descrizione)
    {
        return DBAccess::dbQuery("INSERT INTO prodotti(id_categoria, Nome, Descrizione) VALUES (?,?,?)", $nome, $id_categoria, $descrizione);
    }

    public static function modifyProduct($id_prodotto, $id_categoria, $nome, $descrizione)
    {
        return DBAccess::dbQuery("UPDATE `prodotti` SET `id_categoria` = ?, `Nome` = ?, `Descrizione` = ? WHERE `id_prodotto` = ?", $id_categoria, $nome, $descrizione, $id_prodotto);
    }

    public static function deleteProduct($id_prodotto)
    {
        return DBAccess::dbQuery("DELETE FROM `prodotti` WHERE `id_prodotto` = ?", $id_prodotto);
    }

    public static function getProductName($id_prodotto, $id_categoria)
    {
        $result = DBAccess::dbQuery("SELECT DISTINCT Nome FROM `prodotti` WHERE `prodotti`.`id_prodotto` = ? AND `prodotti`.`id_categoria` = ?", $id_prodotto, $id_categoria);
        if ($result !== false && $result !== null) {
            $result = $result[0]['Nome'];
        }
        return $result;
    }

    public static function getMessages()
    {
        return DBAccess::dbQuery("SELECT messaggi.id_messaggio, messaggi.email, messaggi.data, messaggi.msg, messaggi.letto, prodotti.id_prodotto, prodotti.Nome
        FROM messaggi LEFT JOIN prodotti ON messaggi.id_prodotto = prodotti.id_prodotto
        ORDER BY letto");
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
        return DBAccess::dbQuery("DELETE FROM messaggi WHERE id_messaggio = ?",$id_messaggio);
    }

    public static function addtoWishList($id_prodotto,$id_categoria,$username)
    {
        return DBAccess::dbQuery("INSERT INTO `wishlist` (`username`, `id_prodotto`, `id_categoria`) VALUES (?,?,?)", $username, $id_prodotto, $id_categoria);
    }

    public static function removeFromWishList($id_prodotto,$id_categoria,$username)
    {
        return DBAccess::dbQuery("DELETE FROM wishlist WHERE `wishlist`.`username` = ? AND `wishlist`.`id_prodotto` = ? AND `wishlist`.`id_categoria`=?", $username, $id_prodotto, $id_categoria);
    }
 
    public static function isInWishList($idprod,$idcat,$user) // ritorna true se vero, ritorna null se falso, ritorna false se errore
    {
        return DBAccess::dbQuery("SELECT * FROM `wishlist` WHERE `username`=? AND `id_prodotto`=? AND `id_categoria`=?", $user, $idprod, $idcat);
        // su connessione ritornava isset(row) CONTROLLARE SE FUNZIONA
    }
    
    public static function checkLogin($user, $pass) {
        $result = DBAccess::dbQuery("SELECT * FROM `utente` WHERE `username`= ?", $user);
        if ($result !== false && $result !== null && password_verify($pass, $result[0]['password'])) {
            $result = array("username" => $result[0]['username'],
            "ruolo" => $result[0]['ruolo']);
        } else {
            $result = null; // per avere lo stesso comportamento di connessione
        }
        return $result;
    }

    public static function checkOldPassword($user, $old)
    {
        return DBAccess::dbQuery("SELECT username FROM utente WHERE username = ? AND password = ?", $user, $old);
    }
    
    public static function ChangePassword($user, $old, $new)
    {
        return DBAccess::dbQuery("UPDATE utente SET password = ? WHERE username = ? AND password = ?", $new, $user, $old);
    }

    public static function getHeader($title, $description, $keywords, $username = null, $ruolo = null, $breadcrumb = null, $category = null)
    {
        $pagina="";
        if ($ruolo == "utente") {
            $pagina = file_get_contents("HTML/headerUtente.html");
        } elseif ($ruolo == "admin") {
            $pagina = file_get_contents("HTML/headerAmministratore.html");
        } else {
            $pagina = file_get_contents("HTML/headerSemplice.html");
        }
        
        require_once "header.php";
        return $pagina;
    }

    public static function lang($stringa, $link = false)
    {
        preg_match('/(\{.+?\})/i', $stringa, $parentesi);
        $language = $parentesi[1];
        $language = str_replace('{', '', $language);
        $language = str_replace('}', '', $language);
        
        if (!$link) {
            $stringa = str_replace('{' . $language . '}', '<span lang="' . strtolower($language) . '">', $stringa);
            $stringa = str_replace('{' . $language . '*}', '</span>', $stringa);
        } else {
            $stringa = str_replace('{' . $language . '}', '<a href="' . $link . '" lang="' . strtolower($language) . '">', $stringa);
            $stringa = str_replace('{' . $language . '*}', '</a>', $stringa);
        }
        return $stringa;
    }

    public static function getCategoryIdfromProduct($id_prodotto) {
        return DBAccess::dbQuery("SELECT id_categoria FROM prodotti WHERE id_prodotto = ?", $id_prodotto);
    }

    public static function checkUsern($user) {
        return DBAccess::dbQuery("SELECT username FROM utente WHERE username = ?", $user);
    }

    public static function checkEmail($email) {
        return DBAccess::dbQuery("SELECT email FROM utente WHERE email = ?", $email);
    }

    public static function registraNuovoUtente($pass_reg,$username_reg,$email_reg) {
        $password = password_hash($pass_reg, PASSWORD_DEFAULT);
        return DBAccess::dbQuery("INSERT INTO `utente` (`username`, `password`, `email`, `ruolo`, `data_creazione`) VALUES (?, ?, ?, 'user', current_timestamp())", $username_reg, $password, $email_reg);
    }

    public static function getKeyWordsProdotto($id_prodott) {
        return DBAccess::dbQuery("SELECT `Nome` FROM `tags` WHERE `prodotto` = ?", $id_prodott);
    }

    public static function getProductsOnWishlist($username) {
        return DBAccess::dbQuery("SELECT `wishlist`.`id_prodotto` FROM `wishlist` JOIN `utente` on `wishlist`.`username`=`utente`.`username` WHERE `wishlist`.`username` = ?", $username);
    }
}