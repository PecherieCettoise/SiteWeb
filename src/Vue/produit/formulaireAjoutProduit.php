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
        <label for="prixVente" class="form-label">Prix de vente</label>
        <input type="number" class="form-control" id="prixVente" name="prixVente" required step="0.01">
    </div>

    <div class="mb-3">
        <label for="stock_reel" class="form-label">Stock réel</label>
        <input type="number" class="form-control" id="stock_reel" name="stock_reel" required step="0.01">
    </div>

    <div class="mb-3">
        <label for="stock_disponible" class="form-label">Stock disponible</label>
        <input type="number" class="form-control" id="stock_disponible" name="stock_disponible" required step="0.01">
    </div>

    <div class="mb-3">
        <label for="stockATerme" class="form-label">Stock à terme</label>
        <input type="number" class="form-control" id="stockATerme" name="stockATerme" step="0.01">
    </div>

    <div class="mb-3">
        <label for="poids_Net" class="form-label">Poids net</label>
        <input type="number" class="form-control" id="poids_Net" name="poids_Net" required step="0.01">
    </div>

    <button type="submit" class="btn btn-primary">Ajouter le produit</button>
</form>
