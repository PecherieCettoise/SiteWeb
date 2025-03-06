<?php
namespace App\Pecherie\Modele\GestionFichier;

use PDO;
use PDOException;

class GestionFichierExcel {

    private $pdo;

    public function __construct() {
        // Créez la connexion à la base de données avec l'encodage utf8mb4
        $this->pdo = new PDO(
            "mysql:host=172.17.0.3;port=3306;dbname=PecherieCettoise;charset=utf8mb4",
            "root",
            "Corentin2004",
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
            ]
        );
    }

    // La méthode d'importation de votre fichier CSV
    public function importerFichierCSV($filePath) {
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            fgetcsv($handle); // Sauter la première ligne (en-têtes)
            $data = [];

            // Lire chaque ligne du fichier CSV
            while (($row = fgetcsv($handle)) !== FALSE) {
                $numero = $row[0];
                $intitule = $row[1];
                $categorie_tarifaire = $row[2];
                $email = $row[3];

                // Ajouter les données dans le tableau
                $data[] = [$numero, $intitule, $categorie_tarifaire, $email];
            }
            fclose($handle);

            // Insérer les données dans la base de données
            try {
                // Utilisation de INSERT IGNORE pour ignorer les doublons
                $sql = "INSERT IGNORE INTO client (numero, intitule, categorie_tarifaire, email) VALUES (?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);

                // Démarrer la transaction pour améliorer les performances
                $this->pdo->beginTransaction();

                // Exécuter la requête pour chaque ligne
                foreach ($data as $row) {
                    $stmt->execute($row);
                }

                // Valider la transaction
                $this->pdo->commit();

                return ['success' => 'Importation réussie.'];

            } catch (PDOException $e) {
                $this->pdo->rollBack();
                return ['error' => 'Erreur de base de données : ' . $e->getMessage()];
            }
        }
    }
}

?>
