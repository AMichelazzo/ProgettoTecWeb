<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$paginaHTML = file_get_contents("../HTML/profilo.html");
$result = "";


if(isset($_POST["cambia_password"])) 
{
    $username = /*$_SESSION["username"]*/ "user";
    $oldpassword = $_POST["old_password"];
    $newpassword = $_POST["new_password"];
    $newpassword_repeat = $_POST["new_password_repeat"];

    // da aggiungere controllo lato server e client sulle password (lunghezza, caratteri ecc..)

    if($newpassword == $newpassword_repeat)  {
        $result = $connessione->checkOldPassowrd($username, $oldpassword);

        if($result) {  // vecchia password giusta

            $result = $connessione->ChangePassword($username, $oldpassword, $newpassword);


        }
        else {   //vecchia password sbagliata
        }

    }
    else {}
      // errore: nuova password e password repeat non sono uguali!!
      // altrimenti farlo con js?

    
}

$connessione->closeConnection();

echo $result;

?>