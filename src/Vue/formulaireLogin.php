<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../../ressources/css/style.css">
</head>
<body class="body-connexion">
<nav class="logo-um">
    <img src="../../ressources/images/acceuil/logo.png">
</nav>
<div>
    <?php
    /** @var string[][] $messagesFlash */
    foreach($messagesFlash as $type => $messagesFlashPourUnType) {
        // $type est l'une des valeurs suivantes : "success", "info", "warning", "danger"
        // $messagesFlashPourUnType est la liste des messages flash d'un type
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
    <div class="connexion-container">
        <h1>Connexion</h1>
        <form method="post" action="controleurFrontal.php" >
            <input type="hidden" name="controleur" value="utilisateur">
            <input type="hidden" name="action" value="connecter">
            <div>
                <label for="login">Login :</label>
                <input type="text" name="login" id="login" required>
            </div>
            <div>
                <label for="motdepasse">Mot de passe :</label>
                <input type="password" name="motdepasse" id="motdepasse" required>
            </div>
            <div>
                <button type="submit">Se connecter</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>