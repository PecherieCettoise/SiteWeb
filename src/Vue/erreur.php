<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Message d'Erreur</title>
    <link rel="stylesheet" type="text/css" href="./../ressources/css/style.css">
</head>
<body class="body-erreur">
<main class="main-erreur">
    <?php
    /** @var string $messageErreur
     * @var string $controleur
     * @var string $action
     */
    echo '<p class="p-probleme">Problème :</p>' . $messageErreur;
    ?>
    <p></p>
    <a href="controleurFrontal.php?controleur=page&action=afficherAccueil"><button type="submit" class="submit-button-erreur">Accueil</button></a>
</main>
</body>

