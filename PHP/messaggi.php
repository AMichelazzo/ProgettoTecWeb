<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();

if (1) { //isset($_GET["mess"])
    $result = $id = $username = $msg = $replace ="";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->getMessage($_GET["mess"]);
    $connessione->closeConnection();
    if(count($result)>0){
        $id=$result[0]['Id'];
        $username=$result[0]['Username'];
        $msg=$result[0]['Msg'];
      
    
        $replace = array("Id Messaggio" =>$id,
                            "Username Utente" =>$username,
                            "Messaggio Utente" =>$msg);
                      
    }
    else{
        header("Location: ../PHP/categorie.php");
    }

    $paginaHTML = file_get_contents("../HTML/messaggi.html");
        foreach($replace as $key => $value)
                $paginaHTML = str_replace($key, $value, $paginaHTML);
        echo $paginaHTML;
}
?>