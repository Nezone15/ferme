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
	<?php include VUES . 'pages/header_footer/header.php'; ?>
	<main>		
		<section class="banniere">
				<h1>Actualités</h1>
		</section>

		<section>
			<?php if (isset($_SESSION['erreur_actu_introuvable'])): ?>
				<p style="color: red;"><?php echo $_SESSION['erreur_actu_introuvable']; ?></p>
				<?php unset($_SESSION['erreur_actu_introuvable']); ?>
			<?php endif; ?>
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
					<button type="submit">Rechercher</button>
					<a href="actualites">Réinitialiser</a>
				</form>
			</search>
			<p><?= $totalActus ?> Actualité(s) trouvée(s).</p>
			
			<div class="grille-actualites">
				<?php
				if (empty($actualites)) {
					echo '<p>Aucune actualité trouvée.</p>';
				} else {
					foreach ($actualites as $actu) {
						?>
						<div class="actualite">
							<img src="<?= htmlspecialchars($actu['image']) ?>" alt="<?= htmlspecialchars($actu['titre']) ?>">
							<h3><?= htmlspecialchars($actu['titre']) ?></h3>
							<p>Publié le <?= date('d/m/Y', strtotime($actu['date'])) ?></p>
							<p><?= nl2br(htmlspecialchars(substr($actu['contenu'], 0, 200))) ?>...</p>
							<a href="actualite/<?= $actu['id'] ?>">Lire la suite</a>
						</div>
						<?php
					}
				}
				?>
			</div>
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
		</section>
	</main>
	<?php include VUES . 'pages/header_footer/footer.php'; ?>
</body>
</html>
