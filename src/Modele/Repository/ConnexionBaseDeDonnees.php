<?php
namespace App\Pecherie\Modele\Repository;

use App\Pecherie\Configuration\ConfigurationBaseDeDonnees;
use PDO;
use PDOException;

class ConnexionBaseDeDonnees {
    private static ?ConnexionBaseDeDonnees $instance = null;
    private PDO $pdo;

    public static function getPdo(): PDO {
        return self::getInstance()->pdo;
    }

    // Constructeur privé pour empêcher l'instanciation multiple
    private function __construct() {
        try {
            $nomHote = ConfigurationBaseDeDonnees::getNomHote();
            $login = ConfigurationBaseDeDonnees::getLogin();
            $port = ConfigurationBaseDeDonnees::getPort();
            $motDePasse = ConfigurationBaseDeDonnees::getPassword();
            $nomBaseDeDonnees = ConfigurationBaseDeDonnees::getNomBaseDeDonnees();

            $dsn = "mysql:host=$nomHote;port=$port;dbname=$nomBaseDeDonnees;charset=utf8mb4";

            // Création de la connexion PDO
            $this->pdo = new PDO($dsn, $login, $motDePasse, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);

        } catch (PDOException $e) {
            // Afficher une erreur détaillée en cas d'échec de connexion
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // getInstance s'assure que l'unique instance est créée une seule fois
    private static function getInstance(): ConnexionBaseDeDonnees {
        if (self::$instance === null) {
            self::$instance = new ConnexionBaseDeDonnees();
        }
        return self::$instance;
    }
}
?>
