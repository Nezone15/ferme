<?php
//Si on n'a pas l'id spécifique de l'actu dans le get on redirige vers les actualités
if (!isset($_GET['id'])) {
    header('Location: actualites');
    exit();
} 

//Maintenant on peut récupérer l'actu grâce à son id
require_once(MODELE . 'crud/actualite.php');
$actu = actualiteId($_GET['id']);  
    
//Si l'actu n'existe pas on redirige vers la page des actualités
if (!$actu) {
    $_SESSION['erreur_actu_introuvable'] = "L'actualité que vous essayer de consulter n'existe pas ou n'est plus disponible.";
    header('Location: actualites');
    exit();
} else {
    require_once(MODELE . 'crud/commentaire.php');
    $commentaires = commentaireActualite($_GET['id']);
    include(VUES . 'pages/actualite.php');
}
?>