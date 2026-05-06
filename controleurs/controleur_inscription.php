<?php
if (isset($_POST['bInscription'])) {
    require_once __DIR__ . '/../modele/visiteur/inscription.php';
    // On récupère et sécurise les données du formulaire d'inscription
    $email = trim(htmlspecialchars($_POST['email']));
    $nom = trim(htmlspecialchars($_POST['nom']));
    $prenom = trim(htmlspecialchars($_POST['prenom']));
    $mdp = trim(htmlspecialchars($_POST['mdp']));
    $mdpConfirme = trim(htmlspecialchars($_POST['mdpConfirme']));
    $question_id = (int)trim(htmlspecialchars($_POST['question_id']));
    $reponse_secrete = strtolower(trim(htmlspecialchars($_POST['reponse_secrete'])));

    //Pour les champs optionnels, on regarde s'ils sont vides. Si oui ils prennent null
    $tel = trim(htmlspecialchars($_POST['tel']));
    $tel = ($tel == '') ? null : $tel;
    $rue = trim(htmlspecialchars($_POST['rue']));
    $rue = ($rue == '') ? null : $rue;
    $numero = trim(htmlspecialchars($_POST['numero']));
    $numero = ($numero == '') ? null : $numero;
    $boite = trim(htmlspecialchars($_POST['boite']));
    $boite = ($boite == '') ? null : $boite;
    $code_postal = trim(htmlspecialchars($_POST['code_postal']));
    $code_postal = ($code_postal == '') ? null : $code_postal;
    $commune = trim(htmlspecialchars($_POST['commune']));
    $commune = ($commune == '') ? null : $commune;
    $pays = trim(htmlspecialchars($_POST['pays']));
    $pays = ($pays == '') ? null : $pays;

    //On appelle la fonction qui vérifie si les données sont valides.
    //Ensuite selon le retour, on fait un switch pour indiquer à l'utilisateur ce qui a foiré ou si l'inscription a réussi.
    //Pour l'instant ma vérification est basique. Je fais même pas tous les champs à voir plus tard.
    $validation = verificationInscription($email, $nom, $prenom, $mdp, $mdpConfirme, $question_id, $reponse_secrete, $numero);
    switch ($validation) {
        case 'succes':
            //Ici les données sont vérifiées. Il ne reste plus qu'à l'insérer en bdd. 
            //3 cas de figure : tout fonctionne, l'email est déjà utilisé ou une erreur sql survient.
            try {
                inscription($email, $nom, $prenom, $mdp, $question_id, $reponse_secrete, $tel, $rue, $numero, $boite, $code_postal, $commune, $pays);
                $_SESSION['inscription_succes'] = "Votre inscription a bien réussie. Vous pouvez maintenant vous connecter.";
                header('Location: connexion');
                exit();
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') { 
                    // Code d'erreur pour violation de contrainte. Dans ce cas-ci, je sais que le problème vient de l'email déjà utilisé.
                    //Si jamais je voulais vraiment être précis, je peux regarder si l'errorInfo[1] est 1062. C'est le code spécifique pour l'unicité en mySQL. 
                    $erreur_inscription = "Cette adresse mail est déjà utilisée.";
                } else {
                    $erreur_inscription = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
                }
            }
            break;        
        case 'email_invalide':
            $erreur_inscription = "L'email n'est pas valide.";
            break;
        case 'mdp_court':
            $erreur_inscription = "Le mot de passe doit contenir au moins 6 caractères.";
            break;
        case 'mdp_chiffre':
            $erreur_inscription = "Le mot de passe doit contenir au moins un chiffre.";
            break;
        case 'mdp_majuscule':
            $erreur_inscription = "Le mot de passe doit contenir au moins une majuscule.";
            break;
        case 'mdp_confirme_incorrect':
            $erreur_inscription = "Les mots de passe ne correspondent pas.";
            break;
        case 'numero_invalide':
            $erreur_inscription = "Le numéro de votre adresse n'est pas valide. Ce n'est pas un nombre. Vérifier que vous n'avez pas mis votre boite dans ce champ par erreur.";
            break;
        case 'nom_court':
            $erreur_inscription = "Le nom doit contenir au moins 2 caractères.";
            break;
        case 'prenom_court':
            $erreur_inscription = "Le prénom doit contenir au moins 2 caractères.";
            break;
        case 'champs_manquants':
            $erreur_inscription = "Veuillez remplir tous les champs obligatoires.";
            break;
        case 'question_invalide':
            $erreur_inscription = "La question secrète choisie n'est pas valide.";
            break;
        case 'reponse_secrete_courte':
            $erreur_inscription = "La réponse à la question secrète doit contenir au moins 2 caractères.";
            break;
        default:
            $erreur_inscription = "Une erreur est survenue lors de l'inscription.";
    }
} else {
    require_once __DIR__ . '/../modele/crud/question.php';
    $questions = question();
    include(__DIR__ . '/../vues/pages/inscription.php');
}
?>