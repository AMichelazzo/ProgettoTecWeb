<?php
session_start();
require_once "PHP/class.php";
if (isset($_SESSION["username"])) {
    $template=Access::getHeader("Categorie", "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, Lista", $_SESSION["username"], $_SESSION["ruolo"], "Categorie");
}
else{
    $template=Access::getHeader("Categorie", "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, Lista");
}

$template .= file_get_contents('HTML/categorie.html');

$replace = "";
//SE HO CLICCATO PRODOTTI DA QUALSIASI PAGINA
if (!isset($_GET["cat"])) {
    $result = $nome = $descrizione = "";
    $result = Access::getCategories();
    $ElencoCateg="";
    for ($i = 0; $i < count($result); $i++) {
        $ElencoCateg .= '<div><a href="categorie.php?cat=' . $result[$i]['id_categoria'] . '">' . $result[$i]['Nome'] . '</a></div>
        <div>' . $result[$i]['Descrizione'] . '</div> ';
    }
    $replace = array("<!--categories_place_holder -->" =>$ElencoCateg);
}
//SE HO SELEZIONATO UNA CATEGORIA
if (isset($_GET["cat"])){
    $result = $nome = $descrizione = "";
    $result=Access::getProductsbyCategory($_GET["cat"]);
    if(!empty($result)){
        $ElencoProdot="";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoProdot .= '<div><a href="prodotto.php?prod=' . $result[$i]['id_prodotto'] . '">' . $result[$i]['Nome'] . '</a></div>
            <div>' . $result[$i]['Descrizione'] . '</div>' . '<div><img alt=""></img></div> ';
        }
        $replace = array("<!--categories_place_holder -->" =>$ElencoProdot);
    }
    else{
        $result = $nome = $descrizione = "";
        $result=Access::getCategories();
        $ElencoCateg="";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoCateg .= '<div><a href="categorie.php?cat=' . $result[$i]['id_categoria'] . '">' . $result[$i]['Nome'] . '</a></div>' . '<div>' . $result[$i]['Descrizione'] . '</div> ';
        }
        $replace = array("<!--categories_place_holder -->" =>$ElencoCateg);
    }
}

foreach($replace as $key => $value) {
    $HTMLPage = str_replace($key, $value, $template);
}
echo $HTMLPage;
?>