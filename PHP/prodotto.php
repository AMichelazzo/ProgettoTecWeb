<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$replace = "";

if (isset($_GET["prod"])) { 
    $result = $nome = $descrizione = "";
    $connessioneRiuscita = $connessione->openDBConnection();
    $result=$connessione->getProduct($_GET["prod"]);
    $connessione->closeConnection();
    if(count($result)>0){
        $Prodotto="<div>".$result[0]['Nome']."</div>
                <div><img src=\"".$result[0]['path']."\" alt=\"".$result[0]['alt_img']."\" width='300' height='200'/></div>
                <div>".$result[0]['Descrizione']."</div>";
        $replace = array("<nomeProdotto/>" =>"<title>".$result[0]['Nome']." - Vetrina articoli di Vetro</title>",
                        "<showProdotto />" =>$Prodotto                   
                        );
    }
    else{
        header("Location: ../PHP/categorie.php");
    }
}// forse usare echo file_get_contents("inizio.txt");//stampo l’inizio pagina come su slide prof e quindi dividere la pagina in più parti e poi leggerle in procedura su php

$paginaHTML = file_get_contents("../HTML/prodotto.html");
    foreach($replace as $key => $value) 
            $HTMLPage = str_replace($key, $value, $paginaHTML);
    echo $HTMLPage;
?>
