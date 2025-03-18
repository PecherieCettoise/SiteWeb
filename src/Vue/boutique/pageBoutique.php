<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333646;
            color: white;
            text-align: center;
            padding: 20px;
        }

        h1 {
            margin: 0;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #2C3E50;
            color: white;
            font-size: 1.2em;
        }

        td {
            font-size: 1em;
            color: #34495E;
        }

        tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        tr:hover {
            background-color: #d5d8dc;
        }

        .table-cell {
            width: 25%;
        }

        .table-header {
            width: 20%;
        }

        .price {
            color: #5e9dcf;
            font-weight: bold;
        }

        .no-products {
            text-align: center;
            font-style: italic;
            color: #7f8c8d;
            padding: 20px;
        }


    </style>
</head>
<body>

<header>
    <h1>Bienvenue dans notre boutique</h1>
    <p>Découvrez nos produits et faites vos achats en ligne.</p>
</header>

<table>
    <thead>
    <tr>
        <th class="table-header">Référence</th>
        <th class="table-header">Désignation</th>
        <th class="table-header">Poids net</th>
        <th class="table-header">Prix Vente</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($produits)): ?>
        <tr>
            <td colspan="4" class="no-products">Aucun produit disponible pour le moment.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($produits as $produit): ?>
            <tr>
                <!-- Référence produit (non modifiable, juste affichée) -->
                <td class="table-cell"><?= htmlspecialchars($produit->getReferenceArticle()) ?></td>

                <!-- Désignation produit (affichée sans possibilité de modification) -->
                <td class="table-cell"><?= htmlspecialchars($produit->getDesignation()) ?></td>

                <!-- Poids net -->
                <td class="table-cell"><?= htmlspecialchars($produit->getPoidsNet()) ?> kg</td>

                <!-- Prix de vente -->
                <td class="table-cell"><span class="price"><?= number_format($produit->getPrixVente(), 2, ',', ' ') ?> €</span></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>


</body>
</html>
