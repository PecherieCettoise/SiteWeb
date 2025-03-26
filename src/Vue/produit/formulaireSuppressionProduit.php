<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer des produits</title>
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">
    <script>
        // Fonction de recherche en temps réel
        function filtrerProduits() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("produitsTable");
            tr = table.getElementsByTagName("tr");

            // Parcours toutes les lignes du tableau
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                var match = false;

                // Vérifie si la ligne correspond à la recherche
                for (var j = 1; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                        }
                    }
                }

                tr[i].style.display = match ? "" : "none";
            }
        }
    </script>
</head>
<body>
<main class="main-vueGenerale">
    <div class="profil-page">
        <div class="ajout-supp">
            <h1>Sélectionnez les produits à supprimer</h1>
            <form method="post" action="controleurFrontal.php?action=supprimerProduit&controleur=produit" class="form-ajout-produit">
                <input type="hidden" name="controleur" value="produit">
                <input type="hidden" name="action" value="supprimerProduit">

                <label for="searchInput">Rechercher un produit :</label>
                <input type="text" id="searchInput" onkeyup="filtrerProduits()" placeholder="Rechercher par nom ou description..." class="search-input">

                <table id="produitsTable" class="classement-table">
                    <thead>
                    <tr>
                        <th>Sélectionner</th>
                        <th>Référence</th>
                        <th>Nom du produit</th>
                        <th>Prix Poisson</th>
                        <th>Prix Resto</th>
                        <th>Prix GD</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($produits) && is_array($produits)): ?>
                        <?php foreach ($produits as $produit): ?>
                            <tr>
                                <td><input type="checkbox" name="produit[]" value="<?php echo htmlspecialchars($produit->getReferenceArticle()); ?>"></td>
                                <td><?php echo htmlspecialchars($produit->getReferenceArticle()); ?></td>
                                <td><?php echo htmlspecialchars($produit->getDesignation()); ?></td>
                                <td><?php echo htmlspecialchars($produit->getPVPoiss()); ?> €</td>
                                <td><?php echo htmlspecialchars($produit->getPVResto()); ?> €</td>
                                <td><?php echo htmlspecialchars($produit->getPVGD()); ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">Aucun produit à afficher.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                <div class="form-group">
                    <label for="motdepasse">Mot de passe admin :</label>
                    <input type="password" id="motdepasse" name="motdepasse" required>
                </div>

                <button type="submit" class="btn-delete">Supprimer les produits sélectionnés</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>
