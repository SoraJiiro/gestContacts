<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modification contact</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Modification contact</h2>

    <?php
      $bloc = '';
      if ($erreur !== '') {
          $bloc = '<p class="err">' . $erreur . '</p>';
      } elseif (!$contact) {
          $bloc = '<p class="pasDeContacts">Contact introuvable.</p>';
      } else {
          $bloc = '<form method="post" action="modif-trt.php">';
          $bloc .= '<h3>Modifier</h3><section><div>';
          $bloc .= '<label for="nomActuel">Nom actuel</label>';
          $bloc .= '<input id="nomActuel" name="nomActuel" type="text" value="' . $contact['nom'] . '" readonly>';
          $bloc .= '</div><div><label for="nouveauNom">Nouveau nom</label>';
          $bloc .= '<input id="nouveauNom" name="nouveauNom" type="text" maxlength="30" value="' . $contact['nom'] . '" required>';
          $bloc .= '</div><input type="hidden" name="retour" value="' . $retour . '">';
          $bloc .= '<button type="submit">Modifier</button></section></form>';
      }
      echo $bloc;

      $lienRetour = '<p><a class="btn-link" href="index.php">Accueil</a></p>';
      if ($retour === 'detail' && $contact) {
          $lienRetour = '<p><a class="btn-link" href="detail.php?nom=' . $contact['nom'] . '">Retour detail</a></p>';
      }
      echo $lienRetour;
    ?>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
