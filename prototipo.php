<?php
$pagina = file_get_contents("HTML/prototipo.html");
$target = "Nome negozio";
$titolo = "TITOLO";
$pagina = str_replace($target, $titolo, $pagina);
echo($pagina);
?>