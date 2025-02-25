<?php
namespace App\Pecherie\Controleur;

class ControleurClient extends controleurGenerique {



    
    public static function afficherFormulaireCreation(): void {
        ControleurClient::afficherVue('vueGenerale.php', ["titre" => "Créer étudiant", "cheminCorpsVue" => "utilisateur/formulaireCreation.php"]);
    }
}
?>