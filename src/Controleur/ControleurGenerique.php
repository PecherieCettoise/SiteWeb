<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Lib\MessageFlash;

class ControleurGenerique
{
    /**
     * @param string $cheminVue
     * @param array $parametres
     * @return void
     * Action protected pour que ses filles puissent l'utiliser sans la modifier
     */
    protected static function afficherVue(string $cheminVue, array $parametres = []): void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        $messagesFlash = MessageFlash::lireTousMessages();
        require __DIR__ . "/../$cheminVue"; // Charge la vue
    }


    /**
     * @param string $messageErreur
     * @return void
     * Cette action affiche une vue avec un message centrale d'erreur
     */
    public static function afficherErreur(string $messageErreur, null|string $controleur, null|string $action): void {
        self::afficherVue('vueGenerale.php', ["titre" => "Erreur", "cheminCorpsVue" => "erreur.php", "messageErreur" => $messageErreur, "controleur" => $controleur,"action" => $action]);
    }

    public static function afficherFormulairePreference(): void {
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherFormulaireClassement&controleur=etudiant",
            "Péférences" =>   "#"
        );
        self::afficherVue('vueGenerale.php', ["titre" => "formulaire preference", "cheminCorpsVue" => "formulairePreference.php", 'chemin' => $chemin]);
    }

    public static function redirectionVersURL($url): void {
        header("Location: $url");
        exit();
    }
}