<?php
require_once "connessione.php";
use DB\DBAccess;
use function DB\pulisciInput;

$connessione = new DBAccess();
session_start();
if (isset($_SESSION["username"])) {
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
        //REGEX email è valida
        $okemail=true;
        if (!filter_var($_POST["email_reg"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error_email"]=$_POST["email_reg"];
            $_SESSION["error_email2"]="<img id=\"emailNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Errore nell'inserimento della email.\" height=\"15px\" width=\"15px\" role=\"alert\"/>";
            $okemail=false;
        }
        else{
            $result2=$connessione->checkEmail($_POST["email_reg"]);
        }

        //REGEX username ha solo lettere e spazi
        $okuser=true;
        if (!preg_match('/^[a-zA-Z0-9]{4,}$/', pulisciInput($_POST["username_reg"]))){
            $_SESSION["error_user"]=$_POST["username_reg"];
            $_SESSION["error_user2"]="<img id=\"usernameNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Errore nell'inserimento dello username.\" height=\"15px\" width=\"15px\" role=\"alert\" />";
            $okuser=false;
        }
        else{
            $result=$connessione->checkUsern($_POST["username_reg"]);
        }
        if(!isset($result)&&!isset($result2)&&$okemail&&$okuser){
            if($_POST["pass_reg2"]==$_POST["pass_reg"] && ($_POST["pass_reg"]>=4 &&$_POST["pass_reg"]<=16)){
                $resultReg=$connessione->registraNuovoUtente($_POST["pass_reg"],$_POST["username_reg"],$_POST["email_reg"]);
                $connessione->closeConnection(); 
                header("Location: ../index.php");//o area utente? IMPOSTA SESSIONI DA UTENTE LOGGATO 
            }
            else{
                $_SESSION["error_pass"]="<img id=\"passNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Le password non coincidono.\ height=\"15px\" width=\"15px\" role=\"alert\" />";
                $connessione->closeConnection(); 
                header("Location: ../registrazione.php");
            }
        }
        $connessione->closeConnection(); 
        if(isset($result)){
            $_SESSION["error_user"]=$result;
            $_SESSION["error_user2"]="<img id=\"usernameNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Username non disponibile.\" height=\"15px\" width=\"15px\" role=\"alert\" />";
        }
        if(isset($result2)){
            $_SESSION["error_email"]=$result2;
            $_SESSION["error_email2"]="<img id=\"emailNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Email non disponibile.\" height=\"15px\" width=\"15px\" role=\"alert\" />";
        }
    }
    header("Location: ../registrazione.php");
}

?>