<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Lib\MotDePasse;
use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use App\Pecherie\Modele\HTTP\Session;
use App\Pecherie\Modele\Repository\UtilisateurRepository;


class ControleurUtilisateur extends ControleurGenerique
{

    public static function afficherProfil()
    {
        $utilisateur = UtilisateurRepository::getUtilisateurConnecte();
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $client = null;
        $nom = $utilisateur->getNom();
        $prenom = $utilisateur->getPrenom();
        $Role = $utilisateur->getRole();

        ControleurGenerique::afficherVue('vueGenerale.php',['titre' => "Profil","cheminCorpsVue" => 'utilisateur/profil.php', 'login' => $login, 'nom' => $nom, 'prenom' => $prenom, 'Role' => $Role, 'detailClient' => $client]);
    }



    /*public static function afficherFormulaireAjoutUtilisateur()
    {
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherFormulaireClassement&controleur=etudiant",
            "Profil" => "controleurFrontal.php?action=afficherProfil&controleur=utilisateur",
            "Ajouter utilisateur" => "#"
        );
        $Role = ['administrateur', 'profesionnel', 'particulier'];

        $universiteRepository = new UniversiteRepository();
        $universites = $universiteRepository->recuperer();

        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Ajouter un utilisateur",
            "cheminCorpsVue" => 'utilisateur/formulaireAjouterUtilisateur.php',
            'Role' => $Role,
            'universites' => $universites,
            'chemin' => $chemin,
        ]);
    }

    public static function afficherFormulaireSuppressionUtilisateur()
    {
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateurs = $utilisateurRepository->recuperer(); // Récupérer tous les utilisateurs

        // Récupérer le login de l'utilisateur connecté
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();

        // Filtrer pour exclure l'utilisateur connecté
        $utilisateurs = array_filter($utilisateurs, function ($utilisateur) use ($loginUtilisateurConnecte) {
            return $utilisateur->getLogin() !== $loginUtilisateurConnecte;
        });

        // Vérifier si des utilisateurs restants après le filtrage
        if (empty($utilisateurs)) {
            MessageFlash::ajouter("info", "Aucun utilisateur disponible pour suppression.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
            return;
        }
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherFormulaireClassement&controleur=etudiant",
            "Profil" => "controleurFrontal.php?action=afficherProfil&controleur=utilisateur",
            "Supprimer utilisateur" => "#"
        );

        // Passer les utilisateurs à la vue
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Supprimer un utilisateur",
            'cheminCorpsVue' => 'utilisateur/formulaireSuppressionUtilisateur.php',
            'utilisateurs' => $utilisateurs,// Assurez-vous de passer les utilisateurs à la vue
            'chemin' => $chemin,
        ]);
    }

    public static function supprimerUtilisateur()
    {
        // Récupération du login et mot de passe de l'utilisateur courant
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $motdepasseUtilisateurConnecte = $_POST['motdepasse'] ?? '';

        // Vérifier si le mot de passe de l'utilisateur connecté est correct
        $utilisateurConnecte = (new UtilisateurRepository())->recupererParClePrimaire($loginUtilisateurConnecte);

        // Vérifier si le mot de passe est correct
        if (MotDePasse::verifier($motdepasseUtilisateurConnecte, $utilisateurConnecte->getMdp())) {
            $loginSupp = $_POST['utilisateurs'] ?? [];

            if (!empty($loginSupp)) {
                foreach ($loginSupp as $login) {
                    UtilisateurRepository::supprimerLogin($login);
                }

                MessageFlash::ajouter("success", "Utilisateur supprimé avec succès");
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
            } else {
                MessageFlash::ajouter("info", "Aucun utilisateur sélectionné");
                ControleurGenerique::redirectionVersURL('controleur=utilisateur&action=afficherFormulaireSuppressionUtilisateur');
            }
        } else {
            MessageFlash::ajouter("danger", "Mot de passe incorrect. Veuillez réessayer.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireSuppressionUtilisateur&controleur=utilisateur');
        }


    }

    public static function ajouterUtilisateur()
    {
        // Récupération du login et mot de passe de l'utilisateur connecté
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $motdepasseAdmin = $_POST['motdepasseAdmin'] ?? '';

        // Récupération de l'utilisateur connecté
        $utilisateurConnecte = (new UtilisateurRepository())->recupererParClePrimaire($loginUtilisateurConnecte);

        // Vérification du mot de passe de l'utilisateur connecté
        if (!MotDePasse::verifier($motdepasseAdmin, $utilisateurConnecte->getMdp())) {
            MessageFlash::ajouter("danger", "Mot de passe admin incorrect. Vous ne pouvez pas ajouter d'utilisateur.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutUtilisateur&controleur=utilisateur');
        }

        // Récupérer les données du formulaire
        $login = $_POST['login'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $motdepasseNouveau = $_POST['motdepasseNouveau'];
        $confirmationMotDePasse = $_POST['confirmationMotDePasse'];
        $role = $_POST['Role'];

        // Vérification de la correspondance des mots de passe
        if ($motdepasseNouveau !== $confirmationMotDePasse) {
            MessageFlash::ajouter("danger", "Les mots de passe ne correspondent pas.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutUtilisateur&controleur=utilisateur');
            return;
        }

        // Validation du rôle
        if ($role === 'selection') {
            MessageFlash::ajouter("danger", "Veuillez sélectionner un rôle valide.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutUtilisateur&controleur=utilisateur');
            return;
        }


        // Création d'un objet Utilisateur
        $utilisateur = new Utilisateur(
            $nom,
            $prenom,
            MotDePasse::hacher($motdepasseNouveau),
            $login,
            $role,

        );

        // Ajout dans la base de données
        UtilisateurRepository::ajouter($utilisateur);

        // Confirmation et redirection
        MessageFlash::ajouter("success", "$role ajouté avec succès !");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');

    }*/


