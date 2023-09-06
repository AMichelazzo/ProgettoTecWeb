<?php
require_once "PHP/class.php";
session_start();
if (isset($_SESSION["username"])) {
    header("Location: index.php");
} else {
    if (isset($_POST["pass_reg2"], $_POST["pass_reg"], $_POST["username_reg"], $_POST["email_reg"])) {
        //REGEX email è valida
        $okemail = true;
        if (!filter_var($_POST["email_reg"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error_email"] = $_POST["email_reg"];
            $_SESSION["error_email2"] = "<img id=\"emailNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Errore nell'inserimento della email.\" height=\"15px\" width=\"15px\" role=\"alert\"/>";
            $okemail = false;
        } else {
            $result2 = Access::checkEmail($_POST["email_reg"]);
        }
        //REGEX username ha solo lettere e spazi
        $okuser = true;
        if (!preg_match('/^[a-zA-Z0-9]{4,}$/', $_POST["username_reg"])) {
            $_SESSION["error_user"] = $_POST["username_reg"];
            $_SESSION["error_user2"] = "<img id=\"usernameNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Errore nell'inserimento dello username.\" height=\"15px\" width=\"15px\" role=\"alert\" />";
            $okuser = false;
        } else {
            $result = Access::checkUsern($_POST["username_reg"]);
        }
        if (!isset($result) && !isset($result2) && $okemail && $okuser) {
            if ($_POST["pass_reg2"] == $_POST["pass_reg"] && strlen($_POST["pass_reg"]) >= 4 && strlen($_POST["pass_reg"]) <= 16) {
                $resultReg = Access::registraNuovoUtente($_POST["pass_reg"], $_POST["username_reg"], $_POST["email_reg"]);
                if (isset($resultReg) && $resultReg) {
                    $_SESSION['reg_eff'] = '<div class="change-success" role="alert">Registazione avvenuta con successo.</div>';
                    header("Location: accesso.php");
                } else {
                    $_SESSION["genericError"] = '<div id="msgchange" class="change-error" role="alert">Errore nella creazione dell\'account, riprova più tardi.</div>';
                }
            } else {
                $_SESSION["error_pass"] = "<img id=\"passNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Le password non corrispondono\" height=\"15px\" width=\"15px\" role=\"alert\" />";
            }
        }
        if (isset($result)) {
            $_SESSION["error_user"] = $result;
            $_SESSION["error_user2"] = "<img id=\"usernameNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Username non disponibile.\" height=\"15px\" width=\"15px\" role=\"alert\" />";
        }
        if (isset($result2)) {
            $_SESSION["error_email"] = $result2;
            $_SESSION["error_email2"] = "<img id=\"emailNOT_disponibile\" src=\"img/Xrossa.png\" alt=\"Email non disponibile.\" height=\"15px\" width=\"15px\" role=\"alert\" />";
        }
    }
    if (isset($result) && isset($result2) && !isset($resultReg) && !($_POST["pass_reg2"] == $_POST["pass_reg"] && strlen($_POST["pass_reg"]) >= 4 && strlen($_POST["pass_reg"]) <= 16)) {
        header("Location: registrazione.php");
    }
}

?>