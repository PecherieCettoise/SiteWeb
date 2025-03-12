<?php
namespace App\Pecherie\Modele\GestionFichier;

use App\Pecherie\Lib\MotDePasse;
use PDO;
use PDOException;

class GestionFichierCSV {
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
                "INSERT INTO client (numero, intitule, categorie_tarifaire, date_creation, email) VALUES (?, ?, ?, ?, ?)"
            );

            $stmtUtilisateur = $this->pdo->prepare(
                "INSERT INTO utilisateurs (login, nom, mdp, mdp_clair, Role) VALUES (?, ?, ?, ?, ?)"
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
                $email = !empty($email) ? $email : null; // Convertir '' en NULL

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


    public function importerFichierCSV2(string $fileTmpPath): array {
        set_time_limit(300);
        if (($handle = fopen($fileTmpPath, 'r')) === FALSE) {
            return ["error" => "Erreur lors de l'ouverture du fichier CSV."];
        }

        // Passer la première ligne (les en-têtes)
        fgetcsv($handle);

        try {
            $stmtProduit = $this->pdo->prepare(
                "INSERT INTO produit (reference_article, designation, PrixVente, stock_reel, stock_disponible, stockATerme, Poids_Net) 
              VALUES (?, ?, ?, ?, ?, ?, ?)"
            );

            // Tableau pour les lignes uniques
            $uniqueRows = [];

            while (($row = fgetcsv($handle)) !== FALSE) {
                // Nettoyer les valeurs pour éviter les erreurs SQL
                $reference_article = trim($row[0] ?? '');
                $designation = trim($row[1] ?? '');
                $prixVente = trim($row[2] ?? '');
                $stockReel = trim($row[3] ?? 0);
                $stockDisponible = trim($row[4] ?? 0);
                $stockATerme = trim($row[5] ?? NULL);
                $poidsNet = trim($row[6] ?? 0);

                // Convertir la designation en UTF-8
                $designation = mb_convert_encoding($designation, 'UTF-8', 'auto');

                // Supprimer les caractères non valides de designation
                $designation = preg_replace('/[^\x20-\x7E\xA0-\xFF]/', '', $designation);

                // Nettoyer la valeur de Poids_Net pour enlever " kg"
                if (strpos($poidsNet, ' kg') !== false) {
                    $poidsNet = str_replace(' kg', '', $poidsNet);
                }

                // Vérifier si Poids_Net est numérique
                if (!is_numeric($poidsNet)) {
                    $poidsNet = 0; // ou NULL si tu préfères
                } else {
                    $poidsNet = (float)$poidsNet;
                }

                // Vérifier et nettoyer stockReel
                if (!is_numeric($stockReel)) {
                    $stockReel = 0;
                } else {
                    $stockReel = (float)$stockReel;
                }

                // Vérifier et nettoyer stockDisponible
                if (!is_numeric($stockDisponible)) {
                    $stockDisponible = 0;
                } else {
                    $stockDisponible = (float)$stockDisponible;
                }

                // Vérifier et nettoyer stockATerme, le rendre NULL si vide
                if (empty($stockATerme) || !is_numeric($stockATerme)) {
                    $stockATerme = NULL; // ou 0 si tu préfères
                } else {
                    $stockATerme = (float)$stockATerme;
                }

                // Créer une clé unique pour chaque produit
                $rowKey = $reference_article . '|' . $designation;

                // Vérifier si la ligne existe déjà dans les lignes uniques
                if (!in_array($rowKey, $uniqueRows)) {
                    // Ajouter la ligne unique et insérer les données dans la table produit
                    $uniqueRows[] = $rowKey;

                    // Exécution de la requête d'insertion
                    if (!$stmtProduit->execute([$reference_article, $designation, $prixVente, $stockReel, $stockDisponible, $stockATerme, $poidsNet])) {
                        // Si la requête échoue, afficher l'erreur
                        $errorInfo = $stmtProduit->errorInfo();
                        return ["error" => "Erreur lors de l'insertion dans la table produit : " . $errorInfo[2]];
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
        return 'particulier';
    }
}
?>