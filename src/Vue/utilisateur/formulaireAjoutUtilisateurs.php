<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">
</head>

<?php
use App\Pecherie\Lib\MessageFlash;

$messagesFlash = MessageFlash::lireTousMessages(); // Récupère tous les messages flash
if (!empty($messagesFlash)) {
    foreach ($messagesFlash as $type => $messagesFlashPourUnType) {
        foreach ($messagesFlashPourUnType as $messageFlash) {
            echo "
                <div class=\"alert alert-$type\">
                   $messageFlash
                </div>";
        }
    }
}
?>


<body>
<main class="main-vueGenerale">
    <div class="profil-page">
        <div class="ajout-supp">
            <form action="controleurFrontal.php?action=ajouterUtilisateur&controleur=utilisateur" method="POST" class="form-ajout-utilisateur">
                <h1>Ajouter un utilisateur</h1>

                <div class="form-group">
                    <label for="Role">Role :</label>
                    <select name="Role" id="Role" required>
                        <option value="selection">-- Sélectionner un rôle --</option>
                        <option value="administrateur">administrateur</option>
                        <option value="professionnel">professionnel</option>
                        <option value="particulier">particulier</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="login">Login :</label>
                    <input type="text" id="login" name="login" required>
                </div>

                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>

                <div class="form-group">
                    <label for="motdepasseNouveau">Mot de passe :</label>
                    <input type="password" id="motdepasseNouveau" name="motdepasseNouveau" required>
                </div>

                <div class="form-group">
                    <label for="confirmationMotDePasse">Confirmation du mot de passe :</label>
                    <input type="password" id="confirmationMotDePasse" name="confirmationMotDePasse" required>
                </div>

                <div class="form-group">
                    <label for="motdepasseAdmin">Mot de passe admin :</label>
                    <input type="password" id="motdepasseAdmin" name="motdepasseAdmin" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="bouton-retour">Ajouter l'utilisateur</button>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
