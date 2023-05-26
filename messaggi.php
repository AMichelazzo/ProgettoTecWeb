<?php

require_once "PHP/connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$target="Elementi_Messaggi";
$ElencoMsg="";
$paginaHTML = file_get_contents("HTML/messaggi.html");

if (isset($_POST['form_msg'])) {   // funzione che segna come letti i messaggi selezionati
    $msg_checked = $_POST['form_msg'];
    if (!empty($msg_checked)) {
        for ($i = 0; $i < count($msg_checked); $i++) {
            $connessione->Message_Read($msg_checked[$i]);
        }
    }
}

if(isset($_POST["submit_elimina"])) {  // funzione che elimina i messaggi selezionati 
    $msg_checked = $_POST['form_msg'];
    if(!empty($msg_checked))  {
        for($i=0; $i < count($msg_checked); $i++) {
            $connessione->delete_Message($msg_checked[$i]);
        }
    }
}

    $result=$connessione->getMessages();
    $connessione->closeConnection();

    for($i=0; $i<count($result); $i++) {  // funzione per la creazione dell'inline

        $ElencoMsg .= "<div id=\"messaggi\"><p class=\"inline\"><input type=\"checkbox\" name=\"form_msg[]\" value=" . $result[$i]["id_messaggio"] .
        "\"/></p>";

        $ElencoMsg .= "<p class=\"inline\"> Email:" . $result[$i]["email"] . "</p>";
        $ElencoMsg .= "<p class=\"inline\"> Data:" . $result[$i]["data"] . "</p>";

        if(!is_null($result[$i]["id_prodotto"]))  // se è presente un "id prodotto" nel risultato della query lo mostra con il rispettivo link
            $ElencoMsg .= "<p class=\"inline\"> Prodotto:<a href=\"../PHP/prodotto.php?prod=".$result[$i]['id_prodotto']."\">".$result[$i]['Nome']."</a></p>";
        
        $ElencoMsg .= "<p class=\"inline\"> Messaggio:" . $result[$i]["msg"] . "</p>";

        if($result[$i]["letto"] == 1)
            $ElencoMsg .= "<p class=\"inline\"> Letto:Si</p></div>";
        else    
            $ElencoMsg .= "<p class=\"inline\"> Letto:No</p></div>";
    }
    
    $paginaHTML = str_replace($target, $ElencoMsg, $paginaHTML);

    echo $paginaHTML;
?>
