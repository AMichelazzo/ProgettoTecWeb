<?php

require_once "PHP/class.php";
$target = "Elementi_Messaggi";
$ElencoMsg = "";
session_start();

if (isset($_SESSION["username"]) && $_SESSION["ruolo"] == "admin") {

    $paginaHTML = Access::getHeader("Messaggi", "Messaggi inviati da utenti registrati e non", "messaggi, informazioni", $_SESSION["ruolo"], null, null, null, null, true);
    $paginaHTML .= file_get_contents("HTML/messaggi.html");

    if(isset($_POST["submit_letti"])) { // funzione che segna come letti i messaggi selezionati
        echo "dentro qui";
        if (isset($_POST['form_msg']))
            $msg_checked = $_POST['form_msg'];

        if(!empty($msg_checked)) {

            for ($i = 0; $i < count($msg_checked); $i++)
                Access::Message_Read($msg_checked[$i]);
            echo "dentro qui qui";
            $paginaHTML = str_replace("msg_class", "success-message", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_sr-->", "Successo: ", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_errors-->", "Messaggi segnati come letti", $paginaHTML);
        }else {
            $paginaHTML = str_replace("msg_class", "error-message", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_sr-->", "Errore: ", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_errors-->", "Non hai selezionato nessun messaggio!", $paginaHTML);
        }
    }elseif(isset($_POST["si_elimina"])) {
        if (isset($_POST['form_msg']))
            $msg_checked = $_POST['form_msg'];

        if (!empty($msg_checked)) {

            for ($i = 0; $i < count($msg_checked); $i++)
                Access::delete_Message($msg_checked[$i]);

            $paginaHTML = str_replace("msg_class", "success-message", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_sr-->", "Eliminazione riuscita: ", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_errors-->", "Messaggio eliminato con successo", $paginaHTML);
        } else {
            $paginaHTML = str_replace("msg_class", "error-message", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_sr-->", "Eliminazione non riuscita: ", $paginaHTML);
            $paginaHTML = str_replace("<!--Contenuto_errors-->", "Non hai selezionato nessun messaggio!", $paginaHTML);
        }
    }

    if(isset($_POST["no_elimina"])) {
        header("Location: messaggi.php");
    }

    $result = Access::getMessages();

    if(empty($result))
        $ElencoMsg = "<div><h3>Non sono presenti messaggi da parte di utenti</h3></div>";
    else{
        for ($i = 0; $i < count($result); $i++) { // funzione per la creazione dell'inline

            $ElencoMsg .= '<div id="messaggi" class="';
            if($result[$i]["letto"] == 1)
                $ElencoMsg .="msg_letto";
            else
                $ElencoMsg .="msg_non_letto";
                
            $ElencoMsg .= '"><p class="inline"><input type="checkbox" name="form_msg[]" value="' 
                . $result[$i]["id_messaggio"] . '"/></p>'
                . "<p class=\"inline\"> Email: " . $result[$i]["email"] . "</p>"
                . "<p class=\"inline\"> Data invio: " . $result[$i]["data"] . "</p>";

            if (!is_null($result[$i]["id_prodotto"])) // se è presente un "id prodotto" nel risultato della query lo mostra con il rispettivo link
                $ElencoMsg .= "<p class=\"inline\"> Prodotto: <a href=\"prodotto.php?prod=" . $result[$i]['id_prodotto'] . "\">" . $result[$i]['Nome'] . "</a></p>";

            $ElencoMsg .= "<p class=\"inline\"> Messaggio: " . $result[$i]["msg"] . "</p>";

            if ($result[$i]["letto"] == 1)
                $ElencoMsg .= "<p class=\"inline\"> Letto: Si</p></div>";
            else
                $ElencoMsg .= "<p class=\"inline\"> Letto: No</p></div>";
            }
    }

    $paginaHTML = str_replace($target, $ElencoMsg, $paginaHTML);
    echo $paginaHTML;
} else
    header("Location: index.php");
?>