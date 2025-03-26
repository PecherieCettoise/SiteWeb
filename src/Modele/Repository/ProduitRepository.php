<?php

namespace App\Pecherie\Modele\Repository;

use App\Pecherie\Modele\DataObject\AbstractDataObject;
use App\Pecherie\Modele\DataObject\Produit;
use App\Pecherie\Modele\Repository\ConnexionBaseDeDonnees;
use Exception;
use PDO;

class ProduitRepository extends AbstractRepository
{
    /**
     * @return string
     * Action : retourne le nom de la table
     */
    protected function getNomTable(): string {
        return "produit";
    }

    /**
     * @return string[]
     * Action : retourne le nom de la clé primaire de la table produits
     */
    protected function getNomClePrimaire(): array {
        return ["reference_article"];
    }

    /**
     * @return string[]
     * Action : retourne le nom des colonnes de la table produits
     */
    protected function getNomColonnes(): array {
        return ["reference_article", "designation", "parenthese", "PV_POISS", "MB_POISS", "PV_RESTO", "MB_RESTO", "PV_GD", "MB_GD"];
    }

    /**
     * @param AbstractDataObject $produit
     * @param int $i
     * @return array
     * Action : renvoie les données d'un objet produit sous forme de tableau pour SQL
     */
    public function formatTableauSQL(AbstractDataObject $produit, int $i): array
    {
        return [
            'reference_article' . $i => $produit->getReferenceArticle(),
            'designation' . $i => $produit->getDesignation(),
            'parenthese' . $i => $produit->getParenthese(),
            'PV_POISS' . $i => $produit->getPVPoiss(),
            'MB_POISS' . $i => $produit->getMBPoiss(),
            'PV_RESTO' . $i => $produit->getPVResto(),
            'MB_RESTO' . $i => $produit->getMBResto(),
            'PV_GD' . $i => $produit->getPVGD(),
            'MB_GD' . $i => $produit->getMBGD(),
        ];

    }

    /**
     * @param array $produitFormatTableau
     * @return Produit
     * Action : Construit un produit à partir d'un tableau SQL
     */
    protected static function construireDepuisTableauSQL(array $objetFormatTableau): Produit {
        return new Produit(
            $objetFormatTableau['reference_article'],
            $objetFormatTableau['designation'],
            $objetFormatTableau['parenthese'],
            $objetFormatTableau['PV_POISS'],
            $objetFormatTableau['MB_POISS'] ?? null,
            $objetFormatTableau['PV_RESTO'],
            $objetFormatTableau['MB_RESTO'] ?? null,
            $objetFormatTableau['PV_GD'],
            $objetFormatTableau['MB_GD'] ?? null
        );
    }


    /**
     * PARTIE 2 : RECUPERATION D'un PRODUIT A PARTIR DE LA BASE DE DONNEES
     */

    /**
     * @param string $designation
     * @return Produit|null
     * Action : Récupère un produit par sa désignation
     */
    public function recupererProduitParDesignation(string $designation): ?Produit
    {
        $sql = "SELECT * FROM produit WHERE designation = :designation";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute(["designation" => $designation]);

        $produitFormatTableau = $pdoStatement->fetch();

        return $produitFormatTableau ? ProduitRepository::construireDepuisTableauSQL($produitFormatTableau) : null;
    }



    public function recupererProduitParReference_article(int $reference_article): ?Produit
    {
        $sql = "SELECT * FROM produit WHERE reference_article = :reference_article";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute(["reference_article" => $reference_article]);

        $produitFormatTableau = $pdoStatement->fetch();

        return $produitFormatTableau ? ProduitRepository::construireDepuisTableauSQL($produitFormatTableau) : null;
    }



    public static function ajouterProd(Produit $produit): void {
        try {
            $sql = "INSERT INTO produit (reference_article, designation, parenthese, PV_POISS, MB_POISS, PV_RESTO, MB_RESTO, PV_GD, MB_GD) 
                    VALUES (:reference_article, :designation, :parenthese, :PV_POISS, :MB_POISS, :PV_RESTO, :MB_RESTO, :PV_GD, :MB_GD)";

            $values= [
                "reference_article" => $produit->getReferenceArticle(),
                "designation" => $produit->getDesignation(),
                "parenthese" => $produit->getParenthese(),
                "PV_POISS" => $produit->getPVPoiss(),
                "MB_POISS" => $produit->getMBPoiss(),
                "PV_RESTO" => $produit->getPVResto(),
                "MB_RESTO" => $produit->getMBResto(),
                "PV_GD" => $produit->getPVGD(),
                "MB_GD" => $produit->getMBGD(),
            ];

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $pdoStatement->execute($values);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout du produit : " . $e->getMessage());
        }
    }




    public static function modifierProduit(Produit $produit): void {
        $sql = "UPDATE produit SET 
                designation = :designation, 
                parenthese = :parenthese, 
                PV_POISS = :PV_POISS, 
                MB_POISS = :MB_POISS, 
                PV_RESTO = :PV_RESTO, 
                MB_RESTO = :MB_RESTO, 
                PV_GD = :PV_GD, 
                MB_GD = :MB_GD
            WHERE reference_article = :reference_article";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute([
            "reference_article" => $produit->getReferenceArticle(),
            "designation" => $produit->getDesignation(),
            "parenthese" => $produit->getParenthese(),
            "PV_POISS" => $produit->getPVPoiss(),
            "MB_POISS" => $produit->getMBPoiss(),
            "PV_RESTO" => $produit->getPVResto(),
            "MB_RESTO" => $produit->getMBResto(),
            "PV_GD" => $produit->getPVGD(),
            "MB_GD" => $produit->getMBGD(),
        ]);
    }

    public function supprimerProduit(int $reference_article): void {
        $sql = "DELETE FROM produit WHERE reference_article = :reference_article";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute(["reference_article" => $reference_article]);
    }

    public function recupererTousLesProduits(): array
    {
        $sql = "SELECT * FROM produit";  // Remplacez 'produit' par votre table réelle
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute();

        $produit = [];
        $produitsFormatTableau = $pdoStatement->fetchAll();

        foreach ($produitsFormatTableau as $produitFormat) {
            $produit[] = ProduitRepository::construireDepuisTableauSQL($produitFormat);
        }

        return $produit;
    }


    public function compterTousLesProduits() {
        $pdo = ConnexionBaseDeDonnees::getPDO();
        $stmt = $pdo->query("SELECT COUNT(*) FROM produit");
        return $stmt->fetchColumn();
    }

    public function compterProduitsPermanents() {
        $pdo = ConnexionBaseDeDonnees::getPDO();
        $stmt = $pdo->query("SELECT COUNT(*) FROM produit WHERE PERMANENT = 1 OR PERMANENT= 0 OR PERMANENT = 'OUI'");
        return $stmt->fetchColumn();
    }


    public function getProduitsParPage(int $offset, int $limit): array {
        $sql = "SELECT * FROM produit LIMIT :offset, :limit";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $pdoStatement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $pdoStatement->execute();

        $produits = [];
        $produitsFormatTableau = $pdoStatement->fetchAll();

        foreach ($produitsFormatTableau as $produitFormat) {
            $produits[] = ProduitRepository::construireDepuisTableauSQL($produitFormat);
        }

        return $produits;
    }











}
?>