<?php
//Controleur pour la deconnexion
//On vide et détruit la session
//On supprime le cookie de connexion si il existe
if (isset($_POST['bDeconnexion'])) {
    if (isset($_SESSION['utilisateur'])) {
        unset($_SESSION['utilisateur']);
    }
    session_destroy();
    if (isset($_COOKIE['token_connexion'])) {
        setcookie('token_connexion', '', time() - 3600, "/", '', false, true);
    }
}
header('Location: accueil');
exit();
?>