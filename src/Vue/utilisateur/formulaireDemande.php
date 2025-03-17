<!-- formulaire_reinitialiser_mdp.php -->
<form method="POST" action="controleurFrontal.php?action=envoyerEmailMdp">
    <label for="email">Entrez votre adresse e-mail :</label>
    <input type="email" name="email" required>
    <button type="submit">Envoyer le lien de réinitialisation</button>
</form>
