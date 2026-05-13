<?php
require_once MODELE . "bdd/connexionBdd.php";
/*La table commentaire contient les champs suivants : id, utilisateur_id, actualite_id, message, date
utilisateur_id et actualite_id sont des clés étrangères vers les tables utilisateur et actualite.
utilisateur_id peut etre null si le commentaire est anonyme suite à une suppression de compte par exemple.
actualite_id est obligatoire, un commentaire doit toujours être lié à une actualité.
*/

//Create

/**
 * Crée un nouveau commentaire dans la base de données.
 *
 * @param int $actualite_id L'ID de l'actualité liée au commentaire
 * @param string $message Le contenu du commentaire
 * @param int|null $utilisateur_id L'ID de l'utilisateur, null pour un commentaire anonyme
 *
 * @return int L'ID du commentaire créé
 *
 * @throws PDOException En cas d'erreur sql
 */
function creerCommentaire($actualite_id, $message, $utilisateur_id = null) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("INSERT INTO commentaire (utilisateur_id, actualite_id, message, date)
    VALUES (:utilisateur_id, :actualite_id, :message, NOW())");
    $requete->execute([
        ':utilisateur_id' => $utilisateur_id,
        ':actualite_id' => $actualite_id,
        ':message' => $message
    ]);
    return $connexionBdd->lastInsertId();
}

//Read

/**
 * Récupère tous les commentaires de la base de données.
 *
 * @return array Un tableau de tous les commentaires
 *
 * @throws PDOException En cas d'erreur sql
 */
function commentaire() {
    global $connexionBdd;
    $requete = $connexionBdd->query("SELECT * FROM commentaire ORDER BY date DESC");
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les données d'un commentaire à partir de son ID.
 *
 * @param int $id L'ID du commentaire
 *
 * @return array|false Les données du commentaire ou false s'il n'existe pas
 *
 * @throws PDOException En cas d'erreur sql
 */
function commentaireId($id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM commentaire WHERE id = :id");
    $requete->execute([':id' => $id]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les commentaires d'une actualité à partir de son ID.
 *
 * @param int $actualite_id L'ID de l'actualité
 *
 * @return array Un tableau de tous les commentaires de l'actualité triés par date décroissante
 *
 * @throws PDOException En cas d'erreur sql
 */
function commentaireActualite($actualite_id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM commentaire WHERE actualite_id = :actualite_id ORDER BY date DESC");
    $requete->execute([':actualite_id' => $actualite_id]);
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les commentaires d'un utilisateur à partir de son ID.
 * @param int|null $utilisateur_id L'ID de l'utilisateur ou null pour les commentaires anonymes
 * @return array Un tableau de tous les commentaires de l'utilisateur triés par date décroissante
 * @throws PDOException En cas d'erreur sql
 */
function commentaireUtilisateur($utilisateur_id) {
    global $connexionBdd;
    $condition = ($utilisateur_id === null) ? "utilisateur_id IS NULL" : "utilisateur_id = :utilisateur_id";
    $param = ($utilisateur_id === null) ? [] : [':utilisateur_id' => $utilisateur_id];
    $requete = $connexionBdd->prepare("SELECT * FROM commentaire WHERE $condition ORDER BY date DESC");
    $requete->execute($param);
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère le nombre de commentaires d'un utilisateur à partir de son ID.
 * @param int|null $utilisateur_id L'ID de l'utilisateur ou null pour les commentaires anonymes
 * @return int|false Le nombre de commentaires de l'utilisateur ou false s'il n'existe pas
 * @throws PDOException En cas d'erreur sql
 */
function nombreCommentairesUtilisateur($utilisateur_id) {
    global $connexionBdd;
    $condition = ($utilisateur_id === null) ? "utilisateur_id IS NULL" : "utilisateur_id = :utilisateur_id";
    $param = ($utilisateur_id === null) ? [] : [':utilisateur_id' => $utilisateur_id];
    $requete = $connexionBdd->prepare("SELECT COUNT(*) FROM commentaire WHERE $condition");
    $requete->execute($param);
    return $requete->fetchColumn();
}

/**
 * Fait une jointure entre les tables commentaire et actualite pour récupérer les commentaires d'un utilisateur avec le titre de l'actualité associée.
 * @param int|null $utilisateur_id L'ID de l'utilisateur ou null pour les commentaires anonymes
 * @return array Un tableau de tous les commentaires de l'utilisateur avec les actualités associées, triés par date décroissante
 * @throws PDOException En cas d'erreur sql
 */
function jointureCommentaireActualiteParUtilisateur($utilisateur_id) {
    global $connexionBdd;
    $condition = ($utilisateur_id === null) ? "c.utilisateur_id IS NULL" : "c.utilisateur_id = :utilisateur_id";
    $param = ($utilisateur_id === null) ? [] : [':utilisateur_id' => $utilisateur_id];
    $requete = $connexionBdd->prepare("SELECT c.*, a.titre FROM commentaire c JOIN actualite a ON c.actualite_id = a.id WHERE $condition ORDER BY c.date DESC");
    $requete->execute($param);
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Fait une jointure entre les tables commentaire et actualite pour récupérer tous les commentaires avec le titre de l'actualité associée.
 * @return array Un tableau de tous les commentaires avec les actualités associées, triés par date décroissante
 * @throws PDOException En cas d'erreur sql
 */
function jointureCommentaireActualite() {
    global $connexionBdd;
    $requete = $connexionBdd->query("SELECT c.*, a.titre FROM commentaire c JOIN actualite a ON c.actualite_id = a.id ORDER BY c.date DESC");
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

//Update

/**
 * Modifie le contenu d'un commentaire dans la base de données.
 *
 * @param int $id L'ID du commentaire à modifier
 * @param string $message Le nouveau contenu du commentaire
 * @return bool true si une modification a été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function modifierCommentaire($id, $message) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("UPDATE commentaire SET message = :message WHERE id = :id");
    $requete->execute([':message' => $message, ':id' => $id]);
    return ($requete->rowCount() > 0);
}

//Delete

/**
 * Supprime un commentaire de la base de données.
 *
 * @param int $id L'ID du commentaire à supprimer
 * @return bool true si une suppression a bien été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function supprimerCommentaire($id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("DELETE FROM commentaire WHERE id = :id");
    $requete->execute([':id' => $id]);
    return ($requete->rowCount() > 0);
}

/**
 * Supprime tous les commentaires liés à une actualité.
 *
 * @param int $actualite_id L'ID de l'actualité
 * @return bool true si au moins un commentaire a été supprimé, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function supprimerCommentairesActualite($actualite_id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("DELETE FROM commentaire WHERE actualite_id = :actualite_id");
    $requete->execute([':actualite_id' => $actualite_id]);
    return ($requete->rowCount() > 0);
}
?>