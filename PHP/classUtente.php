<?php

require_once("connessione2.php");

class Utente {

    public static function get() {
        return DBAccess::dbQuery("SELECT * FROM utente WHERE ruolo = 'user'");
    }
    
    public static function isAdmin($username) {
        //if (!isset) return false;
        $amministratore = DBAccess::dbQuery("SELECT * FROM utente WHERE username = ? ruolo = 'admin'", $username);
        $amministratore = $amministratore['username'];
        return $amministratore == $username;
    }
    
    public static function isUser($username) {
        return (DBAccess::dbQuery("SELECT * FROM utente WHERE username = ? ruolo = 'user'", $username) === $username);
    }

    public static function insert($username, $password, $email) {
        return DBAccess::dbQuery("INSERT INTO utente (username, password, email, ruolo, data_creazione) VALUES (?, ?, ?, current_timestamp())", $username, $password, $email);
    }

    public static function delete($username) {
        return DBAccess::dbQuery("DELETE FROM utente WHERE username = ? AND ruolo = 'user'", $username);
    }
}
?>