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

            <form action="controleurFrontal.php?action=changerDeMotDePasse&controleur=utilisateur" method="POST">
                <div class="form-group">
                    <label for="nouveauMotDePasse">Nouveau mot de passe :</label>
                    <input type="password" id="nouveauMotDePasse" name="nouveauMotDePasse" required>
                </div>

                <div class="form-group">
                    <label for="confirmationMotDePasse">Confirmer le nouveau mot de passe :</label>
                    <input type="password" id="confirmationMotDePasse" name="confirmationMotDePasse" required>
                </div>

                <button type="submit" class="btn-delete">Changer le mot de passe</button>
            </form>


        </div>
    </div>
</main>
</body>
</html>
