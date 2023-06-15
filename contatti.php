<?php
require_once "PHP/class.php";
session_start();
$user = (isset($_SESSION["username"])) ? $_SESSION["username"] : null;
$ruolo = (isset($_SESSION["ruolo"])) ? $_SESSION["ruolo"] : null;

$paginaHTML = Access::getHeader("Contatti -", "Pagina per richiedere informazioni generiche o informazioni su un prodotto specifico", "contatti, informazioni", 
$user , $ruolo, "Contatti");

$paginaHTML .= file_get_contents("HTML/contatti.html");
$target = "<!--Elementi_Contatti-->";
$target2 = "<!--Risposta_Messaggi-->";
$Element_Contatti="";
$Result_msg ="";
$Id_prodotto = null;
$Id_categoria = null;
$result = null;
$email = null;
$okemail = true;


if(isset($_SESSION["username"])) // utente loggato
    $Element_Contatti .= "<div><p>Stai inviando questo messaggio come: " . $_SESSION["username"] . "</p></div>";
else {
    $Element_Contatti .= "<div><label for=\"email\"><span lang=\"en\">Email:</span></label>" .  // utente non loggato
    "<input type=\"text\" id=\"email\" name=\"email\"></div>";
    }

if(isset($_POST["informazioni_prodotto"]) && isset($_POST["product_id"]) && isset($_POST["categoria"]))
{
    $Id_prod = $_POST["product_id"];
    $Id_categoria = $_POST["categoria"];
    $Nome_prodotto = Access::getProductName($_POST["product_id"], $_POST["categoria"]);

    if(!is_null($Nome_prodotto)) {
        $Element_Contatti .= "<input type=\"hidden\" class=\"product-id\" name=\"product-id_contatti\" id=\"product-ID\"/>
        <input type=\"hidden\" class=\"categoria\" name=\"categoria_contatti\" id=\"categ_id\"/>";
        $Element_Contatti .= "<div><label>Prodotto su cui si vuole informazioni: " . $Nome_prodotto . "</label></div>";
    }
}

if(isset($_POST["submit_informazioni"])) 
{
    if((isset($_POST["email"]) && $_POST["email"] != null) || isset($_SESSION["username"]))
    {  
        if(isset($_SESSION["username"])) 
            $email = Access::getUserEmail($_SESSION["username"]);
        else if(isset($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
            $okemail = false;
        else
            $email = $_POST["email"];
            
        if($okemail && $_POST["messaggio"] != "") 
            $result = Access::newMessage($email, $Id_prodotto, $Id_categoria, $_POST["messaggio"]);
        
        if($result && $okemail)
            $Result_msg = "<div class=\"success-message\" role=\"alert\"><span class=\"sr-only\">Invio riuscito:</span>
            Messaggio inviato correttamente</div>";
        else if(!$okemail)
            $Result_msg = "<div class=\"error-message\" role=\"alert\"><span class=\"sr-only\">Errore invio:</span>
            <span lang =\"en\">Email</span> inserita non corretta. Riprova.</div>";
        else
            $Result_msg = "<div class=\"error-message\" role=\"alert\"><span class=\"sr-only\">Errore invio:</span>
            Errore nell'invio del messaggio. Riprova.</div>";            
    }
    else
        $Result_msg = "<div class=\"error-message\" role=\"alert\"><span class=\"sr-only\">Errore invio:</span>
        <span lang =\"en\">Email</span> non inserita. Riprova.</div>";
}

if($Result_msg != "")
    $paginaHTML = str_replace($target2, $Result_msg, $paginaHTML);

$paginaHTML = str_replace($target, $Element_Contatti, $paginaHTML);
echo $paginaHTML;

?>
