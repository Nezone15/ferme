<?php
// Ce n'est pas un admin, on le renvoie à la page d'accueil
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['admin'] !== 1) {
    header('Location: accueil');
    exit();
}

require_once(MODELE . 'admin.php');
require_once(MODELE . 'crud/actualite.php');

//Création d'une actualité
if (isset($_POST['bCreerActu'])) {
    $titre = trim(($_POST['titre']));
    $contenu = trim($_POST['contenu']);
    $image = $_FILES['image'];
    $verification = verificationActu($titre, $contenu, $image);
    switch ($verification) {
        case 'titre':
            $creation_actu = '<p style="color: red;">Le titre doit être entre 4 et 100 caractères.</p>';
            break;
        case 'contenu':
            $creation_actu = '<p style="color: red;">Le contenu doit être d\'au moins 20 caractères.</p>';
            break;
        case 'extension':
            $creation_actu = '<p style="color: red;">L\'image doit être au format JPEG, PNG, GIF ou WEBP.</p>';
            break;
         case 'taille':
            $creation_actu = '<p style="color: red;">L\'image doit être inférieure à 5 Mo.</p>';
            break;
        case 'upload':
            $creation_actu = '<p style="color: red;">Une erreur est survenue lors du téléchargement de l\'image.</p>';
            break;
        case 'succes':
            $chemin_image = stockerImage($image);
            try {
                creerActualite($titre, $contenu, $chemin_image);
                $creation_actu = '<p style="color: green;">L\'actualité a été créée avec succès.</p>';
            } catch (Exception $e) {
                //On supprime l'image dans ce cas ? Mais elle peut être déjà utilisée par une autre actu ?
                //D'où ma réfléxion plus haut de cas de figure. A réfléchir. 
                if ($e->getCode() === 23000) {//Titre doit être unique. Seule contrainte violable
                    $creation_actu = '<p style="color: red;">Une actualité avec ce titre existe déjà.</p>';
                } else {
                    error_log('Erreur lors de la création de l\'actualité : ' . $e->getMessage());
                    $creation_actu = '<p style="color: red;">Une erreur est survenue lors de la création de l\'actualité.</p>';
                }
            }
     }
}

if (isset($_POST['bSupprimerActu'])) {
    $id_actu = (int)$_POST['id_actu'];
    try {
        $suppression = supprimerActualite($id_actu);
        if (!$suppression) {
            $suppression_message = '<p style="color: red;">L\'actualité n\'a pas été trouvée?? Bizarre hein. J\'espère que vous avez un dev sous le pouce :)</p>';
        } else {
            $suppression_message = '<p style="color: green;">L\'actualité a été supprimée avec succès.</p>';
        }
    } catch (Exception $e) {
        error_log('Erreur lors de la suppression de l\'actualité : ' . $e->getMessage());
        $suppression_message = '<p style="color: red;">Une erreur est survenue lors de la suppression de l\'actualité.</p>';
    }
}

//On regarde si tri, ordre ou pagination ont été spécifié.
if (isset($_GET['tri'])) {
        $tri = $_GET['tri'];
} else {
        $tri = 'date';
}
if (isset($_GET['ordre'])) {
        $ordre = $_GET['ordre'];
} else {
        $ordre = 'DESC';
}
//Prochain ordre est utilisé dans l'entete de ma table pour pouvoir modifier l'ordre de tri
$prochainOrdre = ($ordre === 'ASC') ? 'DESC' : 'ASC';

if (isset($_GET['pagination'])) {
        $pagination = (int)$_GET['pagination'];
} else {
        $pagination = 1;
}

//Là si l'admin a fait une recherche via mots-clés ou pas
try {
    if (isset($_GET['recherche']) && !empty(trim($_GET['recherche']))) {
        $recherche = trim(($_GET['recherche']));
        $actualites = rechercheActusMots($recherche, 10, $tri, $ordre, $pagination);
        $totalActus = nombreRechercheActusMots($recherche);
    } else {
        //Forcément pas dans le if donc on a pas faire de recherche mots clefs.
        $recherche = '';
        $totalActus= totalActus(); 
        $actualites = triActus(10, $tri, $ordre, $pagination);
    }
} catch (Exception $e) {
    error_log('Erreur lors de la récupération des actualités : ' . $e->getMessage());
    $actualites = [];
    $totalActus = 0;
}

$paginationMax = ceil($totalActus / 10);
//Au cas où il n'y a aucune actu, pour éviter d'avoir une pagination à 0
($paginationMax==0) ? $paginationMax=1 : $paginationMax=$paginationMax;     
include(VUES . 'admin.php');
?>