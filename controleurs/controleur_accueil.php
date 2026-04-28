<?php
//require_once '../modele/actualites/actualites.php';
//$actus = dernieresActus();
if (isset($_POST['bDeconnexion'])) {
    session_destroy();
}
include(__DIR__ . '/../vues/pages/accueil.php');
?>