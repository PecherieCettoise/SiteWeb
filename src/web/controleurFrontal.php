<?php

use App\Pecherie\Controleur\ControleurGenerique;
use App\Pecherie\Controleur\ControleurUtilisateur;
use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Lib\Psr4AutoloaderClass;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use App\Pecherie\Modele\HTTP\Session;


require_once __DIR__ . '/../Lib/Psr4AutoloaderClass.php';



// Vérification de l'existence du fichier Session.php
$sessionFile = __DIR__ . '/../../src/Modele/HTTP/Session.php';

if (!file_exists($sessionFile) || !is_readable($sessionFile)) {
    die("Erreur: Le fichier Session.php est introuvable ou illisible à l'emplacement: $sessionFile");
}

$loader = new Psr4AutoloaderClass();
$loader->register();

$loader->addNamespace('App\Pecherie', __DIR__ . '/../../src');


if (!class_exists(Session::class)) {
    die("Erreur: Impossible de charger la classe Session");
}

// Démarrage de la session ou récupération de l'instance de la session
$session = Session::getInstance();

// Traitement du formulaire de connexion
if (isset($_POST['action']) && $_POST['action'] == 'connecter') {
    $mdp_en_clair = $_POST['motdepasse'] ?? null;
    $login = $_POST['login'] ?? null;

    $array = ControleurUtilisateur::verificationDuLogin($mdp_en_clair, $login);

    if ($array['login'] === null) {
        MessageFlash::ajouter("danger", "Cet utilisateur n'existe pas. Veuillez réessayer.");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion');
    }

    if ($array['role'] === null) {
        MessageFlash::ajouter("danger", "Mot de passe incorrect. Veuillez réessayer.");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion');
    }

    ConnexionUtilisateur::connecter($array['login'], $array['role']);
    MessageFlash::ajouter("success", "Connexion réussie");
    ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherpageAcceuil');

} elseif (!ConnexionUtilisateur::estConnecte()) {
    ControleurUtilisateur::afficherFormulaireConnexion();

} elseif (isset($_GET['user']) && $_GET['user'] == 'deconnecter') {
    ConnexionUtilisateur::deconnecter();
    ControleurUtilisateur::afficherFormulaireConnexion();

} else {
    $controleur = $_POST['controleur'] ?? $_GET['controleur'] ?? $_COOKIE['preferenceControleur'] ?? 'utilisateur';
    $action = $_POST['action'] ?? $_GET['action'] ?? 'afficherProfil';

    $nomDeClasseControleur = 'App\\Pecherie\\Controleur\\' . ucfirst($controleur);

    if (class_exists($nomDeClasseControleur)) {
        $tabFonctions = get_class_methods($nomDeClasseControleur);
        if (in_array($action, $tabFonctions)) {
            $nomDeClasseControleur::$action();
        } else {
            ControleurGenerique::afficherErreur("Cette action n'existe pas", $controleur, $action);
        }
    } else {
        ControleurGenerique::afficherErreur("Ce contrôleur n'existe pas", $controleur, $action);
    }
}
