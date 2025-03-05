<?php

namespace App\Pecherie\GestionFichier;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Pecherie\Modele\Repository\ClientsRepository;

class GestionFichierExcel {

    /**
     * @param $fileImporte
     * @return array
     * Cette méthode permet de vérifier et importer un fichier Excel pour la table `client`.
     */
    public static function importationFichierExcelClient($fileImporte) : array {

        // Vérification si un fichier a été uploadé
        if (isset($fileImporte) && $fileImporte['error'] === UPLOAD_ERR_OK) {
            $file = $fileImporte;

            // Vérifier si le fichier est bien un Excel (XLSX ou XLS)
            $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
            if ($fileType !== 'xlsx' && $fileType !== 'xls') {
                return [0]; // Le fichier n'est pas un Excel
            } else {
                // Utilisation du fichier depuis l'emplacement temporaire
                $fileTmpPath = $file['tmp_name'];

                // Vérification si le fichier est accessible
                if (is_uploaded_file($fileTmpPath)) {
                    return GestionFichierExcel::remplirClientBDD($fileTmpPath);
                }
            }
        } else {
            return [-2]; // Aucun fichier sélectionné ou erreur lors de l'upload
        }

        return [-1]; // Erreur inconnue
    }

    /**
     * @param $fileTmpPath
     * @return array
     * Cette méthode permet d'importer les données du fichier Excel et de remplir la table `client`.
     */
    public static function remplirClientBDD($fileTmpPath) : array {

        // Initialisation du tableau et requêtes d'insertion
        $valuesClient = [];
        $sqlClient = (new ClientsRepository())->creerRequete();

        // Lecture du fichier Excel avec PhpSpreadsheet
        $spreadsheet = IOFactory::load($fileTmpPath);

        // Récupérer la première feuille du fichier Excel
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow(); // Dernière ligne
        $highestColumn = $sheet->getHighestColumn(); // Dernière colonne
        $librairie = array();

        // Parcours de la première ligne pour récupérer les noms des colonnes
        $columns = $sheet->rangeToArray('A1:' . $highestColumn . '1')[0];
        $i = 0;

        // Identifier les indices des colonnes
        foreach ($columns as $colonne) {
            if ($colonne == 'IDClient') {
                $librairie['idClient'] = $i++;
            } else if ($colonne == 'intitule') {
                $librairie['intitule'] = $i++;
            } else if ($colonne == 'categorie_tarifaire') {
                $librairie['categorie_tarifaire'] = $i++;
            } else if ($colonne == 'date_creation') {
                $librairie['date_creation'] = $i++;
            } else if ($colonne == 'email') {
                $librairie['email'] = $i++;
            } else if ($colonne == 'numero') {
                $librairie['numero'] = $i++;
            }
        }

        // Lecture des lignes suivantes (les données) du fichier Excel
        for ($row = 2; $row <= $highestRow; $row++) {
            $valuesClient[] = [
                'idClient' => isset($librairie['idClient']) ? $sheet->getCellByColumnAndRow($librairie['idClient'] + 1, $row)->getValue() : null,
                'intitule' => isset($librairie['intitule']) ? $sheet->getCellByColumnAndRow($librairie['intitule'] + 1, $row)->getValue() : null,
                'categorie_tarifaire' => isset($librairie['categorie_tarifaire']) ? $sheet->getCellByColumnAndRow($librairie['categorie_tarifaire'] + 1, $row)->getValue() : null,
                'date_creation' => isset($librairie['date_creation']) ? $sheet->getCellByColumnAndRow($librairie['date_creation'] + 1, $row)->getValue() : null,
                'email' => isset($librairie['email']) ? $sheet->getCellByColumnAndRow($librairie['email'] + 1, $row)->getValue() : null,
                'numero' => isset($librairie['numero']) ? $sheet->getCellByColumnAndRow($librairie['numero'] + 1, $row)->getValue() : null,
            ];
        }

        // Exécution de la requête d'insertion
        (new ClientsRepository())->executerRequete($sqlClient, $valuesClient);

        return [1]; // Succès de l'importation
    }
}
