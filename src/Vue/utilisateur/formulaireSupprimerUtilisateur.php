<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer des comptes</title>
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">
    <script>
        // Fonction de recherche en temps réel
        function filtrerUtilisateurs() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("utilisateursTable");
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

                if (match) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
</head>
<body>
<main class="main-vueGenerale">
    <div class="profil-page">
        <div class="ajout-supp">
            <h1>Sélectionnez les comptes à supprimer</h1>
            <form method="post" action="controleurFrontal.php?action=supprimerUtilisateur&controleur=utilisateur" class="form-ajout-utilisateur">

                <input type="hidden" name="controleur" value="utilisateur">
                <input type="hidden" name="action" value="supprimerUtilisateur">

                <label for="searchInput">Rechercher un utilisateur :</label>
                <input type="text" id="searchInput" onkeyup="filtrerUtilisateurs()" placeholder="Rechercher par login ou nom..." class="search-input">

                <table id="utilisateursTable" class='classement-table'>
                    <thead>
                    <tr>
                        <th>Sélectionner</th>
                        <th>Login</th>
                        <th>Nom</th>
                        <th>Role</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    if (isset($utilisateurs) && is_array($utilisateurs)):
                        foreach ($utilisateurs as $utilisateur): ?>
                            <tr>
                                <td><input type="checkbox" name="utilisateurs[]" value="<?php echo htmlspecialchars($utilisateur->getLogin()); ?>"></td>
                                <td><?php echo htmlspecialchars($utilisateur->getLogin()); ?></td>
                                <td><?php echo htmlspecialchars($utilisateur->getNom()); ?></td>
                                <td><?php echo htmlspecialchars($utilisateur->getRole()); ?></td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr><td colspan="5">Aucun utilisateur à afficher.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                <div class="form-group">
                    <label for="motdepasse">Mot de passe admin :</label>
                    <input type="password" id="motdepasse" name="motdepasse" required>
                </div>

                <button type="submit" class="btn-delete">Supprimer les comptes sélectionnés</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>
