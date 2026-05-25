<?php
/**
 * Fonction pour calculer le temps écoulé depuis une date donnée et retourner une chaîne lisible (ex: "Il y a 5 minutes")
 * @param string $date La date à comparer (format compatible avec strtotime)
 * @return string Le temps écoulé sous forme lisible
 */
function tempsEcoule($date) {
    $timestamp = strtotime($date);
    $diff = time() - $timestamp;

    if ($diff < 60) {
        return 'Il y a ' . $diff . ' secondes';
    } elseif ($diff < 3600) {
        return 'Il y a ' . floor($diff / 60) . ' minutes';
    } elseif ($diff < 86400) {
        return 'Il y a ' . floor($diff / 3600) . ' heures';
    } else if ($diff < 2592000) { // 30 jours 
        return 'Il y a ' . floor($diff / 86400) . ' jours';
    } elseif ($diff < 31536000) { // 365 jours
        return 'Il y a ' . floor($diff / 2592000) . ' mois';
    } else {
        return 'Il y a ' . floor($diff / 31536000) . ' ans';
    }
}
?>