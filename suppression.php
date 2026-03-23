<?php
session_start();
require_once('constantes.inc.php');
require_once('f.inc.php');

$erreur = '';
$nom = $_GET['nom'] ?? ($_POST['nom'] ?? '');
$contact = null;

try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    if ($nom !== '') {
        $contact = lireContact($pdo, $nom);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($contact) {
            supprimerContact($pdo, $nom);
            header('Location: index.php');
            exit;
        }
        $erreur = 'Contact introuvable.';
    }
} catch (PDOException $ex) {
    $erreur = 'Erreur de base de donnees.';
}

require_once('v/suppression.v.php');
