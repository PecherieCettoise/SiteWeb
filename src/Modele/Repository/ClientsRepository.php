<?php

namespace App\Pecherie\Modele\Repository;

use App\Pecherie\Modele\DataObject\AbstractDataObject;
use App\Pecherie\Modele\DataObject\Clients;
use App\Pecherie\Modele\Repository\ConnexionBaseDeDonnees;

class ClientsRepository extends AbstractRepository
{
    /**
     * @return string
     * Action : retourne le nom de la table
     */
    protected function getNomTable(): string {
        return "client";
    }

    /**
     * @return string[]
     * Action : retourne le nom de la clé primaire de la table clients
     */
    protected function getNomClePrimaire(): array {
        return ["IDClient"];
    }

    /**
     * @return string[]
     * Action : retourne le nom des colonnes de la table clients
     */
    protected function getNomColonnes(): array {
        return ["IDClient", "numero", "intitule", "categorie_tarifaire", "date_creation", "email"];
    }

    /**
     * @param AbstractDataObject $client
     * @param int $i
     * @return array
     * Action : renvoie les données d'un objet client sous forme de tableau pour SQL
     */
    public function formatTableauSQL(AbstractDataObject $client, int $i): array
    {
        return [
            'IDClient' . $i => $client->getIDClient(),
            'numero' . $i => $client->getNumero(),
            'intitule' . $i => $client->getIntitule(),
            'categorie_tarifaire' . $i => $client->getCategorieTarifaire(),
            'date_creation' . $i => $client->getDateCreation()?->format('Y-m-d H:i:s'),
            'email' . $i => $client->getEmail()
        ];
    }

    /**
     * @param array $clientFormatTableau
     * @return Clients
     * Action : Construit un client à partir d'un tableau SQL
     */
    public static function construireDepuisTableauSQL(array $clientFormatTableau): Clients
    {
        // Conversion de la chaîne de caractères en objet DateTime si nécessaire
        $dateCreation = isset($clientFormatTableau['date_creation']) ? new \DateTime($clientFormatTableau['date_creation']) : null;

        return new Clients(
            intval($clientFormatTableau['IDClient']),
            (string) $clientFormatTableau['intitule'],
            (string) $clientFormatTableau['categorie_tarifaire'],
            $dateCreation,
            $clientFormatTableau['email'] ?? '', // Utilisation d'une chaîne vide si l'email est null
            (string) $clientFormatTableau['numero'],
        );
    }



    /**
     * PARTIE 2 : RECUPERATION D'un CLIENT A PARTIR DE LA BASE DE DONNEES
     */

    /**
     * @param string $intitule
     * @return Clients|null
     * Action : Récupère un client par son intitule
     */
    public static function recupererClientParIntitule(string $intitule): ?Clients
    {
        $sql = "SELECT * FROM client WHERE intitule = :intitule";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute(["intitule" => $intitule]);

        $clientFormatTableau = $pdoStatement->fetch();

        return $clientFormatTableau ? ClientsRepository::construireDepuisTableauSQL($clientFormatTableau) : null;
    }


    /**
     * @param string $intitule
     * @return Clients|null
     * Action : Récupère un client par son intitule
     */
    public function recupererClientParIDClient(string $IDClient): ?Clients
    {
        $sql = "SELECT * FROM client WHERE IDClient = :IDClient";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute(["IDClient" => $IDClient]);

        $clientFormatTableau = $pdoStatement->fetch();

        return $clientFormatTableau ? ClientsRepository::construireDepuisTableauSQL($clientFormatTableau) : null;
    }



    /**
     * @param string $email
     * @param string $numero
     * @return Clients|null
     * Action : Récupère un client par son email ou son numéro
     */
    public static function recupererClientParEmailOuNumero(string $email, string $numero): ?Clients
    {
        $sql = "SELECT * FROM client WHERE email = :email OR numero = :numero";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute([
            "email" => $email,
            "numero" => $numero
        ]);

        $clientFormatTableau = $pdoStatement->fetch();

        return $clientFormatTableau ? ClientsRepository::construireDepuisTableauSQL($clientFormatTableau) : null;
    }



    /**
     * @param Clients $client
     * @return void
     * Action : Ajoute un client dans la base de données
     */
    public function ajouter(Clients $client): void
    {
        // Préparation de la requête SQL d'insertion
        $sql = "INSERT INTO client (numero, intitule, categorie_tarifaire, date_creation, email) 
            VALUES (:numero, :intitule, :categorie_tarifaire, :date_creation, :email)";

        // Préparation de la requête avec PDO
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        // Exécution de la requête avec les données du client
        $pdoStatement->execute([
            "numero" => $client->getNumero(),
            "intitule" => $client->getIntitule(),
            "categorie_tarifaire" => $client->getCategorieTarifaire(),
            "date_creation" => $client->getDateCreation()->format('Y-m-d H:i:s'),
            "email" => $client->getEmail()
        ]);
    }

    public function modifierClient(Clients $client): void {
        // Préparation de la requête SQL pour la mise à jour du client
        $sql = "UPDATE client SET 
            intitule = :intitule, 
            categorie_tarifaire = :categorie_tarifaire, 
            date_creation = :date_creation, 
            email = :email, 
            numero = :numero
        WHERE IDClient = :IDClient";

        // Préparation de la requête avec la connexion PDO
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        // Exécution de la requête avec les données du client
        $pdoStatement->execute([
            "IDClient" => $client->getIDClient(),
            "intitule" => $client->getIntitule(),
            "categorie_tarifaire" => $client->getCategorieTarifaire(),
            "date_creation" => $client->getDateCreation()->format('Y-m-d'), // Assurez-vous de convertir la date au format approprié
            "email" => $client->getEmail(),
            "numero" => $client->getNumero()
        ]);
    }

    public function recupererDernierClientID() {
        $stmt = ConnexionBaseDeDonnees::getPdo()->query("SELECT LAST_INSERT_ID()");
        return $stmt->fetchColumn();
    }











}
?>
