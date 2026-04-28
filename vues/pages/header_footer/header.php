<header>
    <a href="accueil"><img src="#" alt="Accueil"></a>
    <nav>
        <ul>
            <li><a href="accueil">Accueil</a></li>
            <li><a href="maison">Maison de vie communautaire</a></li>
            <li><a href="bois">Bois de chauffage</a></li>
            <li><a href="actualites">Actualités</a></li>
            <li><a href="tn">Terre Nouvelle</a></li>
            <li><a href="contact">Contact</a></li>
        </ul>
    </nav>

     <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Si l'utilisateur est connecté -->
    <a href="profil" class="btn-profil">Mon Profil (<?= htmlspecialchars($_SESSION['user_nom']) ?>)</a>
    <form action="deconnexion" method="POST">
        <button type="submit" name="deconnexion">Déconnexion</button>
    </form>
    <?php else: ?>
    <!-- Si l'utilisateur est un visiteur -->
    <button class="bouton bouton_connexion" onclick="ouvreModaleConnexion()">Nous rejoindre</button>
    <?php endif; ?>
    
</header>