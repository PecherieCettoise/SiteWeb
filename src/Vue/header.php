<?php use App\Pecherie\Modele\HTTP\ConnexionUtilisateur; ?>

<header class="site-header">
    <div class="header-logo">
        <a href="controleurFrontal.php?action=afficherAccueil&controleur=page">
            <img src="../../ressources/images/acceuil/logo.png" alt="Logo">
        </a>
    </div>

    <!-- Icône du menu déroulant pour les petits écrans -->
    <div class="menu-icon" onclick="toggleMenu()">☰</div>

    <!-- Menu principal -->
    <div class="header-bouton">
        <strong>
            <a href="controleurFrontal.php?controleur=page&action=afficherAccueil">ACCUEIL</a>
            <a href="controleurFrontal.php?controleur=page&action=afficherPecherieCettoise">LA PÊCHERIE CETTOISE</a>
            <a href="controleurFrontal.php?controleur=page&action=afficherProduits">NOS PRODUITS</a>
            <a href="controleurFrontal.php?controleur=page&action=afficherEngagements">NOS ENGAGEMENTS</a>
            <a href="controleurFrontal.php?controleur=page&action=afficherActualites">ACTUALITÉS</a>
            <a href="controleurFrontal.php?controleur=page&action=afficherCandidatures">CANDIDATURE</a>
            <a href="controleurFrontal.php?controleur=page&action=afficherContact">CONTACT</a>
            <?php if (ConnexionUtilisateur::estConnecte()) : ?>
                <a href="controleurFrontal.php?controleur=page&action=afficherBoutique">BOUTIQUE</a>
            <?php endif; ?>
        </strong>
    </div>

    <?php if (ConnexionUtilisateur::estConnecte()) : ?>
        <a href="controleurFrontal.php?controleur=page&action=afficherProfil">
            <img src="../../ressources/images/connexion/iconeConnecter.png" class="header-recherche">
        </a>
        <a href="controleurFrontal.php?action=deconnecter&controleur=utilisateur">DÉCONNEXION</a>
    <?php else : ?>
        <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion" class="header-recherche">
            <p>Se Connecter</p>
            <img src="../../ressources/images/connexion/iconeConnexion.png">
        </a>
    <?php endif; ?>
</header>

<!-- Menu déroulant pour les petits écrans -->
<div class="menu-dropdown" id="menuDropdown">
    <a href="controleurFrontal.php?controleur=page&action=afficherAccueil">ACCUEIL</a>
    <a href="controleurFrontal.php?controleur=page&action=afficherPecherieCettoise">LA PÊCHERIE CETTOISE</a>
    <a href="controleurFrontal.php?controleur=page&action=afficherProduits">NOS PRODUITS</a>
    <a href="controleurFrontal.php?controleur=page&action=afficherEngagements">NOS ENGAGEMENTS</a>
    <a href="controleurFrontal.php?controleur=page&action=afficherActualites">ACTUALITÉS</a>
    <a href="controleurFrontal.php?controleur=page&action=afficherCandidatures">CANDIDATURE</a>
    <a href="controleurFrontal.php?controleur=page&action=afficherContact">CONTACT</a>
    <?php if (ConnexionUtilisateur::estConnecte()) : ?>
        <a href="controleurFrontal.php?controleur=page&action=afficherBoutique">BOUTIQUE</a>
    <?php endif; ?>
</div>

<style>

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
        color: orangered;
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
        .header-bouton {
            display: none; /* Cache le menu principal */
        }

        .menu-icon {
            display: block; /* Affiche l'icône */
        }

        .menu-dropdown.active {
            display: block; /* Affiche le menu déroulant lorsque l'icône est cliquée */
        }
    }
</style>

<script>
    // Fonction pour afficher/masquer le menu déroulant
    function toggleMenu() {
        var menu = document.getElementById("menuDropdown");
        menu.classList.toggle("active");
    }
</script>
