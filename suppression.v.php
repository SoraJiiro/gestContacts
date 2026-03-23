<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suppression contact</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Suppression contact</h2>

    <?php
      $bloc = '';
      if ($erreur !== '') {
          $bloc = '<p class="err">' . $erreur . '</p>';
      } elseif (!$contact) {
          $bloc = '<p class="pasDeContacts">Contact introuvable.</p>';
      } else {
          $bloc = '<form method="post" action="suppression.php">';
          $bloc .= '<h3>Supprimer</h3><section>';
          $bloc .= '<p>Confirmer la suppression du contact : <strong>' . $contact['nom'] . '</strong></p>';
          $bloc .= '<input type="hidden" name="nom" value="' . $contact['nom'] . '">';
          $bloc .= '<button type="submit">Supprimer</button></section></form>';
      }
      echo $bloc;
    ?>

    <p><a class="btn-link" href="index.php">Accueil</a></p>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
