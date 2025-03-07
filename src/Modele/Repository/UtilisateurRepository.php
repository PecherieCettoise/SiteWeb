<?php

namespace App\Pecherie\Modele\Repository;

use App\Pecherie\Lib\MotDePasse;
use App\Pecherie\Modele\Repository\AbstractRepository;
use App\Pecherie\Modele\DataObject\Utilisateur;
use App\Pecherie\Modele\DataObject\Clients;
use App\Pecherie\Modele\DataObject\AbstractDataObject;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use DateTime;
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
        return ["login", "nom", "mdp", "mdp_clair", "Role"];
    }

    public function formatTableauSQL(AbstractDataObject $utilisateur, int $i): array
    {
        return [
            'login' . $i => $utilisateur->getLogin(),
            'nom' . $i => $utilisateur->getNom(),
            'mdp' . $i => $utilisateur->getMdp(),
            "mdp_clair" . $i => $utilisateur->getMdpClair(),
            'Role' . $i => $utilisateur->getRole(),
        ];
    }

    public function formatTableauSQLUtilisateur(Utilisateur $utilisateur, int $i): array
    {
        return [
            'login' . $i => $utilisateur->getLogin(),
            'nom' . $i => $utilisateur->getNom(),
            'mdp' . $i => MotDePasse::hacher($utilisateur->getMdp()),
            'mdp_clair' . $i => $utilisateur->getMdpClair(),
            'Role' . $i => "utilisateur",
        ];
    }

    public static function construireDepuisTableauSQL(array $utilisateurFormatTableau): Utilisateur
    {
        return new Utilisateur(
            $utilisateurFormatTableau['nom'],
            $utilisateurFormatTableau['mdp'],
            $utilisateurFormatTableau['mdp_clair'],
            $utilisateurFormatTableau['login'],
            $utilisateurFormatTableau['Role']
        );
    }

    /**
     * PARTIE Utilisateur
     */

    // AJOUT

    public function creerRequete() : string {
        return "INSERT INTO utilisateurs (login, nom, mdp, mdp_clair, Role) VALUES";
    }

    public function ajouterValuesRequete(string $requeteSql, int $i) : string {
        if ($i == 1) {
            return $requeteSql . ' ((:login' . $i . '), (:nom' . $i . '), (:mdp' . $i . '), (:mdp_clair' . $i . '),  (:Role' . $i . '))';
        }
        return $requeteSql . ', ((:login' . $i . '), (:nom' . $i . '), (:mdp' . $i . '), (:mdp_clair' . $i . '),  (:Role' . $i . '))';
    }

    // Méthode pour créer un utilisateur professionnel de départ
    public static function creerUtilisateurPro(PDO $pdo, string $login, string $motDePasse, string $role = 'professionnel'): void {
        $motDePasseHache = MotDePasse::hacher($motDePasse);
        $requete = "INSERT INTO utilisateurs (login, nom, mdp, mdp_clair, Role) VALUES (:login, :nom, :mdp, :mdp_clair, :Role)";
        $stmt = $pdo->prepare($requete);

        // Valeurs par défaut pour l'utilisateur professionnel
        $values = [
            'login' => $login,
            'nom' => 'NomPro',  // Tu peux personnaliser ce champ
            'mdp' => $motDePasseHache,
            'mdp_clair' => $motDePasse,
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
        $sql = "INSERT INTO utilisateurs (login, mdp, mdp_clair, nom, Role) VALUES(:login, :mdp, :mdp_clair :nom, :Role)";
        $values = [
            'login' =>$utilisateur->getLogin(),
            'nom'  => $utilisateur->getNom(),
            'mdp' => $utilisateur->getMdp(),
            'mdp_clair' => $utilisateur->getMdpClair(),
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

    public function setMotDePasse(string $motDePasse) : bool
    {
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

    public function setLoginUtilisateur(string $nouveauLogin) : bool
    {
        // Récupérer le login de l'utilisateur connecté
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();

        // Préparer la requête SQL pour mettre à jour le login
        $sql = "UPDATE utilisateurs SET login = :nouveau_login WHERE login = :login;";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        // Valeurs à lier à la requête SQL
        $values = [
            'login' => $login,
            'nouveau_login' => $nouveauLogin
        ];

        // Exécution de la requête
        if ($pdoStatement->execute($values)) {
            error_log("Login mis à jour avec succès.");
            return true;
        } else {
            error_log("Erreur lors de la mise à jour du login.");
            return false;
        }
    }
}
