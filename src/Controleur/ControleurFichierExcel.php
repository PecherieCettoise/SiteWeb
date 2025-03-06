<?php
namespace App\Pecherie\Controleur;


use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Modele\GestionFichier\GestionFichierExcel;
use PDO;


class ControleurFichierExcel extends ControleurGenerique {

    public static function afficherFichierExcel() {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Fichier Excel",
            "cheminCorpsVue" => "fichierExel/formulaireImportationExel.php"
        ]);
    }

    public static function importerFichierExcel() {
        // Vérifier si un fichier a été envoyé
        if (isset($_FILES['fileImporte']) && $_FILES['fileImporte']['error'] === 0) {
            echo "Fichier téléchargé: " . $_FILES['fileImporte']['name']; // Vérification du nom du fichier
            echo " Taille du fichier: " . $_FILES['fileImporte']['size']; // Vérification de la taille du fichier
            echo " Type du fichier: " . $_FILES['fileImporte']['type']; // Vérification du type du fichier

            // Connexion à la base de données
            $pdo = new PDO("mysql:host=172.17.0.3;port=3306;dbname=PecherieCettoise;charset=utf8mb4", "root", "Corentin2004");

            // Créez une instance de la classe GestionFichierExcel
            $gestionFichier = new GestionFichierExcel($pdo);

            // Appel de la méthode d'importation
            $result = $gestionFichier->importerFichierCSV($_FILES['fileImporte']['tmp_name']);

            // Vérification du résultat de l'importation
            var_dump($result); // Affiche les résultats de l'importation

            // Rediriger en fonction du résultat de l'importation
            if (isset($result['success'])) {
                MessageFlash::ajouter("success", $result['success']);
                ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherProfil&controleur=utilisateur");
            } else {
                /*MessageFlash::ajouter("danger", $result['error']);
                ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherProduits&controleur=page");*/
            }
        } else {
            // Aucune erreur spécifique au téléchargement
            MessageFlash::ajouter("danger", "Le fichier n'a pas été correctement téléchargé.");
            ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherProduits&controleur=page");
        }
        exit;
    }

}
?>