    public static function afficherFormulaireConnexion()
    {
        ControleurGenerique::afficherVue('/../Vue/formulaireLogin.php', ['titre' => "Connexion"]);
    }

    public static function verificationDuLogin(?string $mdp_en_clair, ?string $login) : array{
        $array = array(
            "login" => null,
            "role" => null
        );
        if ($login!= null && (new UtilisateurRepository())->recupererParClePrimaire($login) != null) {
            /** @var Utilisateur $utilisateur */
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
            $array["login"] = $utilisateur->getLogin();
            if (MotDePasse::verifier($mdp_en_clair, $utilisateur->getMdp())) {
                $array["role"] = $utilisateur->getRole();
            }
        }
        return $array;
    }

    public static function creeUtilisateur()
    {
        $utilisateur = new Utilisateur("hello","brb", MotDePasse::hacher("lol"), "bebe", "profesionnel");

        UtilisateurRepository::ajouter($utilisateur);
    }

    public static function deconnecter()
    {
        if (ConnexionUtilisateur::estConnecte()) {
            //ConnexionUtilisateur::deconnecter();
            Session::getInstance()->detruire();
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireConnexion');
        }
    }

    public static function construireDepuisFormulaire(): Utilisateur
    {
        // Récupération des valeurs depuis le formulaire
        $login = $_POST['login'] ?? null;
        $nom = $_POST['nom'] ?? null;
        $prenom = $_POST['prenom'] ?? null;
        $mdp = $_POST['motdepasse'] ?? null;

        // Gestion de la case à cocher "admin"
        $Role = $_POST['Role']; // Vérifie si la case est cochée


        // Création de l'objet Utilisateur avec les données du formulaire
        return new Utilisateur($nom, $prenom, MotDePasse::hacher($mdp), $login, $Role);
    }



    public static function changerDeMotDePasse() {
        // Récupération du login et mot de passe de l'utilisateur courant
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $motdepasseUtilisateurConnecte = $_POST['ancienMotDePasse'] ?? '';

        // Vérifier si le mot de passe de l'utilisateur connecté est correct
        $utilisateurConnecte = (new UtilisateurRepository())->recupererParClePrimaire($loginUtilisateurConnecte);

        // Vérifier si le mot de passe est correct
        if (MotDePasse::verifier($motdepasseUtilisateurConnecte, $utilisateurConnecte->getMdp())) {
            $newMDP = $_POST['nouveauMotDePasse'] ?? '';

            $isChanged = false;
            if (isset($newMDP) && $newMDP != '') {
                $isChanged = (new UtilisateurRepository())->setMotDePasse(MotDePasse::hacher($newMDP));
            }


        }

        if (isset($isChanged)) {
            if ($isChanged) {
                MessageFlash::ajouter("success", "Mot de passe modifié !");
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
            } else {
                MessageFlash::ajouter("warning", "Mot de passe inchangé !");
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireMDP&controleur=utilisateur');
            }
        } else {
            MessageFlash::ajouter("danger", "Mot de passe incorrect. Veuillez réessayer.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireMDP&controleur=utilisateur');
        }
    }

    public function afficherAccueil() {
        /* Récupérer les promotions
        $promotions = PageAccueil::getPromotions();*/
        // Inclure la vue d'accueil
        include __DIR__ . '/../../src/Vue/pageAccueil.php';
    }



}