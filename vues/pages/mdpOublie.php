<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
</head>
<body>
    <?php include __DIR__ . '/header_footer/header.php'; ?>
    <main>
        <h1>Mot de passe oublié</h1>
        <?php if (isset($erreur_email_introuvable)): ?>
                <p style="color: red;"><?php echo $erreur_email_introuvable; ?></p>
                <?php unset($erreur_email_introuvable); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['reponse']) && $_SESSION['reponse'] === false): ?>
                <p style="color: red;">Votre réponse est incorrecte. TU ES SUSPECT.</p>
            <?php session_unset();session_destroy();?>
        <?php endif; ?>

        <?php if (!isset($_SESSION['question'])): ?>
            <p>Veuillez entrer votre adresse email pour recevoir votre question secrète.</p>        
            <form action="mdpOublie" method="post">
                <label for="email">Email :</label>
                <input type="text" id="email" name="email" required>

                <button type="submit" name="bQuestion">Envoyer</button>
                <button type="reset">Annuler</button>
            </form>
        <?php elseif (isset($_SESSION['question']) && !isset($_SESSION['reponse'])): ?>
            <p>Votre question secrète est : <strong><?php echo htmlspecialchars($_SESSION['question']['question']); ?></strong></p>
            <form action="mdpOublie" method="post">
                <label for="reponse_secrete">Réponse secrète :</label>
                <input type="text" id="reponse_secrete" name="reponse_secrete" required>
                <button type="submit" name="bReponse">Valider</button>
            </form>
        <?php elseif (isset($_SESSION['reponse']) && $_SESSION['reponse'] === true): ?>
            <?php if (isset($erreur_mdp_non_correspondant)): ?>
                <p style="color: red;"><?php echo $erreur_mdp_non_correspondant; ?></p>
                <?php unset($erreur_mdp_non_correspondant); ?>
            <?php endif; ?>
            <p style="color: green;">Votre réponse est correcte. Vous pouvez maintenant réinitialiser votre mot de passe.</p>
            <form action="mdpOublie" method="post">
                <label for="nouveauMdp">Nouveau mot de passe :</label>
                <input type="password" id="nouveauMdp" name="nouveauMdp" required>
                <label for="confirmeMdp">Confirmer le nouveau mot de passe :</label>
                <input type="password" id="confirmeMdp" name="confirmeMdp" required>
                <button type="submit" name="bNouveauMdp">Réinitialiser</button>
                <button type="reset">Annuler</button>
            </form>
        <?php endif; ?>
        

    </main>
    <?php include __DIR__ . '/header_footer/footer.php'; ?>
    
</body>
</html>