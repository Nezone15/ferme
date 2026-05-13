<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
    <main>
        <section>
            <h1>Gestion des utilisateurs</h1>
        </section>
		
		<!-- La section ci-dessous est pour avoir tous les utilisateurs. Faut faire une autre section dans le cas où on a déjà choisi un utilisateur
		 Avec cette façon de faire on changera la section affichée en fonction de si on a choisi un utilisateur ou pas-->

		 <!-- Message de suppression d'utilisateur -->
		<?php if (isset($_SESSION['utilisateur_suppression'])): ?>
			<p><?= $_SESSION['utilisateur_suppression'] ?></p>
			<?php unset($_SESSION['utilisateur_suppression']); ?>
		<?php endif; ?>

		<!-- Message dans le cas où l'admin essaie de consulter un utilisateur inexistant -->
		<?php if (isset($_SESSION['utilisateur_inexistant'])): ?>
			<p><?= $_SESSION['utilisateur_inexistant'] ?></p>
			<?php unset($_SESSION['utilisateur_inexistant']); ?>
		<?php endif; ?>

        <?php if (!isset($_GET['utilisateur_id'])): ?>
		 <section>
            <section>
			<h2>Gérer les utilisateurs</h2>

			<search>
				<form action="admin_utilisateurs" method="get">
					<?php (isset($_GET['recherche'])) ? $valeur_recherche = trim(htmlspecialchars($_GET['recherche'])) : $valeur_recherche = ''; ?>
					<input type="text" name="recherche" placeholder="Rechercher un utilisateur..." value="<?= $valeur_recherche ?>">
					<button type="submit">Rechercher</button>
					<a href="admin_utilisateurs">Réinitialiser</a>
				</form>
			</search>
			
			<h3>Liste des utilisateurs</h3>
			<p><?= $totalUtilisateurs ?> utilisateur(s) trouvée(s).</p>
			<table>
				<thead>
					<!--A FAIRE PLUS TARD Rendre nom et prénom cliquable pour trier par nom ou prénom. 
					Faudra surement changer les ↑ avec css pour que ce soit plus joli-->
                    <tr>
                        <th>Lien</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Nombre de commentaires</th>
                    </tr>
					
				</thead>
				<tbody>
				<!-- Ici, utiliser une boucle PHP pour afficher les utilisateurs depuis la base de données s'il y en a.
				 On va en afficher 10 à la fois. Donc faut mettre en place une pagination.
				 Il faut aussi ajouter des fonctions dans le crud alors pour gérer la pagination en utilisant OFFSET -->
				<?php if (empty($utilisateurs)): ?>
					<tr>
						<td colspan="4">Aucun utilisateur trouvé.</td>
					</tr>
				<?php else: ?>
			 	<?php foreach ($utilisateurs as $utilisateur): ?>
					<tr>
						<td><a href="/admin/utilisateurs/<?php echo $utilisateur['id']; ?>" target="_blank">Voir l'utilisateur</a></td>
						<td><?php echo $utilisateur['nom']; ?></td>
						<td><?php echo $utilisateur['prenom']; ?></td>
                        <!--On pourrait se dire aie l'utilisateur existe peut etre pas mais en fait on vient de le récupérer de la base de données.
                        Par contre ATTENTION qu'en est-il des utilisateurs anonymes càd ces commentaires dont l'utilisateur n'existe plus.
                        Problème également si sql plante il va se passer quoi ? Je dois mettre un try catch dans ma vue, bizarre
                        SOLUTION POTENTIEL : assigner avant dans le controleur qui s'occupera des éventuels erreurs. A REFLECHIR
                        -->
                        <td><?php echo nombreCommentairesUtilisateur($utilisateur['id']); ?></td>
						<td>
							<form method="post">
								<input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id']; ?>">
								<button type="submit" name="bSupprimerUtilisateur">Supprimer</button>
							</form>
						</td>
					</tr>
			 	<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
        </section>
		<?php endif; ?>

		<!-- Section pour gérer un utilisateur en particulier. On affiche cette section que si on a un utilisateur dans le get-->
		<?php if (isset($_GET['utilisateur_id'])): ?>
		<section>
			<?php if ($utilisateur === null): ?>
				<h2>Gérer les commentaires anonymes</h2>
			<?php else: ?>
				<h2>Gérer l'utilisateur : <?= htmlspecialchars($utilisateur['nom'] . ' ' . $utilisateur['prenom']) ?></h2>
				<p>ID : <?= htmlspecialchars($utilisateur['id']) ?></p>
				<p>Email : <?= htmlspecialchars($utilisateur['email']) ?></p>
				<p>Membre depuis : <?= htmlspecialchars($utilisateur['date_creation']) ?></p>
				<p>Dernière connexion : <?= htmlspecialchars($utilisateur['derniere_activite']) ?></p>
			<?php endif; ?>
			<p>Nombre de commentaires : <?= $nbCommentaires ?></p>
			<h4>Commentaires de l'utilisateur</h4>

			<!-- Message de suppression de commentaire -->
			<?php if (isset($commentaire_suppression)): ?>
				<p><?= $commentaire_suppression ?></p>
				<?php unset($commentaire_suppression); ?>
			<?php endif; ?>
			
			<?php if (empty($commentaires)): ?>
				<p>Aucun commentaire trouvé pour cet utilisateur.</p>
			<?php else: ?>
				<table>
					<thead>
						<tr>
							<th>Date de publication</th>
							<th>Actualité associée</th>						
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
										<button type="submit" name="bSupprimerCommentaire">Supprimer</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
			
			<form action="/admin/utilisateurs/<?= $_GET['utilisateur_id'] ?>" method="post">
					<button type="submit" name="bSupprimerUtilisateur">Supprimer l'utilisateur</button>
			</form>
			<a href="/admin/utilisateurs">Revenir à la liste des utilisateurs</a>
		</section>
		<?php endif; ?>
        <section>
            <a href="/admin">Revenir à la gestion des actualités</a>
        </section>
    </main>
    <?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>