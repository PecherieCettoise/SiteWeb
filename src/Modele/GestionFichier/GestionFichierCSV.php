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

        fgetcsv($handle); // Ignorer les en-têtes

        try {
            $stmtClient = $this->pdo->prepare(
                "INSERT INTO client (numero, intitule, categorie_tarifaire, date_creation, email) 
                VALUES (?, ?, ?, ?, ?)"
            );

            $stmtUtilisateur = $this->pdo->prepare(
                "INSERT INTO utilisateurs (login, nom, mdp, mdp_clair, Role, IDClient) 
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            $uniqueRows = [];

            while (($row = fgetcsv($handle)) !== FALSE) {
                $numero = trim($row[0] ?? '');
                $intitule = trim($row[1] ?? '');
                $categorie_tarifaire = trim($row[2] ?? '');
                $date_creation = trim($row[3] ?? '');
                $email = trim($row[4] ?? '') ?: null;

                $rowKey = $numero . '|' . $intitule . '|' . $categorie_tarifaire . '|' . $date_creation;

                if (!in_array($rowKey, $uniqueRows)) {
                    $uniqueRows[] = $rowKey;

                    // Insérer dans `client`
                    $stmtClient->execute([$numero, $intitule, $categorie_tarifaire, $date_creation, $email]);

                    // Récupérer l'ID du client inséré
                    $clientID = $this->pdo->lastInsertId();

                    // Vérifier si l'utilisateur existe déjà
                    $stmtCheck = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE login = ?");
                    $stmtCheck->execute([$numero]);

                    if ($stmtCheck->fetchColumn() == 0) {
                        $role = $this->determinerRole($categorie_tarifaire);
                        $mdp = MotDePasse::genererChaineAleatoire(12);
                        $mdpHache = MotDePasse::hacher($mdp);

                        // Insérer l'utilisateur avec le bon `IDClient`
                        $stmtUtilisateur->execute([$numero, $intitule, $mdpHache, $mdp, $role, $clientID]);
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

        // Lire tout le fichier et forcer l'encodage en UTF-8 (si nécessaire)
        $fileContents = file_get_contents($fileTmpPath);
        $fileContents = mb_convert_encoding($fileContents, 'UTF-8', 'auto');  // Convertir en UTF-8
        $tempFile = tmpfile();
        fwrite($tempFile, $fileContents);
        rewind($tempFile);

        // Ouvrir le fichier corrigé
        $handle = $tempFile;

        // Passer la première ligne (les en-têtes)
        fgetcsv($handle, 0, ';');  // Spécifie le point-virgule comme délimiteur

        try {
            // Préparation de la requête d'insertion avec les nouvelles colonnes
            $stmtProduit = $this->pdo->prepare(
                "INSERT INTO produit 
            (reference_article, designation, parenthese, PV_POISS, MB_POISS, PV_RESTO, MB_RESTO, PV_GD, MB_GD) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            // Tableau pour les lignes uniques
            $uniqueRows = [];

            $rowNumber = 1;  // Initialiser le compteur de lignes
            while (($row = fgetcsv($handle, 0, ';')) !== FALSE) {  // Spécifie le point-virgule comme délimiteur
                $rowNumber++;  // Incrémenter le numéro de ligne

                // Nettoyer et valider reference_article
                $reference_article = trim($row[0] ?? '');
                if (!is_numeric($reference_article)) {
                    return ["error" => "La référence de l'article doit être un nombre valide. Erreur à la ligne " . $rowNumber . " avec la valeur : " . $row[0]];
                }
                $reference_article = (int)$reference_article;

                // Convertir les valeurs en UTF-8, tout en nettoyant les espaces et les caractères spéciaux
                $designation = mb_convert_encoding(trim($row[1] ?? ''), 'UTF-8', 'auto');
                $parenthese = mb_convert_encoding(trim($row[2] ?? ''), 'UTF-8', 'auto');
                if ($parenthese === "0") {
                    $parenthese = '';
                }

                // Convertir les valeurs avec des virgules en points
                $PV_POISS = str_replace(',', '.', trim($row[3] ?? 0));
                $MB_POISS = str_replace(',', '.', trim($row[4] ?? NULL));
                $PV_RESTO = str_replace(',', '.', trim($row[5] ?? 0));
                $MB_RESTO = str_replace(',', '.', trim($row[6] ?? NULL));
                $PV_GD = str_replace(',', '.', trim($row[7] ?? 0));
                $MB_GD = str_replace(',', '.', trim($row[8] ?? NULL));

                // Vérifier que les valeurs sont numériques
                $PV_POISS = is_numeric($PV_POISS) ? (float)$PV_POISS : 0;
                $MB_POISS = is_numeric($MB_POISS) ? (float)$MB_POISS : NULL;
                $PV_RESTO = is_numeric($PV_RESTO) ? (float)$PV_RESTO : 0;
                $MB_RESTO = is_numeric($MB_RESTO) ? (float)$MB_RESTO : NULL;
                $PV_GD = is_numeric($PV_GD) ? (float)$PV_GD : 0;
                $MB_GD = is_numeric($MB_GD) ? (float)$MB_GD : NULL;

                // Vérifier si la référence de l'article existe déjà dans la base de données
                $stmtCheck = $this->pdo->prepare("SELECT COUNT(*) FROM produit WHERE reference_article = ?");
                $stmtCheck->execute([$reference_article]);
                $exists = $stmtCheck->fetchColumn();

                // Si la référence existe déjà, ignorer l'insertion ou mettre à jour
                if ($exists == 0) {
                    // Créer une clé unique pour chaque produit
                    $rowKey = $reference_article . '|' . $designation;

                    // Vérifier si la ligne existe déjà dans les lignes uniques
                    if (!in_array($rowKey, $uniqueRows)) {
                        $uniqueRows[] = $rowKey;

                        // Exécution de la requête d'insertion
                        if (!$stmtProduit->execute([$reference_article, $designation, $parenthese, $PV_POISS, $MB_POISS, $PV_RESTO, $MB_RESTO, $PV_GD, $MB_GD])) {
                            $errorInfo = $stmtProduit->errorInfo();
                            return ["error" => "Erreur lors de l'insertion dans la table produit : " . $errorInfo[2]];
                        }
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
        if (in_array($categorie_tarifaire, ['PROFESSIONNELS'])) {
            return 'professionnel';
        } elseif (in_array($categorie_tarifaire, ['GD'])) {
            return 'grande distribution';
        } elseif (in_array($categorie_tarifaire, ['RESTAURANT'])) {
            return 'restaurant';
        }
        return 'particulier';
    }
}
?>