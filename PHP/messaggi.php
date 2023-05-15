<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$target="Elementi_Messaggi";
$paginaHTML = file_get_contents("../HTML/messaggi.html");


if(isset($_POST['form_msg']))
{
    $msg_checked = $_POST['form_msg'];
    if(!empty($msg_checked))
    {
        $N = count($msg_checked);
        for($i=0; $i < $N; $i++)
        {
            $connessione->Message_Read($msg_checked[$i]);
        }
    }
}  
   
$result=$connessione->getMessages();
$connessione->closeConnection();
    

$paginaHTML = str_replace("Elementi_Messaggi", $result, $paginaHTML);

echo $paginaHTML;
?>
