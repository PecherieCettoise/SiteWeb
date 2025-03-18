<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Administrateur</title>
    <style>

        .container {
            max-width: 90%;
            margin: 200px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .button-container {
            display: flex;
            flex-wrap: wrap; /* Permet aux boutons d'aller à la ligne si nécessaire */
            justify-content: center;
            gap: 10px; /* Espacement entre les boutons */
        }

        button.rouge {
            background-color: #e74c3c;
            color: black;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            min-width: 180px; /* Assure une taille homogène */
        }

        button.rouge:hover {
            background-color: #c0392b;
        }

        body h1{
            padding-top: ;
            text-align: center;
            align-items: center;
            margin: 0 auto;
        }
    </style>
</head>
<body >

<h1>Privilèges Administrateur</h1>

<div class="container">
        <div class="button-container">
            <a href="controleurFrontal.php?action=afficherFormulaireImportation&controleur=fichierCSV"><button class="rouge">Importation des fichiers</button></a>
            <a href="controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client"><button class="rouge">Ajouter un utilisateur</button></a>
            <a href="controleurFrontal.php?action=afficherFormulaireSuppressionUtilisateur&controleur=utilisateur"><button class="rouge">Supprimer un utilisateur</button></a>
            <a href="controleurFrontal.php?action=afficherTousLesClients&controleur=client"><button class="rouge">Modifier un utilisateur</button></a>
            <a href="controleurFrontal.php?action=afficherFormulaireAjoutProduit&controleur=produit"><button class="rouge">Ajouter un produit</button></a>
            <a href="controleurFrontal.php?action=afficherFormulaireSuppressionProduit&controleur=produit"><button class="rouge">Supprimer un produit</button></a>
            <a href="controleurFrontal.php?action=afficherTousLesProduits&controleur=produit"><button class="rouge">Modifier un produit</button></a>

        </div>

</div>

</body>
</html>
