<?php

require_once "PHP/class.php";
$paginaHTML = "";
session_start();

if(isset($_SESSION["username"])) {
    if ($_SESSION["ruolo"] != "user")
        header("Location: prototipo.php");

    $paginaHTML = Access::getHeader("Profilo -", "Profilo dell'utente","profilo, cambio password, eliminazione account", $_SESSION["username"], $_SESSION["ruolo"], "Profilo");
}
else
    header("Location: prototipo.php");

$paginaHTML .= file_get_contents("HTML/profilo.html");
$result = "";

if(isset($_SESSION["username"]) && isset($_POST["old_password"])  && isset($_POST["new_password"]) 
    && isset($_POST["new_password_repeat"]) && isset($_POST["cambia_password"])) {

        if($_POST["new_password"] == $_POST["new_password_repeat"]) {

            $result = Access::checkOldPassword($_SESSION["username"], $_POST["old_password"]);
            
            if($result) {
            $result2 =  Access::ChangePassword($_SESSION["username"], $_POST["old_password"], $_POST["new_password"]);
            header("Location: ../profilo.php");
            }
        }
        else {
            $_SESSION["error_new_pass"]="<img id=\"passNOT_combaciano\" src=\"img/Xrossa.png\" alt=\"Le due nuove <span lang=\en\">password</span> non sono uguali.
            \ height=\"15px\" width=\"15px\"/>"; 
                header("Location: ../profilo.php");
        }
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
