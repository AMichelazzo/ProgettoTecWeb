<?php
session_start();
require_once "PHP/class.php";

if (isset($_GET["prod"])) {

    $replace = $keywords = "";
    $result = Access::getProduct($_GET["prod"]);
    $result1 = Access::getProductImages($_GET["prod"]);
    $result3 = Access::getKeyWordsProdotto($_GET["prod"]);

    if (count($result) > 0) {
        $nome = $result[0]['Nome'];
        $desc = $result[0]['Descrizione'];
        $idprod = $result[0]['id_prodotto'];
        $idcat = $result[0]['id_categoria'];
        $isLogged = "";
        $slideshow = "";
        if (isset($_SESSION["username"])) {
            $template = Access::getHeader($nome, "Lista prodotti di una categoria scelta.", "Categorie, Prodotti, Oggettistica di vetro, Lista", $_SESSION["ruolo"], Access::getCategoryName($idcat), "categorie.php?cat=" . $idcat, "Prodotti", "categorie.php");
        } else {
            $template = Access::getHeader($nome, "Lista prodotti di una categoria scelta.", "Categorie, Prodotti, Oggettistica di vetro, Lista", null, Access::getCategoryName($idcat), "categorie.php?cat=" . $idcat, "Prodotti", "categorie.php");
        }
        $template .= file_get_contents("HTML/prodotto.html");

        if (empty($result1)) {

            $template = str_replace('<div class="slideshow-container">
            <div class="position-container">
                <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a>
            </div>
        </div>', "", $template);
            
        } else {
            for ($i = 0; $i < count($result1); $i++) {
                $slideshow .= "<div class=\"mySlides fade\">
            <img src=\"" . $result[$i]["path"] . "\" alt=\"" . $result[$i]["alt_img"] . "\" width=\"300\" height=\"300\"/></div>";
            }
        }
           

        if (isset($_SESSION["username"]) && $_SESSION["ruolo"] != "admin") {
            $result2 = Access::isInWishList($idprod, $idcat, $_SESSION["username"]);
            if ($result2 == null) {
                $result2 = false;
            }
            ($result2) ? $testoButton = "Togli dalla Lista" : $testoButton = "Aggiungi alla Lista";
            $isLogged = "<button type=\"button\" id=\"button\" class=\"button\">
                                                <span class=\"button__text\" id=\"buttonid\">" . $testoButton . "</span>
                                                </button>
                                                <div id=\"msgWish\" role=\"alert\"></div>";
        }

        $replace = array(
            "Titolo" => $nome,
            "Nome Prodotto" => $nome,
            "Descrizione Prodotto" => $desc,
            "<div>img</div>" => $slideshow,
            "<!--Wish-->" => $isLogged,
            '<form action="contatti.php" id="contact-form" method="post"></form>' =>
            (isset($_SESSION["username"]) && $_SESSION["ruolo"] == "admin") ? "" : '<form action="contatti.php" id="contact-form" method="post"><fieldset>
            <legend>
                <h3>Per Informazioni</h3>
            </legend>
            <input type="hidden" class="product_id" name="product_id" id="product_id"
                value=' . $idprod . ' />
            <input type="hidden" class="categ_id" name="categoria" id="categ_id"
                value=' . $idcat . ' />
            <div class="submit">
                <input type="submit" id="informazioni" name="informazioni_prodotto"
                    value="Richiedi Informazioni" />
            </div>
        </fieldset></form>'
        );
    } else {
        header("Location: categorie.php");
    }
    if (count($result3) > 0) {
        for ($i = 0; $i < count($result3); $i++) {
            if ($i == count($result3) - 1) {
                $keywords = $keywords . $result3[$i]["Nome"];
            } else {
                $keywords = $keywords . $result3[$i]["Nome"] . ", ";
            }
        }
        $keywords = "<meta name=\"keywords\" content=\"" . $keywords . "\" />";
        $replace["<!--Keywords-->"] = $keywords;
    }
}
foreach ($replace as $key => $value)
    $template = str_replace($key, $value, $template);
echo $template;
?>