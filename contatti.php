<?php
require_once "PHP/class.php";
session_start();
$user = (isset($_SESSION["username"])) ? $_SESSION["username"] : null;
$ruolo = (isset($_SESSION["ruolo"])) ? $_SESSION["ruolo"] : null;

$paginaHTML = Access::getHeader("Contatti", "Pagina per richiedere informazioni generiche o informazioni su un prodotto specifico", "contatti, informazioni", $ruolo);

$paginaHTML .= file_get_contents("HTML/contatti.html");
$target = "<!--Elementi_Contatti-->";
$Element_Contatti = "";
$Id_prodotto = null;
$Id_categoria = null;
$result = null;
$email = null;
$okemail = true;


if (isset($_SESSION["username"])) // utente loggato
    $Element_Contatti .=
    "<div class='sopra'>
        Stai inviando questo messaggio come: 
        <span class='grassetto'>" . 
            $_SESSION["username"] . 
        "</span>
    </div>";
else {
    $Element_Contatti .= 
    "<div>
        <label class='lab' for=\"email\">
            <span class=\"email\" lang=\"en\">
                Email: 
            </span>
        </label>" . // utente non loggato
        "<input type=\"email\" id=\"email\" name=\"email\"\>
    </div>";
}

if (isset($_POST["informazioni_prodotto"]) && isset($_POST["product_id"]) && isset($_POST["categoria"])) {
    $Id_prodotto = $_POST["product_id"];
    $Id_categoria = $_POST["categoria"];

    $Nome_prodotto = Access::getProductName($_POST["product_id"], $_POST["categoria"]);

    if (!is_null($Nome_prodotto)) {
        $Element_Contatti .=
        "<input type=\"hidden\" class=\"product-id\" name=\"product-id_contatti\" id=\"product-ID\"" . "value=\"" . $Id_prodotto . "\">"
        ."<input type=\"hidden\" class=\"categoria\" name=\"categoria_contatti\" id=\"categ_id\"" . "value=\"" . $Id_categoria . "\">
        <div class='sopra'>
            Prodotto su cui si vuole informazioni: 
            <a href=\"prodotto.php?prod=" . $Id_prodotto . "\">"
                . $Nome_prodotto . 
            "</a>
        </div>";
    }
}

if (isset($_POST["submit_informazioni"])) {
    if (isset($_POST["product-id_contatti"]))
        $Id_prodotto = $_POST["product-id_contatti"];

    if (isset($_POST["categoria_contatti"]))
        $Id_categoria = $_POST["categoria_contatti"];

    if ((isset($_POST["email"]) && Access::is_not_null($_POST["email"])) || $ruolo) {
        if ($user)
            $email = Access::getUserEmail($user);
        else if (isset($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
            $okemail = false;
        else
            $email = $_POST["email"];

        if ($okemail && Access::is_not_null($_POST["messaggio"]))
            $result = Access::newMessage($email, $Id_prodotto, $Id_categoria, $_POST["messaggio"]);

        if ($result && $okemail) {
            $paginaHTML = str_replace("message_class", "success-message", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_sr-->", "Invio riuscito:", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_errors-->", "Messaggio inviato correttamente", $paginaHTML);
        } else if (!$okemail) {
            $paginaHTML = str_replace("message_class", "error-message", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_sr-->", "Errore invio:", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_errors-->", "<span lang =\"en\">Email</span> inserita non corretta. Riprova.", $paginaHTML);
        } else {
            $paginaHTML = str_replace("message_class", "error-message", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_sr-->", "Errore invio:", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_errors-->", "Errore nell'invio del messaggio. Riprova.", $paginaHTML);
        }
    } else {
        $paginaHTML = str_replace("message_class", "error-message", $paginaHTML);
        $paginaHTML = str_replace("<!--Contenuto_sr-->", "Errore invio:", $paginaHTML);
        $paginaHTML = str_replace("<!--Contenuto_errors-->", "<span lang =\"en\">Email</span> non inserita. Riprova.", $paginaHTML);
    }
}

$paginaHTML = str_replace($target, $Element_Contatti, $paginaHTML);
echo $paginaHTML;

?>