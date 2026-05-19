<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bois de chauffage</title>
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
    <script defer src="/public/js/bois.js"></script>
    <link rel="stylesheet" href="/public/style/style.css">
    <link rel="stylesheet" href="/public/style/bois.css">
</head>
<body>
    <?php include VUES . 'header_footer/header.php'; ?>
    <main>
        <section class="hero bois">
				<h1>Bois de chauffage</h1>
		</section>

		<section class="contenu">
            <section class="zigzag">
                <article>
                    <h2>Essences, tailles et origine</h2>
                    <p>Le  bois fourni est en provenance des Ardennes. Il arrive à la ferme pour y être fendu et scié en 3 tailles différent pour s’adapter à votre poêle à bois. Les 3 tailles sont 30cm, 40cm ou 50cm.  Le bois est composé d’un mélange de plusieurs essecnces : bouleau, hêtre,  chêne et frêne.</p>
                </article>
                <article>
                    <h2>Commande et tarifs</h2>
                    <p>La ferme Saint Achaire applique un tarif au mètre cube plutôt qu’à la stère. Ce dernier s’élève à 120€/mètre cube.</p>
                    <p>Pour passer commande, appelez le 056/80.75.98. Nous sommes disponible du lundi au vendredi entre 8h00 et 15h30.</p>
                </article>
                <article>
                    <h2>Livraison</h2>
                    <p>La livraison est gratuite tant que la distance est en dessous de 10km.  Passé ce cap, nous appliquons un tarif supplémentaire qui s’élève à 0.50€/km.</p>
                </article>
            </section>
            <aside class="contact">
                <h3>Envie de nous contacter directement ?</h3>
                <a href="contact" class="btn-primaire">Prendre contact</a>
            </aside>
		</section>
    </main>
    <?php include VUES . 'header_footer/footer.php'; ?>    
</body>
</html>