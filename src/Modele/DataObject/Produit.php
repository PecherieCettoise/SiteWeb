<?php

namespace App\Pecherie\Modele\DataObject;

class Produit extends AbstractDataObject {
    private int $reference_article;
    private string $designation;
    private string $parenthese;
    private float $PV_POISS;
    private ?float $MB_POISS;
    private float $PV_RESTO;
    private ?float $MB_RESTO;
    private float $PV_GD;
    private ?float $MB_GD;

    /**
     * Constructeur de la classe Produit
     */
    public function __construct(
        int $reference_article,
        string $designation,
        string $parenthese,
        float $PV_POISS,
        ?float $MB_POISS,
        float $PV_RESTO,
        ?float $MB_RESTO,
        float $PV_GD,
        ?float $MB_GD
    ) {
        $this->reference_article = $reference_article;
        $this->designation = $designation;
        $this->parenthese = $parenthese;
        $this->PV_POISS = $PV_POISS;
        $this->MB_POISS = $MB_POISS;
        $this->PV_RESTO = $PV_RESTO;
        $this->MB_RESTO = $MB_RESTO;
        $this->PV_GD = $PV_GD;
        $this->MB_GD = $MB_GD;
    }

    // GETTERS ET SETTERS
    public function getReferenceArticle(): int {
        return $this->reference_article;
    }

    public function getDesignation(): string {
        return $this->designation;
    }

    public function getParenthese(): string {
        return $this->parenthese;
    }

    public function getPVPoiss(): float {
        return $this->PV_POISS;
    }

    public function getMBPoiss(): ?float {
        return $this->MB_POISS;
    }

    public function getPVResto(): float {
        return $this->PV_RESTO;
    }

    public function getMBResto(): ?float {
        return $this->MB_RESTO;
    }

    public function getPVGD(): float {
        return $this->PV_GD;
    }

    public function getMBGD(): ?float {
        return $this->MB_GD;
    }

    public function setReferenceArticle(int $reference_article): void {
        $this->reference_article = $reference_article;
    }

    public function setDesignation(string $designation): void {
        $this->designation = $designation;
    }

    public function setParenthese(string $parenthese): void {
        $this->parenthese = $parenthese;
    }

    public function setPVPoiss(float $PV_POISS): void {
        $this->PV_POISS = $PV_POISS;
    }

    public function setMBPoiss(?float $MB_POISS): void {
        $this->MB_POISS = $MB_POISS;
    }

    public function setPVResto(float $PV_RESTO): void {
        $this->PV_RESTO = $PV_RESTO;
    }

    public function setMBResto(?float $MB_RESTO): void {
        $this->MB_RESTO = $MB_RESTO;
    }

    public function setPVGD(float $PV_GD): void {
        $this->PV_GD = $PV_GD;
    }

    public function setMBGD(?float $MB_GD): void {
        $this->MB_GD = $MB_GD;
    }

}
