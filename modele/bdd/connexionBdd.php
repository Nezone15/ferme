<?php
$connexionBdd = new PDO('mysql:host=localhost;dbname=adb', 'root', '');
$connexionBdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>