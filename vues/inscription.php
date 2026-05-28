<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferme Saint Achaire | S'inscrire</title>
    <meta name="description" content="Inscrivez-vous à la Ferme Saint Achaire pour profiter de tous nos services.">
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
<script defer src="/public/js/inscription.js"></script>
    <link rel="stylesheet" href="/public/style/style.css">
    <link rel="stylesheet" href="/public/style/inscription.css">
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
    <main>
        <section class="hero inscription">
            <h1>Inscription</h1>
        </section>
        
        <?php if (isset($erreur_inscription)) {
            echo "<p style='color: red;'>$erreur_inscription</p>";
            unset($erreur_inscription);
        }
        ?>
        <form action="inscription" method="post">
            <label for="email">Email :</label>            
            <span id="email-invalide" class="message-erreur"></span>
            <input type="email" id="email" name="email" maxlength="50" autofocus required>

            <label for="nom">Nom :</label>
            <span id="nom-invalide" class="message-erreur"></span>
            <input type="text" id="nom" name="nom" maxlength="50" pattern=".{2,}" required>

            <label for="prenom">Prénom :</label>
            <span id="prenom-invalide" class="message-erreur"></span>
            <input type="text" id="prenom" name="prenom" maxlength="50" pattern=".{2,}" required>

            <label for="mdp">Mot de passe :</label>
            <span id="mdp-invalide" class="message-erreur"></span>
            <input type="password" id="mdp" name="mdp" maxlength="72" pattern="(?=.*\d)(?=.*[A-Z]).{6,}" required>

            <label for="mdpConfirme">Confirmer le mot de passe :</label>
            <span id="mdpConfirme-invalide" class="message-erreur"></span>
            <input type="password" id="mdpConfirme" name="mdpConfirme" maxlength="72" required>

            <label for="question">Choix de votre question secrète :</label>
            <select id="question" name="question_id" required>
                <option value="">Sélectionnez une question</option>
                <?php foreach ($questions as $q) { ?>
                    <option value="<?= $q['id'] ?>"><?= $q['question'] ?></option>
                <?php } ?>
            </select>

            <label for="reponse">Réponse à votre question secrète :</label>
            <input type="text" id="reponse" name="reponse_secrete" maxlength="100" required>

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

            <button class="btn-primaire" type="submit" name="bInscription">S'inscrire</button>
            <a href="connexion">Déjà inscrit ?</a>
        </form>
    </main>
    <?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>