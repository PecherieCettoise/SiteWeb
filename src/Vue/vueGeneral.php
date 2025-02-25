<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <title><?php
        /** @var string $titre */
        echo $titre; ?></title>
</head>
<body class="body-vueG">
<?php
// Inclure le header
require_once __DIR__ . "/../Vue/header.php";
?>

<div class="chemin-container">
    <ol class="chemin">
        <?php
        // Vérification et affichage des éléments du chemin de navigation
        if (isset($chemin) && $chemin != null) {
            foreach ($chemin as $key => $link) {
                if ($link === "#") {
                    echo "<li>{$key}</li>";
                } else {
                    echo "<li><a href=\"{$link}\">{$key}</a></li>";
                }
            }
        }
        ?>
    </ol>
</div>

<main class="main-vueGenerale">
    <?php
    // Chargement du contenu principal de la vue
    // S'assurer que la variable $cheminCorpsVue est bien définie avant de l'utiliser
    if (isset($cheminCorpsVue) && !empty($cheminCorpsVue)) {
        require __DIR__ . "/{$cheminCorpsVue}";
    } else {
        echo "Erreur: Le fichier de la vue corps est manquant.";
    }
    ?>
</main>

<footer>
    <?php
    // Inclure le footer
    require_once __DIR__ . "/../Vue/footer.php";
    ?>
</footer>

</body>
</html>
