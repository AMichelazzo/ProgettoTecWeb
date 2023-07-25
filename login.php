<?php
session_start();
if (isset($_SESSION["username"])) {
    header("Location: index.php");
} else {
    require_once "PHP/class.php";
    $template = Access::getHeader("Login", "Accedi al tuo account.", "accedi, login, registrati, signup, crea account, username, email", "guest", "guest", "Login</span>");
}
$template = str_replace('<div id="riservata"><a href="login.php">Area Riservata</a></div>', '', $template);
$template .= file_get_contents('HTML/login.html');

$err = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$reg = isset($_SESSION["reg_eff"]) ? $_SESSION["reg_eff"] : null;

if ((isset($err) xor isset($reg))) {
    if (isset($err)) {
        $template = str_replace("<!-- errors -->", $err, $template);
        unset($_SESSION["error"]);
    } else {
        $template = str_replace("<!-- errors -->", $reg, $template);
        unset($_SESSION["reg_eff"]);
    }
}
echo $template;
?>