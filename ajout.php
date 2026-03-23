<?php
session_start();
require_once('constantes.inc.php');
require_once('f.inc.php');

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $libelle = $_POST['libelle'] ?? '';
    $numero = $_POST['numero'] ?? '';

    try {
        $pdo = new PDO(DSN, UTILISATEUR, MDP, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $erreur = ajouterContactAvecNumero($pdo, $nom, $libelle, $numero);
        if ($erreur === '') {
            header('Location: index.php');
            exit;
        }
    } catch (PDOException $ex) {
        $erreur = 'Erreur de base de donnees.';
    }
}

require_once('v/ajout.v.php');
