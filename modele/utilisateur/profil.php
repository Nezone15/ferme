<?php

/**
 * Vérifie les données de modification du profil d'un utilisateur
 * @param string $email L'adresse email de l'utilisateur
 * @param string $nom Le nom de l'utilisateur
 * @param string $prenom Le prénom de l'utilisateur
 * @param string|null $numero Le numéro de l'adresse de l'utilisateur (optionnel)
 * @return string L'erreur rencontrée ou 'succes' si les données sont valides
 */
function verificationProfil($email, $nom, $prenom, $numero=null) {
    if (empty($email) || empty($nom) || empty($prenom)) {
        return "champs_obligatoires_manquants";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
        return "email_invalide";
    }
    if (!($numero == null || $numero == '') && !is_numeric($numero)) {
        return "numero_invalide";
    }
    if (strlen($nom) < 2) {
        return "nom_court";
    }
    if (strlen($prenom) < 2) {
        return "prenom_court";
    }
    return 'succes';
}

/**
 * Modifie les données du profil d'un utilisateur dans la base de données. Les champs autorisés sont : email, nom, prenom, tel, rue, numero, boite, code_postal, commune, pays.
 * @param array $formulaire Un tableau associatif contenant les données du formulaire de modification du profil.
 * @return string L'erreur rencontrée ou 'succes' si la modification a été effectuée avec succès
 */
function modifierProfil($formulaire) {
    require_once MODELE . 'crud/utilisateur.php';

    //Avec le formulaire, on regarde ce qui diffère de l'utilisateur qu'on a en session
    $utilisateur = $_SESSION['utilisateur'];
    foreach ($formulaire as $champ => $valeur) {
        if ($valeur !== $utilisateur[$champ]) {
            $modifications[$champ] = $valeur;
        }
    }
    if (empty($modifications)) {
        return 'aucune_modification';
    }
    
    try {
        modifierUtilisateur($utilisateur['id'], $modifications);
        return 'succes';
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Code d'erreur pour violation de contrainte             
            if ($e->errorInfo[1] == 1062) {
                return "email_deja_utilise";
            }
            else {
                return "erreur_contrainte";
            }
        } else {
            return "erreur_sql";
        }
    }
}