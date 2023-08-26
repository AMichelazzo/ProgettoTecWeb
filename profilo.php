<?php

require_once "PHP/class.php";
$paginaHTML = "";
session_start();

if(isset($_SESSION["username"])) {
    if ($_SESSION["ruolo"] != "user")
        header("Location: index.php");

    $paginaHTML = Access::getHeader("Profilo", "Profilo dell'utente","profilo, cambio password, eliminazione account", $_SESSION["ruolo"], null, null, null, null, true);
}
else{
    header("Location: index.php");
}
$paginaHTML .= file_get_contents("HTML/profilo.html");
$result = "";

if(isset($_SESSION["username"]) && isset($_POST["old_password"])  
&& isset($_POST["pass_reg"]) && isset($_POST["pass_reg2"]) 
&& isset($_POST["cambia_password"]) && !isset($_SESSION["changeExec"])) {
    $result = Access::checkOldPassword($_SESSION["username"], $_POST["old_password"]);
    if(isset($result) && $result){
        if( $_POST["pass_reg"]!=$_POST["old_password"]){
            if($_POST["pass_reg"] == $_POST["pass_reg2"]) {
                $result2 =  Access::ChangePassword($_SESSION["username"], $_POST["old_password"], $_POST["pass_reg"]);
                if(isset($result2)&&$result2){
                    $_SESSION["changeExec"]=true;
                }
                else{
                    $_SESSION["error_generic"]='<div id="msgchange" class="change-error" role="alert">Errore nella modifica della password.</div>';
                    $_SESSION["error_generic2"]='<img id="errore_generico" src="img/Xrossa.png" alt="Errore nella modifica della password." height="15px" width="15px"/>';
                }
                header("Location: profilo.php");
            }
            else {
                $_SESSION["error_new_pass"]='<div id="msgchange" class="change-error" role="alert">Le due nuove <span lang=en">password</span> non sono uguali.</div>';
                $_SESSION["error_new_pass2"]='<img id="passNOT_combaciano" src="img/Xrossa.png" alt="Le nuove password non sono uguali." height="15px" width="15px"/>';
                header("Location: profilo.php");
            }
        }
        else {
            $_SESSION["error_new_old"]='<div id="msgchange" class="change-error" role="alert">La nuova <span lang=en">password</span> non può combaciare con quella nuova.</div>';
            $_SESSION["error_new_old2"]='<img id="passNOT_disponibile" src="img/Xrossa.png" alt="La nuova password non può combaciare con quella nuova." height="15px" width="15px"/>'; 
            header("Location: profilo.php");
        }
    }
    else{
        $_SESSION["error_old_pass"]='<div id="msgchange" class="change-error" role="alert">Vecchia <span lang=en">password</span> errata.</div>';
        $_SESSION["error_old_pass2"]='<img id="old_passwordNOT_giusta" src="img/Xrossa.png" alt="Vecchia password errata." height="15px" width="15px"/>';
        header("Location: profilo.php");
    }
}
else{
    if(isset($_SESSION["changeExec"])&&$_SESSION["changeExec"])
    {
        $paginaHTML = str_replace('<div id="msgchange" role="alert"></div>', '<div id="msgchange" class="change-success" role="alert">Modifica avvenuta con successo.</div>', $paginaHTML);
        unset($_SESSION["changeExec"]);
    }
    else{
        if(isset($_SESSION['error_generic'])&&isset($_SESSION['error_generic2']))
        {
            $errgen=$_SESSION['error_generic2'];
        }
        else
        {
            $errgen=null;
        }

        if(isset($_SESSION['error_new_pass'])&&isset($_SESSION['error_new_pass2']))
        {
            $errNonC=$_SESSION['error_new_pass2'];
        }
        else
        {
            $errNonC=null;
        }
        if(isset($_SESSION['error_new_old'])&&isset($_SESSION['error_new_old2']))
        {
            $errUguale=$_SESSION['error_new_old2'];
        }
        else
        {
            $errUguale=null;
        }
        if(isset($_SESSION['error_old_pass'])&&isset($_SESSION['error_old_pass2']))
        {
            $errOPW=$_SESSION['error_old_pass2'];
        }
        else
        {
            $errOPW=null;
        }


        if (isset($errgen)){
            $paginaHTML = str_replace("<!--generico-->", $errgen, $paginaHTML);
            $paginaHTML = str_replace('<div id="msgchange" role="alert"></div>', $_SESSION['error_generic'], $paginaHTML);
            unset($_SESSION["error_generic"]);
            unset($_SESSION["error_generic2"]);
        }
        if (isset($errNonC)){
            $paginaHTML = str_replace("<!--nonCorrisp-->", $errNonC, $paginaHTML);
            $paginaHTML = str_replace('<div id="msgchange" role="alert"></div>', $_SESSION['error_new_pass'], $paginaHTML);
            unset($_SESSION["error_new_pass"]);
            unset($_SESSION["error_new_pass2"]);
        }
        if (isset($errUguale)){
            $paginaHTML = str_replace("<!--oldnew-->", $errUguale, $paginaHTML);
            $paginaHTML = str_replace('<div id="msgchange" role="alert"></div>', $_SESSION['error_new_old'], $paginaHTML);
            unset($_SESSION["error_new_old"]);
            unset($_SESSION["error_new_old2"]);
        }
        if (isset($errOPW)){
            $paginaHTML = str_replace("<!--old-->", $errOPW, $paginaHTML);
            $paginaHTML = str_replace('<div id="msgchange" role="alert"></div>', $_SESSION['error_old_pass'], $paginaHTML);
            unset($_SESSION["error_old_pass"]);
            unset($_SESSION["error_old_pass2"]);
        }
    }
}

if(isset($_POST["elimina"]))
{
    $paginaHTML = str_replace('<form method="post" action="profilo.php"><input type="submit" name="elimina" class="invio" value="Elimina Profilo" /><div id="msg_confirm" role="alert"></div></form>',
    '<form method="post" action="profilo.php"><div class="messaggio_elimina" role="alert">Sicuro di voler eliminare il profilo?</div><div id="msg_confirm" role="alert"><input type="submit" name="si" class="invio" value="Si" /><input type="submit" name="no" class="invio" value="No" /></div></form>', $paginaHTML);
}
if(isset($_POST["si"]))
{
    Access::deleteUtente($_SESSION["username"]);
    $_SESSION["profiloeliminato"]=true;
    header("Location: logout.php");
}
if(isset($_POST["no"]))
{
    header("Location: profilo.php");
}

echo $paginaHTML;
?>
