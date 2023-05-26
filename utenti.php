<?php
//require_once "PHP/connessione.php";
/*require_once "PHP/funUtente.php";*/
require_once "PHP/classUtente.php";
/*use DB\DBAccess;*/

$paginaHTML = file_get_contents("HTML/utenti2.html");

$utenti = "";
$stringaUtenti = "";

//$connessione = new DBAccess();
//$connessioneRiuscita = $connessione->openDBConnection();

//if ($connessioneRiuscita) {
    //$utenti = $connessione->getUtenti();
    //$connessione->closeConnection();
    $utenti = Utente::get();
    if (!empty($utenti)) {
        foreach ($utenti as $utente) {
            $stringaUtenti .= '<div class="utenti">
                <div class="flexutente">
                <div>Username: ' . $utente['username'] . ' </div>
                <div>Email: ' . $utente['email'] . ' </div>
                <form action="PHP/funUtente.php" method="post">
                <input type="hidden" id="userId" name="userId" value="' . $utente['username'] . '"/>
                <input type="submit" id="delete" name="delete" class="invio" value="Elimina"/>
                </form>
            </div>
        </div>';
        }
    } else {
        $stringaUtenti =
        '<div class="utenti">
            <div class="flexutente">
                Nessun utente è presente nel sistema.
            </div>
        </div>';
    }
/*} else {
    $stringaUtenti =
        '<div class="utenti">
            <div class="flexutente">
                Il sistema non è al momento raggiungibile, ci scusiamo per il disagio.
            </div>
        </div>';
}*/

echo str_replace("<utenti/>", $stringaUtenti, $paginaHTML);
?>