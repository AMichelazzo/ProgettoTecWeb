<?php
session_start();
if (isset($_SESSION["username"])) {
    require_once "PHP/class.php";
    $template = Access::getHeader("Lista dei Desideri", "Lista dei desideri", "Wishlist, lista dei desideri, prodotti piaciuti, prodotto", $_SESSION["ruolo"], null, null, null, null, true);
} else {
    header("Location: index.php");
}

$template .= file_get_contents('HTML/listaDesideri.html');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
} else {
    $replace = "";
    $productlist = "";
    $msg = "<div id=\"msgWish\" role=\"alert\"></div>";
    $result = Access::getProductsOnWishlist($_SESSION["username"]);
    if (isset($result)) {
        if (count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                $result2 = Access::getProduct($result[$i]["id_prodotto"]);
                $nome = $result2[0]['Nome'];
                $desc = $result2[0]['Descrizione'];
                $idprod = $result2[0]['id_prodotto'];
                $cat = Access::getCategoryById($result2[0]['id_categoria'])[0]["Nome"];
                $idcat = $result2[0]['id_categoria'];
                $img = "<img src=\"" . $result2[0]["path"] . "\" alt=\"" . $result2[0]["alt_img"] . "\" width=\"200\" height=\"200\"/>";

                $productlist .= "<form action=\"contatti.php\" class=\"prodotto\" name=\"form-prodotto\" method=\"post\">";
                $productlist .= "<div class=\"image-container\">";
                $productlist .= $img;
                $productlist .= "<button class=\"open-button\" aria-label='Ingrandisci' id=\"" . $result2[0]["path"] . "\"><img src=\"img/lente.png\" alt=\"Ingrandisci immagine.\" /></button>";
                $productlist .= "</div>";
                $productlist .= "<div class=\"contentProdotto\">";
                $productlist .= "<div class=\"nome\">Nome prodotto: " . $nome . "</div>";
                $productlist .= "<div class=\"descrizione\">Descrizione: " . $desc . "</div>";
                $productlist .= "<div class=\"categoria\">Categoria: <span><a class=\"wish-link\" href=\"categorie.php?cat=" . $result2[0]['id_categoria'] . "\">" . $cat . "</a></span></div>";
                $productlist .= "<div class=\"button-container\">";
                $productlist .= "<label for=\"informazioni_prodotto-".$nome."\" class=\"sr-only\">Informazioni Prodotto</label>";
                $productlist .= "<input type=\"submit\" id=\"informazioni_prodotto-".$nome."\" name=\"informazioni_prodotto\" value=\"Richiedi Informazioni\" />";
                $productlist .= "<label for=\"" . $idprod . "\" class=\"sr-only\">Scheda Prodotto</label>";
                $productlist .= "<button id=\"" . $idprod . "\" class=\"vaiProdotto\" name=\"Scheda-Prodotto-".$nome."\">Scheda Prodotto <span aria-hidden=\"true\">-&gt</span></button>";
                $productlist .= "<input type=\"hidden\" class=\"product-id\" name=\"product_id\" value=\"" . $idprod . "\"/>";
                $productlist .= "<input type=\"hidden\" class=\"categoria\" name=\"categoria\"  value=\"" . $idcat . "\"/>";
                $productlist .= "<div class=\"rimuovi-container\">";
                $productlist .= "<button class=\"remove-button\" aria-label='Rimuovi' id=\"" . $idprod . "-" . $idcat . "\" name=\"rimuovi\">";
                $productlist .= "<img src=\"img/binClosed.png\" alt=\"Rimuovi prodotto dalla lista dei desideri.\" class=\"non-hover-image\" aria-hidden=\"true\"/>";
                $productlist .= "<img src=\"img/binOpened.png\" alt=\"\" class=\"hover-image\" />";
                $productlist .= "</button>";
                $productlist .= "</div>";
                $productlist .= "</div>";
                $productlist .= "</div>";
                $productlist .= "</form>";
            }
        }
    } else {
        $msg = "<div id=\"wish-error\" role=\"alert\">Lista dei desideri vuota!</div>";
    }
    $replace = array(
        "Titolo" => "Lista dei desideri di " . $_SESSION["username"],
        "<!--Prodotti-->" => $productlist,
        "<div id=\"msgWish\" role=\"alert\"></div>" => $msg
    );
}
foreach ($replace as $key => $value)
    $template = str_replace($key, $value, $template);
echo $template;
?>