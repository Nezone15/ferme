<?php
function fConnexionBdd() {
	static $pdo = null;
	if ($pdo === null) {
		$pdo = new PDO('mysql:host=localhost;dbname=adb', 'root', '');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	return $pdo;
}

// Compatibilité rétroactive : expose une variable globale si des fichiers l'attendent
$GLOBALS['connexionBdd'] = fConnexionBdd();
?>