<?php
require_once(MODELE . 'crud/actualite.php');

//On regarde si tri, ordre ou pagination ont été spécifié.
if (isset($_GET['tri'])) {
        $tri = $_GET['tri'];
} else {
        $tri = 'date';
}
if (isset($_GET['ordre'])) {
        $ordre = $_GET['ordre'];
} else {
        $ordre = 'DESC';
}
if (isset($_GET['pagination'])) {
        $pagination = (int)$_GET['pagination'];
} else {
        $pagination = 1;
}

//Là si l'utilisateur a fait une recherche via mots-clés ou pas
if (isset($_GET['recherche']) && !empty(trim($_GET['recherche']))) {
    $recherche = trim(($_GET['recherche']));
    $actualites = rechercheActusMots($recherche, 9, $tri, $ordre, $pagination);
    $totalActus = nombreRechercheActusMots($recherche);
    var_dump($totalActus);
} else {
    //Forcément pas dans le if donc on a pas faire de recherche mots clefs.
    $recherche = '';
    $totalActus= totalActus(); 
    $actualites = triActus(9, $tri, $ordre, $pagination);
}

$paginationMax = ceil($totalActus / 9);
//Au cas où il n'y a aucune actu, pour éviter d'avoir une pagination à 0
($paginationMax==0) ? $paginationMax=1 : $paginationMax=$paginationMax;     
include(VUES . 'actualites.php');