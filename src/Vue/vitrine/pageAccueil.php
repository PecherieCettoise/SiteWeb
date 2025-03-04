<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressources/css/style.css">


    <!-- Lien vers l'icône de l'onglet -->
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">

    <title>Accueil - Pêcherie Cettoise</title>
    <!-- Header du site -->
    <?php require_once __DIR__ . "../../../Vue/header.php" ?>

</head>
<body>

<main>
    <div class="image-container">
        <h1>Pêcherie Cettoise</h1>
        <p>Mareyeur en produits de la Méditerranée</p>
        <img id="animated-image" src="../../ressources/images/acceuil/arrivage.jpg" alt="Vue ice">
    </div>

    <div class="texte-container">
        <img src="../../ressources/images/acceuil/telephone.png">
        <p>04 67 51 88 51</p>
    </div>


    <div class="devise">
        <p class="fade-right">Notre Devise</p>
        <div class="logo-devise">
            <div class="logo-item">
                <img src="../../ressources/images/acceuil/flocon.png" class="taille1">
                <p class="fade-left">LA FRAICHEUR</p>
            </div>

            <div class="logo-item">
                <img src="../../ressources/images/acceuil/qualite.png">
                <p class="fade-left">LA QUALITÉ</p>
            </div>

            <div class="logo-item">
                <img src="../../ressources/images/acceuil/valide.PNG">
                <p class="fade-left">LA TRACABILITÉ</p>
            </div>
        </div>
    </div>



    <div class="promo">
        <div class="cadre-achat">
            <h3 class="fade-right">Offres du moment</h3>
            <button class="prev" onclick="changeImage(-1)">&#10094;</button> <!-- Flèche gauche -->
            <img id="imagePromo" src="../../ressources/images/acceuil/photoMer.jpg" alt="Image promotion">
            <button class="next" onclick="changeImage(1)">&#10095;</button> <!-- Flèche droite -->
        </div>
    </div>

    <div class="blocs">
        <div class="debutProximite">
            <h2 class="fade-right">Du Pêcheur au Consommateur !</h2><br>
            <p class="fade-left">Un cheminement logique est fait avec soin pour vous sélectionner
                les meilleurs produits aux meilleurs prix.<br> Vos commandes sont préparées par une équipe d’experts pour un service de qualité. </p>
            <h3>Comment ça marche?</h3>
        </div>


        <div class="proximite">
            <div class="photo">
                <img src="../../ressources/images/acceuil/zone.png" alt="Image de la zone de pêche"><br>
                <p class="fade-left">La Pêche locale et durable</p>
                <nav>
                    <table>
                        <tr>
                            <td class="fade-left">Chaque jour, les pêcheurs nous permettent de nous approvisionner sur les espèces de saisonnalité pêchées selon des méthodes artisanales.</td>
                        </tr>
                    </table>
                </nav>
            </div>

            <div class="photo">
                <img src="../../ressources/images/acceuil/poissonSelection.jpg" alt="Image du poisson"><br>
                <p class="fade-left">La Sélection</p>
                <nav>
                    <table>
                        <tr>
                            <td class="fade-left">Nous sélectionnons et contrôlons tous nos <br> arrivages quotidiens afin de vous garantir <br> une qualité et une fraîcheur de nos produits.</td>
                        </tr>
                    </table>
                </nav>
            </div>

            <div class="photo">
                <img src="../../ressources/images/acceuil/pecheur.jpg" alt="Image du travailleur"><br>
                <p class="fade-left">La Préparation</p>
                <nav>
                    <table>
                        <tr>
                            <td class="fade-left">Notre conditionnement en caisse glacée vous est proposé pour un service toujours plus personnalisé.</td>
                        </tr>
                    </table>
                </nav>
            </div>

            <div class="photo">
                <img src="../../ressources/images/acceuil/camion.jpg" alt="Image de la distribution"><br>
                <p class="fade-left">La Distribution</p>
                <nav>
                    <table>
                        <tr>
                            <td class="fade-left">La Pêcherie Cettoise est capable de vous livrer grâce à son service logistique composé de 5 camions réfrigérés qui sillonnent chaque jour l'Hérault.</td>
                        </tr>
                    </table>
                </nav>
            </div>
        </div>

        <div class="separator"></div>


        <div class="lieu">
            <div class="intro">
                <h2 class="fade-right">Nos Approvisionnements</h2>
                <p class="fade-left">
                    Nos fournisseurs sont sélectionnés par nos soins selon un cahier des charges strict, un savoir-faire unique et une capacité à fournir des produits de qualité tenant
                    compte d’un mode de pêche favorisant le maintien de la ressource.
                </p>
            </div>

            <div class="blocs">
                <div class="bloc">
                    <img src="../../ressources/images/acceuil/mediterranee.jpg" alt="mediterranee">
                    <div class="texte">
                        <h3 class="fade-right">La Méditerranée</h3>
                        <img class="fleche" src="../../ressources/images/acceuil/flecheBas.png" alt="Flèche vers le bas">
                        <p class="fade-left">Nous sommes présents en France, en Espagne, en Italie et en Croatie.</p>
                    </div>
                </div>

                <div class="bloc">
                    <img src="../../ressources/images/acceuil/atlantique.jpg" alt="atlantique">
                    <div class="texte">
                        <h3 class="fade-right">L'Atlantique</h3>
                        <img class="fleche" src="../../ressources/images/acceuil/flecheBas.png" alt="Flèche vers le bas">
                        <p class="fade-left">Nous sommes présents dans les plus grands ports Européens du Danemark à la Grèce.</p>
                    </div>
                </div>

                <div class="bloc">
                    <img src="../../ressources/images/acceuil/criee.jpg" alt="criee mediterraneen">
                    <div class="texte">
                        <h3 class="fade-right">En direct des Criées Méditerranéennes</h3>
                        <img class="fleche" src="../../ressources/images/acceuil/flecheBas.png" alt="Flèche vers le bas">
                        <p class="fade-left">Notre équipe d’acheteurs est présente chaque jour sur la Criée Méditerranéen pour vous trouver les meilleurs produits.</p>
                    </div>
                </div>
            </div>



        <div class="separator"></div>

            <div class="video">
                <p>Nous sommes fiers de vous présenter notre triporteur : une manière de contribuer à la démarche d’une ville durable.</p>
                <div class="video-container">
                    <iframe id="video" src="https://www.youtube.com/embed/vePFbTBcju0?autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>

            <div class="separator"></div>

            <div class="chiffre">

                <h2 class="fade-right">La Pêcherie Cettoise en chiffres</h2>
                <div class="imgChiffre">
                    <div>
                        <img src="../../ressources/images/acceuil/chiffreAffaire.png">
                        <h2 class="fade-right counter" data-target="9000000">0</h2>
                        <p class="fade-left">Chiffre d'affaires</p>
                    </div>

                    <div>
                        <img src="../../ressources/images/acceuil/employer.png">
                        <h2 class="fade-right counter" data-target="25">0</h2>
                        <p class="fade-left">Employés</p>
                    </div>

                    <div>
                        <img src="../../ressources/images/acceuil/client.jpg">
                        <h2 class="fade-right counter" data-target="500">0</h2>
                        <p class="fade-left">Clients</p>
                    </div>

                    <div>
                        <img src="../../ressources/images/acceuil/logoPoisson.png">
                        <h2 class="fade-right counter" data-target="500">0</h2>
                        <p class="fade-left">Références</p>
                    </div>
                </div>
            </div>


            <div class="separator"></div>


            <div class="label">
                <h2 class="fade-right">Nos Labels</h2>
                <p>Une origine de nos produits garantie</p>
                <img src="../../ressources/images/acceuil/labels.png">
            </div>



            <div class="confiance">
                <div class="separator">
                    <span class="separator-text">Ils nous font confiance</span>
                </div>
                <div class="carousel">
                    <div class="carousel-images">
                        <img src="../../ressources/images/acceuil/cazorla-logo.png" alt="Logo La Marée Gourmande">
                        <img src="../../ressources/images/acceuil/LaVoileRouge.png" alt="Logo Poissonnerie Cazorla">
                        <img src="../../ressources/images/acceuil/LaPlage.png" alt="Logo Tielle de Sète Dassé">
                        <img src="../../ressources/images/acceuil/logo-La-Maree-Gourmande.jpg" alt="Logo La Maree Gourmande">
                        <img src="../../ressources/images/acceuil/OhGobie.jpeg" alt="Logo Oh Gobie">
                        <img src="../../ressources/images/acceuil/restaurant-ebullition.jpg" alt="Logo Restaurant ebullition">
                        <img src="../../ressources/images/acceuil/TheMarcel.jpg" alt="Logo The Marcel">
                        <img src="../../ressources/images/acceuil/Tiele.png" alt="Tièle Dassé">
                    </div>
                </div>
            </div>
        </div>

</main>

<script src="../../ressources/javascript/pageAccueil.js"></script>


</body>


<?php require_once __DIR__ . "../../../Vue/footer.php" ?>

</html>