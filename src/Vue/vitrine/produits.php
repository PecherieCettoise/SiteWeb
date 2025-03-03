<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../ressources/css/style.css">

    <!-- Lien vers l'icône de l'onglet -->
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">

    <title>Nos Produits - Pêcherie Cettoise</title>
    <!-- Header du site -->
    <?php require_once __DIR__ . "../../../Vue/header.php" ?>
</head>

<body>

<main>
    <!-- Section d'image et titre principal -->
    <div class="imageMer">
        <img src="../../ressources/images/acceuil/photoMer.jpg" alt="Vue sur la mer">
        <h1>Nos Produits</h1>
    </div>

    <!-- Section des boutons avec images -->
    <div class="bouton-container">
        <div class="button-row">
            <button class="btn-produits" onclick="toggleProduits('poissons-frais')">
                <div class="btn-left"></div>
                <img src="../../ressources/images/produits/poisson-frais.png" alt="Poisson frais" class="img-bouton fade-left">
                <span>Poisson frais</span>
            </button>
            <button class="btn-produits" onclick="toggleProduits('filet-dos')">
                <div class="btn-left"></div>
                <img src="../../ressources/images/produits/filet-dos.png" alt="Filets de dos" class="img-bouton fade-left">
                <span>Filets de Dos</span>
            </button>
            <button class="btn-produits" onclick="toggleProduits('coquillage-crustace')">
                <div class="btn-left"></div>
                <img src="../../ressources/images/produits/coquillage-crustace.png" alt="Coquillage et Crustacé" class="img-bouton fade-left">
                <span>Coquillages et Crustacés</span>
            </button>
        </div>
        <div class="button-row">
            <button class="btn-produits" onclick="toggleProduits('cephalopode')">
                <div class="btn-left"></div>
                <img src="../../ressources/images/produits/cephalopode.png" alt="Céphalopodes" class="img-bouton fade-left">
                <span>Céphalopodes</span>
            </button>
            <button class="btn-produits" onclick="toggleProduits('longe-thon')">
                <div class="btn-left"></div>
                <img src="../../ressources/images/produits/espadon.png" alt="Longe de Thon" class="img-bouton fade-left">
                <span>Thon et Espadon</span>
            </button>

        </div>
    </div>

    <!-- Détails des produits -->
    <div class="produits-details" id="poissons-frais">
        <h2>Poissons Frais</h2>
        <div class="produit-container">
            <div class="produit-item">
                <img src="../../ressources/images/produits/loup.jpg" alt="Loup" class="produit-image fade-left">
                <h4>Le Bar, "Loup"</h4>
                <p>
                    Nous vous proposons le Bar, aussi appelé le "loup" en entier ou directement en filets frais.
                </p>
            </div>
            <div class="produit-item">
                <img src="../../ressources/images/produits/Thon-Rouge.png" alt="Thon Rouge" class="produit-image fade-left">
                <h4>Le Thon Rouge de Méditerranée</h4>
                <p>
                    Notre Thon rouge est péché selon une méthode de pêche artisanale, à la ligne, à la palangre. La Pêcherie Cettoise favorise cette pêche traditionnelle et ancestrale et vous permet de vous approvisionner sur des petits poissons frais de - de 24 heures.
                </p>
            </div>
            <div class="produit-item">
                <img src="../../ressources/images/produits/daurade.png" alt="Daurade" class="produit-image fade-left">
                <h4>La Daurade Royale</h4>
                <p>
                    Nous vous proposons la Daurade, en entier ou directement en filets frais selon vos besoins.
                </p>
            </div>
            <div class="produit-item">
                <img src="../../ressources/images/produits/lotte.png" alt="Lotte" class="produit-image fade-left">
                <h4>La Lotte</h4>
                <p>
                    Ce poisson à chair ferme et savoureuse est trés prisé pour réaliser des plats raffinés tels que la Bourride de lotte. Plusieurs calibres vous seront proposés.
                </p>
            </div>
        </div>
    </div>


    <div class="produits-details" id="filet-dos">
        <h2>Filet et Dos</h2>
        <div class="produit-container">
        <div class="produit-item">
            <img src="../../ressources/images/produits/dos-cabillaud.png" alt="Dos de cabillot" class="produit-image fade-left">
            <h4>Dos de Cabillaud</h4>
            <p>
                Notre dos de cabillaud Islandais vous est proposé en pavé de 400g et +. Il est labellisé MSC et vous garantit donc de soutenir la pêche durable.
            </p>
        </div>
        <div class="produit-item">
            <img src="../../ressources/images/produits/filet-daurade-bar.png" alt="Filet de daurade" class="produit-image fade-left">
            <h4>Filet de bar et de daurade</h4>
            <p>
                Ces filets ont une chair bien ferme, sont calibrés en 140/180g et sont trés appréciés tant des restaurants que des brasseries.
            </p>
        </div>
        <div class="produit-item">
            <img src="../../ressources/images/produits/saumon.png" alt="Filet de saumon" class="produit-image fade-left">
            <h4>Filet de saumon</h4>
            <p>
                Avec ou sans arrêtes, dégraissé ou à dégraisser, plusieurs choix s'offrent à vous avec des possibilités de commande à la pièce ou au colis.
            </p>
        </div>
        </div>
    </div>

    <div class="produits-details" id="coquillage-crustace">
        <h2>Coquilles et crustacés</h2>
        <div class="produit-container">
        <div class="produit-item">
            <img src="../../ressources/images/produits/bulot.png" alt="Bulot" class="produit-image fade-left">
            <h4>Les bulots</h4>
            <p>
                Les Bulots sont cuits frais, d’une cuisson artisanale permettant de préserver leurs qualités et leurs saveurs naturelles. Nos bulots sont labellisés PAVILLON FRANCE.

            </p>
        </div>
        <div class="produit-item">
            <img src="../../ressources/images/produits/crevette.png" alt="Crevette" class="produit-image fade-left">
            <h4>Les crevettes</h4>
            <p>
                Nous vous proposons tous types de crevettes:
                D'Equateur, du Nigeria ou même de Madagascar...
                Des petites crevettes 40/60 jusqu'aux Gambas en U10 ou même U5...
                Labellisées ASC ou non, nous pourrons répondre à tous vos besoins.
            </p>
        </div>
        <div class="produit-item">
            <img src="../../ressources/images/produits/moule.png" alt="Moules" class="produit-image fade-left">
            <h4>Les moules</h4>
            <p>
                Moules d'Espagne, Moules de Bouchot AOP, d'Irlande et même de Méditerranée, un large choix de Moules vous est proposé selon la saisonnalité.
            </p>
        </div>
        <div class="produit-item">
            <img src="../../ressources/images/produits/couteau.png" alt="Couteaux" class="produit-image fade-left">
            <h4>Les couteaux</h4>
            <p>
                Nos couteaux à la chair tendre sont pêchés à pieds et vous sont proposés en colis de 3kg, en boote d'1kg.
                Vous pourrez vous procurer des couteaux frais ou encore surgelés.
            </p>
        </div>
        </div>
    </div>

    <div class="produits-details" id="cephalopode">
        <h2>Céphalopodes</h2>
        <div class="produit-container">
        <div class="produit-item">
            <img src="../../ressources/images/produits/seche.png" alt="Sèche" class="produit-image fade-left">
            <h4>La Sèche Congelée</h4>
            <p>
                Retrouvez à la Pêcherie Cettoise plusieurs calibres différents selon vos besoins.
                De la 5/7 ou 2/4 pc au kg pour vos planchas mais également de la 1/2pc au kg pour vos plats cuisinés.
                Très peu de glazing, donc très peu de perte à la cuisson, une chair ferme et une seiche bien blanche.
                La Qualité restant notre priorité.
            </p>
            </p>
        </div>
        <div class="produit-item">
            <img src="../../ressources/images/produits/encornet.png" alt="Encorné" class="produit-image fade-left">
            <h4>L'encornet Congelé</h4>
            <p>
                Nos encornets congelés vous sont proposés entiers ou uniquement en tubes. Nettoyés ou à nettoyer.
                Tous congelés séparément afin que vous puissiez limiter vos pertes en sortant exclusivement ce dont vous avez besoin.
            </p>
        </div>
        <div class="produit-item">
            <img src="../../ressources/images/produits/poulpe.png" alt="Poulpe" class="produit-image fade-left">
            <h4>Le Poulpe Congelé</h4>
            <p>
                Le Poulpe de Roc est réputé pour être le meilleur grâce à ses qualités gustatives.
                Nous vous le proposons congelé à la Pièce, nettoyé ou à nettoyé, en pièces de 500/1kg, 1/2kh ou bien +.
            </p>
        </div>
        <div class="produit-item">
            <img src="../../ressources/images/produits/chipirons.png" alt="Chipirons" class="produit-image fade-left">
            <h4>Le Chipirones</h4>
            <p>
                Les chipirones font partie des tops produits de la saison estivale. Trés appréciés en friture.

            </p>
        </div>
        </div>
    </div>

    <div class="produits-details" id="longe-thon">
        <h2>Longe de Thon et D'Espadon</h2>
        <div class="produit-container">
        <div class="produit-item">
            <img src="../../ressources/images/produits/thon.jpg" alt="Longe de Thon" class="produit-image fade-left">
            <img src="../../ressources/images/produits/espadon.png" alt="Longe de Espadon" class="produit-image fade-left">
            <h4>Longe de Thon et d'espadon</h4>
            <p>
                Plusieurs longes de thon et espadon vous sont proposées. Avec ou sans peau, avec ou sans ligne de sang pour répondre à toutes vos attentes.
            </p>
        </div>
        </div>
    </div>


    <div class="separator"></div>


    <section class="conteneur-traiteur">
        <h2 class="fade-left">Traiteur</h2>
        <div class="traiteur fade-right">
            <div class="itemm">
                <img src="../../ressources/images/produits/soupe-poisson.png" alt="Soupe de poisson" >
                <p>Soupe de poisson</p>
            </div>
            <div class="itemm">
                <img src="../../ressources/images/produits/morin.png" alt="Gamme Morin">
                <p>Gamme Morin</p>
            </div>
            <div class="itemm">
                <img src="../../ressources/images/produits/gamme-JC-david.png" alt="Gamme JC David">
                <p>Gamme JC David</p>
            </div>
            <div class="itemm">
                <img src="../../ressources/images/produits/gamme-sasse.png" alt="Gamme Dassé">
                <p>Gamme Dassé</p>
            </div>
        </div>
    </section>

    <div class="separator"></div>
    
    <div class="provenance">
        <h2 class="fade-left">La provenance de nos produits</h2>
        <img src="../../ressources/images/produits/carte-Provenance.png" class="fade-up">
    </div>

    <div class="separator"></div><br>


</main>

<!-- Footer du site -->
<?php require_once __DIR__ . "../../../Vue/footer.php" ?>

<script>
    function toggleProduits(id) {
        var produitDetails = document.getElementById(id);
        produitDetails.classList.toggle('active');
    }


</script>

<script src="../../ressources/javascript/pagePecherieCettoise.js"></script>

</body>




</html>
