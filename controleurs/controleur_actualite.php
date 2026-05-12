<?php
//Si on n'a pas l'id spécifique de l'actu dans le get on redirige vers les actualités
if (!isset($_GET['id'])) {
    header('Location: actualites');
    exit();
} 

//Maintenant on peut récupérer l'actu grâce à son id
require_once(MODELE . 'crud/actualite.php');
require_once(MODELE . 'crud/utilisateur.php');
require_once(MODELE . 'crud/commentaire.php');
$actu = actualiteId($_GET['id']);  
    
//Si l'actu n'existe pas on redirige vers la page des actualités
if (!$actu) {
    $_SESSION['erreur_actu_introuvable'] = "L'actualité que vous essayez de consulter n'existe pas ou n'est plus disponible.";
    header('Location: actualites');
    exit();
} 

//Processus pour modif une actu. Faut donc que le bon bouton soit cliqué et que c'est bien un admin qui l'a cliqué
if (isset($_POST['bModifierActu'])&& isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['admin'] === 1) {
    require_once(MODELE . 'admin.php');

    //Pour l'insertion bdd on utilise pas htmlspecialchars sinon ça fait de la merde
    //On l'utilise au contraire quand on va l'afficher
    $titre = trim(($_POST['titre']));
    $contenu = trim($_POST['contenu']);
    if (!verificationTitre($_POST['titre'])) {
        $_SESSION['modification_actu'] = "Le titre de l'actualité n'est pas valide.";
    } elseif (!verificationContenu($_POST['contenu'])) {
        $_SESSION['modification_actu'] = "Le contenu de l'actualité n'est pas valide.";
    } else {
        global $connexionBdd;        
        try {
            // Commence une transaction parce qu'on fait 2 appels à la bdd en même temps        
            $connexionBdd->beginTransaction();
            modifierTitre($actu['id'], $titre);        
            modifierContenu($actu['id'], $contenu);
            $_SESSION['modification_actu'] = "L'actualité a été modifiée avec succès.";
            $connexionBdd->commit(); // Valide la transaction si tout s'est bien passé
        } catch (Exception $e) {
            $connexionBdd->rollback(); // Annule la transaction en cas d'erreur
            if ($e->getCode() === 23000) { // Code d'erreur pour violation de contrainte d'unicité
                $_SESSION['modification_actu'] = "Une actualité avec ce titre existe déjà. Veuillez choisir un titre différent.";
            } else {
                error_log("Erreur lors de la modification de l'actualité ID " . $actu['id'] . ": " . $e->getMessage());
                $_SESSION['modification_actu'] = "Une erreur est survenue lors de la modification de l'actualité : ";
            }
        }
    }
}

//Form de like d'un utilisateur connecté
if (isset($_POST['bLiker']) && isset($_SESSION['utilisateur'])) {
    try {
        ajouterLike($actu['id']);
        // Bizarrement, comme j'utilise $actu dans ma vue et qu'ici on l'a déjà assigné et bien ses likes ne sont pas à jour.
        //Donc je le fais manuellement en plus pour que l'utilisateur ne soit pas dépaysé
        //Quand la page sera rechargée, $actu est réassigné. Donc pas de soucis hakuna matata
        $actu['likes']++;
    } catch (Exception $e) {
        error_log("Erreur lors de l'ajout du like pour l'actualité ID " . $actu['id'] . ": " . $e->getMessage());
    }
}

//Form de commentaire d'un utilisateur connecté
if (isset($_POST['bCommenter']) && isset($_SESSION['utilisateur'])) {
    $commentaire = trim(($_POST['commentaire']));
    require_once(MODELE . 'utilisateur/commenter.php');
    try {
        verifierCommentaire($commentaire);
        try {
            creerCommentaire($actu['id'], $commentaire, $_SESSION['utilisateur']['id']);
            $_SESSION['commentaire'] = "Votre commentaire a été ajouté avec succès.";
        } catch (Exception $e) {
            error_log("Erreur lors de la création du commentaire pour l'actualité ID " . $actu['id'] . ": " . $e->getMessage());
            $_SESSION['commentaire'] = "Une erreur est survenue lors de l'ajout de votre commentaire. Veuillez réessayer.";
        }
    } catch (Exception $e) {
         $_SESSION['commentaire'] = $e->getMessage();
    }
}

$commentaires = commentaireActualite($actu['id']);
include(VUES . 'actualite.php');
?>