<?php
session_start();
if (isset($_SESSION["username"])) {
    header("Location: index.php");
}
else{
    require_once "PHP/class.php";
    $template=Access::getHeader("Login", "Accedi al tuo account.", "accedi, login, registrati, signup, crea account, username, email", "guest", "guest", "<span lang=\"en\">Home - Login</span>");
}

$template.= file_get_contents('HTML/login.html');

$err = isset($_SESSION['error']) ? $_SESSION['error'] : null;

try {
    if (isset($err)){
        $template = str_replace("<!-- errors -->", $err, $template);
        unset($_SESSION["error"]);
    }
    echo $template;
} catch (Exception $e) {
    //errore 500
}
?>