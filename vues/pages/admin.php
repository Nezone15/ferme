<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Espace Administrateur</title>
	<script defer src="/vues/js/admin.js"></script>
	<link rel="stylesheet" href="/vues/style/style.css">
	<link rel="stylesheet" href="/vues/style/admin.css">
</head>
<body>
    <?php include VUES . 'pages/header_footer/header.php'; ?>
	<main>
		<section class="banniere">
			<h1>Espace Administrateur</h1>
		</section>

		<section>
			<h2>Créer une actualité</h2>
			 <!-- Afficher le message si l'admin a déjà tenté de créer une actualité -->
			<?php 
			if (isset($creation_actu)) {
				echo $creation_actu;
				unset($creation_actu);
			}?>

			<!-- Formulaire pour créer une actualité.
			 Le enctype permet de dire que ce sera pas juste du texte. Comme ça l'admin peut charger une image -->
			<form action="admin" method="POST" enctype="multipart/form-data">
				<input type="text" name="titre" placeholder="Titre de l'actualité" required>
				<textarea name="contenu" placeholder="Contenu de l'actualité" required></textarea>
				<input type="file" name="image" accept="image/*" required>
				<button type="submit" name="bCreerActu">Créer</button>
			</form>
		</section>

		<section>
			<h2>Gérer les actualités</h2>
			<search>
				<input type="text" placeholder="Rechercher une actualité...">
				<button type="submit">Rechercher</button>
			</search>
			<!-- Ici, utiliser une boucle PHP pour afficher les actualités depuis la base de données -->
			<!-- Exemple d'actualité -->
			<div class="actualite">
				<span class="date">01/01/2024</span>
				<h3>Titre de l'actualité</h3>
				<p>Publié le 01/01/2024 dans la catégorie Politique</p>
				<p>Contenu de l'actualité...</p>
				<div>
					<a href="#">Modifier</a>
					<a href="#">Supprimer</a>
				</div>
			</div>
		</section>

		<section>
			<h2>Gérer les utilisateurs</h2>
			<search>
				<input type="text" placeholder="Rechercher un utilisateur...">
				<button type="submit">Rechercher</button>
			</search>
			<!-- Ici, utiliser une boucle PHP pour afficher les utilisateurs depuis la base de données -->
			<!-- Exemple d'utilisateur -->
			<div class="utilisateur">
				<span class="date">Inscrit le 01/01/2024</span>
				<h3>Nom de l'utilisateur</h3>
				<p>Email : utilisateur@example.com</p>
			</div>
		</section>
	</main>
	<?php include VUES . 'pages/header_footer/footer.php'; ?>
</body>
</html>
