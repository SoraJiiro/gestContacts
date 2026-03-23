<?php
session_start();
require_once('constantes.inc.php');
require_once('f.inc.php');

$erreur = '';
$nom = $_GET['nom'] ?? '';
$libelle = $_GET['libelle'] ?? '';


try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    if ($nom !== '') {
        $contact = lireContact($pdo, $nom);
    }
    if ($contact && $id > 0) {
        $numero = lireNumero($pdo, $id, $nom);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($contact && $numero) {
            $libelle = $_POST['libelle'] ?? '';
            $valeurNumero = $_POST['numero'] ?? '';
            $erreur = modifierNumero($pdo, $id, $nom, $libelle, $valeurNumero);

            if ($erreur === '') {
                header('Location: detail.php?nom=' . $nom);
                exit;
            }

            $numero['libelle'] = $libelle;
            $numero['numero'] = $valeurNumero;
        } else {
            $erreur = 'Numero introuvable.';
        }
    }

    if (!$contact || !$numero) {
        if ($erreur === '') {
            $erreur = 'Numero introuvable.';
        }
    }
} catch (PDOException $ex) {
    $erreur = 'Erreur de base de donnees.';
}

require_once('v/modif-numero.v.php');
