<?php
if (isset($_POST['bConnexion'])) {
    require_once __DIR__ . '/../modele/visiteur/connexion.php';
    $email = trim(htmlspecialchars($_POST['email']));
    $mdp = trim(htmlspecialchars($_POST['mdp']));
    
    try {
        $utilisateur = connexion($email, $mdp);
        if ($utilisateur) {
            connexionReussie($utilisateur);
        } else {
            $erreur_connexion = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        // Gérer l'erreur SQL
        error_log("Erreur SQL lors de la connexion : " . $e->getMessage());
        $erreur_connexion = "Nous avons rencontré un problème lors de la connexion. Veuillez réessayer plus tard.";
    }
}
include(__DIR__ . '/../vues/pages/connexion.php');

?>