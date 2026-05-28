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
        if (supprimerCommentaire($commentaire_id)) {
            $commentaire_suppression = "<p class='message-succes'>Commentaire supprimé avec succès.</p>";
        } else {
            $commentaire_suppression = "<p class='message-erreur'>Pas trouvé le commentaire. T'aurais pas rechargé la page par hasard ?</p>";
        }
    } catch (Exception $e) {
        error_log("Erreur SQL lors de la suppression du commentaire : " . $commentaire_id . $e->getMessage());
        $commentaire_suppression = "<p class='message-erreur'>Une erreur est survenue lors de la suppression du commentaire.</p>";
    }
}

//Admin a cliqué sur le bouton de suppression d'un utilisateur
if (isset($_POST['bSupprimerUtilisateur'])) {
    $utilisateur_id = $_POST['utilisateur_id'];
    try {
        if (supprimerUtilisateur($utilisateur_id)) {
            $_SESSION['utilisateur_suppression'] = "<p class='message-succes'>Utilisateur supprimé avec succès.</p>";
        } else {
            $_SESSION['utilisateur_suppression'] = "<p class='message-erreur'>Pas trouvé l'utilisateur. T'aurais pas rechargé la page par hasard ?</p>";
        }
        header('Location: /admin/utilisateurs');
        exit();
    } catch (Exception $e) {
        error_log("Erreur SQL lors de la suppression de l'utilisateur : " . $utilisateur_id . $e->getMessage());
        $_SESSION['utilisateur_suppression'] = "<p class='message-erreur'>Une erreur est survenue lors de la suppression de l'utilisateur." . $utilisateur_id . "</p>";
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
        $utilisateur = [];
        if ($utilisateur_id==='anonyme') {
            $utilisateur['id'] = '---';
            $utilisateur['nom'] = 'Anonyme';
            $utilisateur['prenom'] = '---';
            $utilisateur['email'] = '---';
            
            $utilisateur['date_creation'] = '---';
            $utilisateur['derniere_activite'] = '---';
        } else {
            $utilisateur = utilisateurId($utilisateur_id);
        }
        if ($utilisateur!==false) {
            $commentaires = jointureCommentaireActualiteParUtilisateur($utilisateur['id'], $triCommentaire, $ordreCommentaire);
            $nbCommentaires = nombreCommentairesUtilisateur($utilisateur['id']);
        } else {
            //Utilisateur inexistant, on renvoie du coup à la gestion générale des utilisateurs
            $_SESSION['utilisateur_inexistant'] = "<p class='message-erreur'>L'utilisateur que vous essayez de consulter n'existe pas.</p>";
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

    try {
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
