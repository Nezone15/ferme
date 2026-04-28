<?php
session_start();

//On regarde s'il y a un cookie de connexion et si oui si on a pas déjà l'utilisateur en $_SESSION
if (isset($_COOKIE['token_connexion']) && !isset($_SESSION['utilisateur'])) {
    require_once __DIR__ . '/modele/crud/session.php';
    try {
        $session = sessionParToken($_COOKIE['token_connexion']);
        if ($session) {
            // Si le token est valide on récupère l'utilisateur on le met dans $_SESSION 
            // Dans tous les cas on supprimera l'ancien token. Si l'utilisateur existe bien on lui fait un nouveau.
            require_once __DIR__ . '/modele/crud/utilisateur.php';
            require_once __DIR__ . '/modele/crud/session.php';
            $utilisateur = utilisateurParId($session['utilisateur_id']);
            supprimerSession($session['id']);
            if ($utilisateur) {
                $_SESSION['utilisateur'] = $utilisateur;            
                $token = creerSession($utilisateur['id']);
                setcookie('token_connexion', $token, time() + (86400 * 30), "/", '', false, true);
            } else {
                // Si l'utilisateur n'existe pas, on supprime le cookie            
                setcookie('token_connexion', '', time() - 3600, "/", '', false, true);
            }
        } else {
            // Si le token n'est pas valide, on supprime le cookie
            setcookie('token_connexion', '', time() - 3600, "/", '', false, true);
        }
    } catch (PDOException $e) {
        // En cas d'erreur SQL, on supprime le cookie pour éviter les problèmes futurs
        setcookie('token_connexion', '', time() - 3600, "/", '', false, true);
    }
}

// On récupère la page demandée, sinon par défaut c'est l'accueil
$page = $_GET['page'] ?? 'accueil';
switch($page) {
    case 'accueil':
        include __DIR__ . '/controleurs/controleur_accueil.php';
        break;
    case 'maison':
        include __DIR__ . '/controleurs/controleur_maison.php';
        break;
    case 'bois':
        include __DIR__ . '/controleurs/controleur_bois.php';
        break;
    case 'actualites':
        include __DIR__ . '/controleurs/controleur_actualites.php';
        break;
    case 'connexion':
        include __DIR__ . '/controleurs/controleur_connexion.php';
        break;
    case 'inscription':
        include __DIR__ . '/controleurs/controleur_inscription.php';
        break;
    case 'profil':
        include __DIR__ . '/controleurs/controleur_profil.php';
        break;
    case 'vueAdmin':
        include __DIR__ . '/controleurs/controleur_vueAdmin.php';
        break;
    case 'tn':
        include __DIR__ . '/controleurs/controleur_tn.php';
        break;
    case 'contact':
        include __DIR__ . '/controleurs/controleur_contact.php';
        break;
    case 'mentions':
        include __DIR__ . '/controleurs/controleur_mentions.php';
        break;
    case 'politique':
        include __DIR__ . '/controleurs/controleur_politique.php';
        break;
}
?>