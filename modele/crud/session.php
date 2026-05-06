<?php
require_once MODELE . "bdd/connexionBdd.php";
/*La table session est garder un utilisateur connecté.
Seulement 3 champs : token, utilisateur_id, date_creation avec token en pk et utilisateur_id unique
On va faire un token de connexion simpliste. On va utiliser time() suivi d'un - et puis un nombre aléatoire de 10 chiffres
utilisateur_id est une fk vers utilisateur. Suppression en cascade.
date_creation est la date de création de la session. Permet de supprimer les sessions expirées (plus de 13 mois)
*/

//Create

/**
 * Génère un token de session au format "timestamp-xxxxxxxxxx". Les x représentent un nombre aléatoire de 10 chiffres.
 *
 * @return string Le token généré
 */
function genererTokenSession() {
	return time() . '-' . random_int(1000000000, 9999999999);
}

/**
 * Crée une session de connexion pour un utilisateur.
 *
 * @param int $utilisateur_id L'ID de l'utilisateur
 *
 * @return string Le token de session créé
 *
 * @throws PDOException En cas d'erreur sql
 */
function creerSession($utilisateur_id) {
	global $connexionBdd;
	$token = genererTokenSession();
	$requete = $connexionBdd->prepare("INSERT INTO session (token, utilisateur_id, date_creation) VALUES (:token, :utilisateur_id, NOW())");
	$requete->execute([
		':token' => $token,
		':utilisateur_id' => $utilisateur_id
	]);
	return $token;
}

//Read

/**
 * Récupère toutes les sessions de la base de données.
 *
 * @return array Un tableau de toutes les sessions
 *
 * @throws PDOException En cas d'erreur sql
 */
function session() {
	global $connexionBdd;
	$requete = $connexionBdd->query("SELECT * FROM session");
	return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les données d'une session à partir de son token.
 *
 * @param string $token Le token de session
 *
 * @return array|false Les données de la session ou false si elle n'existe pas
 *
 * @throws PDOException En cas d'erreur sql
 */
function sessionToken($token) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("SELECT * FROM session WHERE token = :token");
	$requete->execute([':token' => $token]);
	return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les sessions d'un utilisateur à partir de son ID.
 *
 * @param int $utilisateur_id L'ID de l'utilisateur
 *
 * @return array Un tableau des sessions de l'utilisateur
 *
 * @throws PDOException En cas d'erreur sql
 */
function sessionUtilisateur($utilisateur_id) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("SELECT * FROM session WHERE utilisateur_id = :utilisateur_id");
	$requete->execute([':utilisateur_id' => $utilisateur_id]);
	return $requete->fetchAll(PDO::FETCH_ASSOC);
}

//Delete

/**
 * Supprime une session de la base de données.
 *
 * @param string $token Le token de session à supprimer
 * @return bool true si une suppression a bien été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function supprimerSession($token) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("DELETE FROM session WHERE token = :token");
	$requete->execute([':token' => $token]);
	return ($requete->rowCount() > 0);
}

/**
 * Supprime la session d'un utilisateur.
 *
 * @param int $utilisateur_id L'ID de l'utilisateur
 * @return bool true si une session a été supprimée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function supprimerSessionUtilisateur($utilisateur_id) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("DELETE FROM session WHERE utilisateur_id = :utilisateur_id");
	$requete->execute([':utilisateur_id' => $utilisateur_id]);
	return ($requete->rowCount() > 0);
}
?>

