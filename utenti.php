<?php
require_once "PHP/class.php";

session_start();

if (isset($_SESSION["username"]) && $_SESSION["ruolo"] == "admin") {
    $paginaHTML = Access::getHeader("Utenti", "Utenti registrati nel sito", "utenti", $_SESSION["ruolo"], null, null, null, null, true);
    $paginaHTML .= file_get_contents("HTML/utenti.html");

    $utenti = "";
    $stringaUtenti = "";
    $first = 1;

    $utenti = Access::getUtenti();
    if ($utenti !== false) {
        if (!empty($utenti)) {
            foreach ($utenti as $utente) {
                $stringaUtenti .=
                    '<div class="utenti" role="group">
                    <div class="flexutente"><form action="utenti.php" method="post">
                    <fieldset><legend class="sr-only">'.$utente['username'].'</legend>
                        <div><span lang="en"><span class="nome">Username</span></span>: ' . $utente['username'] . ' </div>
                        <div><span lang="en"><span class="email">Email</span></span>: ' . $utente['email'] . ' </div>';
                (isset($_POST["delete"]) && $_POST["userId"] == $utente['username']) ? $stringaUtenti .= '<div class="elimina_utente_big"><div class="messaggio_elimina" role="alert">Sicuro di voler eliminare il profilo?</div>
                        <input type="hidden" id="id' . $utente['username'] . '"name="userId" value="' . $utente['username'] . '"/>
                        <div class="msg_confirm" role="alert"><input type="submit" name="si" class="invio" value="Si" />
                        <input type="submit" name="no" class="invio" value="No" /></div></fieldset></form></div></div></div>' : $stringaUtenti .= '
                        
                            <input type="hidden" id="id' . $utente['username'] . '" name="userId" value="' . $utente['username'] . '"/>
                            <input type="submit" id="delete' . $utente['username'] . '" name="delete" class="invio" value="Elimina"/>
                            <div class="msg_confirm" role="alert"></div></fieldset>
                        </form>
                    </div>
                </div>';
            }

            if (isset($_POST["userId"])) {
                if (isset($_POST["si"])) {
                    Access::deleteUtente($_POST["userId"]);
                    header("Location: utenti.php");
                }
                if (isset($_POST["no"])) {
                    header("Location: utenti.php");
                }
            }
        } else {
            $stringaUtenti =
                '<div class="utenti">
                <div class="flexutente">
                    Nessun utente è presente nel sistema.
                </div>
            </div>';
        }
    } else {
        $stringaUtenti =
            '<div class="utenti">
                <div class="flexutente">
                    Il sistema non è al momento raggiungibile, ci scusiamo per il disagio.
                </div>
            </div>';
    }

    echo str_replace("<utenti />", $stringaUtenti, $paginaHTML);
} else {
    header("Location: index.php");
}
?>