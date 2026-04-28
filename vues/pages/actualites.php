<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Actualites</title>
	<script defer src="/vues/js/actualites.js"></script>
	<link rel="stylesheet" href="/vues/style/style.css">
	<link rel="stylesheet" href="/vues/style/actualites.css">
</head>
<body>
	<?php include __DIR__ . '/header_footer/header.php'; ?>
	<main>		
		<section class="banniere">
				<h1>Actualités</h1>
		</section>

		<section>
			<div>
				<search>
					<form action="recherche" method="GET">
						<label for="site-search">Rechercher une actualité :</label>
						<input type="search" id="site-search" name="q" placeholder="Ex: pommes de terre...">
						<button type="submit">Rechercher</button>
					</form>
				</search>
			</div>
			<div class="actualites-container">
				<!-- Ici, tu peux utiliser une boucle PHP pour afficher les actualités depuis ta base de données -->
				<!-- Exemple d'actualité -->
				<div class="actualite">
					<h2>Titre de l'actualité</h2>
					<p>Contenu de l'actualité...</p>
					<a href="actualites/1">Lire la suite</a>
					<span class="date">Publié le 01/01/2024</span>
				</div>
				<!-- Répète ce bloc pour chaque actualité -->
			</div>
			<div class="pagination">
				<!-- Pagination à implémenter.
				Le paramètre "page" est déjà utilisé pour le routage principal.
				Utiliser un autre paramètre pour la pagination (ex: p).
				Exemples:
				<a href="actualites?p=1">&larr; Précédent</a>
				<span>Page 2</span>
				<a href="actualites?p=3">Suivant &rarr;</a>
				-->
			</div>
		</section>
	</main>
	<?php include __DIR__ . '/header_footer/footer.php'; ?>
</body>
</html>
