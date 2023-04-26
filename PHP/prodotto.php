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
        $nome=$result[0]['Nome'];
        $desc=$result[0]['Descrizione'];
        $Prodotto="<div>".$nome."</div><div class=\"slideshow-container\">";
        for ($i = 0; $i < count($result); $i++) {
                $Prodotto=$Prodotto."<div class=\"mySlides fade\">
                <img src=\"".$result[$i]['path']."\" alt=\"".$result[$i]['alt_img']."\">
              </div>";
            }
        $Prodotto=$Prodotto."<a class=\"Back\" onclick=\"plusSlides(-1)\">&#10094;</a>
        <a class=\"forward\" onclick=\"plusSlides(1)\">&#10095;</a>
      </div>
      <div>".$desc."</div>
                <div>
                <form id=\"contattaci-form\" action=\"../HTML/contatti.html\" method=\"post\">
                <fieldset>
                    <legend>
                    <h2>Per Informazioni</h2>
                    </legend>
                    <input type=\"hidden\" name=\"id_prodotto\" id=\"id_prodotto\"/>
                    <div class=\"submit\"><input type=\"submit\" id=\"informazioni\" name=\"informazioni\" value=\"Richiedi Informazioni\" />
                    </div>
                </fieldset>
                </form>
            </div>";


        $replace = array("<title>- Vetrina articoli di Vetro</title>" =>"<title>".$nome." - Vetrina articoli di Vetro</title>",
                        "<showProdotto />" =>$Prodotto                   
                        );////////////WISH LIST
    }
    else{
        header("Location: ../PHP/categorie.php");
    }
}
// forse usare echo file_get_contents("inizio.txt");
//stampo l’inizio pagina come su slide prof e quindi dividere la pagina in più parti e poi leggerle in procedura su php

$paginaHTML = file_get_contents("../HTML/prodotto.html");
    foreach($replace as $key => $value)
            $HTMLPage = str_replace($key, $value, $paginaHTML);
    echo $HTMLPage;
?>
