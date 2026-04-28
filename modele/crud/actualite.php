<?php
require_once __DIR__ . "/../bdd/connexionBdd.php";
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
 * @throws PDOException En cas d'erreur sql
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
 * Récupère les données d'une actualité à partir de son ID.
 *
 * @param int $id L'ID de l'actualité
 *
 * @return array|false Les données de l'actualité ou false si elle n'existe pas
 *
 * @throws PDOException En cas d'erreur sql
 */
function actualiteParId($id) {
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
function actualiteParTitre($titre) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM actualite WHERE titre = :titre");
    $requete->execute([':titre' => $titre]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Recherche des actualités dont le titre contient un mot-clé donné.
 *
 * @param string $mot Le mot-clé à rechercher dans les titres des actualités
 *
 * @return array Un tableau des actualités correspondantes triées de la plus récente à la plus ancienne
 *
 * @throws PDOException En cas d'erreur sql
 */
function rechercheActus($mot) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM actualite WHERE titre LIKE :mot ORDER BY `date` DESC, id DESC");
    $requete->execute([':mot' => '%' . $mot . '%']);
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

//Update

/**
 * Modifie une actualité dans la base de données.
 *
 * @param int $id L'ID de l'actualité à modifier
 * @param array $modfifications Un tableau associatif des champs à modifier avec leurs nouvelles valeurs (ex: ['titre' => 'Nouveau titre', 'contenu' => 'Nouveau contenu'])
 *
 * @return bool true si une modification a été effectuée, false sinon
 *
 * @throws PDOException En cas d'erreur sql
 */
function modifierActualite($id, $modfifications) {
	global $connexionBdd;
    $attributs = [];
    $params = [':id' => $id];
    foreach ($modfifications as $champ => $valeur) {
        $attributs[] = "$champ = :$champ";
        $params[":$champ"] = $valeur;
    }
	$requete = $connexionBdd->prepare("UPDATE actualite SET " . implode(', ', $attributs) . " WHERE id = :id");
	$requete->execute($params);
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