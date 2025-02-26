<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Controleur\ControleurGenerique ;


class ControleurClient extends ControleurGenerique {



    
    public static function afficherFormulaireCreation(): void {
        ControleurClient::afficherVue('vueGenerale.php', ["titre" => "Créer Client", "cheminCorpsVue" => "utilisateur/formulaireCreation.php"]);
    }
}
?>