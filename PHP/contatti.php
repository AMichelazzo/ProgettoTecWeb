<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$paginaHTML = file_get_contents("../HTML/contatti.html");
$target = "Elementi_Contatti";
$Element_Contatti="";
$Id_prodotto = null;
//

if(isset($_SESSION["username"]))
    $Element_Contatti .= "<a>Stai inviando questo messaggio come: " . $_SESSION["username"] . "</a><br>";
else {
    $Element_Contatti .= "<div><label for=\"nome\"><span lang=\"en\">Email:</span></label><br>
    <input type=\"text\" id=\"email\" name=\"email\"></div>";
    }


if(isset($_POST["product-id"]))
{
    $Id_prodotto = $_POST["product-id"];
    $Element_Contatti .= "<div><a>Prodotto su cui si vuole informazioni: " . $connessione->getProductName($_POST["product-id"]) 
    . "</a></div>";
}

if (isset($_POST["submit_informazioni"]))

    if(isset($_SESSION["username"]))
        $user = $_SESSION["username"];
    else
        $user = $_POST["email"];
    
    if( isset($_SESSION["username"]) && isset($_POST["messaggio"])) {

    $user = $_POST["username"];
    $msg = $_POST["messaggio"];

    $result = $connessione->new_Message($user, 1, $msg);
    $connessione->closeConnection();

    if ($result) {
        
        $Element_Contatti = "Messaggio inviato correttamente";
    }
    else
    {
        $response["success"] = false;
        $response["message"] = "Errore nell'invio del messaggio";
    }

    echo json_encode($response);
}

$paginaHTML = str_replace($target, $Element_Contatti, $paginaHTML);
echo $paginaHTML;

?>