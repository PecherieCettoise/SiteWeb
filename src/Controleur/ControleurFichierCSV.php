<?php
namespace App\Pecherie\Controleur;


use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Modele\GestionFichier\GestionFichierCSV;
use PDO;


class ControleurFichierCSV extends ControleurGenerique {

    public static function afficherFormulaireImportation() {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Importation de fichiers",
            "cheminCorpsVue" => "fichierExel/formulaireImportationCSV.php"
        ]);
    }

    public static function importerFichiers() {
        $pdo = new PDO("mysql:host=172.17.0.3;port=3306;dbname=PecherieCettoise;charset=utf8mb4", "root", "Corentin2004");
        $gestionFichier = new GestionFichierCSV($pdo);
        $messages = [];

        // Vérification et traitement du fichier client
        if (isset($_FILES['fileClient']) && $_FILES['fileClient']['error'] === 0) {
            $result = $gestionFichier->importerFichierCSV($_FILES['fileClient']['tmp_name']);
            $messages[] = $result['success'] ?? $result['error'];
        }

        // Vérification et traitement du fichier produit
        if (isset($_FILES['fileProduit']) && $_FILES['fileProduit']['error'] === 0) {
            $result = $gestionFichier->importerFichierCSV2($_FILES['fileProduit']['tmp_name']);
            $messages[] = $result['success'] ?? $result['error'];
        }

        // Affichage des messages
        foreach ($messages as $message) {
            MessageFlash::ajouter($message === "Importation réussie." ? "success" : "danger", $message);
        }

        ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherProfil&controleur=utilisateur");
        exit;
    }

}
?>
