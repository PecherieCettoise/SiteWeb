<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php /** @var $titre */ ?>
    <title><?= htmlspecialchars($titre) ?></title>
</head>
<body>
<h1>Liste des produits</h1>

<table border="1">
    <thead>
    <tr>
        <th>Référence</th>
        <th>Désignation</th>
        <th>Prix de vente</th>
        <th>Stock réel</th>
        <th>Stock disponible</th>
        <th>Stock à terme</th>
        <th>Poids net</th>
        <th>Modifier</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($produits)): ?>
        <tr>
            <td colspan="8">Aucun produit disponible</td>
        </tr>
    <?php else: ?>
        <?php foreach ($produits as $produit): ?>
            <!-- Formulaire pour modifier un produit -->
            <form method="POST" action="controleurFrontal.php?action=modifierProduit&controleur=produit">
                <tr>
                    <!-- Référence produit (non modifiable, juste affichée) -->
                    <td><?= htmlspecialchars($produit->getReferenceArticle()) ?></td>

                    <!-- Désignation produit -->
                    <td><input type="text" name="designation" value="<?= htmlspecialchars($produit->getDesignation()) ?>" required></td>

                    <!-- Prix de vente -->
                    <td><input type="number" step="0.01" name="prixVente" value="<?= htmlspecialchars($produit->getPrixVente()) ?>" required></td>

                    <!-- Stock réel -->
                    <td><input type="number" name="stock_reel" value="<?= htmlspecialchars($produit->getStockReel()) ?>" required></td>

                    <!-- Stock disponible -->
                    <td><input type="number" name="stock_disponible" value="<?= htmlspecialchars($produit->getStockDisponible()) ?>" required></td>

                    <!-- Stock à terme -->
                    <td><input type="number" name="stockATerme" value="<?= htmlspecialchars($produit->getStockATerme()) ?>" required></td>

                    <!-- Poids net -->
                    <td><input type="number" step="0.01" name="poids_Net" value="<?= htmlspecialchars($produit->getPoidsNet()) ?>" required></td>


                    <!-- Champ caché pour la référence article (pour l'identifier lors de la modification) -->
                    <td>
                        <input type="hidden" name="reference_article" value="<?= htmlspecialchars($produit->getReferenceArticle()) ?>">
                        <button type="submit">Modifier</button>
                    </td>
                </tr>
            </form>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
