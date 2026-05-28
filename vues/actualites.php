<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ferme Saint Achaire | Actualités</title>
	<meta name="description" content="Découvrez les actualités de la ferme Saint Achaire, une maison de vie communautaire engagée dans l'insertion sociale.">


	<!-- Liens vers les polices -->
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
	<link rel="stylesheet" href="/public/style/actualites.css">
</head>
<body>
	<?php include VUES . 'header_footer/header.php'; ?>
	<main>		
		<section class="hero actualites">
				<h1>Actualités</h1>
		</section>

		<section class="page-actualites">
			<search>
				<form action="actualites" method="get">
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
					<a class="btn-primaire" href="actualites">Réinitialiser</a>
				</form>
			</search>
			
			<div class="grille-actualites">
				<?php
				if (empty($actualites)) {
					echo '<p>Aucune actualité trouvée.</p>';
				} else {
					foreach ($actualites as $actu) {
						?>
						<article class="actualite">
							<img src="/public/images/actus/<?= htmlspecialchars($actu['image']) ?>" alt="<?= htmlspecialchars($actu['titre']) ?>">
							<div class="contenu-actu">
								<h2><?= htmlspecialchars($actu['titre']) ?></h2>
								<span>Publié le <?= date('d/m/Y', strtotime($actu['date'])) ?></span>
								<p><?= nl2br(htmlspecialchars(substr($actu['contenu'], 0, 50))) ?>...</p>
							</div>
							<a href="actualite/<?= $actu['id'] ?>">Lire la suite &longrightarrow;</a>
						</article>
						<?php
					}
				}
				?>
			</div>

			 <?php if ($paginationMax > 1): ?>
			<div class="pagination">
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
					echo '<a href="actualites' . $parametres . '">' . $i . '</a> ';
				}
				?>
			</div>
			 <?php endif; ?>
		</section>
	</main>
	<?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>
