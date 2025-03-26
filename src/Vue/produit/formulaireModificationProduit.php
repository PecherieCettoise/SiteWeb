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
        <th>Parenthèse</th>
        <th>Prix de vente Poisson</th>
        <th>Prix de vente Resto</th>
        <th>Prix de vente GD</th>
        <th>Modifier</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($produits)): ?>
        <tr>
            <td colspan="7">Aucun produit disponible</td>
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

                    <!-- Parenthèse produit -->
                    <td><input type="text" name="parenthese" value="<?= htmlspecialchars($produit->getParenthese()) ?>" required></td>

                    <!-- Prix de vente Poisson -->
                    <td><input type="number" step="0.01" name="prixVentePoisson" value="<?= htmlspecialchars($produit->getPVPoiss()) ?>" required></td>

                    <!-- Prix de vente Resto -->
                    <td><input type="number" step="0.01" name="prixVenteResto" value="<?= htmlspecialchars($produit->getPVResto()) ?>" required></td>

                    <!-- Prix de vente GD -->
                    <td><input type="number" step="0.01" name="prixVenteGD" value="<?= htmlspecialchars($produit->getPVGD()) ?>" required></td>

                    <!-- Prix de vente Poisson -->
                    <td><input type="number" step="0.01" name="PV_POISS" value="<?= htmlspecialchars($produit->getPVPoiss()) ?>" required></td>

                    <!-- Prix de vente Resto -->
                    <td><input type="number" step="0.01" name="PV_RESTO" value="<?= htmlspecialchars($produit->getPVResto()) ?>" required></td>

                    <!-- Prix de vente GD -->
                    <td><input type="number" step="0.01" name="PV_GD" value="<?= htmlspecialchars($produit->getPVGD()) ?>" required></td>


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
