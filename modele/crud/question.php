<?php
require_once __DIR__ . "/../bdd/connexionBdd.php";

/*
La table question contient les champs suivants : id, question
La structure est simple : une clé primaire auto-incrémentée et le texte de la question.
*/

// CREATE

/**
 * Crée une nouvelle question secrète dans la base de données.
 * 
 * @param string $question Le texte de la question
 * 
 * @return int L'ID de la question créée
 * 
 * @throws PDOException En cas d'erreur sql
 */
function creerQuestion($question) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("INSERT INTO question (question) VALUES (:question)");
    $requete->execute([
        ':question' => $question
    ]);
    return $connexionBdd->lastInsertId();
}

// READ

/**
 * Récupère toutes les questions secrètes de la base de données.
 * 
 * @return array Un tableau de toutes les questions
 * 
 * @throws PDOException En cas d'erreur sql
 */
function question() {
    global $connexionBdd;
    $requete = $connexionBdd->query("SELECT * FROM question");
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère une question spécifique à partir de son ID.
 * 
 * @param int $id L'ID de la question
 * 
 * @return array|null Les données de la question ou null si non trouvée
 * 
 * @throws PDOException En cas d'erreur sql
 */
function questionParId($id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM question WHERE id = :id");
    $requete->execute([
        ':id' => $id
    ]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

// UPDATE

/**
 * Modifie une question secrète dans la base de données.
 * 
 * @param int $id L'ID de la question à modifier
 * @param string $question Le nouveau texte de la question
 * 
 * @return bool True si la modification a bien été effectuée, false sinon
 * 
 * @throws PDOException En cas d'erreur sql, notamment échec de modification due à la relation RESTRICT entre question et utilisateur
 */
function modifierQuestion($id, $question) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("UPDATE question SET question = :question WHERE id = :id");
    $requete->execute([
        ':id' => $id,
        ':question' => $question
    ]);
    return $requete->rowCount() > 0;
}

// DELETE

/**
 * Supprime une question secrète de la base de données.
 * 
 * @param int $id L'ID de la question à supprimer
 * 
 * @return bool True si une suppression a bien été effectuée, false sinon
 * 
 * @throws PDOException En cas d'erreur sql, notamment échec de suppression due à la relation RESTRICT entre question et utilisateur
 */
function supprimerQuestion($id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("DELETE FROM question WHERE id = :id");
    $requete->execute([
        ':id' => $id
    ]);
    return $requete->rowCount() > 0;
}
?>
