<?php

require_once "connessione.php";
use DB\DBAccess;

$connessione = new DBAccess();
$replace = "";


$paginaHTML = file_get_contents("../HTML/prodotto.html");
    foreach($replace as $key => $value) 
            $HTMLPage = str_replace($key, $value, $paginaHTML);
    echo $HTMLPage;
?>
