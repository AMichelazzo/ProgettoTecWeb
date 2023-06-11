<?php

require_once "connessione2.php";


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
            $result = $result[Nome];
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

    public static function getProductsbyCategory($id_categoria)
    {
        return DBAccess::dbQuery("SELECT * FROM prodotti WHERE id_categoria = ?", $id_categoria);
    }

    public static function getProduct($id_prodotto)
    {
        return DBAccess::dbQuery("SELECT prodotti.id_prodotto, prodotti.id_categoria, prodotti.Nome, prodotti.Descrizione, immagini.path, immagini.alt_img FROM prodotti LEFT JOIN immagini on prodotti.id_prodotto = immagini.id_prodotto WHERE prodotti.id_prodotto = ?", $id_prodotto);
    }
}