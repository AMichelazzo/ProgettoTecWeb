<?php

session_start();

require_once "PHP/class.php";

$title = "Home";
$description = "Homepage";
$keywords = "Homepage, Home, Véro";

if (isset($_SESSION["username"])) {
    $pagina = Access::getHeader($title, $description, $keywords, $_SESSION["ruolo"]);
} else {
    $pagina = Access::getHeader($title, $description, $keywords);
}

$pagina .= file_get_contents("HTML/index.html");
$eliminazione = ( isset($_GET["elim"]) && $_GET["elim"] == true ) ? '<div class="change-success" role="alert">Profilo eliminato con successo!</div>' : null;

if (isset($eliminazione) ){
        $pagina = str_replace('<div role="alert"></div>', $eliminazione, $pagina);
        unset($_SESSION["profiloeliminato"]);
}


$result = Access::getHomeImages();
$slide = '';
$dotContainer = '<div class="slideshow-dots">';
if (!empty($result)) {
    for ($i = 0; $i < count($result); $i++) {
        $slide .= '<div class="mySlides-home fade-home">';
        $slide .= '<img src="' . $result[$i]["path"] . '" alt="' . $result[$i]["alt_img"] . '"class="homeimg" width="500" height="500" data-product-id="' . $result[$i]["id_prodotto"] . '" />';
        $slide .= '</div>';
        $dotContainer .= '<span class="dot" data-slide-index="' . $i . '"></span>';
    }
    $slide .= '<a class="prev-home" >&#10094;</a>';
    $slide .= '<a class="next-home" >&#10095;</a>';
}
$dotContainer .= '</div>';
$pagina = str_replace('<!--slideshow-->', $slide, $pagina);
$pagina = str_replace('<!--dots-->', $dotContainer, $pagina);


echo $pagina;
?>