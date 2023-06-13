<?php
session_start();
require_once "PHP/class.php";
if (isset($_SESSION["username"])) {
    $template=Access::getHeader("Categorie", "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, Lista", $_SESSION["username"], $_SESSION["ruolo"]);
}
else{
    $template=Access::getHeader("Categorie", "Lista delle categorie presenti nel nostro catalogo di oggetti.", "Categorie, Prodotti, Oggettistica di vetro, Lista", "guest", "guest");
}

$template .= file_get_contents('HTML/categorie.html');

require_once "PHP/connessione.php";
use DB\DBAccess;
$connessione = new DBAccess();
$replace = "";
//SE HO CLICCATO PRODOTTI DA QUALSIASI PAGINA
if (!isset($_GET["cat"])) { //check per login? oppure non serve perche ci puo entrare chiunque, o magari se hai fatto login ti mostra prima le categorie preferite? boh
    $result = $nome = $descrizione = "";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->getCategories();
    $connessione->closeConnection();
    $ElencoCateg="";
    for ($i = 0; $i < count($result); $i++) {
        $ElencoCateg=$ElencoCateg."<div><a href=\"categorie.php?cat=".$result[$i]['id_categoria']."\">".$result[$i]['Nome']."</a></div>
                        <div>".$result[$i]['Descrizione']."</div> ";
    }
    $replace = array("<!--categories_place_holder -->" =>$ElencoCateg 
                    );     
}
//SE HO SELEZIONATO UNA CATEGORIA
if (isset($_GET["cat"])) { 

    $result = $nome = $descrizione = "";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->getProductListANDCheckCategory($_GET["cat"]);
    $connessione->closeConnection();
    if(count($result)>0){
        $ElencoProdot="";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoProdot=$ElencoProdot."<div><a href=\"prodotto.php?prod=".$result[$i]['id_prodotto']."\">".$result[$i]['Nome']."</a></div>
                            <div>".$result[$i]['Descrizione']."</div>
                            <div><img <lt=\"\"></img></div> ";
        }
        $replace = array("<!--categories_place_holder -->" =>$ElencoProdot 
                    ); 
    }
    else{
        $result = $nome = $descrizione = "";
        $connessioneRiuscita = $connessione->openDBConnection();
        $result=$connessione->getCategories();
        $connessione->closeConnection();
        $ElencoCateg="";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoCateg=$ElencoCateg."<div><a href=\"categorie.php?cat=".$result[$i]['id_categoria']."\">".$result[$i]['Nome']."</a></div>
                            <div>".$result[$i]['Descrizione']."</div> ";
        }
        $replace = array("<!--categories_place_holder -->" =>$ElencoCateg 
                        ); 
    }
}


    foreach($replace as $key => $value) 
            $HTMLPage = str_replace($key, $value, $template);
echo $HTMLPage;
?>