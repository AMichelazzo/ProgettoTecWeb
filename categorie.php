<?php
session_start();
require_once "PHP/class.php";

$replace = "";
$keywords="";
if(isset($_GET["cat"])){
    $result3 = Access::getKeyWordsCategoria($_GET["cat"]);
    if (count($result3) > 0) {
        for ($i = 0; $i < count($result3); $i++) {
            if ($i == count($result3) - 1) {
                $keywords .= $result3[$i]["Nome"];
            } else {
                $keywords .= $result3[$i]["Nome"] . ", ";
            }
        }
    }
}

//SE HO CLICCATO PRODOTTI DA QUALSIASI PAGINA
if (!isset($_GET["cat"])) {

    if (isset($_SESSION["username"])) {
        $template = Access::getHeader("Prodotti", "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, ".$keywords, $_SESSION["ruolo"]);
    } else {
        $template = Access::getHeader("Prodotti", "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, ".$keywords);
    }
    $template .= file_get_contents('HTML/categorie.html');

    $result = $nome = $descrizione = "";
    $result = Access::getCategories();
    $ElencoCateg = "";
    if($result){
        for ($i = 0; $i < count($result); $i++) {
            $ElencoCateg .= '<div class="conteg-container" role="group" aria-label="Categoria"><div class="img-categ"><img src="'. $result[$i]["img_path"] . '" alt="' . $result[$i]["alt_img"] . '" width="300" height="300"/></div>
            <div class="text-container"><div class="link-class"><a href="categorie.php?cat=' . $result[$i]['id_categoria'] . '">' . $result[$i]['Nome'] . '</a></div>
            <div class="desc-categ">' . $result[$i]['Descrizione'] . '</div></div></div>';
        }
    }
    else
    {
        $ElencoCateg='<div id="wish-error" role="alert">Al momento non sono disponibili prodotti!</div>';
    }
    $replace = array("<!--categories_place_holder -->" => $ElencoCateg);
}

//SE HO SELEZIONATO UNA CATEGORIA
if (isset($_GET["cat"])) {
    $result = $nome = $descrizione = "";
    $result = Access::getProductsbyCategory($_GET["cat"]);

    if (isset($_SESSION["username"])) {
        $template = Access::getHeader(Access::getCategoryName($_GET["cat"]), "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, ".$keywords, $_SESSION["ruolo"], "Prodotti", "categorie.php");
    } else {
        $template = Access::getHeader(Access::getCategoryName($_GET["cat"]), "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, ".$keywords, null, "Prodotti", "categorie.php");
    }
    $template .= file_get_contents('HTML/categorie.html');

    if (!empty($result)) {
        $ElencoProdot = "";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoProdot .= '<div class="conteg-container" role="group" aria-label="Categoria">
            <div class="img-categ"><img src="'. $result[$i]["path"] . '" alt="' . $result[$i]["alt_img"] . '" width="300" height="300"/></div>
            <div class="text-container"><div class="link-class"><a href="prodotto.php?prod=' . $result[$i]['id_prodotto'] . '">' . $result[$i]['Nome'] . '</a></div>
            <div class="desc-categ">' . $result[$i]['Descrizione'] . '</div></div></div>';
        }
        $replace = array("<!--categories_place_holder -->" => $ElencoProdot);
    } else {
        $result = $nome = $descrizione = "";
        $result = Access::getCategories();
        $ElencoCateg = "";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoCateg .= '<div class="conteg-container" role="group" aria-label="Categoria"><div class="img-categ"><img src="'. $result[$i]["img_path"] . '" alt="' . $result[$i]["alt_img"] . '" width="300" height="300"/></div>
            <div class="text-container"><div class="link-class"><a href="categorie.php?cat=' . $result[$i]['id_categoria'] . '">' . $result[$i]['Nome'] . '</a></div>
            <div class="desc-categ">' . $result[$i]['Descrizione'] . '</div></div></div>';
        }
        $replace = array("<!--categories_place_holder -->" => $ElencoCateg);
    }
}

foreach ($replace as $key => $value) {
    $HTMLPage = str_replace($key, $value, $template);
}
echo $HTMLPage;
?>