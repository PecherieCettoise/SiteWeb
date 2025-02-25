<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="../../ressources/css/style.css">

    <!-- Lien vers l'icône de l'onglet -->
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">

    <title>Nos engagements - Pêcherie Cettoise</title>
</head>

<!-- Inclusion du header.php -->
<?php include("../Vue/header.php"); ?>

<body>
<main>
    <div class="imageMer">
        <img src="../../ressources/images/acceuil/photoMer.jpg">
        <h1>Actualité</h1>
    </div>

    <div class="debut-actualite">
        <p>
            La pêcherie Cettoise est présente aux différentes fêtes organisées par la ville de Sète comme la <strong>fête de la Saint Pierre</strong> , la <strong>fête de la Saint Louis</strong> ou encore <strong>Escales à Sète</strong> . Elle a également intégré le club des entreprises Mécène du <strong>Théâtre Molière de Sète</strong>.<br><br>
            C'est pour nous très important de soutenir la ville de Sète et sa culture.
        </p>
    </div>

    <div class="club">
        <h2>Le club des entreprises Mécène du Théâtre Molière</h2>
        <p>
            Comment la Pêcherie Cettoise s’implique dans sa ville ?<br><br>
            En intégrant le Mécène du Théâtre Molière de Sète scène nationale archipel de Thau, une chance pour nous de promouvoir l’art et la culture dans un lieu d’exception pour partager des valeurs communes.
        </p>
        <img src="../../ressources/images/actualite/theatreMoliere.png">
    </div>

    <div class="corps-actualite">
        <div class="corps-actualite-conteneur fade-left">
            <h2>La Fête de la Saint Pierre</h2>
            <p>
                Appelée aussi Saint patron des pêcheurs, la fête de la Saint Pierre c’est une fête traditionnelle organisée par l’Amicale des Pêcheurs Sète Môle.<br><br>
                Elle se déroule le premier week-end de juillet dans le quartier du vieux port de Sète avec une entrée libre.<br><br>
                Une cérémonie en mer est organisée avec les pêcheurs en hommage aux marins disparus.<br><br>
                Un programme est réalisé avec des animations et des expositions qui se déroulent tout au long du week-end comme le tournoi de joutes, le tournoi de boules carrées et la fête foraine.<br><br>
                En fin de journée, sont organisées des soirées musicales au village des pêcheurs à la Criée aux poissons.<br><br>
            </p>
        </div>

        <div class="image-carousel fade-right" id="carousel-1">
            <img id="carousel-image-1" src="../../ressources/images/actualite/bateau.png" alt="Image Saint Pierre" class="carousel-image">
            <button class="prev" onclick="changeImage(-1, 1)">&#10094;</button>
            <button class="next" onclick="changeImage(1, 1)">&#10095;</button>
        </div>
    </div>

    <div class="separator"></div>

    <div class="corps-actualite">
        <div class="corps-actualite-conteneur fade-left">
            <h2>Escales à Sète</h2>
            <p>
                Escales à Sète est la fête des traditions maritimes qui se déroule en avril durant une semaine et qui attire chaque année plus de 300 000 visiteurs.<br><br>
                Une fête dédiée à la sauvegarde du patrimoine maritime et fluvial.<br><br>
                Une parade d’arrivée des grands voiliers est organisée où l’on peut découvrir de grands voiliers venant du monde entier.<br><br>
                Une bataille navale grandeur nature, des joutes sur chariots, des ateliers pour enfants, des concerts, des tournois de joutes et un grand défilé des moussaillons et des équipages sont organisés tout au long de l’événement.<br><br>
            </p>
        </div>

        <div class="image-carousel fade-right" id="carousel-2">
            <img id="carousel-image-2" src="../../ressources/images/actualite/bateau2.png" alt="Image Escales à Sète" class="carousel-image">
            <button class="prev" onclick="changeImage(-1, 2)">&#10094;</button>
            <button class="next" onclick="changeImage(1, 2)">&#10095;</button>
        </div>
    </div>

    <div class="separator"></div>

    <div class="corps-actualite">
        <div class="corps-actualite-conteneur fade-left">
            <h2>La Fête de la Saint Louis</h2>
            <p>
                La Saint Louis est la fête patronale de Sète qui se déroule au mois d’août.<br><br>
                Sur le canal Royal des combats de joutes homériques sont organisées devant des milliers de spectateurs.<br><br>
                Lors de cette fête, se déroule tous types d’activités comme des corsos nautiques, des concerts, des courses cyclistes et des traversées de Sète à la nage.<br><br>
            </p>
        </div>

        <div class="image-carousel fade-right" id="carousel-3">
            <img id="carousel-image-3" src="../../ressources/images/actualite/joueur.png" alt="La Fête de la Saint Louis" class="carousel-image">
            <button class="prev" onclick="changeImage(-1, 3)">&#10094;</button>
            <button class="next" onclick="changeImage(1, 3)">&#10095;</button>
        </div>
    </div>

</main>
</body>

<script src="../../ressources/javascript/actualite.js"></script>
<script src="../../ressources/javascript/pagePecherieCettoise.js"></script>




<?php include("../Vue/footer.php"); ?>

</html>
