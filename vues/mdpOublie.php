<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <meta name="description" content="Processus de réinitialisation du mot de passe pour les utilisateurs ayant oublié leur mot de passe.">
    <!-- Liens vers les polices-->  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Tinos:wght@400;700&display=swap" rel="stylesheet">
	
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="/public/favicon_io/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/public/favicon_io/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/public/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/public/favicon_io/site.webmanifest">

    <script defer src="/public/js/script.js"></script>
    <link rel="stylesheet" href="/public/style/style.css">
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
    <main>
        <section class="hero mdpOublie">
            <h1>Mot de passe oublié</h1>
        </section>


        <!--Le processus de réinitialisation du mot de passe se fait en plusieurs étapes :
        1. Entrer l'adresse email
        2. Répondre à la question secrète qu'on vient de recevoir grâce à l'email fourni
        3. Réinitialiser le mot de passe
        Donc les ifs vont servir à vérifier à quelle étape on est ou bien s'il y a eu une erreur.
        On peut alors soit afficher l'erreur, soit afficher le formulaire correspondant. 
        -->
        <section class="formulaire-mdpOublie">

        <!-- Ce premier if est si on a échoué à l'étape 1 et que l'email n'est pas trouvé. On peut virer l'erreur de la session, une fois affichée -->
        <?php if (isset($erreur_email_introuvable)): ?>
                <p class="message-erreur"><?php echo $erreur_email_introuvable; ?></p>
                <?php unset($erreur_email_introuvable); ?>
        <?php endif; ?>

        <!-- Ce if est si on a échoué à l'étape 3 et que la réponse secrète est incorrecte. 
         Là on fait unset parce qu'on veut enlever l'utilisateur associé à l'email de la session -->
        <?php if (isset($_SESSION['reponse']) && $_SESSION['reponse'] === false): ?>
                <p class="message-erreur">Votre réponse est incorrecte. TU ES SUSPECT.</p>
            <?php session_unset();?>
        <?php endif; ?>

        <!-- Etape 1 : Entrer l'adresse email. D'ailleurs pour ça qu'on vérifie qui'il n'a pas encore eu sa question -->
        <?php if (!isset($_SESSION['question'])): ?>
            <p>Veuillez entrer votre adresse email pour recevoir votre question secrète.</p>        
            <form action="mdpOublie" method="post">
                <label for="email">Email :</label>
                <input type="text" id="email" name="email" required>

                <button class="btn-primaire" type="submit" name="bEmail">Envoyer</button>
            </form>

        <!-- Etape 2 : Afficher la question et demander la réponse secrète -->
        <?php elseif (isset($_SESSION['question']) && !isset($_SESSION['reponse'])): ?>
            <p>Votre question secrète est : <strong><?php echo htmlspecialchars($_SESSION['question']['question']); ?></strong></p>
            <form action="mdpOublie" method="post">
                <label for="reponse_secrete">Réponse secrète :</label>
                <input type="text" id="reponse_secrete" name="reponse_secrete" required>
                <button class="btn-primaire" type="submit" name="bReponse">Valider</button>
            </form>

        <!-- Etape 3 : Si la réponse est correcte, afficher le formulaire de réinitialisation du mot de passe.-->    
        <?php elseif (isset($_SESSION['reponse']) && $_SESSION['reponse'] === true): ?>
            
            <!-- Si le mdp n'est pas conforme, on affiche l'erreur. Comme tout est encore en session, il réatterrit direct ici et peut
             corriger son erreur. On unset l'erreur une fois affichée-->
            <?php if (isset($erreur_mdp_non_conforme)): ?>
                <p class="message-erreur"><?php echo $erreur_mdp_non_conforme; ?></p>
                <?php unset($erreur_mdp_non_conforme); ?>
            <?php endif; ?>

            <p class="message-succes">Votre réponse est correcte. Vous pouvez maintenant réinitialiser votre mot de passe.</p>
            <form action="mdpOublie" method="post">
                <label for="nouveauMdp">Nouveau mot de passe :</label>
                <input type="password" id="nouveauMdp" name="nouveauMdp" required>
                <label for="confirmeMdp">Confirmer le nouveau mot de passe :</label>
                <input type="password" id="confirmeMdp" name="confirmeMdp" required>
                <button class="btn-primaire" type="submit" name="bNouveauMdp">Réinitialiser</button>
                <button class="btn-secondaire" type="reset">Reset</button>
            </form>
        <?php endif; ?>
        </section>
    </main>
    <?php include VUES . 'header_footer/footer.php'; ?>    
</body>
</html>