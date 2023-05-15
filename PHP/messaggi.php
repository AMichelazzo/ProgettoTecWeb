<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$paginaHTML = file_get_contents("../HTML/messaggi.html");

$msg_checked = $_POST['form_msg'];
if(!empty($msg_checked))
{
    $N = count($msg_checked);
    for($i=0; $i < $N; $i++)
    {
        $connessione->Message_Read($msg_checked[$i]);
    }
}
else    
    

    $target="Elementi_Messaggi";

    $result=$connessione->getMessages();
    $connessione->closeConnection();
    

    $paginaHTML = str_replace("Elementi_Messaggi", $result, $paginaHTML);

    echo $paginaHTML;
?>