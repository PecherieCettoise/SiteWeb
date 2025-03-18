<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="../../ressources/css/style.css">
    <link rel="icon" href="../../ressources/images/acceuil/coquillageBleu.png" type="image/x-icon">
</head>

<?php /** @var $login */
/** @var $nom */
/** @var $prenom */
/** @var $Role */

use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\Repository\UtilisateurRepository;

$utilisateur = UtilisateurRepository::getUtilisateurConnecte();

?>


<style>
    /* Style spécifique pour la page de profil */
    .profil-container {
        width: 100%;
        max-width: 900px;
        margin: 30px auto;
        background-color: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    h1.h1-profil {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #444;
    }

    .toggle-label p {
        cursor: pointer;
        font-size: 1.3rem;
        font-weight: 600;
        color: #3498db;
        margin-top: 20px;
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .toggle-label p:hover {
        color: #2980b9;
    }

    .content {
        margin-top: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #ecf0f1;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .value {
        font-size: 1.1rem;
        font-style: italic;
        color: #7f8c8d;
    }

    button {
        background-color: #3498db;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        width: 100%;
        margin-top: 25px;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    button:hover {
        background-color: #2980b9;
    }

    button.rouge {
        background-color: #e74c3c;
    }

    button.rouge:hover {
        background-color: #c0392b;
    }

    button:focus {
        outline: none;
    }

    button:active {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    /* Responsiveness */
    @media screen and (max-width: 768px) {
        .profil-container {
            width: 90%;
            padding: 20px;
        }

        .h1-profil {
            font-size: 2rem;
        }

        .toggle-label p {
            font-size: 1.1rem;
        }

        .info-item {
            padding: 10px 0;
        }

        button {
            padding: 10px 15px;
            font-size: 1rem;
        }
    }

</style>

<div class="profil-container">
    <h1 class="h1-profil">Votre profil</h1>

        <label for="info-toggle" class="toggle-label"><p>Informations</p></label>
        <div class="content">
            <div class="info-item">
                <p class="label">Nom :</p>
                <p class="value"><?php echo htmlspecialchars($utilisateur->getNom()); ?></p>
            </div>
            <div class="info-item">
                <p class="label">Login :</p>
                <p class="value"><?php echo htmlspecialchars($utilisateur->getLogin()); ?></p>
            </div>
            <div class="info-item">
                <p class="label">Role :</p>
                <p class="value"><?php echo htmlspecialchars($utilisateur->getRole()); ?></p>
            </div>
        </div>



    <label  class="toggle-label"><p>Changer de mot de passe</p></label>
    <div class="content">
        <a href="controleurFrontal.php?action=afficherModifierMDP&controleur=utilisateur" id="profil-link"><button class="rouge">Changer de mot de passe</button></a>
    </div>

    <div class="content">
        <a href="controleurFrontal.php?action=afficherModifierLogin&controleur=utilisateur" id="profil-link"><button class="rouge">Changer le login</button></a>
    </div>


    <a href="controleurFrontal.php?controleur=utilisateur&action=deconnecter"><button>Déconnexion</button></a>
</div>


</html>

