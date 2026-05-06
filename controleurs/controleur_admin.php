<?php
require_once(MODELE . 'admin.php');

// Ce n'est pas un admin, on le renvoie à la page d'accueil
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['admin'] !== 1) {
    header('Location: accueil');
    exit();
}

//Création d'une actualité
if (isset($_POST['bCreerActu'])) {
    $titre = trim(htmlspecialchars($_POST['titre']));
    $contenu = trim(htmlspecialchars($_POST['contenu']));
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
            require_once(MODELE . 'crud/actualite.php');
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
include(VUES . 'pages/admin.php');
?>