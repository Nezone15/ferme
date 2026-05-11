<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Actualite</title>
	<script defer src="/vues/js/actualite.js"></script>
	<link rel="stylesheet" href="/vues/style/style.css">
	<link rel="stylesheet" href="/vues/style/actualite.css">
</head>
<body>
    <?php include VUES . 'pages/header_footer/header.php'; ?>
	<main>
		<section>
			<!-- Faudra récupérer les données de l'actualité depuis la base de données et les afficher ici -->
			<img src="#" alt="Photo de l'actualité">
		</section>
		<section>
			<span><?php echo $actu['date']; ?></span>
			<!--Si c'est l'admin qui est co, il devrait pouvoir modifier le titre et son contenu-->
			<?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['admin'] === 1): ?>
				<form action="/actualite/<?php echo $actu['id']; ?>" method="POST">
					<h1><input type="text" name="titre" value="<?php echo $actu['titre']; ?>"></h1>
					<textarea name="contenu"><?php echo $actu['contenu']; ?></textarea>
					<button type="submit" name="bModifierActu">Modifier</button>
				</form>
			<?php else: ?>
				<h1><?php echo $actu['titre']; ?></h1>
				<p><?php echo $actu['contenu']; ?></p>
			<?php endif; ?>
			<hr>
			<div>
				<form action="/actualite/<?php echo $actu['id']; ?>" method="post">
					<button type="submit" name="bLiker">J'aime</button>
				</form>
			</div>
		</section>

		<section>
			<h2>Commentaires</h2>
			<!-- Si utilisateur connecté, afficher le formulaire de commentaire -->
			 <?php if (isset($_SESSION['utilisateur'])): ?>
			<form action="/actualite/<?php echo $actu['id']; ?>" method="post">
				<textarea name="commentaire" placeholder="Ajouter un commentaire..." required></textarea>
				<button type="submit" name="bCommenter">Envoyer</button>
				<button type="reset">Annuler</button>
			</form>
			<?php endif; ?>
				
			<!-- Ici, utiliser une boucle PHP pour afficher les commentaires depuis la base de données
			 Faudra penser au cas où l'utilisateur n'existe plus. Donc anonymiser le posteur -->
			<?php foreach ($commentaires as $commentaire) {
			    echo '<div>';
				$utilisateur = utilisateurId($commentaire['utilisateur_id']);
				if ($utilisateur) {
			    	echo '<span>' . htmlspecialchars(utilisateurId($commentaire['utilisateur_id'])['nom']) . ' ' . htmlspecialchars(utilisateurId($commentaire['utilisateur_id'])['prenom']) . '</span>';
				} else {
					echo '<span>Utilisateur supprimé</span>';
				}
				echo '<span>' . htmlspecialchars($commentaire['date']) . '</span>';
			    echo '<p>' . nl2br(htmlspecialchars($commentaire['message'])) . '</p>';
			    echo '</div>';
			} ?>
		</section>
	</main>
	<?php include VUES . 'pages/header_footer/footer.php'; ?>
</body>
</html>
