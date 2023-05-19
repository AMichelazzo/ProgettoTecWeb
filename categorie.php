<?php
require_once "PHP/connessione.php";
use DB\DBAccess;

session_start();
$template = (file_get_contents('HTML/categorie.html'));


$connessione = new DBAccess();
$replace = "";
//SE HO CLICCATO PRODOTTI DA QUALSIASI PAGINA
if (!isset($_GET["cat"])) {
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
            $ElencoProdot=$ElencoProdot."<div><a href=\"categorie.php\"></div>
                            <div><a href=\"prodotto.php?prod=".$result[$i]['id_prodotto']."\">".$result[$i]['Nome']."</a></div>
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