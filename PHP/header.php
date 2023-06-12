<?php

$pagina = file_get_contents("HTML/header.html");

$pagina = str_replace('<title></title>', '<title>' . $titolo . '</title>', $pagina);

?>