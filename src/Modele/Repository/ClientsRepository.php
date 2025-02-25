<?php

namespace App\Pecherie\Modele\Repository;

use App\Pecherie\Modele\DataObject\AbstractDataObject;
use App\Pecherie\Modele\DataObject\Clients;


class ClientsRepository extends AbstractRepository
{

    /**
     * @return string
     * Action : retourne le nom de la table
     */
    protected function getNomTable(): string { return "client"; }

    /**
     * @return string[]
     * Action : retourne le nom des clés primaires de la table étudiant
     */
    protected function getNomClePrimaire() : array { return array ("clientId", "code_nip"); }

    /**
     * @return string[]
     * Action : retourne le nom des colonnes de la table clients
     */
    protected function getNomColonnes() : array {
        return ["clientId", "code_nip","nom", "prenom"];
    }

    /**
     * @param AbstractDataObject $client
     * @param int $i
     * @return array
     * Action renvoie les données d'un objet étudiant sous forme de tableau
     */
    public function formatTableauSQL(AbstractDataObject $client, int $i): array
    {
        // Génére un tableau
        $v = [
            'etudId' . $i => $client->getClientId(),
            'code_nip' . $i => $client->getCodeNip(),
            'nom' . $i => $client->getNom(),
            'prenom' . $i => $client->getPrenom(),
        ];
        return $v;
    }

    /**
     * @param array $clientFormatTableau
     * @return Clients
     * Action : Construit un étudiant à l'aide de ses données brut
     */
    public static function construireDepuisTableauSQL(array $clientFormatTableau) : Clients {
        return new Clients(
            intval($clientFormatTableau['clientId']),        // clientId (int)
            (string) $clientFormatTableau['nom'],          // nom (string)
            (string) $clientFormatTableau['prenom'],       // prenom (string)
            intval($clientFormatTableau['code_nip']),      // code_nip (int)
        );
    }


    /**
     * PARTIE 1 : SUPPRESSION DANS LA BDD
     */

    /**
     * @param array $tab
     * @param mixed $id
     * @return bool
     * Cette méthode vérifie qu'un tableau de valeur contient bien un id
     */
    public function etudierContientClient(array $tab, mixed $id) : bool {
        foreach ($tab as $ligne) {
            /** @var Etudier $ligne */
            if ($ligne->getCodeNip() == $id)
                return true;
        }
        return false;
    }

    /**
     * @param string $nomClass1
     * @param string $nomClass2
     * @return void
     * Requete de verification des étudiants : suppression des etudiants qui apparaissent dans la table Etudiant mais pas dans la table Etudier après suppression de l'idPromo
     */
    public function supprimerClient() : void {
        // Récupération du contenu de chaqu table
        $tabEtudiants = (new ClientsRepository())->recuperer(); // tableau des étudiants de la BDD
        $tabEtudier = (new ClientsRepository())->recuperer(); // tableau des Etudier de la BDD
        // Préparation de la requête
        $compteurClient = 1;
        $sql = "DELETE FROM clients WHERE code_nip IN (";
        $valuesCodeNip = [];

        foreach ($tabEtudiants as $client) {

            /** @var Clients $client */
            $code_nip = $client->getCodeNip();
            $Utilise = (new ClientsRepository())->etudierContientClient($tabEtudier, $code_nip);

            if (!$Utilise) {
                $sql = AbstractRepository::ajouterValuesRequeteDelete('code_nip', $sql, $compteurClient);
                $valuesCodeNip = $valuesCodeNip + ['code_nip' . $compteurClient => $code_nip];
                $compteurClient++;
            }
        }
        AbstractRepository::executerRequeteDelete($sql, $valuesCodeNip);
    }


    /**
     * PARTIE 2 : RECUPERATION D'un CLIENT A PARTIR DE LA BASE DE DONNEES
     */



    public static function recupererClientParNom(string $nom) : ?Clients {
        $sql = "SELECT * from clients WHERE nom = :nom";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "nom" => $nom
        );
        $pdoStatement->execute($values);

        $clientFormatTableau = $pdoStatement->fetch();

        if (!$clientFormatTableau){
            return null;
        }
        return ClientsRepository::construireDepuisTableauSQL($clientFormatTableau);
    }


}