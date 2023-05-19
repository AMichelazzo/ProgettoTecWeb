<?php
require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
session_start();
if (isset($_SESSION["username"])) {
    if (isset($_SESSION["is_admin"]))
        header("Location: ../prototipo.php");
    else
        header("Location: ../index.php");
}
else
{
    if(isset($_POST["username"],$_POST["password"]))
    {
        $replace = "";
        $connessioneRiuscita = $connessione->openDBConnection();
        $result=$connessione->checkLogin($_POST["username"],$_POST["password"]);
        $connessione->closeConnection(); 
        if(isset($result)){
            $_SESSION["username"]=$result['username'];
            $_SESSION["ruolo"]=$result['ruolo'];
        }
        else
        {
            $_SESSION["error"]="<div id='Login-Error'>Password o Username Errati!</div>";
        }
    }
    header("Location: ../login.php");
}

?>