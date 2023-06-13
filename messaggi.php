<?php

require_once "PHP/class.php";
$target="Elementi_Messaggi";
$ElencoMsg="";
session_start();

if(isset($_SESSION["username"]) && $_SESSION["ruolo"] == "admin") {

    $paginaHTML = Access::getHeader("Messaggi -", "Messaggi inviati da utenti registrati e non","messaggi, informazioni", $_SESSION["username"], $_SESSION["ruolo"]);
    $paginaHTML .= file_get_contents("HTML/messaggi.html");

    if (isset($_POST['form_msg'])) {   // funzione che segna come letti i messaggi selezionati
        $msg_checked = $_POST['form_msg'];
        if (!empty($msg_checked)) {
            for ($i = 0; $i < count($msg_checked); $i++) {
                Access::Message_Read($msg_checked[$i]);
            }
        }
    }

    if(isset($_POST["submit_elimina"])) {  // funzione che elimina i messaggi selezionati 
        $msg_checked = $_POST['form_msg'];
        if(!empty($msg_checked))  {
            for($i=0; $i < count($msg_checked); $i++) {
                Access::delete_Message($msg_checked[$i]);
            }
        }
    }
        $result=Access::getMessages();

        if(count($result) == 0)
            $ElencoMsg = "<div><h3>Non sono presenti messaggi da parte di utenti</h3></div>";
        else {
            for($i=0; $i<count($result); $i++) {  // funzione per la creazione dell'inline

                $ElencoMsg .= "<div id=\"messaggi\"><p class=\"inline\"><input type=\"checkbox\" name=\"form_msg[]\" value=" . $result[$i]["id_messaggio"] .
                "\"/></p>";

                $ElencoMsg .= "<p class=\"inline\"> Email: " . $result[$i]["email"] . "</p>";
                $ElencoMsg .= "<p class=\"inline\"> Data: " . $result[$i]["data"] . "</p>";

                if(!is_null($result[$i]["id_prodotto"]))  // se è presente un "id prodotto" nel risultato della query lo mostra con il rispettivo link
                    $ElencoMsg .= "<p class=\"inline\"> Prodotto:<a href=\"prodotto.php?prod=".$result[$i]['id_prodotto']."\">".$result[$i]['Nome']."</a></p>";
                
                $ElencoMsg .= "<p class=\"inline\"> Messaggio:" . $result[$i]["msg"] . "</p>";

                if($result[$i]["letto"] == 1)
                    $ElencoMsg .= "<p class=\"inline\"> Letto:Si</p></div>";
                else    
                    $ElencoMsg .= "<p class=\"inline\"> Letto:No</p></div>";
            }
        }
        
        $paginaHTML = str_replace($target, $ElencoMsg, $paginaHTML);

        echo $paginaHTML;
}
else 
    header("Location: prototipo.php");
?>
