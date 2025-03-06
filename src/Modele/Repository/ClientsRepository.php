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
        return "clients";
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
        return new Clients(
            intval($clientFormatTableau['IDClient']),
            (string) $clientFormatTableau['numero'],
            (string) $clientFormatTableau['intitule'],
            (string) $clientFormatTableau['categorie_tarifaire'],
            isset($clientFormatTableau['date_creation']) ? new \DateTime($clientFormatTableau['date_creation']) : null,
            $clientFormatTableau['email'] ?? null
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
}
?>
