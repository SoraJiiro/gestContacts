<?php
session_start();
require_once('constantes.inc.php');
require_once('f.inc.php');

$nomActuel = $_POST['nomActuel'] ?? '';
$nouveauNom = $_POST['nouveauNom'] ?? '';
$retour = $_POST['retour'] ?? 'index';

if ($nouveauNom === '') {
    $nouveauNom = $nomActuel;
}

$erreur = '';

try {
    $pdo = new PDO(DSN, UTILISATEUR, MDP, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $erreur = modifierNomContact($pdo, $nomActuel, $nouveauNom);
} catch (PDOException $ex) {
    $erreur = 'Erreur de base de donnees.';
}

if ($erreur !== '') {
    $contact = ['nom' => $nomActuel];
    require_once('v/modif-form.v.php');
    exit;
}

if ($retour === 'detail') {
    header('Location: detail.php?nom=' . $nouveauNom);
    exit;
}

header('Location: index.php');
exit;
