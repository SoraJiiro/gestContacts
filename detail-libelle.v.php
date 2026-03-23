<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail numero</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Detail Libellé</h2>

    <?php
      $bloc = '';
      if ($erreur !== '') {
          $bloc = '<p class="err">' . $erreur . '</p>';
      } else {
          $bloc = '<table><thead><tr><th>Numero</th></tr></thead><tbody><tr>';
          $bloc .= '<td>' . $numero['numero'] . '</td>';
          $bloc .= '</tr></tbody></table>';
          $bloc .= '<p class="liens-inline">';
          $bloc .= '<a class="btn-lien" href="detail.php?nom=' . $nom . '">Retour detail</a>';
          $bloc .= '</p>';
      }
      echo $bloc;
    ?>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
