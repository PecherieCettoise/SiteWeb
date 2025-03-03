<?php use App\Pecherie\Modele\HTTP\ConnexionUtilisateur; ?>

<header class="site-header">
    <div class="header-logo">
        <a href="controleurFrontal.php?action=afficherAccueil&controleur=page">
            <img src="../../ressources/images/acceuil/logo.png" alt="Logo">
        </a>
    </div>

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

<?php

