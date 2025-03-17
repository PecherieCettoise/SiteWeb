<form method="POST" action="controleurFrontal.php?action=modifierMdp&controleur=utilisateur">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>" required>

    <label for="new_password">Nouveau Mot de Passe :</label>
    <input type="password" id="new_password" name="new_password" required>

    <label for="confirm_password">Confirmer le Mot de Passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <button type="submit">Changer le mot de passe</button>
</form>
