<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profil</title>
	<meta name="description" content="Modifier vos informations personnelles sur votre profil.">
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
    <link rel="stylesheet" href="/public/style/profil.css">
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
	<main>
		<section class="hero profil-hero">
			<h1>Profil</h1>
		</section>
			
		<!-- Un form pour permettre à l'utilisateur de modifier ses informations personnelles. En value, il y a ses données actuelles qui sont présentes en session-->
		<section class="profil-infos">
			<h2>Vos informations personnelles</h2>
			
			<!-- Ici l'utilisateur a déjà tenté de modifier son profil. On affiche un message selon le résultat. -->
			<?php if (isset($erreur)) : ?>
				<div class="erreur">
					<p class="message-erreur"><?= $erreur ?></p>
				</div>
			<?php unset($erreur); endif; ?>

			<?php if (isset($succes)) : ?>
				<div class="succes">
					<p class="message-succes"><?= $succes ?></p>
				</div>
			<?php unset($succes); endif; ?>

			<form action="profil" method="post">
				<div class="champ">
					<label for="nom">Nom :</label>
					<input type="text" id="nom" name="nom" value="<?= $_SESSION['utilisateur']['nom'] ?>" required>
				</div>

				<div class="champ">
					<label for="prenom">Prénom :</label>
					<input type="text" id="prenom" name="prenom" value="<?= $_SESSION['utilisateur']['prenom'] ?>" required>
				</div>

				<div class="champ">
					<label for="email">Email :</label>
					<input type="email" id="email" name="email" value="<?= $_SESSION['utilisateur']['email'] ?>" required>
				</div>

				<div class="champ">
					<label for="tel">Téléphone(optionnel) :</label>
					<input type="tel" id="tel" name="tel" value="<?= $_SESSION['utilisateur']['tel'] ?>">
				</div>

				<div class="champ">
					<label for="rue">Rue(optionnel) :</label>
					<input type="text" id="rue" name="rue" value="<?= $_SESSION['utilisateur']['rue'] ?>">
				</div>

				<div class="champ">
					<label for="numero">Numéro(optionnel) :</label>
					<input type="text" id="numero" name="numero" value="<?= $_SESSION['utilisateur']['numero'] ?>">

				</div>
				<div class="champ">
					<label for="boite">Boîte(optionnel) :</label>
					<input type="text" id="boite" name="boite" value="<?= $_SESSION['utilisateur']['boite'] ?>">
				</div>

				<div class="champ">
					<label for="code_postal">Code postal(optionnel) :</label>
					<input type="text" id="code_postal" name="code_postal" value="<?= $_SESSION['utilisateur']['code_postal'] ?>">
				</div>

				<div class="champ">
					<label for="commune">Commune(optionnel) :</label>
					<input type="text" id="commune" name="commune" value="<?= $_SESSION['utilisateur']['commune'] ?>">
				</div>

				<div class="champ">
					<label for="pays">Pays(optionnel) :</label>
					<input type="text" id="pays" name="pays" value="<?= $_SESSION['utilisateur']['pays'] ?>">				
				</div>

				<button class="btn-secondaire" type="submit" name="modifier_profil">Enregistrer les modifications</button>
			</form>
		</section>


		<section class="historique">
			<h2>Historique de vos commentaires</h2>
			<!-- Ici, utiliser une boucle PHP pour afficher les commentaires de l'utilisateur depuis la base de données
			 Il faudra mettre pour chacun l'id de l'actualité pour qu'il puisse y accéder. -->
			<?php if (empty($commentaires)) : ?>
				<p>Vous n'avez pas encore de commentaires.</p>
			<?php else : ?>

			<?php if (isset($erreur_suppression)) : ?>
				<p class="message-erreur"><?= $erreur_suppression ?></p>
			<?php unset($erreur_suppression); endif; ?>

			<?php if (isset($succes_suppression)) : ?>
				<p class="message-succes"><?= $succes_suppression ?></p>
			<?php unset($succes_suppression); endif; ?>

				<!-- Boucle pour afficher les commentaires -->
				 <table>
					<thead>
						<tr>
							<th>Date</th>
							<th>Actualité</th>
							<th>Commentaire</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($commentaires as $commentaire) : ?>
							<tr>
								<td><?=  date('d/m/Y H:i', strtotime($commentaire['date'])) ?></td>
								<td><a href="/actualite/<?= $commentaire['actualite_id'] ?>">Voir l'actualité</a></td>
								<td><?= nl2br(htmlspecialchars($commentaire['message'])) ?></td>
								<td>
									<form action="/profil" method="post">
										<input type="hidden" name="id_commentaire" value="<?= $commentaire['id'] ?>">
										<button class="btn-primaire" type="submit" name="supprimer_commentaire">Supprimer</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</section>
	</main>
	<?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>
