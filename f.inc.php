<?php

function numeroValide($numero) {
    return preg_match('/^\d{2}(?:\.\d{2}){4}$/', $numero) === 1;
}

function libelleValide($libelle) {
    return $libelle !== '' && strlen($libelle) <= 50;
}

function nomValide($nom) {
    return $nom !== '' && strlen($nom) <= 30;
}

function listerContacts($pdo) {
    $req = $pdo->prepare('SELECT nom FROM contact ORDER BY nom');
    $req->execute();
    return $req->fetchAll();
}

function lireContact($pdo, $nom) {
    $req = $pdo->prepare('SELECT nom FROM contact WHERE nom = ?');
    $req->bindParam(1, $nom, PDO::PARAM_STR);
    $req->execute();
    return $req->fetch();
}

function listerNumerosContact($pdo, $nom) {
    $req = $pdo->prepare('SELECT id, libelle, numero FROM numero WHERE nom = ? ORDER BY id');
    $req->bindParam(1, $nom, PDO::PARAM_STR);
    $req->execute();
    return $req->fetchAll();
}

function lireNumero($pdo, $id, $nom) {
    $req = $pdo->prepare('SELECT id, libelle, numero, nom FROM numero WHERE id = ? AND nom = ?');
    $req->bindParam(1, $id, PDO::PARAM_INT);
    $req->bindParam(2, $nom, PDO::PARAM_STR);
    $req->execute();
    return $req->fetch();
}

function numeroExistePourContact($pdo, $nom, $numero) {
    $nb = 0;
    $req = $pdo->prepare('SELECT COUNT(*) AS nb FROM numero WHERE nom = ? AND numero = ?');
    $req->bindParam(1, $nom, PDO::PARAM_STR);
    $req->bindParam(2, $numero, PDO::PARAM_STR);
    $req->execute();
    $ligne = $req->fetch();
    if ($ligne) {
        $nb = (int) $ligne['nb'];
    }
    return $nb > 0;
}

function libelleExistePourContact($pdo, $nom, $libelle) {
    $nb = 0;
    $req = $pdo->prepare('SELECT COUNT(*) AS nb FROM numero WHERE nom = ? AND libelle = ?');
    $req->bindParam(1, $nom, PDO::PARAM_STR);
    $req->bindParam(2, $libelle, PDO::PARAM_STR);
    $req->execute();
    $ligne = $req->fetch();
    if ($ligne) {
        $nb = (int) $ligne['nb'];
    }
    return $nb > 0;
}

function ajouterContactAvecNumero($pdo, $nom, $libelle, $numero) {
    if (!nomValide($nom) || !libelleValide($libelle) || !numeroValide($numero)) {
        return 'Donnees invalides.';
    }

    if (lireContact($pdo, $nom)) {
        return 'Ce contact existe deja.';
    }

    $pdo->beginTransaction();
    try {
        $reqContact = $pdo->prepare('INSERT INTO contact (nom) VALUES (?)');
        $reqContact->bindParam(1, $nom, PDO::PARAM_STR);
        $reqContact->execute();

        $reqNumero = $pdo->prepare('INSERT INTO numero (numero, libelle, nom) VALUES (?, ?, ?)');
        $reqNumero->bindParam(1, $numero, PDO::PARAM_STR);
        $reqNumero->bindParam(2, $libelle, PDO::PARAM_STR);
        $reqNumero->bindParam(3, $nom, PDO::PARAM_STR);
        $reqNumero->execute();
        $pdo->commit();
        return '';
    } catch (Exception $ex) {
        $pdo->rollBack();
        return 'Impossible d\'ajouter le contact.';
    }
}

function lireNumeroDuLibelle($pdo, $libelle, $nom) {
    $req = $pdo->prepare('SELECT numero, id FROM numero WHERE nom = ? AND libelle = ?');
    $req->bindParam(1, $nom, PDO::PARAM_STR);
    $req->bindParam(2, $libelle, PDO::PARAM_STR);
    $req->execute();
    $res = $req->fetch();
    return $res;
}

function supprimerContact($pdo, $nom) {
    $req = $pdo->prepare('DELETE FROM contact WHERE nom = ?');
    $req->bindParam(1, $nom, PDO::PARAM_STR);
    $req->execute();
}

