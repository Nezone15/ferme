<?php
// Contient les fonctions pour gérer les opérations d'administration

/**
 * Vérifie les données de création d'une actualité et retourne un message d'erreur ou de succès
 * @param string $titre Le titre de l'actualité
 * @param string $contenu Le contenu de l'actualité
 * @param array $image Les données de l'image de l'actualité
 * @return string Un message d'erreur ou de succès
 */
function verificationActu($titre, $contenu, $image) {
    if (!verificationTitre($titre)) {
        return 'titre';
    }
    if (!verificationContenu($contenu)) {
        return 'contenu';
    }
    if (!verificationExtensionImage($image)) {
        return 'extension';
    }
    if (!isset($image) || $image['error'] !== UPLOAD_ERR_OK) {
        return 'upload';
    }
     if ($image['size'] > 5000000) {
        return 'taille';
    }
    return 'succes';
}

/**
 * Vérifie que le titre de l'actualité est valide (entre 4 et 100 caractères)
 * @param string $titre Le titre à vérifier
 * @return bool Vrai si le titre est valide, faux sinon
 */
function verificationTitre($titre) {
    return(strlen($titre) >= 4 && strlen($titre) <= 100);
}

/**
 * Vérifie que le contenu de l'actualité est valide (au moins 20 caractères)
 * @param string $contenu Le contenu à vérifier
 * @return bool Vrai si le contenu est valide, faux sinon
 */
function verificationContenu($contenu) {
    return(strlen($contenu) >= 20);
}

/**
 * Vérifie que l'extension de l'image est valide
 * @param array $image Les données de l'image
 * @return bool Vrai si l'extension est valide, faux sinon
 */
function verificationExtensionImage($image) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($image['tmp_name']);
    $types_acceptes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    return in_array($mime_type, $types_acceptes);
}

/**
 * Stocke l'image sur le serveur et retourne le chemin de l'image
 * @param array $image Les données de l'image
 * @return string Le chemin de l'image stockée
 */
function stockerImage($image) {
    /*Pour l'image, on va devoir l'enregistrer sur le serveur et stocker son chemin dans la base de données.
    J'ai demandé à l'ia plusieurs façons de faire. J'ai opté pour celle qui va hasher l'image
    pour éviter les doublons. Je me dis que c'est le plus pro pour éviter de prendre plus de place que
    nécessaire sur le serveur. Ainsi si l'image est déjà utilisé pour une autre actu, on a juste 
    à réutiliser le même chemin. Cela pose quand même la question de la suppression. A reflechir
    */
    // 1. Calculer l'empreinte unique de l'image
    $hash = md5_file($image['tmp_name']);

    // 2. Récupérer l'extension d'origine (.jpg, .png...)
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

    // 3. Créer le nom final basé sur le contenu
    $nom_fichier_image = $hash . '.' . $extension;

    //Le chemin de l'image. Ce qui sera stocké en bdd pour cette actu
    $chemin = 'images/' . $nom_fichier_image;

    // 4. Vérifier si le fichier existe déjà pour éviter les doublons
    //On oublie pas le root parce que sinon php va être duper
    if (!file_exists(ROOT . $chemin)) {
        // Si le fichier n'existe pas, on peut le télécharger vers le dossier images
        move_uploaded_file($image['tmp_name'], ROOT . $chemin);
    }
    return $chemin;
}