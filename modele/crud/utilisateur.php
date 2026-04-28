<?php
require_once "../bdd/connexionBdd.php";
/*La table utilisateur contient les champs suivants : id, email, mdp, nom, prenom, admin, tel, rue, numero, boite, code_postal, commune, pays, date_creation, derniere_visite
Les seuls qui sont obligatoires sont email, mdp, nom et prenom.
*/

//CREATE

/**
 * Crée un nouvel utilisateur dans la base de données.
 * 
 * @param string $email L'email de l'utilisateur
 * @param string $mdp Le mot de passe de l'utilisateur
 * @param string $nom Le nom de l'utilisateur
 * @param string $prenom Le prénom de l'utilisateur
 * @param int $admin Indique si l'utilisateur est administrateur (0 ou 1)
 * @param string|null $tel Le numéro de téléphone de l'utilisateur
 * @param string|null $rue La rue de l'utilisateur
 * @param string|null $numero Le numéro de rue de l'utilisateur
 * @param string|null $boite La boîte postale de l'utilisateur
 * @param string|null $code_postal Le code postal de l'utilisateur
 * @param string|null $commune La commune de l'utilisateur
 * @param string|null $pays Le pays de l'utilisateur
 * 
 * @return int L'ID de l'utilisateur créé
 * 
 *  @throws PDOException En cas d'erreur sql ou échec d'unicité de l'email
 */
function creerUtilisateur($email, $mdp, $nom, $prenom, $admin = 0, $tel = null, $rue = null, $numero = null, $boite = null, $code_postal = null, $commune = null, $pays = null) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("INSERT INTO utilisateur (email, mdp, nom, prenom, admin, tel, rue, numero, boite, code_postal, commune, pays, date_creation, derniere_visite)
     VALUES (:email, :mdp, :nom, :prenom, :admin, :tel, :rue, :numero, :boite, :code_postal, :commune, :pays, NOW(), NOW())");
    $requete->execute([
        ':email' => $email,
        ':mdp' => password_hash($mdp, PASSWORD_DEFAULT),
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':admin' => $admin,
        ':tel' => $tel,
        ':rue' => $rue,
        ':numero' => $numero,
        ':boite' => $boite,
        ':code_postal' => $code_postal,
        ':commune' => $commune,
        ':pays' => $pays
    ]);
    return $connexionBdd->lastInsertId();
}

//READ

/**
 * Récupère tous les utilisateurs de la base de données.
 * 
 * @return array Un tableau de tous les utilisateurs
 * 
 * @throws PDOException En cas d'erreur sql
 */
function utilisateur () {
    global $connexionBdd;
    $requete = $connexionBdd->query("SELECT * FROM utilisateur");
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les utilisateurs qui ne sont pas administrateurs de la base de données.
 * @return array Un tableau de tous les utilisateurs non administrateurs
 * @throws PDOException En cas d'erreur sql
 */
function utilisateurSaufAdmin() {
    global $connexionBdd;
    $requete = $connexionBdd->query("SELECT * FROM utilisateur WHERE admin = 0");
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les données d'un utilisateur à partir de son ID.
 * 
 *  @param int $id L'ID de l'utilisateur
 * 
 *  @return array|false Les données de l'utilisateur ou false s'il n'existe pas
 * 
 * @throws PDOException En cas d'erreur sql
 */
function utilisateurParId($id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM utilisateur WHERE id = :id");
    $requete->execute([':id' => $id]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les données d'un utilisateur à partir de son email.
 * 
 *  @param string $email L'email unique de l'utilisateur
 * 
 *  @return array|false Les données de l'utilisateur ou false s'il n'existe pas
 * 
 * @throws PDOException En cas d'erreur sql
 */
function utilisateurParEmail($email) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $requete->execute([':email' => $email]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les données d'un utilisateur à partir de son email et de son mot de passe.
 * 
 * @param string $email L'email de l'utilisateur
 * @param string $mdp Le mot de passe de l'utilisateur
 * 
 * @return array|false Les données de l'utilisateur ou false si les identifiants sont incorrects
 * 
 * @throws PDOException En cas d'erreur sql
 */
function utilisateurParEmailEtMdp($email, $mdp) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $requete->execute([':email' => $email]);
    $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
    if ($utilisateur && password_verify($mdp, $utilisateur['mdp'])) {
        return $utilisateur;
    }
    return false;
}



//UPDATE

/**
 * Modifie les données d'un utilisateur dans la base de données.
 * 
 * @param int $id L'ID de l'utilisateur à modifier
 * @param array $modifications Un tableau associatif des champs à modifier et de leurs nouvelles valeurs
 * @return bool true si une modification a été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function modifierUtilisateur($id, $modifications) {
    global $connexionBdd;
    $changements = [];
    $params = [':id' => $id];
    foreach ($modifications as $champ => $valeur) {
        if ($champ === 'mdp') {
            $valeur = password_hash($valeur, PASSWORD_DEFAULT);
        }
        $changements[] = "$champ = :$champ";
        $params[":$champ"] = $valeur;
    }
    $requete = $connexionBdd->prepare("UPDATE utilisateur SET " . implode(', ', $changements) . " WHERE id = :id");
    $requete->execute($params);
    return ($requete->rowCount() > 0);
}

/**
 * Met à jour la date de dernière visite d'un utilisateur.
 * @param int $id L'ID de l'utilisateur
 * @return bool true si la mise à jour a été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function updateDerniereVisite($id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("UPDATE utilisateur SET derniere_visite = NOW() WHERE id = :id");
    $requete->execute([':id' => $id]);
    return ($requete->rowCount() > 0);
}

//DELETE
/**
 * Supprime un utilisateur de la base de données.
 * 
 * @param int $id L'ID de l'utilisateur à supprimer
 * @return bool true si une suppression a bien été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function supprimerUtilisateur($id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("DELETE FROM utilisateur WHERE id = :id");
    $requete->execute([':id' => $id]);
    return ($requete->rowCount() > 0);
}
?>