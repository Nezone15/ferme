<?php
session_start();
//On va définir ici la racine du projet pour pouvoir faire des includes plus facilement
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
define('MODELE', ROOT . 'modele' . DIRECTORY_SEPARATOR);
define('VUES', ROOT . 'vues' . DIRECTORY_SEPARATOR);
define('CONTROLEURS', ROOT . 'controleurs' . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', ROOT . 'public' . DIRECTORY_SEPARATOR);

//On regarde s'il y a un cookie de connexion et si oui si on a pas déjà l'utilisateur en $_SESSION
if (isset($_COOKIE['token_connexion']) && !isset($_SESSION['utilisateur'])) {
    require_once MODELE . 'crud/session.php';
    try {
        $session = sessionToken($_COOKIE['token_connexion']);
        if ($session) {
            // Si le token est valide on récupère l'utilisateur on le met dans $_SESSION 
            // Dans tous les cas on supprimera l'ancien token. Si l'utilisateur existe bien on lui fait un nouveau.
            require_once MODELE . 'crud/utilisateur.php';
            require_once MODELE . 'crud/session.php';
            $utilisateur = utilisateurId($session['utilisateur_id']);
            supprimerSession($session['token']);
            if ($utilisateur) {
                $_SESSION['utilisateur'] = $utilisateur;            
                $token = creerSession($utilisateur['id']);
                setcookie('token_connexion', $token, time() + (86400 * 30 * 13), "/", '', false, true);
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
        include CONTROLEURS . 'controleur_accueil.php';
        break;
    case 'maison':
        include CONTROLEURS . 'controleur_maison.php';
        break;
    case 'bois':
        include CONTROLEURS . 'controleur_bois.php';
        break;
    case 'actualites':
        include CONTROLEURS . 'controleur_actualites.php';
        break;
    case 'actualite':
        include CONTROLEURS . 'controleur_actualite.php';
        break;
    case 'connexion':
        include CONTROLEURS . 'controleur_connexion.php';
        break;
    case 'inscription':
        include CONTROLEURS . 'controleur_inscription.php';
        break;
    case 'mdpOublie':
        include CONTROLEURS . 'controleur_mdpOublie.php';
        break;
    case 'profil':
        include CONTROLEURS . 'controleur_profil.php';
        break;
    case 'admin':
        include CONTROLEURS . 'controleur_admin.php';
        break;
    case 'admin/utilisateurs':
        include CONTROLEURS . 'controleur_admin_utilisateurs.php';
        break;
    case 'tn':
        include CONTROLEURS . 'controleur_tn.php';
        break;
    case 'contact':
        include CONTROLEURS . 'controleur_contact.php';
        break;
    case 'mentions':
        include CONTROLEURS . 'controleur_mentions.php';
        break;
    case 'politique':
        include CONTROLEURS . 'controleur_politique.php';
        break;
    case 'deconnexion':
        include CONTROLEURS . 'controleur_deconnexion.php';
        break;
}
?>