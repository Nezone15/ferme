<?php
require_once(MODELE . 'crud/actualite.php');
$actus = dernieresActus();

include(VUES . 'accueil.php');
?>