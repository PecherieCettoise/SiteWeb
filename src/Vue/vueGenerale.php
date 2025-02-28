<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <title><?php
        /** @var string $titre */
        echo $titre; ?></title>
</head>
<body class="body-vueG">
<?php
require_once __DIR__ . "/../Vue/header.php";

?>

<div class="chemin-container">
    <ol class="chemin">
        <?php
        /** @var $chemin */
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
    /**
     * @var string $cheminCorpsVue
     */
    require __DIR__ . "/{$cheminCorpsVue}";
    ?>
</main>
<footer>
    <?php require_once  __DIR__ . '/../Vue/footer.php'?>
</footer>
</body>
</html>