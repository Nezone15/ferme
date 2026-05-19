<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferme Saint Achaire | Connexion</title>
	<meta name="description" content="Connectez-vous à votre compte sur la Ferme Saint Achaire.">   

	<!-- Liens vers les polices-->  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Tinos:wght@400;700&display=swap" rel="stylesheet">
	
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="/public/favicon_io/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/public/favicon_io/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/public/favicon_io/favicon-16x16.png">
	<link rel="manifest" href="/public/favicon_io/site.webmanifest">

    <link rel="stylesheet" href="/public/style/style.css">
    <link rel="stylesheet" href="/public/style/connexion.css">
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
    <main>
        <section class="hero connexion">
            <h1>Connexion</h1>
        </section>

        <section class="contenu">
            <?php if (isset($_SESSION['inscription_succes'])) {
                echo '<p class="succes">' . $_SESSION['inscription_succes'] . '</p>';
                unset($_SESSION['inscription_succes']);
            }
            if (isset($erreur_connexion)) {
                echo "<p class=\"erreur\">$erreur_connexion</p>";
                unset($erreur_connexion);
            }
            if (isset($_SESSION['reset_mdp_succes'])) {
                echo '<p class="succes">' . $_SESSION['reset_mdp_succes'] . '</p>';
                unset($_SESSION['reset_mdp_succes']);
            }
            ?>

            <form action="/connexion" method="post">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Email" required>

                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required>

                <button class="btn-primaire" type="submit" name="bConnexion">Se connecter</button>
                <div class="connexion-liens">
                    <a href="/mdpOublie">Mot de passe oublié ?</a>
                    <a href="/inscription">Pas encore inscrit ?</a>
                </div>
                
            </form>
        </section>
    </main>
    <?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>