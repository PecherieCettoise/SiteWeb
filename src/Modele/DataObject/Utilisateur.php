<?php
namespace App\Pecherie\Modele\DataObject;


use App\Pecherie\Modele\DataObject\AbstractDataObject;

class Utilisateur extends AbstractDataObject {

    private ?string $nom;
    private ?string $prenom;
    private string $mdp;
    private string $login;
    private string $Role;

    /**
     * @param string|null $nom
     * @param string|null $prenom
     * @param string $mdp
     * @param string $login
     * @param string $Role
     */
    public function __construct(?string $nom, ?string $prenom, string $mdp, string $login, string $Role)
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdp = $mdp;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(?string $mdp): void
    {
        $this->mdp = $mdp;
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

    public static function estProfesionnel($Role) : bool{
        return $Role === "profesionnel";
    }

    public static function estParticulier($Role) : bool{
        return $Role === "particulier";
    }




}