<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le mot de passe</title>
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">
</head>
<body>


<main class="main-vueGenerale">
    <div class="profil-page">
        <div class="ajout-supp">
            <h1>Mot de passe</h1>

            <form action="controleurFrontal.php?action=changerLogin&controleur=utilisateur" method="POST">
                <div class="form-group">
                    <label for="nouveauLogin">Nouveau login :</label>
                    <input type="text" id="nouveauLogin" name="nouveauLogin" required>
                </div>

                <div class="form-group">
                    <label for="confirmationLogin">Confirmer le nouveau login :</label>
                    <input type="text" id="confirmationLogin" name="confirmationLogin" required>
                </div>

                <button type="submit" class="btn-delete">Changer le login</button>
            </form>

        </div>
    </div>
</main>
</body>
</html>
