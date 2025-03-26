<form method="POST" action="controleurFrontal.php?action=ajouterClient&controleur=client">
    <div class="form-group">
        <label for="intitule">Nom du Client</label>
        <input type="text" id="intitule" name="intitule" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="categorie_tarifaire">Catégorie Tarifaire</label>
        <input type="text" id="categorie_tarifaire" name="categorie_tarifaire" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="numero">Numéro</label>
        <input type="text" id="numero" name="numero" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="role">Rôle de l'utilisateur</label>
        <select id="role" name="role" class="form-control" required>
            <option value="selection" disabled selected>Choisir un rôle</option>
            <option value="particulier">Particulier</option>
            <option value="professionnel">Professionnel</option>
            <option value="administrateur">Administrateur</option>
            <option value="grande distribution">Grande distribution</option>
            <option value="restaurant">Restaurant</option>
        </select>
    </div>

    <div class="form-group">
        <label for="motdepasseAdmin">Mot de passe administrateur</label>
        <input type="password" id="motdepasseAdmin" name="motdepasseAdmin" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter le Client</button>
</form>
