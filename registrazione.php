<?php
session_start();
if (isset($_SESSION["username"])) { // non so se lasciarlo (come su login), non so se va bene non lasciare l'accesso alla pagina se l'utente è loggato
    if (isset($_SESSION["ruolo"])&&$_SESSION["ruolo"]=="admin")
        header("Location: prototipo.php");
    else
        header("Location: index.php");
}
$template = (file_get_contents('HTML/registrazione.html'));

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