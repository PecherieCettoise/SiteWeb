<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Modele\GestionFichier\GestionFichierExcel;


class ControleurFichierExel extends ControleurGenerique
{
    public static function afficherFichierExcel()
    {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Fichier Exel",
            "cheminCorpsVue" => "fichierExel/formulaireImportationExel.php"
        ]);
    }

    public static function importerFichierExcel()
    {
        // Vérifier si un fichier a été envoyé via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileImporte'])) {
            // Appel de la méthode d'importation
            $result = GestionFichierExcel::importationFichierExcelClient($_FILES['fileImporte']);

            // Rediriger en fonction du résultat de l'importation
            if ($result[0] === 1) {
                header('Location: votre_page.php?success=1');
            } else {
                header('Location: votre_page.php?error=1');
            }
            exit;
        }
    }
}
