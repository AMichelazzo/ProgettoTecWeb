<?php


require_once "PHP/class.php";

$paginaHTML = file_get_contents("HTML/contatti.html");
$target = "<!--Elementi_Contatti-->";
$target2 = "<!--Risposta_Messaggi-->";
$Element_Contatti="";
$Result_msg ="";
$Id_prodotto = null;
$Id_categoria = null;
$result = null;
$email = null;


if(isset($_SESSION["username"])) // utente loggato
    $Element_Contatti .= "<div><a>Stai inviando questo messaggio come: " . $_SESSION["username"] . "</a></div>";
else {
    $Element_Contatti .= "<div><label for=\"email\"><span lang=\"en\">Email:</span></label>" .  // utente non loggato
    "<input type=\"text\" id=\"email\" name=\"email\"></div>";
    }

if(isset($_POST["informazioni_prodotto"]) && isset($_POST["product-id"]) && isset($_POST["categoria"]))
{
    $Id_prod = $_POST["product-id"];
    $Id_categoria = $_POST["categoria"];
    $Nome_prodotto = Access::getProductName($_POST["product-id"], $_POST["categoria"]);
    echo "d";

    if(!is_null($Nome_prodotto)) {
        $Element_Contatti .= "<input type=\"hidden\" class=\"product-id\" name=\"product-id_contatti\" id=\"product-ID\"/>
        <input type=\"hidden\" class=\"categoria\" name=\"categoria_contatti\" id=\"categ_id\"/>";
        $Element_Contatti .= "<div><label>Prodotto su cui si vuole informazioni: " . $Nome_prodotto . "</label></div>";
    }
}

if (isset($_POST["submit_informazioni"]) && isset($_POST["messaggio"]) && (isset($_POST["email"]) || isset($_SESSION["username"]))) {

    if(!isset($_SESSION["username"]) && !isset($_POST["email"]) && !is_null($_POST["email"])) // errore mail non inserita e non loggato
        $Result_msg = "<a>Inserisci la <span lang=\"en\">mail</span>!</a>";
    else {
        if(isset($_SESSION["username"])) {
               $email = Access::getUserEmail($_SESSION["username"]);
        }
        else if(isset($_POST["email"]))
            $email = $_POST["email"];

        $msg = $_POST["messaggio"];
        
        if($email != null)
            $result = Access::newMessage($email, $Id_prodotto, $Id_categoria, $msg);

        if ($result && !is_null($email))
            $Result_msg = "<div><p>Messaggio inviato correttamente!</p></div>";
        else       
            $Result_msg = "<div><p>Errore nell'invio del messaggio, riprovare!<p></div>";
    }
}
if($Result_msg != "")
    $paginaHTML = str_replace($target2, $Result_msg, $paginaHTML);

$paginaHTML = str_replace($target, $Element_Contatti, $paginaHTML);
echo $paginaHTML;

?>
