<?php
require_once __DIR__ . "/../modele/crud/utilisateur.php";
require_once __DIR__ . "/../modele/crud/question.php";
var_dump($_SESSION);
var_dump($_POST);
if (isset($_POST['bQuestion'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $_SESSION['utilisateur'] = utilisateurParEmail($email);

    if ($_SESSION['utilisateur']) {
        $_SESSION['question'] = questionParId($_SESSION['utilisateur']['question_id']);
    } else {
        $erreur_email_introuvable = "Aucun compte trouvé avec cet email.";
    }
} else if (isset($_POST['bReponse'])) {
    $reponse_secrete = strtolower(trim(htmlspecialchars($_POST['reponse_secrete'])));
    
    if (password_verify($reponse_secrete, $_SESSION['utilisateur']['reponse_secrete'])) {
        $_SESSION['reponse'] = true;
    } else {
        $_SESSION['reponse'] = false;
    }
} else if (isset($_POST['bNouveauMdp'])) {
    $nouveauMdp = trim(htmlspecialchars($_POST['nouveauMdp']));
    $confirmeMdp = trim(htmlspecialchars($_POST['confirmeMdp']));

    if ($nouveauMdp === $confirmeMdp) {
        modifierMdp($_SESSION['utilisateur']['id'], $nouveauMdp);
        session_unset();
        session_destroy();
        unset($nouveauMdp, $confirmeMdp);
        $_SESSION['reset_mdp_succes'] = "Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.";
        header("Location: connexion");
        exit();
    } else {
        $erreur_mdp_non_correspondant = "Les mots de passe ne correspondent pas.";
    }
}
include __DIR__ . "/../vues/pages/mdpOublie.php";
?>