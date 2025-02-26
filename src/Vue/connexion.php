<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <title>Formulaire de connexion</title>
</head>
<body class="contact">

<?php require_once __DIR__ . "/../Vue/header.php" ?>

<form method="POST" enctype="multipart/form-data">

    <h1>Se Connecter</h1>

    <div class="form">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
    </div>

    <div class="form">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>
    </div>

    <button type="submit">Envoyer</button>

</form>

<?php require_once __DIR__ . "/../Vue/footer.php" ?>
</body>


</html>
