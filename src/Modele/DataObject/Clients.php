<?php

namespace App\Pecherie\Modele\DataObject;

class Clients extends AbstractDataObject {

    private ?int $IDClient;
    private string $numero;
    private string $intitule;
    private string $categorie_tarifaire;
    private ?\DateTime $date_creation;
    private ?string $email;

    /**
     * Constructeur de la classe Clients
     *
     * @param int|null $IDClient
     * @param string $numero
     * @param string $intitule
     * @param string $categorie_tarifaire
     * @param \DateTime|null $date_creation
     * @param string|null $email
     */
    public function __construct(?int $IDClient, string $numero, string $intitule, string $categorie_tarifaire, ?\DateTime $date_creation = null, ?string $email = null)
    {
        $this->IDClient = $IDClient;
        $this->numero = $numero;
        $this->intitule = $intitule;
        $this->categorie_tarifaire = $categorie_tarifaire;
        $this->date_creation = $date_creation ?? new \DateTime();
        $this->email = $email;
    }

    // GETTERS ET SETTERS

    public function getIDClient(): ?int {
        return $this->IDClient;
    }

    public function setIDClient(?int $IDClient): void {
        $this->IDClient = $IDClient;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function setNumero(string $numero): void {
        $this->numero = $numero;
    }

    public function getIntitule(): string {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): void {
        $this->intitule = $intitule;
    }

    public function getCategorieTarifaire(): string {
        return $this->categorie_tarifaire;
    }

    public function setCategorieTarifaire(string $categorie_tarifaire): void {
        $this->categorie_tarifaire = $categorie_tarifaire;
    }

    public function getDateCreation(): ?\DateTime {
        return $this->date_creation;
    }

    public function setDateCreation(?\DateTime $date_creation): void {
        $this->date_creation = $date_creation;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }
}
?>
