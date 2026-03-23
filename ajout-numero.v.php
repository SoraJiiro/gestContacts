<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajout numero</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Ajout numero</h2>

    <?php
      $bloc = '';
      if ($erreur !== '') {
          $bloc .= '<p class="err">' . $erreur . '</p>';
      }

      if ($contact) {
          $bloc .= '<p>Contact : <strong>' . $contact['nom'] . '</strong></p>';
          $bloc .= '<p><i><span>*</span> Format numero : xx.xx.xx.xx.xx</i></p>';
          $bloc .= '<form method="post" action="ajout-numero.php"><h3>Ajouter</h3><section>';
          $bloc .= '<input type="hidden" name="nom" value="' . $contact['nom'] . '">';
          $bloc .= '<div><label for="libelle">Libelle</label><input id="libelle" name="libelle" type="text" maxlength="50" required></div>';
          $bloc .= '<div><label for="numero">Numero <span>*</span></label><input id="numero" name="numero" type="text" maxlength="14" placeholder="03.26.45.44.27" required></div>';
          $bloc .= '<button type="submit">Ajouter</button></section></form>';
          $bloc .= '<p><a class="btn-link" href="detail.php?nom=' . $contact['nom'] . '">Retour detail</a></p>';
      } else {
          $bloc .= '<p><a class="btn-link" href="index.php">Accueil</a></p>';
      }
      echo $bloc;
    ?>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
