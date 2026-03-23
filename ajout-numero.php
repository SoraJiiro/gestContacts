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
    if (!$contact) {
        $erreur = 'Contact introuvable.';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $contact) {
        $libelle = $_POST['libelle'] ?? '';
        $numero = $_POST['numero'] ?? '';
        $erreur = ajouterNumero($pdo, $nom, $libelle, $numero);

        if ($erreur === '') {
            header('Location: detail.php?nom=' . $nom);
            exit;
        }
    }
} catch (PDOException $ex) {
    $erreur = 'Erreur de base de donnees.';
}

require_once('v/ajout-numero.v.php');
