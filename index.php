<?php

session_start(); // ATTENZIONE ALLA BREADCRUMB

require_once "PHP/class.php";

$title = "index";
$description = "Pagina di prova";
$keywords = "Prova";

if (isset($_SESSION["username"])) {
    $pagina = Access::getHeader($title, $description, $keywords, $_SESSION["ruolo"]);
} else {
    $pagina = Access::getHeader($title, $description, $keywords);
}

$pagina .= file_get_contents("HTML/index.html");
$eliminazione=(isset($_GET["elim"])&&$_GET["elim"]==true)? '<div class="change-success" role="alert">Profilo eliminato con successo!</div>':null;
if (isset($eliminazione) ){
        $pagina = str_replace('<div role="alert"></div>', $eliminazione, $pagina);
        unset($_SESSION["profiloeliminato"]);
}
echo $pagina;
?>