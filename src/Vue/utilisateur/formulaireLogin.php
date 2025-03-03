<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../../ressources/css/style.css">

    <!-- Lien vers l'icône de l'onglet -->
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">
</head>
<body class="connexion">
<?php require_once __DIR__ . "../../../Vue/header.php" ?>

<div class="alert-connexion">
    <?php
    /** @var string[][] $messagesFlash */
    $messagesFlash = $messagesFlash ?? []; // Assurer que la variable est bien définie

    foreach ($messagesFlash as $type => $messagesFlashPourUnType) {
        // $type peut être "success", "info", "warning", "danger"
        foreach ($messagesFlashPourUnType as $messageFlash) {
            echo "
            <div class=\"alert alert-$type-connexion\">
               $messageFlash
            </div>";
        }
    }
    ?>
</div>


<main class="main-vueGenerale">
    <div class="contact">
        <form method="post" action="controleurFrontal.php" >
            <h1>Connexion</h1>
            <input type="hidden" name="controleur" value="utilisateur">
            <input type="hidden" name="action" value="connecter">
            <div class="form-group">
                <label for="login">Login :</label>
                <input type="text" name="login" id="login" required>
            </div>
            <div class="form-group">
                <label for="motdepasse">Mot de passe :</label>
                <input type="password" name="motdepasse" id="motdepasse" required>
            </div>

                <button type="submit">Se connecter</button>

        </form>
    </div>
</main>
</body>

<?php require_once __DIR__ . "../../../Vue/footer.php" ?>
</html>