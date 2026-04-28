<?php
if (isset($_POST['bConnexion'])) {
    require_once __DIR__ . '/../modele/visiteur/connexion.php';
    $email = trim(htmlspecialchars($_POST['email']));
    $mdp = trim(htmlspecialchars($_POST['mdp']));
    var_dump($email, $mdp);
    
    try {
        $utilisateur = connexion($email, $mdp);
        if ($utilisateur) {
            // Connexion réussie, on stocke les infos de l'utilisateur en session
            $_SESSION['utilisateur'] = $utilisateur;

            //Maintenant on lui fait sa session de connexion et on lui met son cookie de 13 mois.
            require_once __DIR__ . '/../modele/crud/session.php';
            $token = creerSession($utilisateur['id']);
            setcookie('token_connexion', $token, time() + (86400 * 30), "/", '', false, true);
            
            // Redirection vers la page d'accueil après connexion
            header('Location: accueil');
            exit();
        } else {
            $erreur_connexion = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        // Gérer l'erreur SQL
        $erreur_connexion = "Nous avons rencontré un problème lors de la connexion. Veuillez réessayer plus tard.";
    }
}
include(__DIR__ . '/../vues/pages/connexion.php');

?>