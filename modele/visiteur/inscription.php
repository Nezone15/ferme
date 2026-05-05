<?php
/** 
 * Vérifie les données d'inscription d'un visiteur
 * @param string $email L'adresse email du visiteur
 * @param string $nom Le nom du visiteur
 * @param string $prenom Le prénom du visiteur
 * @param string $mdp Le mot de passe du visiteur
 * @param string $mdpConfirme La confirmation du mot de passe
 * @param int $question_id L'ID de la question secrète choisie par le visiteur
 * @param string $reponse_secrete La réponse à la question secrète du visiteur
 * @param string|null $numero Le numéro de l'adresse du visiteur (optionnel)
 * @return string L'erreur rencontrée ou 'succes' si les données sont valides
 */
function verificationInscription($email, $nom, $prenom, $mdp, $mdpConfirme, $question_id, $reponse_secrete, $numero = null) {
    if (empty($email) || empty($nom) || empty($prenom) || empty($mdp) || empty($mdpConfirme) || empty($question_id) || empty($reponse_secrete)) {
        return "champs_manquants";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
        return "email_invalide";
    }
    if (strlen($mdp) < 6) {
        return "mdp_court";
    }
    if (!preg_match('/\d/', $mdp)) {
        return "mdp_chiffre";
    }
    if (!preg_match('/[A-Z]/', $mdp)) {
        return "mdp_majuscule";
    }
    if ($mdp !== $mdpConfirme) {
        return "mdp_confirme_incorrect";
    }
    if ($numero !== null && !is_numeric($numero)) {
        return "numero_invalide";
    }
    if (strlen($nom) < 2) {
        return "nom_court";
    }
    if (strlen($prenom) < 2) {
        return "prenom_court";
    }
    if (1 > $question_id || $question_id > 5) {
        return "question_invalide";
    }
    if (strlen($reponse_secrete) < 2) {
        return "reponse_secrete_courte";
    }
    return 'succes';
}

/**
 * Inscrit un nouveau visiteur dans la base de données.
 * 
 * @param string $email L'adresse email du visiteur
 * @param string $nom Le nom du visiteur
 * @param string $prenom Le prénom du visiteur
 * @param string $mdp Le mot de passe du visiteur
 * @param int $question_id L'ID de la question secrète choisie par le visiteur
 * @param string $reponse_secrete La réponse à la question secrète du visiteur
 * @param string|null $tel Le numéro de téléphone du visiteur (optionnel)
 * @param string|null $rue La rue de l'adresse du visiteur (optionnel)
 * @param string|null $numero Le numéro de l'adresse du visiteur (optionnel)
 * @param string|null $boite La boîte postale de l'adresse du visiteur (optionnel)
 * @param string|null $code_postal Le code postal de l'adresse du visiteur (optionnel)
 * @param string|null $commune La commune de l'adresse du visiteur (optionnel)
 * @param string|null $pays Le pays de l'adresse du visiteur (optionnel)
 * 
 * @return int L'ID de l'utilisateur créé
 * 
 * @throws PDOException En cas d'erreur sql ou échec d'unicité de l'email
 */
function inscription($email, $nom, $prenom, $mdp, $question_id, $reponse_secrete, $tel = null, $rue = null, $numero = null, $boite = null, $code_postal = null, $commune = null, $pays = null) {
    require_once __DIR__ . '/../crud/utilisateur.php';
    return creerUtilisateur(email: $email, mdp: $mdp, nom: $nom, prenom: $prenom, question_id: $question_id, reponse_secrete: $reponse_secrete, admin: 0, tel: $tel, rue: $rue, numero: $numero, boite: $boite, code_postal: $code_postal, commune: $commune, pays: $pays);
}
?>