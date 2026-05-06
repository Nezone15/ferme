<?php
require_once __DIR__ . "/../modele/crud/utilisateur.php";
require_once __DIR__ . "/../modele/crud/question.php";

/*
Le processus de réinitialisation du mot de passe se fait en plusieurs étapes :
1. Entrer l'adresse email
2. Répondre à la question associée à l'email fourni
3. Réinitialiser le mot de passe
Donc les ifs vont servir à vérifier à quelle étape et récupérer les données nécessaires pour progresser. Sinon indiquer l'erreur qui est survenue et la communiquer.
D'ailleurs je triche en gardant question et reponse en session pour savoir à quelle étape on est
*/

//Le form bEmail est le premier. C'est là que l'utilisateur entre son email. On doit alors lui donner la question associée à son compte.
//Forcément si on trouve pas de compte avec cet email, on le communique.
if (isset($_POST['bEmail'])) {
    $email = trim(htmlspecialchars($_POST['email']));

    //Je l'appelle utilisateur_reinitialisation parce que je veux pas confondre avec l'utilisateur connecté $_SESSION['utilisateur']
    //Parce qu'alors mon header verrait l'utilisateur comme étant connecté et un lien vers son profil apparaîtrait alors que c'est pas le cas. 
    $_SESSION['utilisateur_reinitialisation'] = utilisateurEmail($email);

    //Soit on l'a trouvé et alors on stocke la question, soit erreur. 
    if ($_SESSION['utilisateur_reinitialisation']) {
        $_SESSION['question'] = questionId($_SESSION['utilisateur_reinitialisation']['question_id']);
    } else {
        $erreur_email_introuvable = "Aucun compte trouvé avec cet email.";
    } 
} else if (isset($_POST['bReponse'])) { //Etape 2 : L'utilisateur a reçu sa question. Le form bReponse contient la réponse qu'il a donné.
    $reponse_secrete = strtolower(trim(htmlspecialchars($_POST['reponse_secrete'])));
    
    //On vérifie sa réponse. On stocke en session s'il a réussi
    if (password_verify($reponse_secrete, $_SESSION['utilisateur_reinitialisation']['reponse_secrete'])) {
        $_SESSION['reponse'] = true;
    } else {
        $_SESSION['reponse'] = false;
    }
} else if (isset($_POST['bNouveauMdp'])) { //Etape 3 : L'utilisateur était correct. Le form bNouveauMdp va lui permettre de réinitialiser son mot de passe. 
    $nouveauMdp = trim(htmlspecialchars($_POST['nouveauMdp']));
    $confirmeMdp = trim(htmlspecialchars($_POST['confirmeMdp']));

    //Vérification de correspondance
    if ($nouveauMdp === $confirmeMdp) {
        //Vérification de la conformité du mdp. On indique l'erreur précise pour que l'utilisateur puisse corriger.
        include_once __DIR__ . "/../modele/visiteur/inscription.php";
        $verifieMdp = verifierMdp($nouveauMdp);
        if ($verifieMdp !== 'succes') {
            switch ($verifieMdp) {
                case "mdp_court":
                    $erreur_mdp_non_conforme = "Le mot de passe doit comporter au moins 6 caractères.";
                    break;
                case "mdp_chiffre":
                    $erreur_mdp_non_conforme = "Le mot de passe doit comporter au moins un chiffre.";
                    break;
                case "mdp_majuscule":
                    $erreur_mdp_non_conforme = "Le mot de passe doit comporter au moins une majuscule.";
                    break;
            }
        } else { //C'est bon. On unset la session et on le redirige vers la page de connexion avec un message de succès.
            modifierMdp($_SESSION['utilisateur_reinitialisation']['id'], $nouveauMdp);
            session_unset();
            
            $_SESSION['reset_mdp_succes'] = "Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.";
            header("Location: connexion");
            exit();
        }
    } else {
        $erreur_mdp_non_conforme = "Les mots de passe ne correspondent pas.";
    }
}
include __DIR__ . "/../vues/pages/mdpOublie.php";
?>