<?php

require_once("connessione2.php");

class Utente {

    public static function get() {
        return DBAccess::dbQuery("SELECT * FROM utente WHERE ruolo = 'user'");
    }
}
?>