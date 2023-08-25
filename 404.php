<?php

session_start();

require_once "PHP/class.php";

$title = "Pagina non trovata";
$description = "Pagina di errore";
$keywords = "404";

if (isset($_SESSION["username"])) {
    $pagina = Access::getHeader($title, $description, $keywords, $_SESSION["ruolo"]);
} else {
    $pagina = Access::getHeader($title, $description, $keywords);
}

$pagina .= file_get_contents("HTML/404.html");
echo $pagina;
?>