<?php

namespace App\Pecherie\Modele\DataObject;

class Clients extends AbstractDataObject {

    private ?int $clientId;
    private ?string $nom;
    private ?string $prenom;
    private int $code_nip; //numClient

    // un constructeur

    /**
     * @param int|null $clientId
     * @param string|null $nom
     * @param string|null $prenom
     * @param int $code_nip

     */
    public function __construct(?int $clientId, ?string $nom, ?string $prenom, int $code_nip)
    {
        $this->clientId = null|$clientId;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->code_nip = $code_nip;
    }

    // GETTER ET SETTER
    public function getNom() : ?string {
        return $this->nom;
    }
    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    /**
     * @return int
     */
    public function getClientId() : ?int {
        return $this->clientId;
    }



    /**
     * @param int $clientId
     */
    public function setClientId(?int $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getPrenom() : ?string {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }

    public function getCodeNip(): int
    {
        return $this->code_nip;
    }

    public function setCodeNip(int $code_nip): void
    {
        $this->code_nip = $code_nip;
    }

}
?>