<?php
namespace App\Pecherie\Modele\GestionFichier;

use App\Pecherie\Lib\MotDePasse;
use PDO;
use PDOException;

class GestionFichierExcel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function importerFichierCSV(string $fileTmpPath): array {
        set_time_limit(300);
        if (($handle = fopen($fileTmpPath, 'r')) === FALSE) {
            return ["error" => "Erreur lors de l'ouverture du fichier CSV."];
        }

        // Passer la première ligne (les en-têtes)
        fgetcsv($handle);

        try {
            $stmtClient = $this->pdo->prepare(
                "INSERT IGNORE INTO client (numero, intitule, categorie_tarifaire, date_creation, email) VALUES (?, ?, ?, ?, ?)"
            );

            $stmtUtilisateur = $this->pdo->prepare(
                "INSERT IGNORE INTO utilisateurs (login, nom, mdp, mdp_clair, Role) VALUES (?, ?, ?, ?, ?)"
            );

            // Tableau pour les lignes uniques
            $uniqueRows = [];

            while (($row = fgetcsv($handle)) !== FALSE) {
                // Nettoyer les valeurs pour éviter les erreurs SQL
                $numero = trim($row[0] ?? '');
                $intitule = trim($row[1] ?? '');
                $categorie_tarifaire = trim($row[2] ?? '');
                $date_creation = trim($row[3] ?? '');
                $email = trim($row[4] ?? '');

                // Créer une clé unique pour chaque ligne sans l'email
                $rowKey = $numero . '|' . $intitule . '|' . $categorie_tarifaire . '|' . $date_creation;

                // Vérifier si la ligne existe déjà dans les lignes uniques
                if (!in_array($rowKey, $uniqueRows)) {
                    // Ajouter la ligne unique et insérer les données dans les tables
                    $uniqueRows[] = $rowKey;

                    // Insérer dans `client`
                    $stmtClient->execute([$numero, $intitule, $categorie_tarifaire, $date_creation, $email]);

                    // Définir le rôle avec les conditions spécifiques
                    $role = $this->determinerRole($categorie_tarifaire);

                    // Générer un login unique
                    $login = $numero;

                    // Vérifier si l'utilisateur existe déjà
                    $stmtCheck = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE login = ?");
                    $stmtCheck->execute([$login]);
                    if ($stmtCheck->fetchColumn() == 0) {
                        // Générer et hacher un mot de passe
                        $mdp = MotDePasse::genererChaineAleatoire(12);
                        $mdpHache = MotDePasse::hacher($mdp);

                        // Insérer dans `utilisateurs`
                        $stmtUtilisateur->execute([$login, $intitule, $mdpHache, $mdp, $role]);
                    }
                }
            }

            fclose($handle);

            return ["success" => "Importation réussie."];
        } catch (PDOException $e) {
            return ["error" => "Erreur de base de données : " . $e->getMessage()];
        }
    }

    // Fonction pour déterminer le rôle
    private function determinerRole(string $categorie_tarifaire): string {
        // Vérifie les différents types de catégories et renvoie le rôle approprié
        if (in_array($categorie_tarifaire, ['PROFESSIONNELS', 'GD', 'RESTAURANT'])) {
            return 'professionnel';
        }

        // Si aucune correspondance n'est trouvée, renvoie 'particulier'
        return 'particulier';
    }
}
?>
