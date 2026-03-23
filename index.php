<?php
session_start();
require_once("constantes.inc.php");
require_once("f.inc.php");

$contacts = [];
$erreur = '';

try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP);
    $contacts = listerContacts($pdo);
} catch (PDOException $ex) {
    $erreur = 'Erreur de connexion a la base.';
}

require_once('v/index.v.php');
?>
