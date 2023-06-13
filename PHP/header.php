<?php

// inserisce title
$pagina = str_replace('<title></title>', '<title>' . $title . ' - Véro</title>', $pagina);

// inserisce description
$pagina = str_replace('<meta name="description" content="" />', '<meta name="description" content="' . $description . '" />', $pagina);

// inserisce keywords
$pagina = str_replace('<meta name="keywords" content="" />', '<meta name="keywords" content="' . $keywords . '" />', $pagina);

// inserisci breadcrumb dinamico
if(!isset($breadcrumb)){
    $breadcrumb="<p>Ti trovi in: <span lang=\"en\">Home</span></p>";
}else{
    $breadcrumb='<p>Ti trovi in: <span lang=\"en\">Home</span> - '.$breadcrumb.'</span></p>';
}

$pagina = str_replace('<p>Ti trovi in: <span lang="en">Home</span></p>', $breadcrumb, $pagina);

// attiva il link corrente
switch ($title) {
    case "Prototipo":
        $pagina = str_replace('<li><a href="prototipo.php" lang="en">Home</a></li>', '<li id="currentLink" lang="en">Home</li>', $pagina);
        break;
    
    case "Categorie":
        $pagina = str_replace('<li><a href="categorie.php">Prodotti</a></li>', '<li id="currentLink">Prodotti</li>', $pagina);
        break;
    
    case "Contatti":
        $pagina = str_replace('<li><a href="contatti.php">Contatti</a></li>', '<li id="currentLink">Contatti</li>', $pagina);
        break;
}
?>