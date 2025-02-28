<?php

namespace App\Pecherie\Modele\Repository;

use App\Pecherie\Lib\MotDePasse;
use App\Pecherie\Modele\Repository\AbstractRepository;
use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\DataObject\Clients;
use App\Pecherie\Modele\DataObject\AbstractDataObject;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use PDO;


class UtilisateurRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "utilisateurs";
    }

    public function getNomClePrimaire(): array
    {
        return array("login");
    }

    protected function getNomColonnes(): array
    {
        return ["login", "nom", "prenom", "mdp", "Role"];
    }

    public function formatTableauSQL(AbstractDataObject $utilisateur, int $i): array
    {
        return [
            'login' . $i => $utilisateur->getLogin(),
            'nom' . $i => $utilisateur->getNom(),
            'prenom' . $i => $utilisateur->getPrenom(),
            'mdp' . $i => $utilisateur->getMdp(),
            'Role' . $i => $utilisateur->getRole(),
        ];
    }

    public function formatTableauSQLUtilisateur(Clients $etudiant, int $i): array
    {
        return [
            'login' . $i => $etudiant->getClientId(),
            'nom' . $i => $etudiant->getNom(),
            'prenom' . $i => $etudiant->getPrenom(),
            'mdp' . $i => MotDePasse::hacher($etudiant->getCodeNip()),
            'Role' . $i => "client"
        ];
    }

    public static function construireDepuisTableauSQL(array $clientFormatTableau): Utilisateur
    {
        return new Utilisateur(
            $clientFormatTableau['nom'],
            $clientFormatTableau['prenom'],
            $clientFormatTableau['mdp'],
            $clientFormatTableau['login'],
            $clientFormatTableau['Role']
        );
    }


    /**
     * PARTIE Utilisateur
     */

    // AJOUT

    public function creerRequete() : string {
        return "INSERT INTO utilisateurs (login, nom, prenom, mdp, Role) VALUES";
    }

    public function ajouterValuesRequete(string $requeteSql, int $i) : string {
        if ($i == 1) {
            return $requeteSql . ' ((:login' . $i . '), (:nom' . $i . '), (:prenom' . $i . '), (:mdp' . $i . '), (:Role' . $i . '))';
        }
        return $requeteSql . ', ((:login' . $i . '), (:nom' . $i . '), (:prenom' . $i . '), (:mdp' . $i . '), (:Role' . $i . '))';
    }

    // Méthode pour créer un utilisateur professionnel de départ
    public static function creerUtilisateurPro(PDO $pdo, string $login, string $motDePasse, string $role = 'professionnel'): void {
        $motDePasseHache = MotDePasse::hacher($motDePasse);
        $requete = "INSERT INTO utilisateurs (login, nom, prenom, mdp, Role) VALUES (:login, :nom, :prenom, :mdp, :Role)";
        $stmt = $pdo->prepare($requete);

        // Valeurs par défaut pour l'utilisateur professionnel
        $values = [
            'login' => $login,
            'nom' => 'NomPro',  // Tu peux personnaliser ce champ
            'prenom' => 'PrenomPro',  // Tu peux personnaliser ce champ
            'mdp' => $motDePasseHache,
            'Role' => $role,
        ];

        $stmt->execute($values);
        echo "Utilisateur professionnel créé avec succès !";
    }

    public function recupererParClePrimaire(string $clePrimaire): ?Utilisateur
    {
        $sql = "SELECT * from " . $this->getNomTable() . " WHERE " . $this->getNomClePrimaire()[0] . " = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "loginTag" => $clePrimaire,
        );

        $pdoStatement->execute($values);

        $objetFormatTableau = $pdoStatement->fetch();
        if (!$objetFormatTableau) return null;
        return UtilisateurRepository::construireDepuisTableauSQL($objetFormatTableau);
    }

    public static function ajouter(Utilisateur $utilisateur){
        $sql = "INSERT INTO utilisateurs (login, mdp, nom, prenom, Role) VALUES(:login, :mdp, :nom, :prenom, :Role)";
        $values = [
            'login' =>$utilisateur->getLogin(),
            'nom'  => $utilisateur->getNom(),
            'prenom'  => $utilisateur->getPrenom(),
            'mdp' => $utilisateur->getMdp(),
            'Role' => $utilisateur->getRole(),
        ];
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
    }

    public static function supprimerLogin(string $login){
        $sql = "DELETE FROM utilisateurs WHERE login = :login";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute(['login' => $login]);
    }

    public static function getUtilisateurConnecte() : ?Utilisateur {
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $sql = "SELECT * FROM utilisateurs WHERE login = :login";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            'login' => $login,
        ];
        $pdoStatement->execute($values);
        $objetFormatTableau = $pdoStatement->fetch();

        if (!$objetFormatTableau) return null;

        return UtilisateurRepository::construireDepuisTableauSQL($objetFormatTableau);
    }

    public function setMotDePasse(string $motDePasse) : bool {
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $sql = "UPDATE utilisateurs SET mdp = :nouveau_mdp WHERE login = :login;";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            'login' => $login,
            'nouveau_mdp' => $motDePasse
        ];

        if ($pdoStatement->execute($values)) {
            error_log("Mot de passe mis à jour avec succès.");
            return true;
        } else {
            error_log("Erreur lors de la mise à jour du mot de passe.");
            return false;
        }
    }






}