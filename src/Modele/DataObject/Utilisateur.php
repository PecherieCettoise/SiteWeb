<?php

namespace App\Pecherie\Modele\DataObject;


class Utilisateur extends AbstractDataObject {

    private ?string $nom;
    private string $mdp;
    private string $mdp_clair;
    private string $login;
    private string $Role;

    /**
     * @param string|null $nom
     * @param string $mdp
     * @param string $mdp_clair
     * @param string $login
     * @param string $Role
     */
    public function __construct(?string $nom, string $mdp, string $mdp_clair, string $login, string $Role)
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->mdp = $mdp;
        $this->mdp_clair = $mdp_clair;
        $this->Role = $Role;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(?string $mdp): void
    {
        $this->mdp = $mdp;
    }

    public function getMdpClair(): string
    {
        return $this->mdp_clair;
    }

    public function setMdpClair(string $mdp_clair): void
    {
        $this->mdp_clair = $mdp_clair;
    }


    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): void
    {
        $this->login = $login;
    }

    public function getRole() : ?string{
        return $this->Role;
    }

    public function setRole(string $Role): void{
        $this->Role = $Role;
    }

    public static function estProfessionnel($Role) : bool{
        return $Role === "professionnel";
    }

    public static function estParticulier($Role) : bool{
        return $Role === "particulier";
    }

    public static function estAdministrateur($Role) : bool{
        return $Role === "administrateur";
    }




}