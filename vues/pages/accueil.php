<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <script defer src="/vues/js/accueil.js"></script>
    <link rel="stylesheet" href="/vues/style/style.css">
    <link rel="stylesheet" href="/vues/style/accueil.css">
</head>
<body>
    <?php include VUES . 'pages/header_footer/header.php'; ?>
    <main>
        <!--Section carousel -->
        <section class="carousel">
            <div class="carousel-container">
                <!-- Flèche gauche -->
                <button aria-label="Image précédente">
                    &#10094;
                </button>

                <!-- Slides -->
                <div class="carousel-slides">
                    <!-- Slide 1 -->
                    <div class="carousel-slide">
                        <img src="#" alt="Photo de la ferme Saint Achaire">
                        <div class="carousel-content">
                            <h2>Maison de vie communautaire</h2>
                            <p>La ferme Saint Achaire est avant tout une maison de vie communautaire qui offre une solution d'accueil aux personnes en difficulté.</p>
                            <a href="maison">Découvrir le projet</a>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-slide">
                        <img src="#" alt="Photo de l'activité de bois de chauffage">
                        <div class="carousel-content">
                            <h2>Bois de chauffage</h2>
                            <p>La ferme Saint Achaire a une activité de production de bois de chauffage pour fournir une occupation à sa communauté.</p>
                            <a href="bois">Découvrir l'activité</a>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-slide">
                        <img src="#" alt="Photo de Terre Nouvelle">
                        <div class="carousel-content">
                            <h2>Terre Nouvelle</h2>
                            <p>Terre Nouvelle est une maison d'accueil d'urgence qui est liée à la ferme Saint Achaire.</p>
                            <a href="tn">En savoir plus</a>
                        </div>
                    </div>
                </div>

                <!-- Flèche droite -->
                <button aria-label="Image suivante">
                    &#10095;
                </button>
            </div>

            <!-- Indicateur de position -->
            <div class="carousel-counter">
                <span id="current-slide">1/3</span>
            </div>
        </section>
        <!-- Section présentation -->
        <section class="presentation">
            <h1>Bienvenue à la ferme Saint Achaire</h1>
            <p>L'engagement social est au cœur de notre mission. Nous agissons
            quotidiennement pour soutenir ceux qui en ont le plus besoin à travers trois
            projets sociaux.</p>
            <div class="projets">
                <div class="projet">
                    <h3>Maison de vie communautaire</h3>
                    <p>Un espace bienveillant pour poser ses bagages
                    et retrouver le calme nécessaire à une
                    reconstruction personnelle durable au sein de
                    notre communauté.</p>
                    <a href="maison">En savoir plus</a>
                </div>

                <div class="projet">
                    <h3>Bois de chauffage</h3>
                    <p>Une activité d'insertion professionnelle par la
                    production et la livraison de bois de chauffage.</p>
                    <a href="bois">En savoir plus</a>
                </div>

                <div class="projet">
                    <h3>Terre Nouvelle</h3>
                    <p>Terre Nouvelle est une maison d'accueil d'urgence prête à accueillir les personnes sans-abris dans l'urgence sur deux sites distincts. L'un pour les hommes, l'autre pour les femmes et les enfants.</p>
                    <a href="tn">En savoir plus</a>
                </div>
            </div>
            <hr>
            <div class="contact">
                <h3>Envie de nous contacter directement ?</h3>
                <a href="contact">Prendre contact</a>
            </div>
        </section>
        

        <!-- Section bannière de chiffres -->
        <section class="section_chiffres">
            <h3>En 2025</h3>
            <div class="chiffres">                
                <div class="chiffre">
                    <h3>150+</h3>
                    <p>Personnes accompagnées</p>
                </div>
                <div class="chiffre">
                    <h3>50+</h3>
                    <p>Personnes relogées</p>
                </div>
                <div class="chiffre">
                    <h3>1000+</h3>
                    <p>Stères livrées</p>
                </div>
            </div>
        </section>

        <!-- Section actus -->
        <section class="actus">
            <h2>Les dernières actualités</h2>
            <div class="actualites">
                <!-- <?php /*foreach ($actus as $actu): ?>
                <article>
                    <img src="<?= htmlspecialchars($actu['image']) ?>" alt="<?= htmlspecialchars($actu['titre']) ?>">
                    <p><?= htmlspecialchars($actu['date']) ?></p>
                    <h3><?= htmlspecialchars($actu['titre']) ?></h3>
                    <p><?= htmlspecialchars($actu['description']) ?></p>
                    <a class="lire_suite" href="<?= htmlspecialchars($actu['lien']) ?>">Lire la suite</a>
                </article>
                <?php endforeach; */?>-->
            </div>
        </section>

    </main>
    <?php include VUES . 'pages/header_footer/footer.php'; ?>
    
</body>
</html>