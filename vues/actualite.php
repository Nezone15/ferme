<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ferme Saint Achaire | Actualite</title>
	<meta name="description" content="Découvrez l'une des actualités de la Ferme Saint Achaire.">

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
	<link rel="stylesheet" href="/public/style/style.css">
	<link rel="stylesheet" href="/public/style/actualite.css">
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
	<main>
		<!--Premiere section pour l'actu, la deuxieme pour les commentaires-->
		<section id="actu">
			<img src="/public/images/actus/<?= htmlspecialchars($actu['image']) ?>" alt="<?= htmlspecialchars($actu['titre']) ?>">
		
			<span><?php echo 'Publié le ' . date('d/m/Y', strtotime($actu['date'])); ?></span>
			<!--Si c'est l'admin qui est co, il devrait pouvoir modifier le titre et son contenu
			J'envisage d'utiliser des modales avec un bouton pour les faire pop. A REFLECHIR-->
			<?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['admin'] === 1): ?>
				<?php if (isset($_SESSION['modification_actu'])) {
					echo '<p>' . $_SESSION['modification_actu'] . '</p>';
					unset($_SESSION['modification_actu']);
				}?>
				<form action="/actualite/<?php echo $actu['id']; ?>" method="POST">
					<h1><input type="text" name="titre" value="<?php echo htmlspecialchars($actu['titre']); ?>"></h1>
					<textarea name="contenu"><?php echo htmlspecialchars($actu['contenu']); ?></textarea>
					<button class="btn-secondaire" type="submit" name="bModifierActu">Modifier</button>
				</form>
			<?php else: ?>
				<h1><?php echo htmlspecialchars($actu['titre']); ?></h1>
				<p><?php echo nl2br(htmlspecialchars($actu['contenu'])); ?></p>
			<?php endif; ?>
			</section>

			<!--aside pour les likes-->
			<aside id="likes">				
				
				<form action="/actualite/<?php echo $actu['id']; ?>" method="post">
					<button class="btn-primaire" type="submit" <?php if (!isset($_SESSION['utilisateur'])) echo 'disabled'; ?> name="bLiker">J'aime</button>
				</form>
				<span><?php echo ' : ' . $actu['likes']; ?></span>
			</aside>
		

		<section id="commentaires">
			<h2>Commentaires</h2>
			<!--Afficher le message d'erreur ou réussite si l'utilisateur a déjà tenté de commenter-->
			 <?php if (isset($_SESSION['commentaire'])): ?>
				<p class="message-succes"><?php echo $_SESSION['commentaire']; ?></p>
				<?php unset($_SESSION['commentaire']); ?>
			<?php endif; ?>

			<!-- Si utilisateur connecté, afficher le formulaire de commentaire -->
			 <?php if (isset($_SESSION['utilisateur'])): ?>
			<form class="commentaire formulaire-commentaire" action="/actualite/<?php echo $actu['id']; ?>" method="post">
				<textarea name="commentaire" placeholder="Ajouter un commentaire..." required></textarea>
				<div class="boutons-commentaires">
					<button class="btn-primaire" type="submit" name="bCommenter">Envoyer</button>
					<button class="btn-secondaire" type="reset">Annuler</button>
				</div>
			</form>
			<?php endif; ?>
			
			<div id="boite-commentaires">
			<!-- Ici, utiliser une boucle PHP pour afficher les commentaires depuis la base de données
			 Faudra penser au cas où l'utilisateur n'existe plus. Donc anonymiser le posteur -->
			<?php foreach ($commentaires as $commentaire) {
			    echo '<div class="commentaire">';
				$utilisateur = utilisateurId($commentaire['utilisateur_id']);
					echo '<div class="enteteCommentaire">';
						if ($utilisateur) {
							echo '<p>' . htmlspecialchars($utilisateur['nom']) . ' ' . htmlspecialchars($utilisateur['prenom']) . '</p>';
						} else {
							echo '<p>Utilisateur supprimé</p>';
						}
						echo '<span>' . tempsEcoule($commentaire['date']) . '</span>';
					echo'</div>';
			    echo '<p>' . nl2br(htmlspecialchars($commentaire['message'])) . '</p>';
			    echo '</div>';
			} ?>
			</div>
		</section>
	</main>
	<?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>
