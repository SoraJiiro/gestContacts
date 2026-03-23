<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajout contact</title>
  <link rel="stylesheet" href="css/styleCommun.css">
  <link rel="stylesheet" href="css/styleAccueil.css">
</head>
<body>
  <?php require('header.v.php'); ?>
  <main>
    <h2>Ajout contact</h2>
    <p><i><span>*</span> Format numero : xx.xx.xx.xx.xx</i></p>
    <?php
      $msgErreur = '';
      if ($erreur !== '') {
          $msgErreur = '<p class="err">' . $erreur . '</p>';
      }
      echo $msgErreur;
    ?>

    <form method="post" action="ajout.php">
      <h3>Ajouter</h3>
      <section>
        <div>
          <label for="nom">Nom</label>
          <input id="nom" name="nom" type="text" maxlength="30" required>
        </div>
        <div>
          <label for="libelle">Libelle du numero</label>
          <input id="libelle" name="libelle" type="text" maxlength="50" required>
        </div>
        <div>
          <label for="numero">Numero <span>*</span></label>
          <input id="numero" name="numero" type="text" maxlength="14" placeholder="03.26.45.44.27" required>
        </div>
        <button type="submit">Ajouter</button>
      </section>
    </form>
  </main>
  <?php require('footer.v.php'); ?>
</body>
</html>
