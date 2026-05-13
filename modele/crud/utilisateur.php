<?php
require_once MODELE . "bdd/connexionBdd.php";
/*La table utilisateur contient les champs suivants : 
id, email, mdp, nom, prenom, admin, question_id, reponse_secrete, date_creation, derniere_activite, tel, rue, numero, boite, code_postal, commune, pays
Les champs obligatoires sont : email, mdp, nom, prenom, question_id, reponse_secrete.
question_id est une fk vers question. RESTRICT la question ne peut pas être supprimée si un utilisateur y est lié.
email est unique
derniere_activite est mis à jour à chaque fois que l'utilisateur se connecte ou modifie ses données. Permet de supprimer les utilisateurs inactifs depuis plus de 5 ans.
*/

//CREATE

/**
 * Crée un nouvel utilisateur dans la base de données.
 * 
 * @param string $email L'email de l'utilisateur
 * @param string $mdp Le mot de passe de l'utilisateur
 * @param string $nom Le nom de l'utilisateur
 * @param string $prenom Le prénom de l'utilisateur
 * @param int $question_id L'ID de la question secrète
 * @param string $reponse_secrete La réponse à la question secrète
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
function creerUtilisateur($email, $mdp, $nom, $prenom, $question_id, $reponse_secrete, $admin = 0, $tel = null, $rue = null, $numero = null, $boite = null, $code_postal = null, $commune = null, $pays = null) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("INSERT INTO utilisateur (email, mdp, nom, prenom, question_id, reponse_secrete, admin, tel, rue, numero, boite, code_postal, commune, pays, date_creation, derniere_activite)
     VALUES (:email, :mdp, :nom, :prenom, :question_id, :reponse_secrete, :admin, :tel, :rue, :numero, :boite, :code_postal, :commune, :pays, NOW(), NOW())");
    $requete->execute([
        ':email' => $email,
        ':mdp' => password_hash($mdp, PASSWORD_DEFAULT),
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':question_id' => $question_id,
        ':reponse_secrete' => password_hash($reponse_secrete, PASSWORD_DEFAULT),
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
function utilisateurId($id) {
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
function utilisateurEmail($email) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $requete->execute([':email' => $email]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

//UPDATE

/**
 * Modifie le mot de passe d'un utilisateur dans la base de données.
 * @param int $id L'ID de l'utilisateur
 * @param string $nouveauMdp Le nouveau mot de passe de l'utilisateur
 * @return bool true si la modification a été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function modifierMdp($id, $nouveauMdp) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("UPDATE utilisateur SET mdp = :mdp WHERE id = :id");
    $requete->execute([
        ':mdp' => password_hash($nouveauMdp, PASSWORD_DEFAULT),
        ':id' => $id
    ]);
    return ($requete->rowCount() > 0);
}

/**
 * Met à jour la date de dernière activité d'un utilisateur dans la base de données.
 * @param int $id L'ID de l'utilisateur
 * @return void
 * @throws PDOException En cas d'erreur sql
 */
function modifierDerniereActivite($id) {
    global $connexionBdd;
    $requete = $connexionBdd->prepare("UPDATE utilisateur SET derniere_activite = NOW() WHERE id = :id");
    $requete->execute([':id' => $id]);
}

/**
 * Modifie les données d'un utilisateur dans la base de données. Les champs autorisés sont : email, nom, prenom, tel, rue, numero, boite, code_postal, commune, pays. 
 * 
 * @param int $id L'ID de l'utilisateur à modifier
 * @param array $modifications Un tableau associatif des champs à modifier et de leurs nouvelles valeurs.
 * @return bool true si une modification a été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql dont l'unicité de l'email.
 */
function modifierUtilisateur($id, $modifications) {
    global $connexionBdd;
    $champsAutorises = ['email', 'nom', 'prenom', 'tel', 'rue', 'numero', 'boite', 'code_postal', 'commune', 'pays'];
    $changements = [];
    $params = [':id' => $id];
    foreach ($modifications as $champ => $valeur) {
        if (in_array($champ, $champsAutorises)) {           
            $changements[] = "$champ = :$champ";
            $params[":$champ"] = $valeur;
        }
    }
    if (empty($changements)) {
        return false; // Aucun champ à modifier
    }
    $requete = $connexionBdd->prepare("UPDATE utilisateur SET " . implode(', ', $changements) . " WHERE id = :id");
    $requete->execute($params);
    return ($requete->rowCount() > 0);
}

//DELETE
/**
 * Supprime un utilisateur de la base de données.
 * 
 * @param int|null $id L'ID de l'utilisateur à supprimer ou null pour supprimer l'utilisateur anonyme
 * @return bool true si une suppression a bien été effectuée, false sinon
 * @throws PDOException En cas d'erreur sql
 */
function supprimerUtilisateur($id) {
    global $connexionBdd;
    $condition = ($id === null) ? "id IS NULL" : "id = :id";
    $param = ($id === null) ? [] : [':id' => $id];
    $requete = $connexionBdd->prepare("DELETE FROM utilisateur WHERE " . $condition);
    $requete->execute($param);
    return ($requete->rowCount() > 0);
}
?>