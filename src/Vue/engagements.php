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
        <h1>Nos Engagements</h1>
    </div>


    <!-- Bloc 1 -->
    <div class="client-conteneur">
        <div class="text-client">
            <h2 class="jaune-client">1) Le Respect du Client</h2>
            <p>
                La Pêcherie Cettoise, vous propose un service personnalisé grâce à une équipe de professionnels qualifiés et passionnés
                qui s’active au quotidien pour vous proposer des produits d’une qualité et d’une fraîcheur incomparable.<br><br>
                Nos heures d’arrivage marchandise sont différentes en fonction des zones d’approvisionnement. C’est un point essentiel
                qu’il faut prendre en compte lorsque les clients passent commande.
            </p>
        </div>
        <img src="../../ressources/images/engagement/respect-client.png" class="img-client" alt="Image respect client">
    </div>

    <div class="separator"></div>

    <!-- Bloc 2 (image à gauche grâce à .inverse) -->
    <div class="client-conteneur inverse">
        <img src="../../ressources/images/engagement/poisson.jpg" class="img-client" alt="Image poisson">

        <div class="text-client-inverse">

            <h2 class="bleu-produit">2) Le respect des espèces proposées</h2>
            <p>
                Nous tenons à proposer à notre clientèle une large offre de produits de la Mer. Vous retrouverez à la Pêcherie Cettoise des espèces de poissons frais ou surgelés, entiers ou en filets mais également des coquillages et crustacés crus ou cuits.
                Sans jamais délaisser la qualité qui reste notre priorité.
            </p>
        </div>

    </div>

    <div class="separator"></div>

    <!-- Bloc 3 -->
    <div class="client-conteneur">
        <div class="text-client">
            <h2 class="vert-engagement">3) Le respect de l'environnement</h2>
            <p>
                Nous soutenons différents labels de la Pêche durable en vous proposant des produits, ASC, MSC et bien d'autres. Et nous veillons également à travailler avec des pêcheurs qui pratiquent des techniques de pêche locales, artisanales et durables qui ne détruisent pas les fonds marins.
            </p>
        </div>
        <img src="../../ressources/images/engagement/environnement.png" class="img-client" alt="Image respect environnement">
    </div>
</main>
</body>


<?php include("../Vue/footer.php"); ?>

</html>
