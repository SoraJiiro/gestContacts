<?php
session_start();
require_once('constantes.inc.php');
require_once('f.inc.php');

$erreur = '';
$nom = $_GET['nom'] ?? '';
$contact = null;
$numeros = [];

try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    if ($nom !== '') {
        $contact = lireContact($pdo, $nom);
        if ($contact) {
            $numeros = listerNumerosContact($pdo, $nom);
        } else {
            $erreur = 'Contact introuvable.';
        }
    } else {
        $erreur = 'Nom de contact manquant.';
    }
} catch (PDOException $ex) {
    $erreur = 'Erreur de base de donnees.';
}

require_once('v/detail.v.php');
