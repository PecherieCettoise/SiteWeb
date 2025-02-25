<?php

namespace App\Pecherie\Modele\Repository;

use App\Pecherie\Modele\DataObject\AbstractDataObject;


abstract class AbstractRepository {


    protected abstract function getNomTable(): string; // ex : etudiant
    protected abstract function getNomClePrimaire() : array; // ex : code_nip
    protected abstract function getNomColonnes() : array; // ex : etud_id code_nip nom pren//nom pseudo etc...
    protected static abstract function construireDepuisTableauSQL(array $objetFormatTableau) : AbstractDataObject;
    protected abstract function formatTableauSQL(AbstractDataObject $objet, int $i): array;

    /** PARTIE INSERTION DANS LA BDD */

    /**
     * Créer une requête sql à partir d'un AbstractDataObject courant dans la BDD
     */
    public function creerRequete(): string
    {
        // Récupère le nom de la table, les colonnes et la clé primaire
        $nomTable = $this->getNomTable();
        $colonnes = $this->getNomColonnes();

        // Génération des parties VALUES et ON DUPLICATE KEY UPDATE
        $columnsStr = join(', ', $colonnes);

        // Création de la requête SQL
        $sql = "INSERT INTO $nomTable ($columnsStr) VALUES";

        return $sql;
    }

    /**
     * Cette méthode ajoute la partie values à la requête sql
     * Exemple :(:loginTag1, :nomTag1, :prenomTag1)
     *
     * @param string $requeteSql
     * @param int $i : le i ème tuple ajouté à la requête
     * @return string : la requete sql de type "INSERT INTO nomTable (colonne1, colonne2, colonne3) VALUES (:colonne1, :colonne2, :colonne3), (:colonne1A, :colonne2A, :colonne3A), (:colonne1B, :colonne2B, :colonne3B)
     *
     */
    public function ajouterValuesRequete(string $requeteSql, int $i) : string {
        $colonnes = $this->getNomColonnes();

        // Créer la string de type "(:loginTag1, :nomTag1, :prenomTag1)"
        $separateur = $i .', :';
        $valuesStr = ':' . join($separateur, $colonnes) . $i;

        // Ajout de la string de type "(:loginTag1, :nomTag1, :prenomTag1)"
        if (str_ends_with($requeteSql, 'S')) {
            return $requeteSql . ' (' . $valuesStr . ')';
        }
        return $requeteSql . ', (' . $valuesStr . ')';
    }


    /**
     * @param AbstractDataObject $object
     * @param string $requeteSql
     * @return bool
     *  Cette méthode ajoute la dernière partie à la requête sql qui gère les duplications de tuples
     *  exp : ON DUPLICATE KEY UPDATE login=VALUES(login), nom=VALUES(nom), prenom=VALUES(prenom);
     */
    public function executerRequete(string $requeteSql, array $values): bool
    {
        // Récupère le nom de la table, les colonnes et la clé primaire
        $colonnes = $this->getNomColonnes();

        // Crée la string avec array_map et utilise array_filter pour en exclure la clé primaire pour l'update
        $updateStr = join(', ', array_map(function($col) { return "$col = VALUES($col)"; }, $colonnes /*array_filter($colonnes, fn($col) => !in_array($col, $clePrimaire))*/));

        // Création de la requête SQL avec ON DUPLICATE KEY UPDATE
        if ($updateStr == null || $this->getNomTable() == 'promotion') {
            $finRequeteSql = ";";
        } else {
            $finRequeteSql = " ON DUPLICATE KEY UPDATE $updateStr;";
        }

        // Retourne la requête complète
        $requeteSql = $requeteSql . $finRequeteSql;

        //   Vérification de la requête finale
//        echo '<br>Requête sql finale '. $this->getNomTable() . ' : <br>';
//        var_dump($requeteSql);
//        echo '<br>Tableau final ' . $this->getNomTable() . ' : <br>';
//        var_dump($values);

        if (empty($values)) {
            //echo '<br> Aucune valeurs insérées dans '. $this->getNomTable() . '<br>';
            return false;
        }
        // Execution
        return ConnexionBaseDeDonnees::getPdo()->prepare($requeteSql)->execute($values);
    }


    /** PARTIE RECUPERATION DANS LA BDD */

    /**
     * @return self[]
     * Fonction qui ne prend pas d’arguments et renvoie le tableau d’objets de la classe Utilisateur correspondant à la base de données.
     */
    public function recuperer() : array {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query('SELECT * FROM ' . $this->getNomTable() . ';');
        $listes = [];
        foreach ($pdoStatement as $element) {
            $listes[] = $this->construireDepuisTableauSQL($element);
        }
        return $listes;
    }

    /**
     * @return self[]
     * Fonction qui ne prend pas d’arguments et renvoie le tableau d’objets de la classe Utilisateur correspondant à la base de données.
     */
    public function recupererOrdre(string $ordreVoulue) : array {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query('SELECT * FROM ' . $this->getNomTable() . ' ORDER BY ' . $ordreVoulue . ";");
        $listes = [];
        foreach ($pdoStatement as $element) {
            $listes[] = $this->construireDepuisTableauSQL($element);
        }
        return $listes;
    }

    /** PARTIE SUPPRESSION DANS LA BDD */

    /**
     * Cette méthode ajoute la partie values à la requête sql
     * Exemple :(:loginTag1, :nomTag1, :prenomTag1)
     *
     * @param string $requeteSql
     * @param int $i : le i ème tuple ajouté à la requête
     * @return string : la requete sql de type "INSERT INTO nomTable (colonne1, colonne2, colonne3) VALUES (:colonne1, :colonne2, :colonne3), (:colonne1A, :colonne2A, :colonne3A), (:colonne1B, :colonne2B, :colonne3B)
     *
     */
    public static function ajouterValuesRequeteDelete(string $nomColonne, string $requeteSql, int $i) : string {
        // Créer la string de type "(:loginTag1, :nomTag1, :prenomTag1)"
        if ($i == 1) {
            $valuesStr = ':' . $nomColonne . $i;
        } else {
            $valuesStr = ', :' . $nomColonne . $i;
        }
        return $requeteSql . $valuesStr;
    }
    public static function executerRequeteDelete(string $requeteSql, array $values): bool
    {
        echo '<br><br>';
        $requeteSql = $requeteSql . ');';
        if (empty($values)) {
            //echo '<br> Aucune valeurs insérées dans ' . $this->getNomTable() . '<br>';
            return false;
        }
        // Execution
        return ConnexionBaseDeDonnees::getPdo()->prepare($requeteSql)->execute($values);
    }
}