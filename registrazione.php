<?php
session_start();
require_once "PHP/class.php";
if (isset($_SESSION["username"])) {
    header("Location: index.php");
}
else{
    $template=Access::getHeader("Registrati", "Registra un nuovo account.", "registrati, signup, accedi, login, crea account, username, email");
}
$template=str_replace('<div id="riservata"><a href="login.php">Area Riservata</a></div>',"",$template);
$template .= file_get_contents('HTML/registrazione.html');

$errUs = isset($_SESSION['error_user']) ? $_SESSION['error_user2'] : null;
$errEm = isset($_SESSION['error_email']) ? $_SESSION['error_email2'] : null;
$errPw = isset($_SESSION['error_pass']) ? $_SESSION['error_pass'] : null;
$gen = isset($_SESSION["genericError"])? $_SESSION['genericError']:null;

if (isset($gen)){
    $template = str_replace('<div id="msgchange" role="alert"></div>', $gen, $template);
    unset($_SESSION["genericError"]);
}
if (isset($errUs)){
    $template = str_replace("<!--user-->", $errUs, $template);
    $template = str_replace('name="username_reg" placeholder=""', 'name="username_reg" placeholder="'.$_SESSION['error_user'].'"', $template);
    unset($_SESSION["error_user"]);
    unset($_SESSION["error_user2"]);
}
if (isset($errEm)){
    $template = str_replace("<!--email-->", $errEm, $template);
    $template = str_replace('name="email_reg" placeholder=""', 'name="email_reg" placeholder="'.$_SESSION['error_email'].'"', $template);
    unset($_SESSION["error_email"]);
    unset($_SESSION["error_email2"]);
}
if (isset($errPw)){
    $template = str_replace("<!--password-->", $errPw, $template);
    unset($_SESSION["error_pass"]);
}
echo $template;
?>