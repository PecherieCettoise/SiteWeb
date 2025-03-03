<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <title>Formulaire de contact</title>

    <!-- Lien vers l'icône de l'onglet -->
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">
</head>
<body class="candidature">

<?php require_once __DIR__ . "../../../Vue/header.php" ?>

<form action="controleurFrontal.php?action=afficherMailCandidature&controleur=page" method="POST" enctype="multipart/form-data">

    <h1>Candidature</h1>

    <div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
    </div>

    <div class="form-group">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>
    </div>

    <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="poste">Poste :</label>
        <input type="text" id="poste" name="poste" required>
    </div>

    <div class="form-group">
        <label for="message">Message :</label>
        <textarea id="message" name="message" required></textarea>
    </div>

    <div class="form-group">
        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required>
    </div>

    <div class="form-group">
        <label for="fichier">CV et Lettre de motivation :</label>
        <input type="file" id="fichier" name="fichier[]" accept=".pdf,.docx,.doc,.txt" multiple>
    </div>

    <button type="submit">Envoyer</button>

</form>

<?php require_once __DIR__ . "../../../Vue/footer.php" ?>

</body>
</html>
