<?php
//Controleur pour la deconnexion
require_once __DIR__ . '/../modele/utilisateur/deconnexion.php';
if (isset($_POST['bDeconnexion'])) {
    deconnexion();
}
header('Location: accueil');
exit();
?>