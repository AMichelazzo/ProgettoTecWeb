<?php
session_start();
require_once "PHP/class.php";
if (isset($_SESSION["username"])) {
    header("Location: index.php");
}
else{
    $template=Access::getHeader("Registrati", "Registra un nuovo account.", "registrati, signup, accedi, login, crea account, username, email", "guest", "guest", "<span lang=\"en\">Home</span> - Registrati");
}

$template .= file_get_contents('HTML/registrazione.html');

$errUs = isset($_SESSION['error_user']) ? $_SESSION['error_user2'] : null;
$errEm = isset($_SESSION['error_email']) ? $_SESSION['error_email2'] : null;
$errPw = isset($_SESSION['error_pass']) ? $_SESSION['error_pass'] : null;

try {
    if (isset($errUs)){
        $template = str_replace("<!--user-->", $errUs, $template);
        $template = str_replace("Pinco Pallino", $_SESSION['error_user'], $template);
        unset($_SESSION["error_user"]);
        unset($_SESSION["error_user2"]);
    }
    if (isset($errEm)){
        $template = str_replace("<!--email-->", $errEm, $template);
        $template = str_replace("email@test.org", $_SESSION['error_email'], $template);
        unset($_SESSION["error_email"]);
        unset($_SESSION["error_email2"]);
    }
    if (isset($errPw)){
        $template = str_replace("<!--password-->", $errPw, $template);
        unset($_SESSION["error_pass"]);
    }
    echo $template;
} catch (Exception $e) {
    //errore 500
}
?>