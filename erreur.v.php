<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Erreur</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Erreur</h2>
    <p class="err"><?= $erreur ?></p>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
