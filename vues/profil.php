<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profil</title>
	<script defer src="<?=PUBLIC_PATH ?>/js/profil.js"></script>
	<link rel="stylesheet" href="<?=PUBLIC_PATH ?>/css/style.css">
	<link rel="stylesheet" href="<?=PUBLIC_PATH ?>/css/profil.css">
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
	<main>
		<section class="banniere">
			<h1>Profil</h1>
		</section>
			
		<!-- Un form pour permettre à l'utilisateur de modifier ses informations personnelles. En value, il y a ses données actuelles qui sont présentes en session-->
		<section>
			<h2>Vos informations personnelles</h2>
			
			<!-- Ici l'utilisateur a déjà tenté de modifier son profil. On affiche un message selon le résultat. -->
			<?php if (isset($erreur)) : ?>
				<div class="erreur">
					<p style="color: red;"><?= $erreur ?></p>
				</div>
			<?php unset($erreur); endif; ?>
			<?php if (isset($succes)) : ?>
				<div class="succes">
					<p style="color: green;"><?= $succes ?></p>
				</div>
			<?php unset($succes); endif; ?>

			<form action="profil" method="post">
				<label for="nom">Nom :</label>
				<input type="text" id="nom" name="nom" value="<?= $_SESSION['utilisateur']['nom'] ?>" required>

				<label for="prenom">Prénom :</label>
				<input type="text" id="prenom" name="prenom" value="<?= $_SESSION['utilisateur']['prenom'] ?>" required>

				<label for="email">Email :</label>
				<input type="email" id="email" name="email" value="<?= $_SESSION['utilisateur']['email'] ?>" required>

				<label for="tel">Téléphone(optionnel) :</label>
				<input type="tel" id="tel" name="tel" value="<?= $_SESSION['utilisateur']['tel'] ?>">

				<label for="rue">Rue(optionnel) :</label>
				<input type="text" id="rue" name="rue" value="<?= $_SESSION['utilisateur']['rue'] ?>">

				<label for="numero">Numéro(optionnel) :</label>
				<input type="text" id="numero" name="numero" value="<?= $_SESSION['utilisateur']['numero'] ?>">

				<label for="boite">Boîte(optionnel) :</label>
				<input type="text" id="boite" name="boite" value="<?= $_SESSION['utilisateur']['boite'] ?>">

				<label for="code_postal">Code postal(optionnel) :</label>
				<input type="text" id="code_postal" name="code_postal" value="<?= $_SESSION['utilisateur']['code_postal'] ?>">

				<label for="commune">Commune(optionnel) :</label>
				<input type="text" id="commune" name="commune" value="<?= $_SESSION['utilisateur']['commune'] ?>">

				<label for="pays">Pays(optionnel) :</label>
				<input type="text" id="pays" name="pays" value="<?= $_SESSION['utilisateur']['pays'] ?>">				

				<button type="submit" name="modifier_profil">Enregistrer les modifications</button>
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
	<?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>
