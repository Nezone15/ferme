<?php

/**
 * Vérifie la validité d'un commentaire.
 *
 * @param string $commentaire Le commentaire à vérifier
 *
 * @throws Exception En cas de commentaire invalide
 */
function verifierCommentaire($commentaire) {
    if (empty($commentaire)) {
        throw new Exception("Le commentaire ne peut pas être vide.");
    }
    if (strlen($commentaire) > 500) {
        throw new Exception("Le commentaire ne peut pas dépasser 500 caractères.");
    }
    // On peut ajouter d'autres vérifications si nécessaire (ex: interdiction de certains mots, etc.)
}
?>