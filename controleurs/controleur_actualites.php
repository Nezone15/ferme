<?php
if (isset($_GET['id'])) {
    $actualiteId = $_GET['id'];
    // Récuper les données de l'actu dans $actu
    include(__DIR__ . '/../vues/actualite.php');
} else {
    //Récuperer touts les actus dans $actus
    include(__DIR__ . '/../vues/pages/actualites.php');
}
?>