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


<main class="main-vueGenerale">
    <div class="contact">
        <form method="post" action="controleurFrontal.php" >
            <h1>Connexion</h1>
            <input type="hidden" name="controleur" value="utilisateur">
            <input type="hidden" name="action" value="connecter">
            <div class="form-group">
                <label for="login">Login :</label>
                <input type="text" name="login" id="login">
            </div>
            <div class="form-group">
                <label for="motdepasse">Mot de passe :</label>
                <input type="password" name="motdepasse" id="motdepasse">
            </div>



            <button type="submit">Se connecter</button>

            <div class="content">
                <a href="controleurFrontal.php?action=afficherFormulaireReinitialisationMDP&controleur=utilisateur">Changer de mot de passe</a>
            </div>

        </form>
    </div>
</main>
</body>

<?php require_once __DIR__ . "../../../Vue/footer.php" ?>
</html>