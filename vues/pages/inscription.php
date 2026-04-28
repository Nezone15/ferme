<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>
</head>
<body>
    <?php include 'header_footer/header.php'; ?>
    <main>
        <h1>Inscription</h1>
        <?php if (isset($erreur_inscription)) {
            echo "<p'>$erreur_inscription</p>";
            unset($erreur_inscription);
        }
        ?>
        <form action="inscription" method="post">
            <label for="email">Email :</label>
            <input type="text" id="email" name="email" maxlength="50" autofocus required>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" maxlength="50" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" maxlength="50" required>

            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" maxlength="72" required>

            <label for="mdpConfirme">Confirmer le mot de passe :</label>
            <input type="password" id="mdpConfirme" name="mdpConfirme" maxlength="72" required>

            <label for="tel">Téléphone(optionnel) :</label>
            <input type="text" id="tel" name="tel" maxlength="20">

            <label for="rue">Rue(optionnel) :</label>
            <input type="text" id="rue" name="rue" maxlength="100">

            <label for="numero">Numéro(optionnel) :</label>
            <input type="text" id="numero" name="numero" maxlength="10">

            <label for="boite">Boîte(optionnel) :</label>
            <input type="text" id="boite" name="boite" maxlength="10">

            <label for="code_postal">Code postal(optionnel) :</label>
            <input type="text" id="code_postal" name="code_postal" maxlength="20">

            <label for="commune">Commune(optionnel) :</label>
            <input type="text" id="commune" name="commune" maxlength="50">

            <label for="pays">Pays(optionnel) :</label>
            <input type="text" id="pays" name="pays" maxlength="50">

            <button type="submit" name="bInscription">S'inscrire</button>
            <button type="reset">Annuler</button>
            <a href="connexion">Déjà inscrit ?</a>
        </form>
    </main>
    <?php include 'header_footer/footer.php'; ?>
</body>
</html>