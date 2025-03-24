<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <style>

        /* Styles pour le header */
        header {
            background-color: #2d3e50;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        header p {
            margin: 5px 0;
            font-size: 1.2em;
        }

        /* Styles pour le tableau */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2d3e50;
            color: #fff;
        }

        /* Styles pour les lignes alternées */
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:nth-child(even) {
            background-color: #D3D3D3 ; /* Couleur paires légèrement atténuée */
        }

        tbody {
            color: black;
        }

        /* Pagination */
        .pagination {
            text-align: center;
            margin: 20px;
        }

        .pagination a {
            text-decoration: none;
            color: #2d3e50;
            padding: 10px 15px;
            margin: 0 5px;
            border-radius: 5px;
            background-color: #e2e2e2;
        }

        .pagination a:hover {
            background-color: #b0bec5;
        }

        .pagination span {
            font-size: 1.2em;
            margin: 0 10px;
        }

    </style>


</head>
<body>

<header>
    <h1>Bienvenue dans notre boutique</h1>
    <p>Découvrez nos produits et faites vos achats en ligne.</p>
</header>

<!-- Tableau des produits -->
<table id="produitsTable">
    <thead>
    <tr>
        <th>Référence</th>
        <th>Désignation</th>
        <th>Poids net</th>
        <th>Prix Vente</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!isset($produits) || empty($produits)): ?>
        <tr>
            <td colspan="4" style="text-align: center;">Aucun produit disponible pour le moment.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($produits as $produit): ?>
            <tr>
                <?php if ($produit->getPERMANENT() == 0 || $produit->getPERMANENT() == 1 || $produit->getPERMANENT() == 'OUI'): ?>
                <td><?= htmlspecialchars($produit->getReferenceArticle()) ?></td>
                <td><a href="controleurFrontal.php?controleur=produit&action=afficherProduit&id=<?= urlencode($produit->getReferenceArticle()) ?>">
                        <?= htmlspecialchars($produit->getDesignation()) ?>
                    </a></td>
                <td><?= htmlspecialchars($produit->getPoidsNet()) ?> kg</td>
                <td><?= number_format($produit->getPrixVente(), 2, ',', ' ') ?> €</td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<!-- Pagination -->
<div class="pagination">
    <?php
    /** @var $page */
    /** @var $totalPages */
    if ($page > 1): ?>
        <a href="controleurFrontal.php?controleur=produit&action=afficherBoutique&page=<?= $page - 1 ?>">Précédent</a>
    <?php endif; ?>

    <span>Page <?= $page ?> / <?= $totalPages ?></span>

    <?php if ($page < $totalPages): ?>
        <a href="controleurFrontal.php?controleur=produit&action=afficherBoutique&page=<?= $page + 1 ?>">Suivant</a>
    <?php endif; ?>
</div>


</body>
</html>