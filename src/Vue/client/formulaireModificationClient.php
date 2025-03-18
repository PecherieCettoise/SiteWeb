<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php /** @var $titre */ ?>
    <title><?= htmlspecialchars($titre) ?></title>
</head>
<body>
<h1>Liste des clients</h1>

<table border="1">
    <thead>
    <tr>
        <th>ID Client</th>
        <th>Intitulé</th>
        <th>Catégorie tarifaire</th>
        <th>Date de création</th>
        <th>Email</th>
        <th>Numéro</th>
        <th>Modifier</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($clients)): ?>
        <tr>
            <td colspan="7">Aucun client disponible</td>
        </tr>
    <?php else: ?>
        <?php foreach ($clients as $client): ?>
            <!-- Formulaire pour modifier un client -->
            <form method="POST" action="controleurFrontal.php?action=modifierClient&controleur=client">
                <tr>
                    <!-- ID client (non modifiable, juste affiché) -->
                    <td><?= htmlspecialchars($client->getIDClient()) ?></td>

                    <!-- Intitulé du client -->
                    <td><input type="text" name="intitule" value="<?= htmlspecialchars($client->getIntitule()) ?>" required></td>

                    <!-- Catégorie tarifaire -->
                    <td><input type="text" name="categorie_tarifaire" value="<?= htmlspecialchars($client->getCategorieTarifaire()) ?>" required></td>

                    <!-- Date de création -->
                    <td><input type="date" name="date_creation" value="<?= htmlspecialchars($client->getDateCreation()->format('Y-m-d')) ?>" required></td>

                    <!-- Email -->
                    <td><input type="email" name="email" value="<?= htmlspecialchars($client->getEmail()) ?>" required></td>

                    <!-- Numéro -->
                    <td><input type="text" name="numero" value="<?= htmlspecialchars($client->getNumero()) ?>" required></td>

                    <!-- Champ caché pour l'ID client (pour l'identifier lors de la modification) -->
                    <td>
                        <input type="hidden" name="IDClient" value="<?= htmlspecialchars($client->getIDClient()) ?>">
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
