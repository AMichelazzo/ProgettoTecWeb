<?php
require_once "PHP/classUtente.php";

if (isset($_POST["userId"], $_POST["delete"])) {
    utente::delete($_POST["userId"]);
}

$paginaHTML = file_get_contents("HTML/utenti2.html");

$utenti = "";
$stringaUtenti = "";

$utenti = Utente::get();
if (!empty($utenti)) {
    foreach ($utenti as $utente) {
        $stringaUtenti .= '<div class="utenti">
            <div class="flexutente">
            <div><span lang="en">Username</span>: ' . $utente['username'] . ' </div>
            <div><span lang="en">Email</span>: ' . $utente['email'] . ' </div>
            <form action="utenti.php" method="post">
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