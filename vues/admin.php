<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Espace Administrateur</title>

	<!-- Liens vers les polices -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Tinos:wght@400;700&display=swap" rel="stylesheet">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon_io/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon_io/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon_io/favicon-16x16.png">

	<script defer src="/public/js/admin.js"></script>
	<link rel="stylesheet" href="/public/style/style.css">
	<link rel="stylesheet" href="/public/style/admin.css">
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
	<main>
		<section class="hero admin-hero">
			<h1>Espace Administrateur</h1>
		</section>

		<section class="contenu barre-separation">
			<h2>Créer une actualité</h2>
			 <!-- Afficher le message si l'admin a déjà tenté de créer une actualité -->
			<?php 
			if (isset($creation_actu)) {
				echo $creation_actu;
				unset($creation_actu);
			}?>

			<!-- Formulaire pour créer une actualité.
			 Le enctype permet de dire que ce sera pas juste du texte. Comme ça l'admin peut charger une image -->
			<form class="formulaire-creation" action="admin" method="POST" enctype="multipart/form-data">
				<input type="text" name="titre" placeholder="Titre de l'actualité" required>
				<textarea name="contenu" placeholder="Contenu de l'actualité" required></textarea>
				<div>
					<label for="image" class="btn-primaire">Choisir une image</label>
					<input type="file" id="image" name="image" accept="image/*" required>
					<span id="nom-fichier">Aucun fichier choisi</span>
				</div>
				
				<button class="btn-secondaire" type="submit" name="bCreerActu">Créer</button>
			</form>
		</section>

		<section class="contenu">
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
					<button class="btn-secondaire" type="submit">Rechercher</button>
					<a class="btn-primaire" href="admin">Réinitialiser</a>
				</form>
			</search>
			
			<p><?php echo $totalActus . (($totalActus > 1) ? ' actualités trouvées.' : ' actualité trouvée'); ?></p>
			
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
						<th>Action</th>
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
						<td><a href="/actualite/<?php echo $actu['id']; ?>" target="_blank">Voir l'actualité</a></td>
						<td><?php echo htmlspecialchars($actu['titre']); ?></td>
						<td><?php echo date('d/m/Y', strtotime($actu['date'])); ?></td>
						<td>
							<form method="post">
								<input type="hidden" name="id_actu" value="<?php echo $actu['id']; ?>">
								<button class="btn-primaire" type="submit" name="bSupprimerActu">Supprimer</button>
							</form>
						</td>
					</tr>
			 	<?php endforeach ?>
				</tbody>
			</table>
			
				<!-- Ici, ajouter les liens pour la pagination. -->
				<?php
				if ($paginationMax > 1) {
					echo '<div class="pagination">';
					echo '<span>Pages : ';
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
						echo '<a href="admin' . $parametres . '">' . $i . '</a></span>';
					}
					echo '</div>';
				}				
				?>
					
		</section>
		<aside id="gestion-utilisateurs"><a href="admin/utilisateurs">Gérer les utilisateurs&longrightarrow;</a></aside>
	</main>
	<?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>
