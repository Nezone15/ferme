<?php
// On récupère la page demandée, sinon par défaut c'est l'accueil
$page = $_GET['page'] ?? 'accueil';
switch($page) {
    case 'accueil':
        include 'controleurs/controleur_accueil.php';
        break;
    case 'maison':
        include 'controleurs/controleur_maison.php';
        break;
    case 'bois':
        include 'controleurs/controleur_bois.php';
        break;
    case 'actualites':
        include 'controleurs/controleur_actualites.php';
        break;
    case 'connexion':
        include 'controleurs/controleur_connexion.php';
        break;
    case 'inscription':
        include 'controleurs/controleur_inscription.php';
        break;
    case 'profil':
        include 'controleurs/controleur_profil.php';
        break;
    case 'vueAdmin':
        include 'controleurs/controleur_vueAdmin.php';
        break;
    case 'tn':
        include 'controleurs/controleur_tn.php';
        break;
    case 'contact':
        include 'controleurs/controleur_contact.php';
        break;
    case 'mentions':
        include 'controleurs/controleur_mentions.php';
        break;
    case 'politique':
        include 'controleurs/controleur_politique.php';
        break;
}
?>