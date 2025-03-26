<form action="controleurFrontal.php?action=ajouterProduit&controleur=produit" method="POST">
    <div class="mb-3">
        <label for="reference_article" class="form-label">Référence du produit</label>
        <input type="number" class="form-control" id="reference_article" name="reference_article" required>
    </div>

    <div class="mb-3">
        <label for="designation" class="form-label">Désignation du produit</label>
        <input type="text" class="form-control" id="designation" name="designation" required>
    </div>

    <div class="mb-3">
        <label for="parenthese" class="form-label">Parenthèse</label>
        <input type="text" class="form-control" id="parenthese" name="parenthese">
    </div>

    <div class="mb-3">
        <label for="PV_POISS" class="form-label">Prix de vente Poisson</label>
        <input type="number" class="form-control" id="PV_POISS" name="PV_POISS" required step="0.01">
    </div>

    <div class="mb-3">
        <label for="MB_POISS" class="form-label">Marge Poisson</label>
        <input type="number" class="form-control" id="MB_POISS" name="MB_POISS" step="0.01">
    </div>

    <div class="mb-3">
        <label for="PV_RESTO" class="form-label">Prix de vente Resto</label>
        <input type="number" class="form-control" id="PV_RESTO" name="PV_RESTO" required step="0.01">
    </div>

    <div class="mb-3">
        <label for="MB_RESTO" class="form-label">Marge Resto</label>
        <input type="number" class="form-control" id="MB_RESTO" name="MB_RESTO" step="0.01">
    </div>

    <div class="mb-3">
        <label for="PV_GD" class="form-label">Prix de vente Grande Distribution</label>
        <input type="number" class="form-control" id="PV_GD" name="PV_GD" required step="0.01">
    </div>

    <div class="mb-3">
        <label for="MB_GD" class="form-label">Marge Grande Distribution</label>
        <input type="number" class="form-control" id="MB_GD" name="MB_GD" step="0.01">
    </div>

    <div class="mb-3">
        <label for="poids_Net" class="form-label">Poids net</label>
        <input type="number" class="form-control" id="poids_Net" name="poids_Net" required step="0.01">
    </div>

    <button type="submit" class="btn btn-primary">Ajouter le produit</button>
</form>
