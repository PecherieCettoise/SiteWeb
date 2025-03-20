<?php

use App\Pecherie\Controleur\ControleurGenerique;
use App\Pecherie\Controleur\ControleurProduit;use App\Pecherie\Controleur\ControleurUtilisateur;
use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Lib\Psr4AutoloaderClass;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use App\Pecherie\Modele\HTTP\Session;


require_once __DIR__ . '/../Lib/Psr4AutoloaderClass.php';

// Initialisation de l'autoloader
$loader = new Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App\Pecherie', __DIR__ . '/../../src');


// Vérification de la classe Session
if (!class_exists(Session::class)) {
    die("Erreur: Impossible de charger la classe Session");
}

//ControleurUtilisateur::creeUtilisateur();
$session = Session::getInstance();  // Initialisation de la session

// Vérification de la connexion
if (isset($_POST['action']) && $_POST['action'] == 'connecter') {
    $mdp_en_clair = $_POST['motdepasse'] ?? null;
    $login = $_POST['login'] ?? null;

    $array = ControleurUtilisateur::verificationDuLogin($mdp_en_clair, $login);

    if ($array["login"] == null) {
        MessageFlash::ajouter("danger", "Cet utilisateur n'existe pas. Veuillez vous rapprocher du service commercial au 04 67 51 88 51.");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion');
    }
    if ($array["role"] == null) {
        MessageFlash::ajouter("danger", "Mot de passe incorrect. Veuillez réessayer.");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion');
    }

    ConnexionUtilisateur::connecter($array["login"], $array["role"]);
    ControleurGenerique::redirectionVersURL('controleurFrontal.php');
} elseif (isset($_GET['controleur']) && $_GET['controleur'] === 'page' && isset($_GET['action']) && $_GET['action'] === 'afficherLogin') {
    ControleurUtilisateur::afficherFormulaireConnexion();
} elseif (isset($_GET['user']) && $_GET['user'] == 'deconnecter') {
    ConnexionUtilisateur::deconnecter();
    ControleurUtilisateur::afficherFormulaireConnexion();
}elseif (isset($_GET['action']) && $_GET['action'] === 'afficherBoutique' && isset($_GET['controleur']) && $_GET['controleur'] === 'produit') {
    // Appeler la méthode afficherBoutique()
    $controleurProduit = new ControleurProduit();
    $controleurProduit->afficherBoutique();
} else {
    // Récupérer le contrôleur et l'action à partir de l'URL (par défaut 'page' et 'afficherAccueil')
    $controleur = $_GET['controleur'] ?? 'page';
    $action = $_GET['action'] ?? 'afficherAccueil';

    // Construire le nom de la classe du contrôleur
    $nomDeClasseControleur = 'App\\Pecherie\\Controleur\\Controleur' . ucfirst($controleur);

    // Vérifier si la classe du contrôleur existe
    if (class_exists($nomDeClasseControleur)) {
        $controleurInstance = new $nomDeClasseControleur();

        // Vérifier si l'action existe dans le contrôleur
        if (method_exists($controleurInstance, $action)) {
            // Appeler l'action correspondante
            $controleurInstance->$action();
        } else {
            // Si l'action n'existe pas, afficher une erreur
            ControleurGenerique::afficherErreur("Cette action n'existe pas", $controleur, $action);
            echo $action;
            echo $controleur;
        }
    } else {
        echo $nomDeClasseControleur;
        // Si le contrôleur n'existe pas, afficher une erreur
        ControleurGenerique::afficherErreur("Ce contrôleur n'existe pas", $controleur, $action);

    }
}
?>
