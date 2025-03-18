<?php

namespace App\Pecherie\Modele\DataObject;

class Produit extends AbstractDataObject {

    private int $reference_article;
    private string $designation;
    private float $prixVente;
    private float $stock_reel;
    private float $stock_disponible;
    private ?float $stockATerme;
    private float $poids_Net;
    private ?string $PERMANENT;



    /**
     * Constructeur de la classe Produit
     *
     * @param int $reference_article
     * @param string $designation
     * @param float $prixVente
     * @param float $stock_reel
     * @param float $stock_disponible
     * @param float|null $stockATerme
     * @param float $poids_Net
     * @param string $PERMANENT
 */
    public function __construct(int $reference_article, string $designation, float $prixVente, float $stock_reel, float $stock_disponible, float $stockATerme , float $poids_Net, string $PERMANENT) {
        $this->reference_article =  $reference_article;
        $this->designation = $designation;
        $this->prixVente =  $prixVente;
        $this->stock_reel = $stock_reel;
        $this->stock_disponible =  $stock_disponible;
        $this->stockATerme = $stockATerme;
        $this->poids_Net =  $poids_Net;
        $this->PERMANENT =  $PERMANENT;

    }

    public function getPERMANENT(): ?string
    {
        return $this->PERMANENT;
    }

    public function setPERMANENT(?string $PERMANENT): void
    {
        $this->PERMANENT = $PERMANENT;
    }

    // GETTERS ET SETTERS

    public function getReferenceArticle(): int {
        return $this->reference_article;
    }

    public function setReferenceArticle(int $reference_article): void {
        $this->reference_article = (int) $reference_article;
    }

    public function getDesignation(): string {
        return $this->designation;
    }

    public function setDesignation(string $designation): void {
        $this->designation = trim($designation);
    }

    public function getPrixVente(): float {
        return $this->prixVente;
    }

    public function setPrixVente(float $prixVente): void {
        $this->prixVente = (float) $prixVente;
    }

    public function getStockReel(): float {
        return $this->stock_reel;
    }

    public function setStockReel(float $stock_reel): void {
        $this->stock_reel = (float) $stock_reel;
    }

    public function getStockDisponible(): float {
        return $this->stock_disponible;
    }

    public function setStockDisponible(float $stock_disponible): void {
        $this->stock_disponible = (float) $stock_disponible;
    }

    public function getPoidsNet(): float {
        return $this->poids_Net;
    }

    public function setPoidsNet(float $poids_Net): void {
        $this->poids_Net = (float) $poids_Net;
    }

    public function getStockATerme(): ?float {
        return $this->stockATerme;
    }

    public function setStockATerme(?float $stockATerme): void {
        $this->stockATerme = (int) $stockATerme;
    }
}
?>
