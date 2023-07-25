<?php
session_start();
require_once "PHP/class.php";

$replace = "";
//SE HO CLICCATO PRODOTTI DA QUALSIASI PAGINA
if (!isset($_GET["cat"])) {

    if (isset($_SESSION["username"])) {
        $template = Access::getHeader("Prodotti", "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, Lista", $_SESSION["ruolo"]);
    } else {
        $template = Access::getHeader("Prodotti", "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, Lista");
    }
    $template .= file_get_contents('HTML/categorie.html');

    $result = $nome = $descrizione = "";
    $result = Access::getCategories();
    $ElencoCateg = "";
    for ($i = 0; $i < count($result); $i++) {
        $ElencoCateg .= '<div><a href="categorie.php?cat=' . $result[$i]['id_categoria'] . '">' . $result[$i]['Nome'] . '</a></div>
        <div>' . $result[$i]['Descrizione'] . '</div> ';
    }
    $replace = array("<!--categories_place_holder -->" => $ElencoCateg);
}

//SE HO SELEZIONATO UNA CATEGORIA
if (isset($_GET["cat"])) {
    $result = $nome = $descrizione = "";
    $result = Access::getProductsbyCategory($_GET["cat"]);

    if (isset($_SESSION["username"])) {
        $template = Access::getHeader(Access::getCategoryName($_GET["cat"]), "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, Lista", $_SESSION["ruolo"], "Prodotti", "categorie.php");
    } else {
        $template = Access::getHeader(Access::getCategoryName($_GET["cat"]), "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, Lista", null, "Prodotti", "categorie.php");
    }
    $template .= file_get_contents('HTML/categorie.html');

    if (!empty($result)) {
        $ElencoProdot = "";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoProdot .= '<div><a href="prodotto.php?prod=' . $result[$i]['id_prodotto'] . '">' . $result[$i]['Nome'] . '</a></div>
            <div>' . $result[$i]['Descrizione'] . '</div>' . '<div><img alt=""></img></div> ';
        }
        $replace = array("<!--categories_place_holder -->" => $ElencoProdot);
    } else {
        $result = $nome = $descrizione = "";
        $result = Access::getCategories();
        $ElencoCateg = "";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoCateg .= '<div><a href="categorie.php?cat=' . $result[$i]['id_categoria'] . '">' . $result[$i]['Nome'] . '</a></div>' . '<div>' . $result[$i]['Descrizione'] . '</div> ';
        }
        $replace = array("<!--categories_place_holder -->" => $ElencoCateg);
    }
}

foreach ($replace as $key => $value) {
    $HTMLPage = str_replace($key, $value, $template);
}
echo $HTMLPage;
?>