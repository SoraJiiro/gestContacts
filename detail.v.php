<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail contact</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Detail contact</h2>

    <?php
      $bloc = '';
      if ($erreur !== '') {
          $bloc = '<p class="err">' . $erreur . '</p>';
      } elseif (!$contact) {
          $bloc = '<p class="pasDeContacts">Contact introuvable.</p>';
      } else {
          $bloc = '<p>Contact : <strong>' . $contact['nom'] . '</strong></p>';
          if (!$numeros) {
              $bloc .= '<p class="pasDeContacts">Aucun numero enregistre pour ce contact.</p>';
          } else {
              $bloc .= '<table><thead><tr><th>Libellé(s)</th><th>Actions</th></tr></thead><tbody>';
              foreach ($numeros as $num) {
                  $bloc .= '<tr><td><a href="detail-libelle.php?libelle=' . $num['libelle'] . '&nom=' . $contact["nom"] . '">' . $num['libelle'] . '</td><td><a href="sup-numero.php?nom=' . $contact['nom'] . '&libelle=' . $num['libelle'] . '"><img src="imgs/supp.svg" width="26px"></a><a href="modif-numero.php?nom=' . $contact['nom'] . '&libelle=' . $num['libelle'] . '"><img src="imgs/modif.png" width="32px"></a></td></tr>';
              }
              $bloc .= '</tbody></table>';
          }
          $bloc .= '<p class="liens-inline">';
          $bloc .= '<a class="btn-lien" href="index.php">Accueil</a></p>';
      }
      echo $bloc;
    ?>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
