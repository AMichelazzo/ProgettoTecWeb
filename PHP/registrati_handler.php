<?php
require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
session_start();
if (isset($_SESSION["username"])) {// non so se lasciarlo (come su login), non so se va bene non lasciare l'accesso alla pagina se l'utente è loggato
    if (isset($_SESSION["is_admin"]))
        header("Location: ../prototipo.php");
    else
        header("Location: ../index.php");
}
else
{
    if(isset($_POST["pass_reg2"],$_POST["pass_reg"],$_POST["username_reg"],$_POST["email_reg"]))
    {
        $replace = "";
        $connessioneRiuscita = $connessione->openDBConnection();
        $result=$connessione->checkUsern($_POST["username_reg"]);
        $result2=$connessione->checkEmail($_POST["email_reg"]);//va bene? nel senso, non penso abbiamo problemi di sovraccarico del database
        if(!isset($result)&&!isset($result2)){
            //AGGIUNGI REGEX PER PASSWORD?? MAGARI DA JS ? ((((CRIPTARE PASSWORD?))))
            if($_POST["pass_reg2"]==$_POST["pass_reg"]){
                $resultReg=$connessione->registraNuovoUtente($_POST["pass_reg"],$_POST["username_reg"],$_POST["email_reg"]);
                $connessione->closeConnection(); 
                header("Location: ../index.php");//o area utente?
            }
            else{
                $_SESSION["error_pass"]="<img id=\"passNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Errore nell'inserimento.\ height=\"15px\" width=\"15px\"/>";
                $connessione->closeConnection(); 
                header("Location: ../registrazione.php");
            }
        }
        $connessione->closeConnection(); 
        if(isset($result)){   
            $_SESSION["error_user"]=$result;
            $_SESSION["error_user2"]="<img id=\"emailNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Errore nell'inserimento.\" height=\"15px\" width=\"15px\"/>";
        }
        if(isset($result2)){
            $_SESSION["error_email"]=$result2;
            $_SESSION["error_email2"]="<img id=\"usernameNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Errore nell'inserimento.\" height=\"15px\" width=\"15px\"/>";
        }
    }
    header("Location: ../registrazione.php");
}

?>