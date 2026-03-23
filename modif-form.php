<?php
session_start();
require_once('constantes.inc.php');
require_once('f.inc.php');

$erreur = '';
$nom = $_GET['nom'] ?? '';
$retour = $_GET['retour'] ?? 'index';
$contact = null;

try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    if ($nom !== '') {
        $contact = lireContact($pdo, $nom);
        if (!$contact) {
            $erreur = 'Contact introuvable.';
        }
    } else {
        $erreur = 'Nom de contact manquant.';
    }
} catch (PDOException $ex) {
    $erreur = 'Erreur de base de donnees.';
}

require_once('v/modif-form.v.php');
