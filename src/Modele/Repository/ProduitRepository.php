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
        return ["reference_article", "designation", "prixVente", "stock_reel", "stock_disponible", "stockATerme", "poids_Net", "PERMANENT"];
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
            'prixVente' . $i => $produit->getPrixVente(),
            'stock_reel' . $i => $produit->getStockReel(),
            'stock_disponible' . $i => $produit->getStockDisponible(),
            'stockATerme' . $i => $produit->getStockATerme(),
            'poids_Net' . $i => $produit->getPoidsNet(),
            'PERMANENT' . $i => $produit->getPermanent(),
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
            $objetFormatTableau['prixVente'],
            $objetFormatTableau['stock_reel'] ?? 0.0,         // ✅ Remplace NULL par 0.0
            $objetFormatTableau['stock_disponible'] ?? 0.0,      // ✅ Remplace NULL par 0.0
            $objetFormatTableau['stockATerme'] ?? 0.0,
            $objetFormatTableau['poids_Net'] ?? 0.0,  // ✅ Remplace NULL par 0.0
        $objetFormatTableau['PERMANENT'] ?? 0.0,
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
            $sql = "INSERT INTO produit (reference_article, designation, prixVente, stock_reel, stock_disponible, stockATerme, poids_Net, PERMANENT) 
                VALUES (:reference_article, :designation, :prixVente, :stock_reel, :stock_disponible, :stockATerme, :poids_Net, :PERMANENT)";

            $values = [
                "reference_article" => $produit->getReferenceArticle(),
                "designation" => $produit->getDesignation(),
                "prixVente" => $produit->getPrixVente(),
                "stock_reel" => $produit->getStockReel(),
                "stock_disponible" => $produit->getStockDisponible(),
                "stockATerme" => $produit->getStockATerme(),
                "poids_Net" => $produit->getPoidsNet(),
                "PERMANENT" => $produit->getPermanent(),
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
                prixVente = :prixVente, 
                stock_reel = :stock_reel, 
                stock_disponible = :stock_disponible, 
                stockATerme = :stockATerme, 
                poids_Net = :poids_Net,
                PERMANENT = :PERMANENT
            WHERE reference_article = :reference_article";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute([
            "reference_article" => $produit->getReferenceArticle(),
            "designation" => $produit->getDesignation(),
            "prixVente" => $produit->getPrixVente(),
            "stock_reel" => $produit->getStockReel(),
            "stock_disponible" => $produit->getStockDisponible(),
            "stockATerme" => $produit->getStockATerme(),
            "poids_Net" => $produit->getPoidsNet(),
            "PERMANENT" => $produit->getPermanent(),
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








}
?>