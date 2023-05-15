<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();

if(isset($_POST["username"]) || isset($_POST["messaggio"]))
{
    $user = $_POST["username"];
    $msg = $_POST["messaggio"];

    $result = $connessione->new_Message($user, 1, $msg);
    $connessione->closeConnection();

    if ($result) {
        $response["success"] = true;
        $response["message"] = "Messaggio inviato correttamente";
    }
    else
    {
        $response["success"] = false;
        $response["message"] = "Errore nell'invio del messaggio";
    }

    echo json_encode($response);
}

$paginaHTML = file_get_contents("../HTML/contatti.html");
echo $paginaHTML;

?>


