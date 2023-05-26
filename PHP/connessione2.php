<?php
//namespace DB;

error_reporting(E_ALL); ini_set('display_errors', '1');

class DBAccess {
    private const HOST_DB = "127.0.0.1";
    private const DATABASE_NAME = "tecweb";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private static $connection;

    private static function startConnection() {
        $connection = new mysqli(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

        if ($connection->connect_errno) {
            echo "Fallita"; // funzione per gestire errore 500
        }

        return $connection;
    }

    public static function dbQuery($query, ...$parametri) {
        $connection = self::startConnection();
        $stmt = $connection->prepare($query);

        // controllo parametri
        foreach ($parametri as $parametro) {
            $parametro = mysqli_real_escape_string($connection, $parametro);
        }

        // aggiunta parametri
        if (count($parametri) > 0) {
            $stmt->bind_param( str_repeat("s", count($parametri)), ...$parametri);}
        
        $stmt->execute();
        $queryResult = $stmt->get_result();

        // capire che tipo di query è: SELECT || ALTRO
        // se select deve ritornare delle righe, altrimenti ritorna null?
        // una select ritorna delle righe, se vuota ritorna true, se c'è un errore ritorna false
        // altre non ritornano delle righe, se portano delle modifiche ritorna true, se non porta a delle modifiche?, se c'è un errore false
        
        if (strpos($query, "SELECT") === 0) { /* è una select */
            if ($queryResult === false) {return false;}
            $result = array();
            while ($row = mysqli_fetch_assoc($queryResult)) {
            array_push($result, $row);
            }
        }
        $connection->close();

        return $result;
    }
};

?>