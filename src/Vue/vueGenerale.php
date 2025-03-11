<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titre ?? 'Page'; ?></title>
    <link rel="stylesheet" href="../../ressources/css/style.css">
</head>
<body class="body-vueG">
<?php
require_once __DIR__ . "/../Vue/header.php";
?>

<main class="main-vueGenerale">
    <?php
    /**
     * @var string $cheminCorpsVue
     */
    require __DIR__ . "/{$cheminCorpsVue}";
    ?>
</main>

<!-- Inclure le footer (s'il existe) -->
<footer>
    <?php require_once __DIR__ . '/../Vue/footer.php'; ?>
</footer>
</body>
</html>