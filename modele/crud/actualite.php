<?php
require_once MODELE . "bdd/connexionBdd.php";
/*La table actualite contient les champs id(ai), titre, contenu, image, date, likes.
Titre est unique. Date est indexé et généré par défaut(CURRENT_TIMESTAMP).
*/

//Create

/**
 * Crée une nouvelle actualité dans la base de données.
 *
 * @param string $titre Le titre de l'actualité
 * @param string $contenu Le contenu de l'actualité
 * @param string $image Le chemin de l'image de l'actualité
 *
 * @return int L'ID de l'actualité créée
 *
 * @throws PDOException En cas d'erreur sql, notamment si le titre n'est pas unique
 */
function creerActualite($titre, $contenu, $image) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("INSERT INTO actualite (titre, contenu, image) VALUES (:titre, :contenu, :image)");
	$requete->execute([
		':titre' => $titre,
		':contenu' => $contenu,
		':image' => $image
	]);
	return $connexionBdd->lastInsertId();
}

//Read

/**
 * Récupère toutes les actualités de la base de données.
 *
 * @return array Un tableau de toutes les actualités triées de la plus récente à la plus ancienne
 *
 * @throws PDOException En cas d'erreur sql
 */
function actualite() {
	global $connexionBdd;
	$requete = $connexionBdd->query("SELECT * FROM actualite ORDER BY `date` DESC, id DESC");
	return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les 3 dernières actualités de la base de données.
 *
 * @return array Un tableau des 3 dernières actualités
 *
 * @throws PDOException En cas d'erreur sql
 */
function dernieresActus() {
    global $connexionBdd;
    $requete = $connexionBdd->query("SELECT * FROM actualite ORDER BY `date` DESC, id DESC LIMIT 3");
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les actualités de la base de données en fonction de la pagination.
 *
 * @param int $pagination Le numéro de la page à récupérer
 *
 * @return array Un tableau des actualités de la page spécifiée
 *
 * @throws PDOException En cas d'erreur sql
 */
function actualitePagination($pagination) {
	global $connexionBdd;
	$offset = ($pagination - 1) * 10;
	$requete = $connexionBdd->prepare("SELECT * FROM actualite ORDER BY `date` DESC, id DESC LIMIT 10 OFFSET :offset");
	$requete->execute([':offset' => $offset]);
	return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Calcule le nombre total d'actualités présentes dans la bdd.
 * @return int Le nombre total d'actualités en bdd
 * @throws PDOException En cas d'erreur sql
 */
function totalActus() {
	global $connexionBdd;
	$requete = $connexionBdd->query("SELECT COUNT(*) AS total FROM actualite");
	$total = $requete->fetch(PDO::FETCH_ASSOC)['total'];
	return $total;
}

/**
 * Récupère les données d'une actualité à partir de son ID.
 *
 * @param int $id L'ID de l'actualité
 *
 * @return array|false Les données de l'actualité ou false si elle n'existe pas
 *
 * @throws PDOException En cas d'erreur sql
 */
function actualiteId($id) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("SELECT * FROM actualite WHERE id = :id");
	$requete->execute([':id' => $id]);
	return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les données d'une actualité à partir de son titre.
 *
 * @param string $titre Le titre de l'actualité
 *
 * @return array|false Les données de l'actualité ou false si elle n'existe pas
 *
 * @throws PDOException En cas d'erreur sql
 */
function actualiteTitre($titre) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM actualite WHERE titre = :titre");
    $requete->execute([':titre' => $titre]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les 10 actualités de la bdd en fonction du tri, de l'ordre et de la pagination spécifiés.
 * @param string $tri Le champ par lequel trier les actualités (titre ou date). Par défaut, tri par date.
 * @param string $ordre L'ordre de tri (ASC ou DESC). Par défaut, tri descendant (DESC).
 * @param int $pagination Le numéro de la page à récupérer pour la pagination (par défaut 1)
 * @return array Un tableau des actualités triées selon les critères spécifiés
 * @throws PDOException En cas d'erreur sql
 */
function triActus($tri='date', $ordre='DESC', $pagination=1) {
	global $connexionBdd;
	$offset = ($pagination - 1) * 10;
	$requete = $connexionBdd->prepare("SELECT * FROM actualite ORDER BY `$tri` $ordre LIMIT 10 OFFSET $offset");
	$requete->execute();
	return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Recherche des 10 actualités si elles existent dont le titre contient le ou les mots-clés donnés. Donne aussi le nombre total d'actualités correspondantes à cette recherche.
 *
 * @param string $mots Les mots-clés à rechercher dans les titres des actualités
 * @param string $tri Le champ par lequel trier les résultats (titre ou date). Par défaut, tri par date.
 * @param string $ordre L'ordre de tri (ASC ou DESC). Par défaut, tri descendant (DESC).
 * @param int $pagination Le numéro de la page à récupérer pour la pagination (par défaut 1)
 *
 * @return array Un tableau contenant le nombre total d'actualités correspondantes et les 10 actualités triées selon les critères spécifiés
 *
 * @throws PDOException En cas d'erreur sql
 */
function rechercheActusMots($mots, $tri='date', $ordre='DESC', $pagination=1) {
    global $connexionBdd;
	$countRequete = $connexionBdd->prepare("SELECT COUNT(*) AS total FROM actualite WHERE MATCH(titre) AGAINST(:mots)");
	$countRequete->execute([':mots' => $mots]);
	$total = $countRequete->fetch(PDO::FETCH_ASSOC)['total'];

	$offset = ($pagination - 1) * 10;
    $requete = $connexionBdd->prepare("SELECT * FROM actualite WHERE MATCH(titre) AGAINST(:mots) ORDER BY `$tri` $ordre LIMIT 10 OFFSET $offset");
    $requete->execute([':mots' => $mots]);
    return ['total' => $total, 'actualites' => $requete->fetchAll(PDO::FETCH_ASSOC)];
}

//Update

/**
 * Modifie le titre d'une actualité dans la base de données.
 *
 * @param int $id L'ID de l'actualité
 * @param string $nouveauTitre Le nouveau titre de l'actualité
 *
 * @return bool true si une modification a été effectuée, false sinon
 *
 * @throws PDOException En cas d'erreur sql, notamment si le nouveau titre n'est pas unique
 */
function modifierTitre($id, $nouveauTitre) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("UPDATE actualite SET titre = :titre WHERE id = :id");
	$requete->execute([':titre' => $nouveauTitre, ':id' => $id]);
	return ($requete->rowCount() > 0);
}

/**
 * Modifie le contenu d'une actualité dans la base de données.
 *
 * @param int $id L'ID de l'actualité
 * @param string $nouveauContenu Le nouveau contenu de l'actualité
 *
 * @return bool true si une modification a été effectuée, false sinon
 *
 * @throws PDOException En cas d'erreur sql
 */
function modifierContenu($id, $nouveauContenu) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("UPDATE actualite SET contenu = :contenu WHERE id = :id");
	$requete->execute([':contenu' => $nouveauContenu, ':id' => $id]);
	return ($requete->rowCount() > 0);
}

/**
 * Modifie l'image d'une actualité dans la base de données.
 *
 * @param int $id L'ID de l'actualité à modifier
 * @param string $nouvelleImage Le nouveau chemin de l'image de l'actualité
 *
 * @return bool true si une modification a été effectuée, false sinon
 *
 * @throws PDOException En cas d'erreur sql
 */
function modifierImage($id, $nouvelleImage) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("UPDATE actualite SET image = :image WHERE id = :id");
	$requete->execute([':image' => $nouvelleImage, ':id' => $id]);
	return ($requete->rowCount() > 0);
}

//Delete

/**
 * Supprime une actualité de la base de données.
 *
 * @param int $id L'ID de l'actualité à supprimer
 *
 * @return bool true si une suppression a bien été effectuée, false sinon
 *
 * @throws PDOException En cas d'erreur sql
 */
function supprimerActualite($id) {
	global $connexionBdd;
	$requete = $connexionBdd->prepare("DELETE FROM actualite WHERE id = :id");
	$requete->execute([':id' => $id]);
	return ($requete->rowCount() > 0);
}
?>