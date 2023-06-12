<?php

session_start();

if (isset($_SESSION["username"])) {
    if (isset($_SESSION["ruolo"]) == "utente") {
        // carica header utente registrato
        $pagina = file_get_contents("HTML/headerUtente.html");
        require_once "PHP/header.php";
    
    } elseif (isset($_SESSION["ruolo"]) == "amministratore") {
        $pagina = file_get_contents("HTML/headerAmministratore.html");
    }
} else {
    $pagina = file_get_contents("HTML/headerSemplice.html");
}
// inserire info nell'header
// carica contenuto
// carica footer

$titolo = "TITOLO";

echo $pagina;
?>