<?php

require_once "PHP/connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$paginaHTML = file_get_contents("HTML/contatti.html");
$target = "<!--Elementi_Contatti-->";
$target2 = "<!--Risposta_Messaggi-->";
$Element_Contatti="";
$Result_msg ="";
$Id_prodotto = NULL;
$Id_categoria = NULL;
$result = null;


if(isset($_SESSION["username"]))
    $Element_Contatti .= "<a>Stai inviando questo messaggio come: " . $_SESSION["username"] . "</a><br>";
else {
    $Element_Contatti .= "<div><label for=\"nome\"><span lang=\"en\">Email:</span></label><br>
    <input type=\"text\" id=\"email\" name=\"email\"></div>";
    }

if(isset($_POST["product_id"]) && isset($_POST["category_id"]))
{
    $Id_prod = $_POST["product_id"];
    $Id_categoria = $_POST["category_id"];
    $Nome_prodotto = $connessione->getProductName($_POST["product_id"], $_POST["category_id"]);

    if(!is_null($Nome_prodotto))
        $Element_Contatti .= "<div><label>Prodotto su cui si vuole informazioni: " . $Nome_prodotto . "</label></div>";
}

if (isset($_POST["submit_informazioni"]) && isset($_POST["messaggio"]) && (isset($_POST["email"]) || isset($_SESSION["username"]))) {

    if(!isset($_SESSION["username"]) && !isset($_POST["email"]) && !is_null($_POST["email"])) // errore mail non inserita e non loggato
        $Result_msg = "<a>Inserisci la <span lang=\"en\">mail</span>!</a>";
    else {
        if(isset($_SESSION["username"]))
            $user = $_SESSION["username"];
        else if(isset($_POST["email"]))
            $user = $_POST["email"];

        $msg = $_POST["messaggio"];

        $result = $connessione->new_Message($user, $Id_prodotto, $Id_categoria, $msg);
        $connessione->closeConnection();

        if ($result && !is_null($user))
            $Result_msg = "<a>Messaggio inviato correttamente!</a>";
        else       
            $Result_msg = "<a>Errore nell'invio del messaggio, riprovare!<a>";
    }
}
if($Result_msg != "")
    $paginaHTML = str_replace($target2, $Result_msg, $paginaHTML);

$paginaHTML = str_replace($target, $Element_Contatti, $paginaHTML);
echo $paginaHTML;

?>
