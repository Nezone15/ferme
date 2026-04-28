<?php
//require_once '../modele/actualites/actualites.php';
//$actus = dernieresActus();

//Pour la déconnexion, on détruit la session et le cookie de connexion s'il existe
if (isset($_POST['bDeconnexion'])) {
    session_destroy();
    if (isset($_COOKIE['token_connexion'])) {
        setcookie('token_connexion', '', time() - 3600, "/", '', false, true);
    }
}
include(__DIR__ . '/../vues/pages/accueil.php');
?>