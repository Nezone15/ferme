<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Actualite</title>
	<script src="/vues/js/modaleConnexion.js" defer></script>
	<script defer src="/vues/js/actualite.js"></script>
	<link rel="stylesheet" href="/vues/style/style.css">
	<link rel="stylesheet" href="/vues/style/actualite.css">
</head>
<body>
    <?php include 'header_footer/header.php'; ?>
	<main>
		<section>
			<!-- Faudra récupérer les données de l'actualité depuis la base de données et les afficher ici -->
			<img src="#" alt="Photo de l'actualité">
		</section>
		<section>
			<span class="date">01/01/2024</span>
			<h1>Titre de l'actualité</h1>
			<p>Publié le 01/01/2024 dans la catégorie Politique</p>
			<p>Contenu de l'actualité...</p>
			<hr>
			<div>
				<a href="#">Partager</a>
				<button>J'aime</button>
			</div>
		</section>

		<section>
			<h2>Commentaires</h2>
			<!-- Si utilisateur connecté, afficher le formulaire de commentaire -->
			 <?php if (isset($_SESSION['utilisateur_id'])): ?>
			<form id="form-commentaire">
				<textarea name="commentaire" placeholder="Ajouter un commentaire..." required></textarea>
				<button type="submit">Envoyer</button>
				<button type="reset">Annuler</button>
			</form>
			<?php endif; ?>
				
			<!-- Ici, utiliser une boucle PHP pour afficher les commentaires depuis la base de données -->
			<!-- Exemple de commentaire -->
			<div class="commentaire">
				<span class="auteur">Auteur du commentaire</span>
				<span class="date">01/01/2024</span>
				<p>Contenu du commentaire...</p>
			</div>
		</section>
	</main>
	<?php include 'header_footer/footer.php'; ?>
</body>
</html>
