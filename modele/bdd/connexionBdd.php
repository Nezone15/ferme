<?php
$GLOBALS['connexionBdd'] = new PDO('mysql:host=localhost;dbname=adb', 'root', '');
$GLOBALS['connexionBdd']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>