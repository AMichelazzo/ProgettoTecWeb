<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();
$paginaHTML = file_get_contents("../HTML/messaggi.html");

if(isset($_POST['form_msg']))
{
    $msg_checked = $_POST['form_msg'];
    if(!empty($msg_checked))
    {
        $N = count($msg_checked);
        for($i=0; $i < $N; $i++)
        {
            $connessione->Message_Read($msg_checked[$i]);
        }
    }
}

    $target="Elementi_Messaggi";

    $result=$connessione->getMessages();
    $ElencoMsg="";
    $connessione->closeConnection();
    
    for($i=0; $i<count($result); $i++) 
    {
        $ElencoMsg.= "<tr><td><input type=\"checkbox\" name=\"form_msg[]\" value=" . $result[$i]["id_messaggio"] .
        "\"/></td>";

        $ElencoMsg .= "<td>" . $result[$i]["id_messaggio"] ."</td><td>" . $result[$i]["username"] . "</td><td>" .
        $result[$i]["data"] . "</td><td>" . "<a href=\"../PHP/prodotto.php?prod=".$result[$i]['id_prodotto']."\">".$result[$i]['Nome']."</a>".
        "</td><td>" . $result[$i]["msg"];

        if($result[$i]["letto"] == 1)
            $ElencoMsg .= "<td>Si</td></tr>";
        else   
            $ElencoMsg .= "<td>No</td></tr>";
    }

    $paginaHTML = str_replace("Elementi_Messaggi", $ElencoMsg, $paginaHTML);

    echo $paginaHTML;
?>
