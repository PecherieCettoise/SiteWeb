<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Lib\MotDePasse;
use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use App\Pecherie\Modele\HTTP\Session;
use App\Pecherie\Modele\Repository\UtilisateurRepository;
use DateInterval;
use DateTime;
use Exception;


class ControleurUtilisateur extends ControleurGenerique
{

    public static function afficherProfil()
    {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Profil",
            "cheminCorpsVue" => 'utilisateur/profil.php',
        ]);
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
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
            return;
        }
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAcceuil&controleur=page",
            "Profil" => "controleurFrontal.php?action=afficherProfil&controleur=utilisateur",
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
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
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
        $motdepasseNouveau = $_POST['motdepasseNouveau'] ?? null;
        $confirmationMotDePasse = $_POST['confirmationMotDePasse'] ?? null;
        $role = $_POST['Role'] ?? null;

        // Validation des champs du formulaire
        if (!$login || !$nom || !$motdepasseNouveau || !$confirmationMotDePasse || !$role || $role === 'selection') {
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
        $utilisateur = new Utilisateur("Martinez", MotDePasse::hacher("coco"), "coco", "corentin", "administrateur");

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
        $mdp = $_POST['motdepasse'] ?? null;
        $mdpClair = $_POST['motdepasseClair'] ?? null;

        // Gestion de la case à cocher "admin"
        $Role = $_POST['Role']; // Vérifie si la case est cochée


        // Création de l'objet Utilisateur avec les données du formulaire
        return new Utilisateur($nom, MotDePasse::hacher($mdp), $mdpClair, $login, $Role);
    }



    public static function changerDeMotDePasse() {
        // Récupérer le login de l'utilisateur connecté
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();

        // Récupérer les mots de passe du formulaire
        $newMDP = $_POST['nouveauMotDePasse'] ?? '';
        $confirmeMDP = $_POST['confirmationMotDePasse'] ?? '';

        // Vérifier si les mots de passe sont identiques
        if ($newMDP !== $confirmeMDP) {
            MessageFlash::ajouter("danger", "Les mots de passe ne correspondent pas. Veuillez réessayer.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherModifierMDP&controleur=utilisateur');
            exit();  // Assure-toi d'utiliser exit pour stopper l'exécution du script
        }

        // Vérifier que le nouveau mot de passe est bien renseigné
        if (empty($newMDP)) {
            MessageFlash::ajouter("danger", "Veuillez entrer un nouveau mot de passe.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherModifierMDP&controleur=utilisateur');
            exit();
        }

        // Hacher le mot de passe avant de l'enregistrer
        $hashedMDP = MotDePasse::hacher($newMDP);

        // Mettre à jour le mot de passe dans la base de données
        $isChanged = (new UtilisateurRepository())->setMotDePasse($hashedMDP);
        //(new UtilisateurRepository())->setMotDePasse($newMDP);

        // Vérifier si la mise à jour a été effectuée
        if ($isChanged) {
            MessageFlash::ajouter("success", "Mot de passe modifié !");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
        } else {
            MessageFlash::ajouter("warning", "Mot de passe inchangé !");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherModifierMDP&controleur=utilisateur');
        }
        exit();  // Assure-toi d'utiliser exit pour stopper l'exécution du script
    }




    public function afficherModifierMDP() {
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAccueil&controleur=utilisateur",
            "Profil" => "controleurFrontal.php?action=afficherProfil&controleur=utilisateur",
            "Ajouter utilisateur" => "#"
        );

        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Modifier votre mot de passe",
            "cheminCorpsVue" => 'utilisateur/changementMDP.php',
            'chemin' => $chemin,
        ]);
    }

    public static function changerLogin() {
        // Récupérer le login de l'utilisateur connecté
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();

        // Récupérer les logins du formulaire
        $newLogin = $_POST['nouveauLogin'] ?? '';
        $confirmeLogin = $_POST['confirmationLogin'] ?? '';

        // Vérifier si les logins sont identiques
        if ($newLogin !== $confirmeLogin) {
            MessageFlash::ajouter("danger", "Les logins ne correspondent pas. Veuillez réessayer.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherModifierLogin&controleur=utilisateur');
            exit();
        }

        // Vérifier que le nouveau login est bien renseigné
        if (empty($newLogin)) {
            MessageFlash::ajouter("danger", "Veuillez entrer un nouveau login.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherModifierLogin&controleur=utilisateur');
            exit();
        }

        // Mettre à jour le login dans la base de données
        $isChanged = (new UtilisateurRepository())->setLoginUtilisateur($newLogin);

        // Vérifier si la mise à jour a été effectuée
        if ($isChanged) {
            // Réinitialiser ou mettre à jour la session avec le nouveau login
            $_SESSION['login'] = $newLogin;

            // Déconnecter l'utilisateur de la session (fin de la session actuelle)
            session_unset();  // Retirer toutes les variables de session
            session_destroy(); // Détruire la session

            // Rediriger l'utilisateur vers la page de connexion
            MessageFlash::ajouter("success", "Login modifié ! Vous devez vous reconnecter.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireConnexion&controleur=utilisateur');
        } else {
            MessageFlash::ajouter("warning", "Login inchangé !");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherModifierLogin&controleur=utilisateur');
        }
        exit();
    }



    public function afficherModifierLogin() {
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAccueil&controleur=utilisateur",
            "Profil" => "controleurFrontal.php?action=afficherProfil&controleur=utilisateur",
            "Ajouter utilisateur" => "#"
        );

        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Modifier votre login",
            "cheminCorpsVue" => 'utilisateur/changementLogin.php',
            'chemin' => $chemin,
        ]);
    }

    public static function modifierMDP() {
        include __DIR__ . '/../Vue/utilisateur/formulaireDemande.php';
    }


    public static function afficherFormulaireDemande() {
        ControleurGenerique::afficherVue("vueGenerale.php", [
            'titre' => "Formulaire de demande",
            "chemin" => "utilisateur/formulaireDemande.php",
        ]);
    }

    public static function traiterDemandeReinitialisation()
    {
        // Récupérer l'email du formulaire
        $email = $_POST['email'] ?? '';

        // Vérifier si l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            MessageFlash::ajouter("danger", "L'adresse email n'est pas valide.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireDemande&controleur=utilisateur');
            return;
        }

        // Récupérer l'utilisateur en fonction de l'email
        $utilisateur = (new UtilisateurRepository())->recupererParEmail($email);
        if (!$utilisateur) {
            MessageFlash::ajouter("danger", "Aucun utilisateur trouvé avec cet email.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireDemande&controleur=utilisateur');
            return;
        }

        // Générer un token unique pour la réinitialisation
        $token = bin2hex(random_bytes(32)); // Génère un token aléatoire
        $expiration = new DateTime();
        $expiration->add(new DateInterval('PT20M')); // Lien valide pendant 20 minutes

        // Enregistrer le token et son expiration dans la base de données
        (new UtilisateurRepository())->enregistrerTokenDeReinitialisation($utilisateur->getLogin(), $token, $expiration);

        // Créer le lien de réinitialisation
        $lien = "http://votresite.com/reinitialiser-mot-de-passe?token=$token";

        // Envoyer l'email
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $lien";
        mail($email, $subject, $message);

        // Confirmation à l'utilisateur
        MessageFlash::ajouter("success", "Un email de réinitialisation a été envoyé.");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireConnexion&controleur=utilisateur');
    }

    public static function afficherFormulaireReinitialisation()
    {
        $token = $_GET['token'] ?? '';

        // Vérifier si le token est valide
        if (empty($token) || !self::verifierToken($token)) {
            MessageFlash::ajouter("danger", "Le lien est invalide ou a expiré.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireDemande&controleur=utilisateur');
            return;
        }

        // Afficher le formulaire de réinitialisation
        ControleurGenerique::afficherVue("vueGenerale.php", [
            'titre' => "Réinitialiser votre mot de passe",
            "chemin" => "utilisateur/formulaireReinitialisation.php",
            'token' => $token
        ]);
    }

    public static function traiterReinitialisation()
    {
        $token = $_POST['token'] ?? '';
        $nouveauMotDePasse = $_POST['nouveauMotDePasse'] ?? '';
        $confirmationMotDePasse = $_POST['confirmationMotDePasse'] ?? '';

        // Vérifier que les mots de passe correspondent
        if ($nouveauMotDePasse !== $confirmationMotDePasse) {
            MessageFlash::ajouter("danger", "Les mots de passe ne correspondent pas.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireReinitialisation&controleur=utilisateur&token=' . $token);
            return;
        }

        // Vérifier si le token est valide
        if (!self::verifierToken($token)) {
            MessageFlash::ajouter("danger", "Le lien est invalide ou a expiré.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireDemande&controleur=utilisateur');
            return;
        }

        // Récupérer l'utilisateur correspondant au token
        $utilisateur = (new UtilisateurRepository())->recupererParToken($token);
        if (!$utilisateur) {
            MessageFlash::ajouter("danger", "Aucun utilisateur trouvé pour ce token.");
            return;
        }

        // Hacher le nouveau mot de passe
        $hashedPassword = MotDePasse::hacher($nouveauMotDePasse);

        // Mettre à jour le mot de passe dans la base de données
        (new UtilisateurRepository())->changerMotDePasse($utilisateur->getLogin(), $hashedPassword);

        // Supprimer le token après utilisation
        (new UtilisateurRepository())->supprimerToken($token);

        MessageFlash::ajouter("success", "Votre mot de passe a été réinitialisé avec succès.");
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireConnexion&controleur=utilisateur');
    }

    public static function verifierToken($token)
    {
        $tokenData = (new UtilisateurRepository())->recupererToken($token);

        if (!$tokenData) {
            return false; // Le token n'existe pas
        }

        $expiration = new DateTime($tokenData['expiration']);
        if ($expiration < new DateTime()) {
            return false; // Le token a expiré
        }

        return true;
    }










}