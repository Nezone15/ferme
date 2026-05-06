<?php
//Controleur pour la deconnexion
require_once MODELE . 'utilisateur/deconnexion.php';
if (isset($_POST['bDeconnexion'])) {
    deconnexion();
}
header('Location: accueil');
exit();
?>