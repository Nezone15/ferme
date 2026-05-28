<?php
//Ce script me génère un fichier CSV d'utilisateurs

$fichier = 'utilisateur.csv';
$ecrire = fopen($fichier, 'w');

/* L'entête du CSV. Phpmyadmin ne saute pas la ligne 1 ?
fputcsv($ecrire, ['email', 'mdp', 'nom', 'prenom', 'question_id', 'reponse_secrete']);
*/

//Les données ont le format : utilisateur_i@example.com, Mdp123, Nom_i, Prenom_i, question_id (1-10), reponse

// Mdp et reponse secreté hashé
$mdp_hash = password_hash('Mdp123', PASSWORD_DEFAULT);
$reponse_hash = password_hash('reponse', PASSWORD_DEFAULT);

//Boucler pour créer les données factices
for ($i = 1; $i <= 20; $i++) {
    fputcsv($ecrire, [
        "utilisateur_$i@example.com",
        $mdp_hash,
        "Nom_$i",
        "Prenom_$i",
        rand(1,10),
        $reponse_hash
    ]);
}

fclose($ecrire);
?>