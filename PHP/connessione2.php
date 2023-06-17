<?php

class DBAccess
{
    private const HOST_DB = "127.0.0.1";
    private const DATABASE_NAME = "tecweb";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private static $connection;

    private static function startConnection()
    {
        try {
            return new mysqli(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function dbQuery($query, ...$parametri)
    {
        $connection = self::startConnection();
        if ($connection === false) {return false;}
        
        $stmt = $connection->prepare($query);
        // controllo parametri
        foreach ($parametri as $parametro) {
            $parametro = mysqli_real_escape_string($connection, $parametro);
        }
        // aggiunta parametri
        if (count($parametri) > 0) {
            $stmt->bind_param(str_repeat("s", count($parametri)), ...$parametri);
        }
        $stmt->execute();
        $queryResult = $stmt->get_result();

        $select = false;
        if (strpos($query, "SELECT") === 0) { // verifica se è una select
            $select = true;
        }

        if ($stmt->errno != 0) {
            $connection->close(); return false; // messaggio di errore
        }

        if (empty($queryResult)) { // senza risultato
            if ($select) {
                $queryResult->free(); $connection->close(); return null;
            } else {
                $connection->close(); return true;
            }
        }

        $result = array();
        while ($row = mysqli_fetch_assoc($queryResult)) {
            array_push($result, $row);
        }
        $queryResult->free();
        $connection->close();
        return $result;
    }
}

function error500()
{
    http_response_code(500);
    echo file_get_contents("HTML/500.html");
    exit();
}


/*
class DBAccess // NUOVA VERSIONE
{
    private const HOST_DB = "127.0.0.1";
    private const DATABASE_NAME = "tecweb";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private static $connection;

    private static function startConnection()
    {
        try {
            return new mysqli(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function dbQuery($query, ...$parametri)
    {
        $connection = self::startConnection();
        if ($connection === false) {return false;}
        
        $stmt = $connection->prepare($query);
        // controllo parametri
        foreach ($parametri as $parametro) {
            $parametro = mysqli_real_escape_string($connection, $parametro);
        }
        // aggiunta parametri
        if (count($parametri) > 0) {
            $stmt->bind_param(str_repeat("s", count($parametri)), ...$parametri);
        }
        $stmt->execute();
        $queryResult = $stmt->get_result();
        $select = false;
        
        if (strpos($query, "SELECT") === 0) { // verifica se è una select
            $select = true;
        }

        if ($stmt->errno != 0) {
            $connection->close(); return false; // messaggio di errore
        }

        if ($select) {
            $result = array();
            while ($row = mysqli_fetch_assoc($queryResult)) {
                array_push($result, $row);
            }
            $queryResult->free();
            $connection->close();
            if (empty($result)) {
                return null;
            } else {
                return $result;
            }
        } else {
            $connection->close();
            return true;
        }
    }
}

function error500()
{
    http_response_code(500);
    echo file_get_contents("HTML/500.html");
    exit();
}*/

?>