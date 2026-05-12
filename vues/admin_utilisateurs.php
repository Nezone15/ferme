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
				<?php endif ?>
			 	<?php foreach ($utilisateurs as $utilisateur): ?>
					<tr>
						<td><a href="/admin/utilisateur?id=<?php echo $utilisateur['id']; ?>" target="_blank">Voir l'utilisateur</a></td>
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
			 	<?php endforeach ?>
				</tbody>
			</table>
        </section>

        <section>
            <a href="/admin">Revenir à la gestion des actualités</a>
        </section>
    </main>
    <?php include VUES . 'header_footer/footer.php'; ?>
</body>
</html>