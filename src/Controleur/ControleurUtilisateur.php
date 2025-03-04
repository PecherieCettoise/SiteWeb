<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Lib\MotDePasse;
use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use App\Pecherie\Modele\HTTP\Session;
use App\Pecherie\Modele\Repository\UtilisateurRepository;
use Exception;


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



    public static function afficherFormulaireAjoutUtilisateur()
    {
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAccueil&controleur=utilisateur",
            "Profil" => "controleurFrontal.php?action=afficherProfil&controleur=utilisateur",
            "Ajouter utilisateur" => "#"
        );
        $Role = ['administrateur', 'professionnel', 'particulier'];

        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Ajouter un utilisateur",
            "cheminCorpsVue" => 'utilisateur/formulaireAjoutUtilisateurs.php',
            'Role' => $Role,
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
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=page');
            return;
        }
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAcceuil&controleur=page",
            "Profil" => "controleurFrontal.php?action=afficherProfil&controleur=page",
            "Supprimer utilisateur" => "#"
        );

        // Passer les utilisateurs à la vue
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Supprimer un utilisateur",
            'cheminCorpsVue' => 'utilisateur/formulaireSupprimerUtilisateur.php',
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
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=page');
            } else {
                MessageFlash::ajouter("info", "Aucun utilisateur sélectionné");
                ControleurGenerique::redirectionVersURL('controleur=utilisateur&action=afficherFormulaireSupprimerUtilisateur');
            }
        } else {
            MessageFlash::ajouter("danger", "Mot de passe incorrect. Veuillez réessayer.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireSupprimerUtilisateur&controleur=utilisateur');
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
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjout&controleur=utilisateur');
            return;
        }

        // Récupération des données du formulaire
        $login = $_POST['login'] ?? null;
        $nom = $_POST['nom'] ?? null;
        $prenom = $_POST['prenom'] ?? null;
        $motdepasseNouveau = $_POST['motdepasseNouveau'] ?? null;
        $confirmationMotDePasse = $_POST['confirmationMotDePasse'] ?? null;
        $role = $_POST['Role'] ?? null;

        // Validation des champs du formulaire
        if (!$login || !$nom || !$prenom || !$motdepasseNouveau || !$confirmationMotDePasse || !$role || $role === 'selection') {
            MessageFlash::ajouter("danger", "Tous les champs doivent être remplis et un rôle valide doit être sélectionné.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjout&controleur=utilisateur');
            return;
        }

        // Vérification de la correspondance des mots de passe
        if ($motdepasseNouveau !== $confirmationMotDePasse) {
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjout&controleur=utilisateur');
            MessageFlash::ajouter("danger", "Les mots de passe ne correspondent pas.");

            return;
        }

        // Vérification si l'utilisateur existe déjà
        $utilisateurExist = (new UtilisateurRepository())->recupererParClePrimaire($login);
        if ($utilisateurExist) {
            MessageFlash::ajouter("danger", "Un utilisateur avec ce login existe déjà.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjout&controleur=utilisateur');
            return;
        }

        $rolesValides = ['particulier', 'professionnel', 'administrateur'];

        if (!in_array($role, $rolesValides)) {
            MessageFlash::ajouter("danger", "Rôle invalide sélectionné.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjout&controleur=utilisateur');
            return;
        }


        // Création d'un objet Utilisateur
        $utilisateur = new Utilisateur(
            $nom,
            $prenom,
            MotDePasse::hacher($motdepasseNouveau),
            $login,
            $role
        );

        try {
            // Ajout dans la base de données
            UtilisateurRepository::ajouter($utilisateur);
            MessageFlash::ajouter("success", "$role ajouté avec succès !");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
        } catch (Exception $e) {
            // En cas d'erreur d'ajout
            MessageFlash::ajouter("danger", "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjout&controleur=utilisateur');
        }
    }




    public static function afficherFormulaireConnexion()
    {
        ControleurGenerique::afficherVue('/../Vue/utilisateur/formulaireLogin.php', ['titre' => "Connexion"]);
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
        $utilisateur = new Utilisateur("Martinez","Corentin", MotDePasse::hacher("coco"), "corentin", "administrateur");

        UtilisateurRepository::ajouter($utilisateur);
    }

    public static function deconnecter()
    {
        if (ConnexionUtilisateur::estConnecte()) {
            //ConnexionUtilisateur::deconnecter();
            Session::getInstance()->detruire();
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireConnexion&controleur=utilisateur');
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
        // Récupérer le login de l'utilisateur connecté
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $motdepasseUtilisateurConnecte = $_POST['ancienMotDePasse'] ?? '';

        // Récupérer l'utilisateur dans la base de données
        $utilisateurConnecte = (new UtilisateurRepository())->recupererParClePrimaire($loginUtilisateurConnecte);

        // Vérifier si le mot de passe actuel est correct
        if (MotDePasse::verifier($motdepasseUtilisateurConnecte, $utilisateurConnecte->getMdp())) {
            // Nouveau mot de passe
            $newMDP = $_POST['nouveauMotDePasse'] ?? '';

            if (isset($newMDP) && $newMDP != '') {
                // Hacher le mot de passe avant de l'enregistrer
                $hashedMDP = MotDePasse::hacher($newMDP);

                // Mettre à jour le mot de passe dans la base de données
                $isChanged = (new UtilisateurRepository())->setMotDePasse($hashedMDP);

                // Vérifier si la mise à jour a été effectuée
                if ($isChanged) {
                    MessageFlash::ajouter("success", "Mot de passe modifié !");
                    ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
                    exit();  // Assure-toi d'utiliser exit pour stopper l'exécution du script
                } else {
                    MessageFlash::ajouter("warning", "Mot de passe inchangé !");
                    ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherModifierMDP&controleur=utilisateur');
                    exit();  // Assure-toi d'utiliser exit pour stopper l'exécution du script
                }
            }
        } else {
            MessageFlash::ajouter("danger", "Mot de passe incorrect. Veuillez réessayer.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherModifierMDP&controleur=utilisateur');
            exit();  // Assure-toi d'utiliser exit pour stopper l'exécution du script
        }
    }



    public function afficherModifierMDP() {
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAccueil&controleur=utilisateur",
            "Profil" => "controleurFrontal.php?action=afficherProfil&controleur=utilisateur",
            "Ajouter utilisateur" => "#"
        );

        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Ajouter un utilisateur",
            "cheminCorpsVue" => 'utilisateur/changementMDP.php',
            'chemin' => $chemin,
        ]);
    }

    /*public static function afficherModifierMDP() {
        include __DIR__ . '/../Vue/utilisateur/changementMDP.php';
    }

    public static function modifierMDP() {
        include __DIR__ . '/../Vue/utilisateur/formuDemande.php';
    }*/




}