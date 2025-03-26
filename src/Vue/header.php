<?php use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur; ?>

<header class="site-header">
    <div class="header-logo">
        <a href="controleurFrontal.php?action=afficherAccueil&controleur=page">
            <img src="../../ressources/images/acceuil/logo.png" alt="Logo">
        </a>
    </div>

    <!-- Icône du menu déroulant pour les petits écrans -->
    <div class="menu-icon" onclick="toggleMenu()">☰</div>

    <!-- Si on est sur la boutique, on affiche uniquement la barre de recherche -->
    <?php if (isset($_GET['action']) && $_GET['action'] === 'afficherBoutique' && isset($_GET['controleur']) && $_GET['controleur'] === 'produit') : ?>
        <?php if (ConnexionUtilisateur::estConnecte()) : ?>
            <form action="controleurFrontal.php" method="get" class="search-form">
                <input type="hidden" name="action" value="afficherBoutique">
                <input type="hidden" name="controleur" value="produit">
                <input type="text" name="search" class="search-input" placeholder="Rechercher un produit..."
                       value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit">Rechercher</button>
            </form>
        <?php endif; ?>

    <?php else : ?>
        <!-- Menu principal (affiché seulement si on n'est PAS sur la boutique) -->
        <div class="header-bouton">
            <strong>
                <a href="controleurFrontal.php?action=afficherAccueil&controleur=page">ACCUEIL</a>
                <a href="controleurFrontal.php?action=afficherPecherieCettoise&controleur=page">LA PÊCHERIE CETTOISE</a>
                <a href="controleurFrontal.php?action=afficherProduits&controleur=page">NOS PRODUITS</a>
                <a href="controleurFrontal.php?action=afficherEngagements&controleur=page">NOS ENGAGEMENTS</a>
                <a href="controleurFrontal.php?action=afficherActualites&controleur=page">ACTUALITÉS</a>
                <a href="controleurFrontal.php?action=afficherCandidatures&controleur=page">CANDIDATURE</a>
                <a href="controleurFrontal.php?action=afficherContact&controleur=page">CONTACT</a>

                <?php if (ConnexionUtilisateur::estConnecte()) : ?>
                    <a href="controleurFrontal.php?action=afficherBoutique&controleur=produit">BOUTIQUE</a>
                <?php endif; ?>

                <?php if (ConnexionUtilisateur::estConnecte() && Utilisateur::estAdministrateur("administrateur")) : ?>
                    <a href="controleurFrontal.php?action=afficherPageAdmin&controleur=utilisateur">ADMINISTRATEUR</a>
                <?php endif; ?>
            </strong>
        </div>
    <?php endif; ?>

    <!-- Icônes de connexion/déconnexion -->
    <?php if (ConnexionUtilisateur::estConnecte()) : ?>
        <a href="controleurFrontal.php?action=afficherProfil&controleur=utilisateur">
            <img src="../../ressources/images/connexion/iconeConnecter.png" class="header-recherche">
        </a>
        <a href="controleurFrontal.php?action=deconnecter&controleur=utilisateur">
            <img src="../../ressources/images/acceuil/deconnexion.png" alt="Logo" class="header-recherche">
        </a>
    <?php else : ?>
        <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion" class="header-recherche">
            <p>Se Connecter</p>
            <img src="../../ressources/images/connexion/iconeConnexion.png">
        </a>
    <?php endif; ?>
</header>


<!-- Menu déroulant pour les petits écrans -->
<div class="menu-dropdown" id="menuDropdown">
    <a href="controleurFrontal.php?action=afficherAccueil&controleur=page">ACCUEIL</a>
    <a href="controleurFrontal.php?action=afficherPecherieCettoise&controleur=page">LA PÊCHERIE CETTOISE</a>
    <a href="controleurFrontal.php?action=afficherProduits&controleur=page">NOS PRODUITS</a>
    <a href="controleurFrontal.php?action=afficherEngagements&controleur=page">NOS ENGAGEMENTS</a>
    <a href="controleurFrontal.php?action=afficherActualites&controleur=page">ACTUALITÉS</a>
    <a href="controleurFrontal.php?action=afficherCandidatures&controleur=page">CANDIDATURE</a>
    <a href="controleurFrontal.php?action=afficherContact&controleur=page">CONTACT</a>

    <?php if (ConnexionUtilisateur::estConnecte()) : ?>
        <a href="controleurFrontal.php?action=afficherBoutique&controleur=produit">BOUTIQUE</a>
    <?php endif; ?>
</div>

<div>
    <?php
    /** @var string[][] $messagesFlash */
    if (isset($messagesFlash)) {
        foreach ($messagesFlash as $type => $messagesFlashPourUnType) {
            foreach ($messagesFlashPourUnType as $messageFlash) {
                echo "
                <div class=\"alert alert-$type\">
                   $messageFlash
                </div>";
            }
        }
    }
    ?>
</div>

<style>
    .search-form {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 10px;
        background-color: #333;
    }

    .site-header {
        display: flex;
        flex-direction: row;
    }

    /* Styles du menu déroulant */
    .menu-dropdown {
        display: none;
        background-color: #333;
        position: absolute;
        top: 50px;
        left: 0;
        width: 100%;
        z-index: 1;
    }

    .menu-dropdown a {
        display: block;
        padding: 10px;
        color: white;
        text-decoration: none;
        text-align: left;
    }

    .menu-dropdown a:hover {
        color: #5e9dcf;
    }

    /* Icône du menu pour les petits écrans */
    .menu-icon {
        display: none;
        cursor: pointer;
        font-size: 30px;
        color: dodgerblue;
        padding: 10px;
    }

    /* Afficher le menu déroulant et l'icône sur petits écrans */
    @media (max-width: 768px) {
        .menu-icon {
            display: block;
        }

        .menu-dropdown.active {
            display: block;
        }
    }
</style>

<script>
    function toggleMenu() {
        var menu = document.getElementById("menuDropdown");
        menu.classList.toggle("active");
    }
</script>
