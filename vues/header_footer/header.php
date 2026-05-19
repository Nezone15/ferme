<header>
    <a href="/accueil"><img class="logo" src="/public/images/site/logo_fsa_svg.svg" alt="Logo de la Ferme Saint Achaire"></a>
    <nav>
        <ul>
            <li><a href="/accueil">Accueil</a></li>
            <li><a href="/maison">Maison de vie communautaire</a></li>
            <li><a href="/bois">Bois de chauffage</a></li>
            <li><a href="/actualites">Actualités</a></li>
            <li><a href="/tn">Terre Nouvelle</a></li>
            <li><a href="/contact">Contact</a></li>
             <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['admin'] === 1): ?>
            <li><a href="/admin">Espace Admin</a></li>
            <?php endif; ?>   
        </ul>
    </nav>

     <?php if (isset($_SESSION['utilisateur'])): ?>
        <!-- Si l'utilisateur est connecté -->
        <a class="btn-secondaire" href="/profil">Mon Profil</a>
        <form action="/deconnexion" id="deconnexion" method="POST">
            <button type="submit" name="bDeconnexion">Déconnexion</button>
        </form>
    <?php else: ?>
        <!-- Si l'utilisateur est un visiteur -->
        <a class="btn-secondaire" href="/connexion">Nous rejoindre</a>
    <?php endif; ?>    
</header>