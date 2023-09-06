<?php

// inserisce title
$pagina = str_replace('<title></title>', '<title>' . $title . ' - Véro</title>', $pagina);

// inserisce description
$pagina = str_replace('<meta name="description" content="" />', '<meta name="description" content="' . $description . '" />', $pagina);

// inserisce keywords
$pagina = str_replace('<meta name="keywords" content="" />', '<meta name="keywords" content="' . $keywords . '" />', $pagina);

// inserisci breadcrumb dinamico
/*if(!isset($breadcrumb)){
    $breadcrumb='<p>Ti trovi in: <span lang="en">Home</span></p>';
}else{
    $breadcrumb='<p>Ti trovi in: <span lang="en">Home</span> - '.$breadcrumb.'</span></p>';
}
/*
Ti trovi in: Home / Prodotti / Something / aProduct;
Ti trovi in: <a href="" lang="en">Home</a> / <a href="">Prodotti</a> / <a href="" lang="en">Something</a> / <span>aProduct</span>
*/
if ($breadcrumb !== null) // tramite i nuovi get e la lang
{
    if ($category === null) {
        $breadcrumb = '<p>Ti trovi in: <a href="" lang="en">Home</a> / ' . $title . '</p>';
    } else {
        $breadcrumb = '<p>Ti trovi in: <a href="" lang="en">Home</a> / ' . '<a href="">' . $category . '</a> / ' . $title . '</p>';
    }
    $pagina = str_replace('<p>Ti trovi in: <span lang="en">Home</span></p>', $breadcrumb, $pagina);
}



// attiva il link corrente
switch ($title) {
    case "index":
        $pagina = str_replace('<li><a href="index.php" lang="en">Home</a></li>', '<li id="currentLink" lang="en">Home</li>', $pagina);
        break;

    case "Categorie":
        $pagina = str_replace('<li><a href="categorie.php">Prodotti</a></li>', '<li id="currentLink">Prodotti</li>', $pagina);
        break;

    case "Contatti":
        $pagina = str_replace('<li><a href="contatti.php">Contatti</a></li>', '<li id="currentLink">Contatti</li>', $pagina);
        break;
}
?>