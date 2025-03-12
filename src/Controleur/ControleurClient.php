<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Controleur\ControleurGenerique ;
use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Lib\MotDePasse;
use App\Pecherie\Modele\DataObject\Clients;
use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use App\Pecherie\Modele\Repository\ClientsRepository;
use App\Pecherie\Modele\Repository\UtilisateurRepository;
use Exception;


class ControleurClient extends ControleurGenerique {




    public static function afficherFormulaireCreation(): void {
        ControleurClient::afficherVue('vueGenerale.php', ["titre" => "Créer Client", "cheminCorpsVue" => "utilisateur/formulaireCreation.php"]);
    }

    public static function ajouterClient()
    {
        // Récupération du login et mot de passe de l'utilisateur connecté
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $motdepasseAdmin = $_POST['motdepasseAdmin'] ?? '';

        // Récupération de l'utilisateur connecté
        $utilisateurConnecte = (new UtilisateurRepository())->recupererParClePrimaire($loginUtilisateurConnecte);

        // Vérification du mot de passe de l'utilisateur connecté
        if (!MotDePasse::verifier($motdepasseAdmin, $utilisateurConnecte->getMdp())) {
            MessageFlash::ajouter("danger", "Mot de passe admin incorrect. Vous ne pouvez pas ajouter d'utilisateur.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
            return;
        }

        // Récupération des données du formulaire
        $intitule = $_POST['intitule'] ?? null;
        $categorieTarifaire = $_POST['categorie_tarifaire'] ?? null;
        $email = $_POST['email'] ?? null;
        $numero = $_POST['numero'] ?? null;
        $dateCreation = $_POST['date_creation'] ?? null;
        $role = $_POST['role'] ?? 'client'; // Rôle par défaut "client"

        // Validation des champs du formulaire
        if (!$intitule || !$categorieTarifaire || !$email || !$numero || !$role || $role === 'selection') {
            MessageFlash::ajouter("danger", "Tous les champs doivent être remplis et un rôle valide doit être sélectionné.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
            return;
        }

        // Vérification si un client existe déjà avec le même email ou numéro
        $clientExist = (new ClientsRepository())::recupererClientParEmailOuNumero($email, $numero);
        if ($clientExist) {
            MessageFlash::ajouter("danger", "Un client avec cet email ou numéro existe déjà.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
            return;
        }

        // Vérifier si une date de création a été donnée
        if ($dateCreation) {
            // Convertir la date depuis le format d/m/Y en objet DateTime
            $dateCreation = \DateTime::createFromFormat('d/m/Y', $dateCreation);
            if (!$dateCreation) {
                MessageFlash::ajouter("danger", "La date doit être au format jj/mm/aaaa.");
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
                return;
            }
        } else {
            // Si pas de date donnée, utiliser la date actuelle
            $dateCreation = new \DateTime();
        }

        // Création d'un objet Client
        $client = new Clients(
            null,
            $intitule,
            $categorieTarifaire,
            $dateCreation, // Assurez-vous que c'est un objet DateTime
            $email,
            $numero
        );

        try {
            // Ajout du client dans la base de données
            (new ClientsRepository())->ajouter($client);

            // Création de l'utilisateur associé à ce client
            $motdepasseUtilisateur = MotDePasse::genererChaineAleatoire(); // Méthode pour générer un mot de passe sécurisé
            $motdepasseHache = MotDePasse::hacher($motdepasseUtilisateur); // Hachage du mot de passe pour la sécurité

            // Création de l'objet Utilisateur
            $utilisateur = new Utilisateur(
                $numero,       // Login
                $intitule,     // Nom
                $motdepasseUtilisateur, // Mot de passe clair
                $motdepasseHache, // Mot de passe haché
                $role          // Rôle
            );


            // Ajout de l'utilisateur dans la base de données
            (new UtilisateurRepository())->ajouter($utilisateur);

            MessageFlash::ajouter("success", "Client et utilisateur ajoutés avec succès !");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
        } catch (Exception $e) {
            // En cas d'erreur d'ajout
            MessageFlash::ajouter("danger", "Erreur lors de l'ajout du client et/ou de l'utilisateur : " . $e->getMessage());
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
        }
    }


    public static function afficherFormulaireAjoutClient(){
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Ajouter un client",
            "cheminCorpsVue" => 'client/formulaireCreationClient.php',
        ]);
    }
}



?>