<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suppression numero</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Suppression numero</h2>

    <?php
      $bloc = '';
      if ($erreur !== '') {
          $bloc = '<p class="err">' . $erreur . '</p>';
      } elseif (!$contact || !$numero) {
          $bloc = '<p class="pasDeContacts">Numero introuvable.</p>';
      } else {
          $bloc = '<form method="post" action="sup-numero.php"><h3>Supprimer</h3><section>';
          $bloc .= '<p>Contact : <strong>' . $contact['nom'] . '</strong></p>';
          $bloc .= '<p>Libelle : <strong>' . $numero['libelle'] . '</strong></p>';
          $bloc .= '<p>Numero : <strong>' . $numero['numero'] . '</strong></p>';
          $bloc .= '<input type="hidden" name="nom" value="' . $contact['nom'] . '">';
          $bloc .= '<input type="hidden" name="id" value="' . (int) $numero['id'] . '">';
          $bloc .= '<button type="submit">Supprimer</button></section></form>';
          $bloc .= '<p><a class="btn-link" href="detail.php?nom=' . $contact['nom'] . '">Retour detail</a></p>';
      }
      echo $bloc;
    ?>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
