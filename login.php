<?php
session_start();
if (isset($_SESSION["username"])) {
    if (isset($_SESSION["ruolo"])&&$_SESSION["ruolo"]=="admin")
        header("Location: prototipo.php");
    else
        header("Location: index.php");
}
$template = (file_get_contents('HTML/login.html'));

$err = isset($_SESSION['error']) ? $_SESSION['error'] : null;

try {
    if (isset($err))
        $template = str_replace("<!-- errors -->", $err, $template);
        unset($_SESSION["error"]);

    echo $template;
} catch (Exception $e) {
    //errore 500
}
?>