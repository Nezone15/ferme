<?php
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
    require_once __DIR__ . '/../crud/utilisateur.php';
    var_dump($email, $mdp);
    $utilisateur = utilisateurParEmail($email);
    if ($utilisateur && password_verify($mdp, $utilisateur['mdp'])) {
        // Connexion réussie, on renvoie les infos de l'utilisateur
        return $utilisateur;
    }
    return false;    
}
