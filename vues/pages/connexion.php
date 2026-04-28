<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
</head>
<body>
    <?php include __DIR__ . '/header_footer/header.php'; ?>
    <main>
        <h1>Connexion</h1>
        <?php if (isset($_SESSION['inscription_succes'])) {
            echo '<p style="color: green;">' . $_SESSION['inscription_succes'] . '</p>';
            unset($_SESSION['inscription_succes']);
        }
        if (isset($erreur_connexion)) {
            echo "<p style='color: red;'>$erreur_connexion</p>";
            unset($erreur_connexion);
        }
        ?>

        <form action="connexion" method="post">
            <label for="email">Email :</label>
            <input type="text" id="email" name="email" required>

            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required>

            <button type="submit" name="bConnexion">Se connecter</button>
            <button type="reset">Annuler</button>
            <a href="inscription">Pas encore inscrit ?</a>
        </form>
    </main>
    <?php include __DIR__ . '/header_footer/footer.php'; ?>
</body>
</html>