<?php

require_once "connessione.php";
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
        $ElencoCateg=$ElencoCateg."<div><a href=\"../PHP/categorie.php?cat=".$result[$i]['id_categoria']."\">".$result[$i]['Nome']."</a></div>
                        <div>".$result[$i]['Descrizione']."</div> ";
    }
    $replace = array("<categories_place_holder />" =>$ElencoCateg 
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
            $ElencoProdot=$ElencoProdot."<div><a href=\"../PHP/categorie.php\"></div>
                            <div><a href=\"../PHP/prodotto.php?prod=".$result[$i]['id_prodotto']."\">".$result[$i]['Nome']."</a></div>
                            <div>".$result[$i]['Descrizione']."</div>
                            <div><img <lt=\"\"></img></div> ";
        }
        $replace = array("<categories_place_holder />" =>$ElencoProdot 
                    ); 
    }
    else{
        $result = $nome = $descrizione = "";
        $connessioneRiuscita = $connessione->openDBConnection();
        $result=$connessione->getCategories();
        $connessione->closeConnection();
        $ElencoCateg="";
        for ($i = 0; $i < count($result); $i++) {
            $ElencoCateg=$ElencoCateg."<div><a href=\"../PHP/categorie.php?cat=".$result[$i]['id_categoria']."\">".$result[$i]['Nome']."</a></div>
                            <div>".$result[$i]['Descrizione']."</div> ";
        }
        $replace = array("<categories_place_holder />" =>$ElencoCateg 
                        ); 
    }
}






$paginaHTML = file_get_contents("../HTML/categorie.html");
    foreach($replace as $key => $value) 
            $HTMLPage = str_replace($key, $value, $paginaHTML);
    echo $HTMLPage;
?>
