<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Controleur\ControleurGenerique ;
use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Lib\MotDePasse;
use App\Pecherie\Modele\DataObject\Clients;
use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use App\Pecherie\Modele\Repository\ClientsRepository;
use App\Pecherie\Modele\Repository\ConnexionBaseDeDonnees;
use App\Pecherie\Modele\Repository\UtilisateurRepository;
use Exception;


class ControleurClient extends ControleurGenerique {




    public static function afficherFormulaireCreation(): void {
        ControleurClient::afficherVue('vueGenerale.php', ["titre" => "Créer Client", "cheminCorpsVue" => "utilisateur/formulaireCreation.php"]);
    }

    public static function ajouterClient()
    {
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $motdepasseAdmin = $_POST['motdepasseAdmin'] ?? '';

        $utilisateurConnecte = (new UtilisateurRepository())->recupererParClePrimaire($loginUtilisateurConnecte);

        if (!$utilisateurConnecte || !MotDePasse::verifier($motdepasseAdmin, $utilisateurConnecte->getMdp())) {
            MessageFlash::ajouter("danger", "Mot de passe admin incorrect.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
            return;
        }

        $intitule = $_POST['intitule'] ?? null;
        $categorieTarifaire = $_POST['categorie_tarifaire'] ?? null;
        $email = $_POST['email'] ?? null;
        $numero = $_POST['numero'] ?? null;
        $dateCreation = $_POST['date_creation'] ?? null;
        $role = $_POST['role'] ?? 'client';

        if (!$intitule || !$categorieTarifaire || !$email || !$numero || !$role || $role === 'selection') {
            MessageFlash::ajouter("danger", "Tous les champs doivent être remplis.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
            return;
        }

        if ((new ClientsRepository())->recupererClientParEmailOuNumero($email, $numero)) {
            MessageFlash::ajouter("danger", "Un client avec cet email ou numéro existe déjà.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
            return;
        }

        $dateCreation = $dateCreation ? \DateTime::createFromFormat('d/m/Y', $dateCreation) : new \DateTime();
        if (!$dateCreation) {
            MessageFlash::ajouter("danger", "La date doit être au format jj/mm/aaaa.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
            return;
        }

        $client = new Clients(null, $intitule, $categorieTarifaire, $dateCreation, $email, $numero);

        try {
            (new ClientsRepository())->ajouter($client);
            $clientID = ConnexionBaseDeDonnees::getPdo()->lastInsertId();
            $clientID = (int)$clientID;

            if (!$clientID) {
                $clientID = (new ClientsRepository())->recupererClientParEmailOuNumero($email, $numero)?->getIDClient();
                $clientID = (int)$clientID;
            }

            if (!$clientID) {
                MessageFlash::ajouter("danger", "Erreur lors de la récupération de l'ID du client.");
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
                return;
            }

            $client->setIDClient($clientID);

            $motdepasseUtilisateur = MotDePasse::genererChaineAleatoire();
            $motdepasseHache = MotDePasse::hacher($motdepasseUtilisateur);

            $utilisateur = new Utilisateur(
                $intitule,
                $motdepasseHache,
                $motdepasseUtilisateur,
                $numero,
                $role,
                $clientID
            );

            (new UtilisateurRepository())->ajouter($utilisateur);

            MessageFlash::ajouter("success", "Client et utilisateur ajoutés avec succès !");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
        } catch (Exception $e) {
            MessageFlash::ajouter("danger", "Erreur lors de l'ajout : " . $e->getMessage());
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutClient&controleur=client');
        }
    }






    public static function afficherFormulaireAjoutClient(){
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Ajouter un client",
            "cheminCorpsVue" => 'client/formulaireCreationClient.php',
        ]);
    }


    public static function afficherTousLesClients()
    {
        // Récupérer tous les clients via le repository
        $clientRepository = new ClientsRepository();
        $clients = $clientRepository->recuperer(); // Méthode qui récupère tous les clients

        // Définir le chemin de la vue
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAcceuil&controleur=page",
            "Clients" => "controleurFrontal.php?action=afficherTousLesClients&controleur=client"
        );

        // Afficher la vue avec les clients récupérés
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Liste des clients",
            'cheminCorpsVue' => 'client/formulaireModificationClient.php', // Vue où seront affichés les clients
            'clients' => $clients,  // Passer les clients à la vue
            'chemin' => $chemin,
        ]);
    }

    public static function modifierClient()
    {
        // Vérifier si tous les champs sont bien envoyés
        if (!isset($_POST['IDClient'])) {
            MessageFlash::ajouter("danger", "Aucun client sélectionné.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesClients&controleur=client');
            return;
        }

        // Récupérer les données
        $idClient = intval($_POST['IDClient']);
        $intitule = htmlspecialchars($_POST['intitule']);
        $categorieTarifaire = htmlspecialchars($_POST['categorie_tarifaire']);
        $email = $_POST['email'];
        $numero = $_POST['numero'];

        // Récupérer le client existant
        $clientRepository = new ClientsRepository();
        $client = $clientRepository->recupererClientParIDClient($idClient);

        if (!$client) {
            MessageFlash::ajouter("danger", "Client introuvable.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesClients&controleur=client');
            return;
        }

        // Mise à jour des valeurs
        $client->setIntitule($intitule);
        $client->setCategorieTarifaire($categorieTarifaire);
        $client->setEmail($email);
        $client->setNumero($numero);

        try {
            // Mise à jour du client
            $clientRepository->modifierClient($client);
            MessageFlash::ajouter("success", "Client modifié avec succès !");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesClients&controleur=client');
        } catch (Exception $e) {
            MessageFlash::ajouter("danger", "Erreur lors de la modification du client : " . $e->getMessage());
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesClients&controleur=client');
        }
    }
}



?>