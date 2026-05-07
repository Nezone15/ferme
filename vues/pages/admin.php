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
				<form action="admin" method="get">
					<?php (isset($_GET['recherche'])) ? $valeur_recherche = trim(htmlspecialchars($_GET['recherche'])) : $valeur_recherche = ''; ?>
					<input type="text" name="recherche" placeholder="Rechercher une actualité..." value="<?= $valeur_recherche ?>">
					<select name="tri">
						<option <?= ($tri === 'date') ? 'selected' : '' ?> value="date">Trier par date</option>
						<option <?= ($tri === 'titre') ? 'selected' : '' ?> value="titre">Trier par titre</option>
					</select>
					<select name="ordre">
						<option <?= ($ordre === 'DESC') ? 'selected' : '' ?> value="DESC">Ordre décroissant</option>
						<option <?= ($ordre === 'ASC') ? 'selected' : '' ?> value="ASC">Ordre croissant</option>
					</select>
					<button type="submit">Rechercher</button>
					<a href="admin">Réinitialiser</a>
				</form>
			</search>
			
			<h3>Liste des actualités</h3>
			<p><?= $totalActus ?> actualité(s) trouvée(s).</p>
			<table>
				<thead>
					<!-- Rendre titre et date cliquable pour trier par titre ou date.
					 Ma fonction me génère l'URL de tri.
					 Faudra surement changer les ↑ avec css pour que ce soit plus joli-->
					<tr>
						<th>Lien vers l'actualité</th>
						<th>
							<a href="<?= genererUrlTri('titre', $prochainOrdre, $recherche) ?>">
                			Titre <?= ($tri === 'titre') ? ($ordre === 'ASC' ? '↑' : '↓') : '' ?></a>
						</th>
						<th>
							<a href="<?= genererUrlTri('date', $prochainOrdre, $recherche) ?>">
								Date de publication <?= ($tri === 'date') ? ($ordre === 'ASC' ? '↑' : '↓') : '' ?>
							</a>
						</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<!-- Ici, utiliser une boucle PHP pour afficher les actualités depuis la base de données s'il y en a.
				 On va en afficher 10 à la fois. Donc faut mettre en place une pagination.
				 Il faut aussi ajouter des fonctions dans le crud alors pour gérer la pagination en utilisant OFFSET -->
					 <?php if (empty($actualites)): ?>
					<tr>
						<td colspan="4">Aucune actualité trouvée.</td>
					</tr>
				<?php endif ?>
			 	<?php foreach ($actualites as $actu): ?>
					<tr>
						<td><a href="actu?id=<?php echo $actu['id']; ?>" target="_blank">Voir l'actualité</a></td>
						<td><?php echo $actu['titre']; ?></td>
						<td><?php echo $actu['date']; ?></td>
						<td>
							<form action="actualite/?id=<?php echo $actu['id']; ?>" method="post">
								<button type="submit" name="bModifierActu">Modifier</button>
							</form>
							<form method="post">
								<input type="hidden" name="id_actu" value="<?php echo $actu['id']; ?>">
								<button type="submit" name="bSupprimerActu">Supprimer</button>
							</form>
						</td>
					</tr>
			 	<?php endforeach ?>
				</tbody>
			</table>
			<div>
				<!-- Ici, ajouter les liens pour la pagination. -->
				<?php
				for ($i = 1; $i <= $paginationMax; $i++) {
					$parametres = "?pagination=$i";
					if (isset($_GET['tri'])) {
						$parametres .= "&tri=" . urlencode($_GET['tri']);
					}
					if (isset($_GET['ordre'])) {
						$parametres .= "&ordre=" . urlencode($_GET['ordre']);
					}
					if (isset($_GET['recherche'])) {
						$parametres .= "&recherche=" . urlencode($_GET['recherche']);
					}
					echo '<a href="admin' . $parametres . '">' . $i . '</a> ';
				}
				?>
			</div>
			
		</section>

		<section>
			<h2>Gérer les utilisateurs</h2>
			<search>
				<form action="admin" method="post">
					<input type="text" name="recherche_utilisateur" placeholder="Rechercher un utilisateur...">
					<button type="submit" name="bRechercherUtilisateur">Rechercher</button>
				</form>
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
