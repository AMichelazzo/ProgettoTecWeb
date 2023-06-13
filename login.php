<?php
session_start();
if (isset($_SESSION["username"])) {
    header("Location: index.php");
}
else{
    require_once "PHP/class.php";
    $template=Access::getHeader("Login", "ciao", "Login, Registrazione", "guest", "guest");
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