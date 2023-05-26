<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$paginaHTML = file_get_contents("HTML/profilo.html");
$result = "";



if(/*isset($_SESSION["username"]) &&*/ isset($_POST["old_password"])  && isset($_POST["new_password"]) 
    && isset($_POST["new_password_repeat"]) && isset($_POST["cambia_password"])) {

        $connessioneRiuscita = $connessione->openDBConnection();

        if($_POST["new_password"] == $_POST["new_password_repeat"]) {

            $result = $connessione->checkOldPassword(/*$_SESSION["username"]*/"user", $_POST["old_password"]);
            
            if($result) {
            $result2 = $connessione->ChangePassword(/*$_SESSION["username"]*/"user", $_POST["old_password"], $_POST["new_password"]);
            $connessione->closeConnection();
            header("Location: ../profilo.php");
            }
        }
        else {
            $_SESSION["error_new_pass"]="<img id=\"passNOT_combaciano\" src=\"img/Xrossa.png\" alt=\"Le due nuove <span lang=\en\">password</span> non sono uguali.
            \ height=\"15px\" width=\"15px\"/>";
                $connessione->closeConnection(); 
                header("Location: ../profilo.php");
        }
        $connessione->closeConnection();
        if(isset($result)) {
            $_SESSION["error_old_pass"]=$result;
            $_SESSION["error_old_pass2"]="<img id=\"old_passwordNOT_giusta\" src=\"img/Xrossa.png\" alt=\"Vecchia password sbagliata.\" height=\"15px\" width=\"15px\"/>";
        }
        else if(isset($result2)) {
            $_SESSION["error_generic"]=$result2;
            $_SESSION["error_generic2"]="<img id=\"errore_generico\" src=\"img/Xrossa.png\" alt=\"Errore nella modifica della password.\" height=\"15px\" width=\"15px\"/>";
        
        }

        }
    

echo $paginaHTML;

?>
