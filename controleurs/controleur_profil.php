<?php
//Controleur du profil.
//Déjà si j'ai pas d'utilisateur en session, je le redirige vers la page d'accueil parce que forcément j'ai pas de données de profil à afficher
if (!isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit();
} else if(isset($_POST['modifier_profil'])) {
    //Si le formulaire de modification du profil est soumis, je récupére les données.
    $formulaire = [];
    $formulaire['nom'] = trim(htmlspecialchars($_POST['nom']));
    $formulaire['prenom'] = trim(htmlspecialchars($_POST['prenom']));
    $formulaire['email'] = trim(htmlspecialchars($_POST['email']));


    $formulaire['tel'] = trim(htmlspecialchars($_POST['tel']));
    ($formulaire['tel'] === '') ? $formulaire['tel'] = null : $formulaire['tel'] = $formulaire['tel'];
    $formulaire['rue'] = trim(htmlspecialchars($_POST['rue']));
    ($formulaire['rue'] === '') ? $formulaire['rue'] = null : $formulaire['rue'] = $formulaire['rue'];
    $formulaire['numero'] = trim(htmlspecialchars($_POST['numero']));
    ($formulaire['numero'] === '') ? $formulaire['numero'] = null : $formulaire['numero'] = $formulaire['numero'];
    $formulaire['boite'] = trim(htmlspecialchars($_POST['boite']));
    ($formulaire['boite'] === '') ? $formulaire['boite'] = null : $formulaire['boite'] = $formulaire['boite'];
    $formulaire['code_postal'] = trim(htmlspecialchars($_POST['code_postal']));
    ($formulaire['code_postal'] === '') ? $formulaire['code_postal'] = null : $formulaire['code_postal'] = $formulaire['code_postal'];
    $formulaire['commune'] = trim(htmlspecialchars($_POST['commune']));
    ($formulaire['commune'] === '') ? $formulaire['commune'] = null : $formulaire['commune'] = $formulaire['commune'];
    $formulaire['pays'] = trim(htmlspecialchars($_POST['pays']));
    ($formulaire['pays'] === '') ? $formulaire['pays'] = null : $formulaire['pays'] = $formulaire['pays'];

    //On va les vérifier et puis si c'est ok mettre à jour la base de données. 
    //Toutes les données n'ont pas une vérification spécifique. A compléter plus tard au besoin.
    require_once MODELE . 'utilisateur/profil.php';
    $verification = verificationProfil($formulaire['email'], $formulaire['nom'], $formulaire['prenom'], $formulaire['numero']);

    switch ($verification) {
        case 'champs_obligatoires_manquants':
            $erreur = "Veuillez remplir tous les champs obligatoires.";
            break;
        case 'email_invalide':
            $erreur = "L'adresse email est invalide.";
            break;
        case 'numero_invalide':
            $erreur = "Le numéro de l'adresse doit être un nombre.";
            break;
        case 'nom_court':
            $erreur = "Le nom doit comporter au moins 2 caractères.";
            break;
        case 'prenom_court':
            $erreur = "Le prénom doit comporter au moins 2 caractères.";
            break;
        case 'succes':
            $retourModif = modifierProfil($formulaire);            
            switch ($retourModif) {
                case 'aucune_modification':
                    $erreur = "Aucune modification n'a été fournie.";
                    break;
                case 'email_deja_utilise':
                    $erreur = "L'adresse email est déjà utilisée.";
                    break;
                case 'erreur_contrainte':
                    $erreur = "Une contrainte de la base de données a été violée.";
                    break;
                case 'erreur_sql':
                    $erreur = "Une erreur est survenue lors de la modification du profil.";
                    break;
                case 'succes':
                    $succes = "Profil modifié avec succès.";
                    //On met à jour les données de l'utilisateur en session
                    $_SESSION['utilisateur'] = utilisateurId($_SESSION['utilisateur']['id']); 
                    break;
            }                
            break;
    }
} elseif (isset($_POST['supprimer_commentaire'])) {
    $id_commentaire = $_POST['id_commentaire'];
    try {
        require_once MODELE . 'crud/commentaire.php';
        if(supprimerCommentaire($id_commentaire)) {
            $succes_suppression = "Commentaire supprimé avec succès.";
        } else {
            $erreur_suppression = "Nous n'avons pas pu supprimer le commentaire.";
        };
    } catch (PDOException $e) {
        $erreur_suppression = "Une erreur est survenue lors de la suppression du commentaire.";
    }
}
require_once MODELE . 'crud/commentaire.php';
$commentaires = commentaireUtilisateur($_SESSION['utilisateur']['id']);
include(VUES . 'profil.php');
?>