function modifierNomContact($pdo, $nomActuel, $nouveauNom) {
    if (!nomValide($nomActuel) || !nomValide($nouveauNom)) {
        return 'Nom invalide.';
    }
    if (!lireContact($pdo, $nomActuel)) {
        return 'Contact introuvable.';
    }
    if ($nomActuel === $nouveauNom) {
        return 'Ce nom est deja celui du contact.';
    }
    if ($nomActuel !== $nouveauNom && lireContact($pdo, $nouveauNom)) {
        return 'Le nouveau nom existe deja.';
    }

    $req = $pdo->prepare('UPDATE contact SET nom = ? WHERE nom = ?');
    $req->bindParam(1, $nouveauNom, PDO::PARAM_STR);
    $req->bindParam(2, $nomActuel, PDO::PARAM_STR);
    $req->execute();
}

function ajouterNumero($pdo, $nom, $libelle, $numero) {
    if (!nomValide($nom) || !libelleValide($libelle) || !numeroValide($numero)) {
        return 'Donnees invalides.';
    }
    if (!lireContact($pdo, $nom)) {
        return 'Contact introuvable.';
    }
    if (libelleExistePourContact($pdo, $nom, $libelle)) {
        return 'Ce libelle existe deja pour ce contact.';
    }
    if (numeroExistePourContact($pdo, $nom, $numero)) {
        return 'Ce numero existe deja pour ce contact.';
    }

    $req = $pdo->prepare('INSERT INTO numero (numero, libelle, nom) VALUES (?, ?, ?)');
    $req->bindParam(1, $numero, PDO::PARAM_STR);
    $req->bindParam(2, $libelle, PDO::PARAM_STR);
    $req->bindParam(3, $nom, PDO::PARAM_STR);
    $req->execute();
    return '';
}

function supprimerNumero($pdo, $id, $nom) {
    $req = $pdo->prepare('DELETE FROM numero WHERE id = ? AND nom = ?');
    $req->bindParam(1, $id, PDO::PARAM_INT);
    $req->bindParam(2, $nom, PDO::PARAM_STR);
    $req->execute();
}

function modifierNumero($pdo, $id, $nom, $libelle, $numero) {
    if (!libelleValide($libelle) || !numeroValide($numero)) {
        return 'Donnees invalides.';
    }

    $actuel = lireNumero($pdo, $id, $nom);
    if (!$actuel) {
        return 'Numero introuvable.';
    }
    if ($actuel['libelle'] === $libelle && $actuel['numero'] === $numero) {
        return 'Ce numero est deja enregistre ainsi.';
    }

    $nbLibelle = 0;
    $reqLibelle = $pdo->prepare('SELECT COUNT(*) AS nb FROM numero WHERE nom = ? AND libelle = ? AND id <> ?');
    $reqLibelle->bindParam(1, $nom, PDO::PARAM_STR);
    $reqLibelle->bindParam(2, $libelle, PDO::PARAM_STR);
    $reqLibelle->bindParam(3, $id, PDO::PARAM_INT);
    $reqLibelle->execute();
    $ligneLibelle = $reqLibelle->fetch();
    if ($ligneLibelle) {
        $nbLibelle = (int) $ligneLibelle['nb'];
    }
    if ($nbLibelle > 0) {
        return 'Ce libelle existe deja pour ce contact.';
    }

    $nbNumero = 0;
    $reqNumero = $pdo->prepare('SELECT COUNT(*) AS nb FROM numero WHERE nom = ? AND numero = ? AND id <> ?');
    $reqNumero->bindParam(1, $nom, PDO::PARAM_STR);
    $reqNumero->bindParam(2, $numero, PDO::PARAM_STR);
    $reqNumero->bindParam(3, $id, PDO::PARAM_INT);
    $reqNumero->execute();
    $ligneNumero = $reqNumero->fetch();
    if ($ligneNumero) {
        $nbNumero = (int) $ligneNumero['nb'];
    }
    if ($nbNumero > 0) {
        return 'Ce numero existe deja pour ce contact.';
    }

    $req = $pdo->prepare('UPDATE numero SET libelle = ?, numero = ? WHERE id = ? AND nom = ?');
    $req->bindParam(1, $libelle, PDO::PARAM_STR);
    $req->bindParam(2, $numero, PDO::PARAM_STR);
    $req->bindParam(3, $id, PDO::PARAM_INT);
    $req->bindParam(4, $nom, PDO::PARAM_STR);
    $req->execute();
    return '';
}
