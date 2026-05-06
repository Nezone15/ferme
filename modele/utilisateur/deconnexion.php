<?php
/**
 * Fonction de déconnexion d'un utilisateur. Unset et delete la session. Supprime également le cookie de connexion s'il existe. 
 */
function deconnexion() {
    session_unset();
    session_destroy();
    
    setcookie('token_connexion', '', time() - 3600, "/");

    header('Location: index.php');
    exit();
}