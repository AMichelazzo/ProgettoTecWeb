<?php
require_once "connessione.php";
use DB\DBAccess;

$paginaHTML = file_get_contents("../HTML/utenti2.html");

$utenti = "";
$stringaUtenti = "";

$connessione = new DBAccess();
$connessioneRiuscita = $connessione->openDBConnection();

if ($connessioneRiuscita) {
    $utenti = $connessione->getUtenti();
    $connessione->closeConnection();
    if (!empty($utenti)) {
        foreach ($utenti as $utente) {
            $stringaUtenti .= '<div id="utenti">
                <div class="flexutente">
                <div>Username: ' . $utente['username'] . ' </div>
                <div>Email: ' . $utente['email'] . ' </div>
                <div>
                    <form method="post" action="" class="inline">
                    <input type="submit" id="submit" name="submit" class="invio" value="Elimina" />
                    </form>
                </div>
            </div>
        </div>';
        }
    } else {
        $stringaUtenti =
        '<div id="utenti">
            <div class="flexutente">
                Nessun utente è presente nel sistema.
            </div>
        </div>';
    }
} else {
    $stringaUtenti =
        '<div id="utenti">
            <div class="flexutente">
                Il sistema non è al momento raggiungibile, ci scusiamo per il disagio.
            </div>
        </div>';
}

echo str_replace("<utenti/>", $stringaUtenti, $paginaHTML);
?>