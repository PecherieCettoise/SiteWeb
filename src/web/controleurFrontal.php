<?php

require_once __DIR__ . '/../Lib/Psr4AutoloaderClass.php'; // chemin correct
require_once __DIR__ . '/../Modele/HTTP/Session.php';
require_once __DIR__ . '/../Lib/ConnexionUtilisateur.php';
require_once __DIR__ . '/../Controleur/ControleurUtilisateur.php';


$loader = new \App\Pecherie\Lib\Psr4AutoloaderClass(true);
$loader->register();
$loader->addNamespace('App\Pecherie', __DIR__ . '/../src');


// Utilisation des namespaces pour les classes
use App\Pecherie\Controleur\ControleurGenerique;
use App\Pecherie\Controleur\ControleurUtilisateur;
use App\Pecherie\Lib\ConnexionUtilisateur;
use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Modele\HTTP\Session;

// Démarrage de la session ou récupération de l'instance de la session
$session = Session::getInstance();

// Traitement du formulaire de connexion
if (isset($_POST['action']) && $_POST['action'] == 'connecter') {
    $mdp_en_clair = $_POST['motdepasse'] ?? null;
    $login = $_POST['login'] ?? null;

    // Vérification des informations de connexion
    $array = ControleurUtilisateur::verificationDuLogin($mdp_en_clair, $login);

    // Vérification de l'existence du login
    if ($array["login"] == null) {
        MessageFlash::ajouter("danger", "Cet utilisateur n'existe pas. Veuillez réessayer.");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion');
    }

    // Vérification du mot de passe
    if ($array["role"] == null) {
        MessageFlash::ajouter("danger", "Mot de passe incorrect. Veuillez réessayer.");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion');
    }

    // Connexion réussie
    ConnexionUtilisateur::connecter($array["login"], $array["role"]);

    // Message de succès
    MessageFlash::ajouter("success", "Connexion réussie");

    // Redirection vers la page d'accueil
    ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherpageAcceuil');
} elseif (!ConnexionUtilisateur::estConnecte()) {
    // Si l'utilisateur n'est pas connecté, afficher le formulaire de connexion
    ControleurUtilisateur::afficherFormulaireConnexion();
} elseif (isset($_GET['user']) && $_GET['user'] == 'deconnecter') {
    // Déconnexion de l'utilisateur
    ConnexionUtilisateur::deconnecter();
    ControleurUtilisateur::afficherFormulaireConnexion();
} else {
    // Récupérer le contrôleur et l'action demandée
    $controleur = $_POST['controleur'] ?? $_GET['controleur'] ?? $_COOKIE['preferenceControleur'] ?? 'utilisateur';
    $action = $_POST['action'] ?? $_GET['action'] ?? 'afficherProfil';

    // Charger et exécuter le contrôleur et l'action demandée
    $nomDeClasseControleur = 'App\Pecherie\Controleur\\' . ucfirst($controleur);

    if (class_exists($nomDeClasseControleur)) {
        $tabFonctions = get_class_methods($nomDeClasseControleur);
        if (in_array($action, $tabFonctions)) {
            // Vérifier que la méthode existe dans la classe
            $nomDeClasseControleur::$action(); // Appel de la méthode statique
        } else {
            ControleurGenerique::afficherErreur("Cette action n'existe pas", $controleur, $action);
        }
    } else {
        ControleurGenerique::afficherErreur("Ce contrôleur n'existe pas", $controleur, $action);
    }
}
?>
