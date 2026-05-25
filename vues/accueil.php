<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ferme Saint Achaire | Accueil</title>
        <meta name="description" content="Découvrez la ferme Saint Achaire, une maison de vie communautaire engagée dans l'insertion sociale et professionnelle. Explorez nos projets sociaux : maison de vie, bois de chauffage et Terre Nouvelle.">

        <!-- Liens vers les polices -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Tinos:wght@400;700&display=swap" rel="stylesheet">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon_io/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon_io/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon_io/favicon-16x16.png">
        <link rel="manifest" href="/public/favicon_io/site.webmanifest">

        <script defer src="/public/js/accueil.js"></script>
        <link rel="stylesheet" href="/public/style/style.css">
        <link rel="stylesheet" href="/public/style/accueil.css">
    </head>
    <body>

        <?php include VUES . 'header_footer/header.php'; ?>

        <main>
            <!-- Section carousel -->
            <section class="carrousel">
                <!-- Flèche gauche -->
                        <button id="btn-precedent" type="button" class="btn-carrousel">
                            &#10216;
                        </button>

                        <!-- Flèche droite -->
                        <button id="btn-suivant" type="button" class="btn-carrousel">
                            &#10217;
                        </button>    
                <!-- Slides -->
                <div id="carrousel-conteneur" aria-live="polite">
                    <!-- CLONE Slide 3 -->
                    <div class="carrousel-slide">
                        <img src="/public/images/site/terre_nouvelle.JPG" alt="Terre Nouvelle">
                        <div class="carrousel-contenu">
                            <h2>Terre Nouvelle</h2>
                            <p>Terre Nouvelle est une maison d'accueil d'urgence qui est liée à la ferme Saint Achaire.</p>
                            <a href="tn">En savoir plus</a>
                        </div>
                    </div>

                    <!-- Slide 1 -->
                    <div class="carrousel-slide">
                        <img src="/public/images/site/ferme.webp" alt="La ferme Saint Achaire">
                        <div class="carrousel-contenu">
                            <h2>Maison de vie communautaire</h2>
                            <p>La ferme Saint Achaire est avant tout une maison de vie communautaire qui offre une solution d'accueil aux personnes en difficulté.</p>
                            <a href="maison">Découvrir le projet</a>
                        </div>
                        
                    </div>

                    <!-- Slide 2 -->
                    <div class="carrousel-slide">
                        <img src="/public/images/site/bois.jpeg" alt="Notre activité de bois de chauffage">
                        <div class="carrousel-contenu">
                            <h2>Bois de chauffage</h2>
                            <p>La ferme Saint Achaire a une activité de production de bois de chauffage pour fournir une occupation à sa communauté.</p>
                            <a  href="bois">Découvrir l'activité</a>
                        </div>
                        
                    </div>

                    <!-- Slide 3 -->
                    <div class="carrousel-slide">
                        <img src="/public/images/site/terre_nouvelle.JPG" alt="Terre Nouvelle">
                        <div class="carrousel-contenu">
                            <h2>Terre Nouvelle</h2>
                            <p>Terre Nouvelle est une maison d'accueil d'urgence qui est liée à la ferme Saint Achaire.</p>
                            <a href="tn">En savoir plus</a>
                        </div>
                    </div>

                     <!-- CLONE Slide 1 -->
                    <div class="carrousel-slide">

                        <img src="/public/images/site/ferme.webp" alt="La ferme Saint Achaire">
                        <div class="carrousel-contenu">
                            <h2>Maison de vie communautaire</h2>
                            <p>La ferme Saint Achaire est avant tout une maison de vie communautaire qui offre une solution d'accueil aux personnes en difficulté.</p>
                            <a href="maison">Découvrir le projet</a>
                        </div>                        
                    </div>
                </div>

               
                <!-- Indicateur de position -->
                <div class="carrousel-compteur">
                    <span id="slide-actuel"></span>
                </div>
            </section>

            <!-- Section présentation -->
            <section class="presentation">
                <h1>Bienvenue à la ferme Saint Achaire</h1>
                <p>
                    L'engagement social est au cœur de notre mission. Nous agissons quotidiennement
                    pour soutenir ceux qui en ont le plus besoin à travers trois projets sociaux.
                </p>

                <div class="projets">
                    <article class="projet">
                        <h3>Maison de vie communautaire</h3>
                        <p>
                            Un espace bienveillant pour poser ses bagages et retrouver le calme nécessaire
                            à une reconstruction personnelle durable au sein de notre communauté.
                        </p>
                        <a href="maison">En savoir plus &longrightarrow;</a>
                    </article>

                    <article class="projet">
                        <h3>Bois de chauffage</h3>
                        <p>
                            Une activité d'insertion professionnelle par la production et la livraison
                            de bois de chauffage.
                        </p>
                        <a href="bois">En savoir plus &longrightarrow;</a>
                    </article>

                    <article class="projet">
                        <h3>Terre Nouvelle</h3>
                        <p>
                            Terre Nouvelle est une maison d'accueil d'urgence prête à accueillir les personnes
                            sans-abris dans l'urgence sur deux sites distincts : l'un pour les hommes,
                            l'autre pour les femmes et les enfants.
                        </p>
                        <a href="tn">En savoir plus &longrightarrow;</a>
                    </article>
                </div>

                <aside class="contact">
                    <p>Envie de nous contacter directement ?</p>
                    <a class="btn-primaire" href="contact">Prendre contact</a>
                </aside>
            </section>

            <!-- Section bannière de chiffres -->
            <section class="banniere-chiffres">
                <h2>En 2025</h2>
                <div class="chiffres">
                    <div>
                        <h3>156</h3>
                        <p>Personnes accompagnées</p>
                    </div>
                    <div>
                        <h3>52</h3>
                        <p>Personnes relogées</p>
                    </div>
                    <div>
                        <h3>987</h3>
                        <p>Stères livrées</p>
                    </div>
                </div>
            </section>

            <!-- Section actus -->
            <section>
                <h2>Les dernières actualités</h2>
                <div>
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

        <?php include VUES . 'header_footer/footer.php'; ?>

    </body>
</html>