<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="../../ressources/css/style.css">

    <!-- Lien vers l'icône de l'onglet -->
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">

    <title>La Pêcherie Cettoise - Pêcherie Cettoise</title>
</head>

<!-- Inclusion du header.php -->
<?php require_once __DIR__ . "../../../Vue/header.php" ?>

<!-- Contenu de la page -->
<body>
    <main>
    <div class="imageMer">
        <img src="../../ressources/images/acceuil/photoMer.jpg">
        <h1>La Pêcherie Cettoise</h1>
    </div>

    <div class="conteneur-experience">
        <div class="imageBateau">
            <img src="../../ressources/images/acceuil/photo_bateau.jpg">
            <p>
                La Pêcherie Cettoise, vous propose <strong>une qualité constante</strong> et <strong>une fraîcheur incomparable</strong> sur une offre de poissons, coquillages et crustacés en provenance de <strong>l’Atlantique</strong>, de <strong>la mer Méditerranée</strong> et de la <strong>Criée</strong> tout au long de l’année.
            </p>
        </div>

        <div class="experience">
            <h1 class="TitreBleu">16</h1>
            <h1>ans d'expérience</h1>
            <p>
                Avec plus de <strong>15 ans d’expérience</strong>, la Pêcherie Cettoise est implantée depuis 2006 au cœur du premier port de pêche en Méditerranée.
            </p>
            <p>Les <strong>3 mots d’ordre</strong> de la Pêcherie Cettoise d’aujourd’hui :</p>
            <div class="motsOrdre">
                <img src="../../ressources/images/acceuil/valideBleu.png">
                <p class="fade-right">PROFESSIONNALISME</p>
            </div>
            <div class="motsOrdre">
                <img src="../../ressources/images/acceuil/valideBleu.png">
                <p class="fade-right">ECOUTE</p>
            </div>
            <div class="motsOrdre">
                <img src="../../ressources/images/acceuil/valideBleu.png">
                <p class="fade-right">CONSEIL</p>
            </div>
        </div>
    </div>



    <div class="separator"></div>

        <div class="conteneur-histoire">
            <div class="histoire fade-left">
                <h1 class="TitreBleu">Notre Histoire</h1>
                <p>
                    C’est <strong> en 2018</strong>, que Christophe, Jacques et Nicolas Fournier reprennent l’entreprise et forment alors une équipe de 20 hommes et femmes qualifiés et réactifs pour répondre à vos besoins.<br><br>
                    « Dans le cadre de notre activité et de notre développement, nous favorisons la pêche durable en choisissant de travailler avec des acteurs locaux »
                </p>
            </div>
            <div class="imageHistoire fade-right">
                <img src="../../ressources/images/acceuil/camion2frere.png" alt="Camion">
            </div>
        </div>


        <div class="separator"></div>

        <div class="conteneur-mareyeur">
            <div class="image-mareyeur">
                <img src="../../ressources/images/acceuil/local.jpeg" alt="Image du mareyeur">
                <p>En tant que Mareyeur, notre mission est de <strong>valoriser une offre de produits frais issus de la pêche</strong>.</p>
            </div>
            <div class="mareyeur">
                <h1>Notre métier, le Mareyage</h1>
                <img src="../../ressources/images/acceuil/liens.png" class="fade-up">
                <p>Nous sommes <strong> un lien essentiel </strong> entre nos pêcheurs et nos clients. Nous respectons le client au travers <strong> d’un service de proximité</strong> et <strong> de réactivité </strong> apporter dans le respect du produit par son mode de sélection et d’approvisionnement.</p>
                <img src="../../ressources/images/acceuil/planetVerte.png" class="fade-up">
                <p>La Pêcherie Cettoise, <strong>experte dans son domaine</strong> , est en mesure de vous proposer des produits de la pêche de différents horizons, tout en <strong>respectant la saisonnalité</strong>  dans un but précis, de <strong>préserver l’écosystème qui nous entoure</strong> .</p>
                <img src="../../ressources/images/acceuil/serrageMain.png" class="fade-up">
                <p><strong>Nous négocions</strong>  auprès de nos fournisseurs pour vous proposer un large choix de produits de la mer <strong>d’une provenance contrôlée</strong> , d’une <strong>qualité inégalable au meilleur prix</strong> .</p>
            </div>
        </div>

        <div class="separator"></div>

        <div class="engagement-container">
            <h2 class="titreH2Engagement fade-right">Nos Engagements</h2>
            <div class="engagement fade-up">
                <div class="respect">
                    <h2>Respect du client</h2>
                    <div class="separator"></div>
                    <div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Une équipe qualifiée et passionnée.</p>
                        </div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Des produits frais de qualité.</p>
                        </div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Un service personnalisé.</p>
                        </div>
                    </div>
                    <a href="controleurFrontal.php?action=afficherEngagements&controleur=page" class="btn-decouverte">Découvrir</a>
                </div>

                <div class="produit">
                    <h2>Respect du produit</h2>
                    <div class="separator"></div>
                    <div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Des espèces de saisonnalité.</p>
                        </div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Un cahier des charges rigoureux.</p>
                        </div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Une sélection spécifique.</p>
                        </div>
                    </div>
                    <a href="controleurFrontal.php?action=afficherEngagements&controleur=page" class="btn-decouverte">Découvrir</a>
                </div>

                <div class="environnement">
                    <h2>Respect de l'environnement</h2>
                    <div class="separator"></div>
                    <div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Nous soutenons différents labels.</p>
                        </div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Nous valorisons une pêche durable et local.</p>
                        </div>
                        <div class="item">
                            <img src="../../ressources/images/acceuil/valideBleu.png" alt="Image">
                            <p>Un service adapter.</p>
                        </div>
                    </div>
                    <a href="controleurFrontal.php?action=afficherEngagements&controleur=page" class="btn-decouverte">Découvrir</a>
                </div>
            </div>
        </div>




        <div class="separator"></div>

        <div class="services">
            <h2 class="fade-left">Nos Services</h2>
            <div class="service-image">
                <img src="../../ressources/images/acceuil/arrivage.jpg" class="fade-right">
                <img src="../../ressources/images/acceuil/poisson.jpg" class="fade-right">
                <img src="../../ressources/images/acceuil/velo.jpg" class="fade-right">
            </div>
            <div class="menu fade-up">
                <div class="accordion-item">
                    <button class="accordion-header">
                        Le Conseil = Expertise
                        <span class="fleche2">▲</span>
                    </button>
                    <div class="accordion-content">
                        <p class="fade-up">
                            Le client est au coeur de nos préoccupations. Notre équipe commerciale s’active au quotidien pour répondre à vos demandes et vous conseille tous les jours de l’année au 04 67 51 88 51 du lundi au vendredi.<br><br>

                            Une permanence les dimanches en période estivale est mise en place pour vous permettre  de vous s’approvisionner directement sur place.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header">
                        La Réactivité = Fraîcheur
                        <span class="arrow">▲</span>
                    </button>
                    <div class="accordion-content">
                        <p class="fade-up">
                            Afin de réduire nos délais de traitement des demandes d’achats spéciales nos services vente et achat travaillent ensemble. Ce fonctionnement permet de vous proposer une offre extra-fraîche.<br><br>

                            Vous pouvez également commander sur notre site internet dans votre espace client.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header">
                        La Livraison
                        <span class="arrow">▲</span>
                    </button>
                    <div class="accordion-content">
                        <p class="fade-up">
                            Grâce à nos véhicules adaptés et à notre équipe de livraison, nous approvisionnons directement nos clients sur l’arc Méditerranéen tout au long de l’année.<br><br>

                            Toutes les commandes faites la veille vous sont livrées dès le lendemain moins de 12 heures après la pêche.<br><br>

                            Pour les destinations plus lointaines, nous faisons appel à des prestataires spécialisés dans le transport des produits de la mer.<br><br>

                            Chaque été, nous livrons nos plus proches partenaires comme les restaurants et les poissonniers Sétois avec notre vélo à assistance électrique, un moyen pour nous de protéger l’environnement qui nous entoure !<br><br>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="separator"></div>

        <div class="livraison">
            <div>
            <h2 class="fade-left">L'ultime étape, la livraison</h2>
            <p class="fade-left">
                La Pêcherie Cettoise livre en matinée sur le pourtour du bassin de Thau, Montpellier, Palavas les Flots et la Grande Motte.<br><br>

                Une livraison de la Pêcherie Cettoise est également faite au Grau du Roi entre 14h00 et 16h30.<br><br>

                Nos prestataires spécialisés STEF et DELANCHY livrent des commandes j+1 pour des destinations plus lointaines.<br><br>
            </p>

            </div>

            <div>
                <img src="../../ressources/images/acceuil/carte.png" class="fade-right">
            </div>
        </div>

        <div class="separator"></div>

        <div class="equipe">
            <div class="equipe-texte">
                <h2 class="fade-left">Notre Equipe</h2>
                <p class="fade-right">
                    La Pêcherie Cettoise emploie aujourd’hui une équipe de 20 hommes et femmes passionnés qui s’organisent pour vous satisfaire.
                </p>
            </div>
            <div class="image-equipe">
                <img src="../../ressources/images/acceuil/photoGroupe.png" class="imgG">
                <img src="../../ressources/images/acceuil/femmeCamion.png" class="imgD">
            </div>
        </div>


        <div class="clients">
            <div class="separator">
                <span class="separator-text">Nos clients</span>
            </div>

            <div class="alignement fade-up">
                <div class="client-item">
                    <img src="../../ressources/images/acceuil/coquillageBleu.png" class="client-image">
                    <div class="texte-clients">
                        <h3>La Grande Distribution</h3>
                        <p>Grandes, moyennes et petites surfaces situées sur le bassin Méditerranéen.</p>
                    </div>
                </div>

                <div class="client-item">
                    <img src="../../ressources/images/acceuil/coquillageBleu.png" class="client-image">
                    <div class="texte-clients">
                        <h3>Les Poissonneries</h3>
                        <p>Partout en France.</p>
                    </div>
                </div>

                <div class="client-item">
                    <img src="../../ressources/images/acceuil/coquillageBleu.png" class="client-image">
                    <div class="texte-clients">
                        <h3>Les Restaurants</h3>
                        <p>Des bistrots, traiteurs et restaurants étoilés.</p>
                    </div>
                </div>
            </div>

        </div>






    </main>

    <script src="../../ressources/javascript/pagePecherieCettoise.js"></script>
    <script src="/../../ressources/javascript/pageAccueil.js"></script>

</body>

<?php require_once __DIR__ . "../../../Vue/footer.php" ?>

</html>


