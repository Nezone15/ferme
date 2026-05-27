<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
	<!-- Liens vers les polices -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Tinos:wght@400;700&display=swap" rel="stylesheet">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon_io/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon_io/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon_io/favicon-16x16.png">

	<script defer src="/public/js/script.js"></script>
	<link rel="stylesheet" href="/public/style/style.css">
	<link rel="stylesheet" href="/public/style/admin.css">
	<link rel="stylesheet" href="/public/style/admin_utilisateurs.css">
	
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
    <main>
        <section class="hero admin-hero">
            <h1>Gestion des utilisateurs</h1>
        </section>
		<!-- La section ci-dessous est pour avoir tous les utilisateurs. Faut faire une autre section dans le cas où on a déjà choisi un utilisateur
		 Avec cette façon de faire on changera la section affichée en fonction de si on a choisi un utilisateur ou pas-->
		 

        <?php if (!isset($_GET['utilisateur_id'])): ?>
            <section class="contenu">
			<h2>Gérer les utilisateurs</h2>

			<!-- Message de suppression d'utilisateur -->
		<?php if (isset($_SESSION['utilisateur_suppression'])): ?>
			<?= $_SESSION['utilisateur_suppression'] ?>
			<?php unset($_SESSION['utilisateur_suppression']); ?>
		<?php endif; ?>

		<!-- Message dans le cas où l'admin essaie de consulter un utilisateur inexistant -->
		<?php if (isset($_SESSION['utilisateur_inexistant'])): ?>
			<?= $_SESSION['utilisateur_inexistant'] ?>
			<?php unset($_SESSION['utilisateur_inexistant']); ?>
		<?php endif; ?>

			<search>
				<form action="/admin/utilisateurs" method="get">
					<?php (isset($_GET['recherche'])) ? $valeur_recherche = trim(htmlspecialchars($_GET['recherche'])) : $valeur_recherche = ''; ?>
					<input type="text" name="recherche" placeholder="Rechercher un utilisateur..." value="<?= $valeur_recherche ?>">
					<select name="triUtilisateur">
						<option value="nom" <?= ($triUtilisateur === 'nom') ? 'selected' : '' ?>>Nom</option>
						<option value="prenom" <?= ($triUtilisateur === 'prenom') ? 'selected' : '' ?>>Prénom</option>
						<option value="date_creation" <?= ($triUtilisateur === 'date_creation') ? 'selected' : '' ?>>Ancienneté</option>
						<option value="derniere_activite" <?= ($triUtilisateur === 'derniere_activite') ? 'selected' : '' ?>>Dernière activité</option>
						<option value="nb_commentaires" <?= ($triUtilisateur === 'nb_commentaires') ? 'selected' : '' ?>>Nombre de commentaires</option>
					</select>
					<select name="ordreUtilisateur">
						<option value="ASC" <?= ($ordreUtilisateur === 'ASC') ? 'selected' : '' ?>>Ordre croissant</option>
						<option value="DESC" <?= ($ordreUtilisateur === 'DESC') ? 'selected' : '' ?>>Ordre décroissant</option>
					</select>
					<button class="btn-secondaire" type="submit">Rechercher</button>
					<a class="btn-primaire" href="/admin/utilisateurs">Réinitialiser</a>
				</form>
			</search>

			<p class="nombre-trouve"> <?= $totalUtilisateurs ?> <?= ($totalUtilisateurs > 1) ? 'utilisateurs' : 'utilisateur' ?> <?= ($totalUtilisateurs > 1) ? 'trouvés' : 'trouvé' ?>.</p>
			
			<table>
				<thead>
					<!--Faudra surement changer les ↑ avec css pour que ce soit plus joli-->
                    <tr>
                        <th>Lien</th>
                        <th><a href="<?= genererUrlTriUtilisateur('nom', $prochainOrdreUtilisateur, $recherche) ?>">
							Nom<?= ($triUtilisateur === 'nom') ? ($ordreUtilisateur === 'ASC' ? '↑' : '↓') : '' ?></a></th>
                        <th><a href="<?= genererUrlTriUtilisateur('prenom', $prochainOrdreUtilisateur, $recherche) ?>">
							Prénom<?= ($triUtilisateur === 'prenom') ? ($ordreUtilisateur === 'ASC' ? '↑' : '↓') : '' ?></a></th>
						<th><a href="<?= genererUrlTriUtilisateur('date_creation', $prochainOrdreUtilisateur, $recherche) ?>">
							Membre depuis<?= ($triUtilisateur === 'date_creation') ? ($ordreUtilisateur === 'ASC' ? '↑' : '↓') : '' ?></a></th>
						<th><a href="<?= genererUrlTriUtilisateur('derniere_activite', $prochainOrdreUtilisateur, $recherche) ?>">
							Dernière activité<?= ($triUtilisateur === 'derniere_activite') ? ($ordreUtilisateur === 'ASC' ? '↑' : '↓') : '' ?></a></th>
                        <th><a href="<?= genererUrlTriUtilisateur('nb_commentaires', $prochainOrdreUtilisateur, $recherche) ?>">
							Nombre de commentaires<?= ($triUtilisateur === 'nb_commentaires') ? ($ordreUtilisateur === 'ASC' ? '↑' : '↓') : '' ?></a></th>
						<th>Supprimer l'utilisateur</th>
                    </tr>
					
				</thead>
				<tbody>
				<!-- Ici, utiliser une boucle PHP pour afficher les utilisateurs depuis la base de données s'il y en a.
				 A FAIRE On va en afficher 10 à la fois. Donc faut mettre en place une pagination.
				 Il faut aussi ajouter des fonctions dans le crud alors pour gérer la pagination en utilisant OFFSET -->
				<?php if (empty($utilisateurs)): ?>
					<tr>
						<td colspan="7">Aucun utilisateur trouvé.</td>
					</tr>
				<?php else: ?>
			 	<?php foreach ($utilisateurs as $utilisateur): ?>
					<tr>
						<?php if ($utilisateur['id'] === null): ?>
							<td><a href="/admin/utilisateurs/anonyme" target="_blank">Voir les commentaires anonymes</a></td>
						<?php else: ?>
							<td><a href="/admin/utilisateurs/<?php echo $utilisateur['id']; ?>" target="_blank">Voir l'utilisateur</a></td>
						<?php endif; ?>
						<td><?php echo trim(htmlspecialchars($utilisateur['nom'])); ?></td>
						<td><?php echo trim(htmlspecialchars($utilisateur['prenom'])); ?></td>
						<td><?php echo trim(htmlspecialchars($utilisateur['date_creation'])); ?></td>
						<td><?php echo trim(htmlspecialchars($utilisateur['derniere_activite'])); ?></td>
                        <td><?php echo trim(htmlspecialchars($utilisateur['nb_commentaires'])); ?></td>
						<td>
							<form action="/admin/utilisateurs" method="post">
								<input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id']; ?>">
								<button class="btn-primaire" type="submit" name="bSupprimerUtilisateur">Supprimer</button>
							</form>
						</td>
					</tr>
			 	<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>

			<!-- Pagination -->
			 <?php
				if ($paginationMax > 1) {
					echo '<div class="pagination">';
					echo '<span>Pages : ';
						for ($i = 1; $i <= $paginationMax; $i++) {
							?><a href="<?= genererUrlTriUtilisateur($triUtilisateur, $ordreUtilisateur, $recherche, $i) ?>"><?= $i ?></a></span>';<?php
						 }
					 echo '</div>';
				}
			?>	

        </section>
		<?php endif; ?>

		<!-- Section pour gérer un utilisateur en particulier. On affiche cette section que si on a un utilisateur dans le get-->
		<?php if (isset($_GET['utilisateur_id'])): ?>
		<section class="contenu">
			<?php if ($utilisateur === null): ?>
				<h2>Gérer les commentaires anonymes</h2>
			<?php else: ?>
				<h2>Gérer l'utilisateur : <?= htmlspecialchars($utilisateur['nom'] . ' ' . $utilisateur['prenom']) ?></h2>
				<p>ID : <?= htmlspecialchars($utilisateur['id']) ?></p>
				<p>Nom : <?= htmlspecialchars($utilisateur['nom']) ?></p>
				<p>Prénom : <?= htmlspecialchars($utilisateur['prenom']) ?></p>
				<p>Email : <?= htmlspecialchars($utilisateur['email']) ?></p>
				<p>Membre depuis : <?= htmlspecialchars($utilisateur['date_creation']) ?></p>
				<p>Dernière connexion : <?= htmlspecialchars($utilisateur['derniere_activite']) ?></p>
				<form action="/admin/utilisateurs" method="post">
					<input type="hidden" name="utilisateur_id" value="<?= $_GET['utilisateur_id'] ?>">
					<button id="supprimer-utilisateur" class="btn-primaire" type="submit" name="bSupprimerUtilisateur">Supprimer l'utilisateur</button>
			</form>
			<?php endif; ?>
			
			<h2>Commentaires de l'utilisateur</h2>

			<!-- Message de suppression de commentaire -->
			<?php if (isset($commentaire_suppression)): ?>
				<p><?= $commentaire_suppression ?></p>
				<?php unset($commentaire_suppression); ?>
			<?php endif; ?>
			
			<p class="nombre-trouve">Nombre de commentaires : <?= $nbCommentaires ?></p>
			
				<!-- On va permettre de trier par date de publication du commentaire et par le titre de l'actualité -->
				 <search>
				 <form action="/admin/utilisateurs" method="post">
					<select name="triCommentaire">
							<option <?= ($triCommentaire === 'date') ? 'selected' : '' ?> value="date">Trier par date</option>
							<option <?= ($triCommentaire === 'titre') ? 'selected' : '' ?> value="titre">Trier par titre de l'actualité</option>
						</select>
					<select name="ordreCommentaire">
						<option <?= ($ordreCommentaire === 'DESC') ? 'selected' : '' ?> value="DESC">Ordre décroissant</option>
						<option <?= ($ordreCommentaire === 'ASC') ? 'selected' : '' ?> value="ASC">Ordre croissant</option>
					</select>
					<button class="btn-secondaire" type="submit" name="bTrierCommentaires">Appliquer le tri</button>
				</form>
			</search>

				<table>
					<thead>
						<tr>
							<th><a href="<?= genererUrlTriCommentaire($_GET['utilisateur_id'], 'date', $prochainOrdreCommentaire) ?>">
								Date de publication<?= ($triCommentaire === 'date') ? ($ordreCommentaire === 'ASC' ? '↑' : '↓') : '' ?></a></th>
							<th><a href="<?= genererUrlTriCommentaire($_GET['utilisateur_id'], 'titre', $prochainOrdreCommentaire) ?>">
								Actualité associée<?= ($triCommentaire === 'titre') ? ($ordreCommentaire === 'ASC' ? '↑' : '↓') : '' ?></a></th>
							<th>Commentaire</th>
							<th>Supprimer le commentaire</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($commentaires as $commentaire): ?>
							<tr>						
								<td><?= htmlspecialchars($commentaire['date']) ?></td>
								<td><a href="/actualite/<?= $commentaire['actualite_id'] ?>" target="_blank"><?= htmlspecialchars($commentaire['titre']) ?></a></td>
								<td><?= htmlspecialchars($commentaire['message']) ?></td>
								<td>
									<form action="/admin/utilisateurs/<?= $_GET['utilisateur_id'] ?>" method="post">
										<input type="hidden" name="commentaire_id" value="<?= $commentaire['id'] ?>">
										<button class="btn-primaire" type="submit" name="bSupprimerCommentaire">Supprimer</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</section>

		<?php endif; ?>
        <aside class="lien-redirection-admin">
			<a href="/admin/utilisateurs">Revenir à la liste des utilisateurs&longrightarrow;</a>
            <a href="/admin">Revenir à la gestion des actualités&longrightarrow;</a>
        </aside>
    </main>
    <?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>