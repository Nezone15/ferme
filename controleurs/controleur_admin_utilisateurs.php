<?php
// Ce n'est pas un admin, on le renvoie à la page d'accueil
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['admin'] !== 1) {
    header('Location: accueil');
    exit();
}

require_once(MODELE . 'admin.php');
require_once(MODELE . 'crud/utilisateur.php');
require_once(MODELE . 'crud/commentaire.php');

//On va permettre à l'admin de voir tous les utilisateurs
$utilisateurs = utilisateurSaufAdmin();
$totalUtilisateurs = count($utilisateurs);

/*A REFLECHIR. J'envisage de faire un group_by utilisateur_id sur la table commentaire et de join le resultat avec la table utilisateur pour éviter de faire 
une requete par utilisateur pour compter le nombre de commentaires. ça a l'avantage également de compter les commentaires pour l'utilisateur null
Cependant, il faudrait adapter le crud en conséquence*/
include VUES . 'admin_utilisateurs.php';
?>
