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
    $utilisateur_id = $_POST['utilisateur_id'];
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
    //On initialise les filtres
    $triCommentaire = $_GET['triCommentaire'] ?? 'date';
    $ordreCommentaire = $_GET['ordreCommentaire'] ?? 'DESC';
    $prochainOrdreCommentaire = ($ordreCommentaire === 'ASC') ? 'DESC' : 'ASC';

    $utilisateur_id = $_GET['utilisateur_id'];
    try {
        //On fait attention au cas où l'utilisateur_id est null
        ($utilisateur_id==='null')? $utilisateur = null : $utilisateur = utilisateurId($utilisateur_id) ;
        if ($utilisateur!==false) {
            $commentaires = jointureCommentaireActualiteParUtilisateur($utilisateur['id'], $triCommentaire, $ordreCommentaire);
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
    $triUtilisateur = $_GET['triUtilisateur'] ?? 'nom';
    $ordreUtilisateur = $_GET['ordreUtilisateur'] ?? 'ASC';
    $prochainOrdreUtilisateur = ($ordreUtilisateur === 'ASC') ? 'DESC' : 'ASC';
    $recherche = $_GET['recherche'] ?? '';
    //L'admin aime peut être fortement la barre espace. On va être sympa et nettoyer pour lui
    $recherche = strtolower(trim($recherche));
    $recherche = preg_replace('/\s+/', ' ', $recherche);
    $pagination = $_GET['pagination'] ?? 1;

    if (isset($_POST['bTrierUtilisateurs'])) {
        $triUtilisateur = $_POST['triUtilisateur'] ?? 'nom';
        $ordreUtilisateur = $_POST['ordreUtilisateur'] ?? 'ASC';
    }
    try {
        //A FAIRE Il faudra modif la fonction pour gérer la recherche et la pagination. En soit ma variable $utilisateurs ne devrait avoir max que 10 utilisateurs.
        $utilisateurs = jointureUtilisateurCommentaire($triUtilisateur, $ordreUtilisateur, $recherche, 10, $pagination);
        $totalUtilisateurs = nombreUtilisateurRecherche($recherche);
        if ($recherche === '' || str_contains('anonyme', $recherche)) {
            if (anonymeCommentaire()) {
                $totalUtilisateurs++;
            }
        }       
    } catch (Exception $e) {
        //Erreur sql lors de la récupération des utilisateurs ou de leur comptage
        error_log("Erreur SQL lors de la récupération des utilisateurs : " . $e->getMessage());
        $utilisateurs = [];
        $totalUtilisateurs = 0;
    }
    $paginationMax = ceil($totalUtilisateurs / 10);
    ($paginationMax == 0) ? $paginationMax = 1 : $paginationMax = $paginationMax;
}
include VUES . 'admin_utilisateurs.php';
?>
