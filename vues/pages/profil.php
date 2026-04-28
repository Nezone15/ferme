<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profil</title>
	<script defer src="/vues/js/profil.js"></script>
	<link rel="stylesheet" href="/vues/style/style.css">
	<link rel="stylesheet" href="/vues/style/profil.css">
</head>
<body>
    <?php include 'header_footer/header.php'; ?>
	<main>
		<section class="banniere">
			<h1>Profil</h1>
		</section>


		<!-- Un form pour permettre à l'utilisateur de modifier ses informations personnelles. En value, il faudra mettre ses données actuelles -->
		<section>
			<h2>Vos informations personnelles</h2>
			<form action="profil" method="post">
				<label for="nom">Nom :</label>
				<input type="text" id="nom" name="nom" value="nom" required>

				<label for="prenom">Prénom :</label>
				<input type="text" id="prenom" name="prenom" value="prénom" required>

				<label for="email">Email :</label>
				<input type="email" id="email" name="email" value="email" required>

				<label for="tel">Téléphone :</label>
				<input type="tel" id="tel" name="tel" value="téléphone" required>

				<label for="adresse">Adresse :</label>
				<input type="text" id="adresse" name="adresse" value="adresse" required>

				<label for="code_postal">Code postal :</label>
				<input type="text" id="code_postal" name="code_postal" value="code_postal" required>

				<label for="commune">Commune :</label>
				<input type="text" id="commune" name="commune" value="commune" required>

				<label for="pays">Pays :</label>
				<input type="text" id="pays" name="pays" value="pays" required>				

				<button type="submit">Enregistrer les modifications</button>
				<button type="reset">Annuler</button>
			</form>
		</section>


		<section>
			<h2>Historique de vos commentaires</h2>
			<!-- Ici, utiliser une boucle PHP pour afficher les commentaires de l'utilisateur depuis la base de données
			 Il faudra mettre pour chacun l'id de l'actualité pour qu'il puisse y accéder. -->

			<!-- Exemple de commentaire -->	
			<div class="commentaire">
				<span class="date">01/01/2024</span>
				<form action="modifier_commentaire" method="post">
					<input type="hidden" name="id_commentaire" value="1">
					<textarea name="commentaire" value="Contenu du commentaire..." required></textarea>
					<button type="submit">Enregistrer les modifications</button>
				</form>
				<form action="supprimer_commentaire" method="post">
					<input type="hidden" name="id_commentaire" value="1">
					<button type="submit">Supprimer</button>
				</form>
				<a href="actualite/1">Lien de l'actualité</a>				
			</div>
		</section>
	</main>
	<?php include 'header_footer/footer.php'; ?>
</body>
</html>
