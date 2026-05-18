<?php
require_once MODELE . 'crud/utilisateur.php';
/**
 * Fonction de connexion d'un utilisateur
 * 
 * @param string $email L'email de l'utilisateur
 * @param string $mdp Le mot de passe de l'utilisateur
 * 
 * @return array|false Les données de l'utilisateur connecté ou false si la connexion a échoué
 * 
 * @throws PDOException En cas d'erreur sql
 */
function connexion($email, $mdp) {
    $utilisateur = utilisateurEmail($email);
    if ($utilisateur && password_verify($mdp, $utilisateur['mdp'])) {
        // Connexion réussie, on renvoie les infos de l'utilisateur
        return $utilisateur;
    }
    return false;    
}

/**
 * Fonction appelée lorsqu'une connexion est réussie. Enregiste l'utilisateur en session et lui crée une session de connexion. Redirige l'utilisateur vers la page d'accueil et met à jour sa derniere_activite.
 * 
 * @param array $utilisateur Les données de l'utilisateur connecté
 */
function connexionReussie($utilisateur) {    
    modifierDerniereActivite($utilisateur['id']);
    
    //Maintenant on lui fait sa session de connexion
    //On supprime une ancienne si elle existe et on lui met son cookie de 13 mois.
    require_once MODELE . 'crud/session.php';
    supprimerSessionUtilisateur($utilisateur['id']);
    $token = creerSession($utilisateur['id']);
    setcookie('token_connexion', $token, time() + (86400 * 30 * 13), "/", '', false, true);
    
    // Redirection vers la page d'accueil après connexion
    $_SESSION['utilisateur'] = $utilisateur;
    header('Location: accueil');
    exit();
}