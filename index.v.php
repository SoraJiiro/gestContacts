<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Gestionnaire de contacts</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Liste des contacts</h2>

    <?php
      $bloc = '';
      if ($erreur !== '') {
          $bloc = '<p class="err">' . $erreur . '</p>';
      } elseif (!$contacts) {
          $bloc = '<p class="pasDeContacts">Aucun contact enregistre.</p>';
      } else {
          $bloc = '<table><thead><tr><th>Nom</th><th>Actions</th></tr></thead><tbody>';
          foreach ($contacts as $contact) {
              $nom = $contact['nom'];
              $bloc .= '<tr><td><a href="detail.php?nom=' . $nom . '">' . $nom . '</a></td><td class="actions">';
              $bloc .= '<a href="modif-form.php?nom=' . $nom . '">Modifier</a>';
              $bloc .= '<a href="suppression.php?nom=' . $nom . '">Supprimer</a>';
              $bloc .= '</td></tr>';
          }
          $bloc .= '</tbody></table>';
      }
      echo $bloc;
    ?>

    <p><a class="btn-link" href="ajout.php">Ajouter un contact</a></p>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
