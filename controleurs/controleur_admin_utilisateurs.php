<?php
// Ce n'est pas un admin, on le renvoie à la page d'accueil
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['admin'] !== 1) {
    header('Location: accueil');
    exit();
}

require_once(MODELE . 'admin.php');
require_once(MODELE . 'crud/utilisateur.php');
require_once(MODELE . 'crud/commentaire.php');
require_once(MODELE . 'crud/actualite.php');


//Admin a cliqué sur le bouton de suppression d'un commentaire
if (isset($_POST['bSupprimerCommentaire'])) {
    $commentaire_id = $_POST['commentaire_id'];
    try {
        supprimerCommentaire($commentaire_id);
        $commentaire_suppression = "Commentaire supprimé avec succès.";
    } catch (Exception $e) {
        error_log("Erreur SQL lors de la suppression du commentaire : " . $commentaire_id . $e->getMessage());
        $commentaire_suppression = "Une erreur est survenue lors de la suppression du commentaire.";
    }
}

//Admin a cliqué sur le bouton de suppression d'un utilisateur
if (isset($_POST['bSupprimerUtilisateur'])) {
    $utilisateur_id = $_GET['utilisateur_id'];
    try {
        supprimerUtilisateur($utilisateur_id);
        $_SESSION['utilisateur_suppression'] = "Utilisateur supprimé avec succès.";
        header('Location: /admin/utilisateurs');
        exit();
    } catch (Exception $e) {
        error_log("Erreur SQL lors de la suppression de l'utilisateur : " . $utilisateur_id . $e->getMessage());
        $_SESSION['utilisateur_suppression'] = "Une erreur est survenue lors de la suppression de l'utilisateur." . $utilisateur_id;
        header('Location: /admin/utilisateurs');
        exit();
    }
}

//Commme on a fait 2 sections dans la vue en fonction de si on a choisi un utilisateur ou pas, on va gérer les 2 cas de figure ici

//On commence avec le cas où un utilisateur est dans le get
if (isset($_GET['utilisateur_id'])) {
    $utilisateur_id = $_GET['utilisateur_id'];
    try {
        //On fait attention au cas où l'utilisateur_id est null
        ($utilisateur_id==='null')? $utilisateur = null : $utilisateur = utilisateurId($utilisateur_id) ;
        if ($utilisateur!==false) {
            $commentaires = jointureCommentaireActualiteParUtilisateur($utilisateur['id']);
            $nbCommentaires = nombreCommentairesUtilisateur($utilisateur['id']);
        } else {
            //Utilisateur inexistant, on renvoie du coup à la gestion générale des utilisateurs
            $_SESSION['utilisateur_inexistant'] = "L'utilisateur que vous essayez de consulter n'existe pas.";
            header('Location: /admin/utilisateurs');
            exit();
        }
    } catch (Exception $e) {
        //Erreur sql lors du traitement de l'utilisateur
        error_log("Erreur SQL lors de la récupération de l'utilisateur : " . $utilisateur_id . $e->getMessage());
        header('Location: /admin/utilisateurs');
        exit();
    }
} else {
    //A FAIRE
    $utilisateurs = utilisateurSaufAdmin();
    $totalUtilisateurs = count($utilisateurs);
}


/*A REFLECHIR. J'envisage de faire un group_by utilisateur_id sur la table commentaire et de join le resultat avec la table utilisateur pour éviter de faire 
une requete par utilisateur pour compter le nombre de commentaires. ça a l'avantage également de compter les commentaires pour l'utilisateur null
Cependant, il faudrait adapter le crud en conséquence*/
include VUES . 'admin_utilisateurs.php';
?>
