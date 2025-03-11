<?php
namespace App\Pecherie\Controleur;

use App\Pecherie\Lib\MessageFlash;

class ControleurGenerique
{
    /**
     * Affiche une vue en utilisant un chemin et des paramètres.
     *
     * @param string $cheminVue Le chemin relatif de la vue.
     * @param array $parametres Les paramètres à passer à la vue.
     * @return void
     */
    protected static function afficherVue(string $cheminVue, array $parametres = []): void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        $messagesFlash = MessageFlash::lireTousMessages();
        require __DIR__ . "/../Vue/$cheminVue"; // Charge la vue
    }

    /**
     * Affiche une erreur dans la vue générale.
     *
     * @param string $messageErreur Le message d'erreur à afficher.
     * @param string|null $controleur Le nom du contrôleur pour la redirection.
     * @param string|null $action L'action pour la redirection.
     * @return void
     */
    public static function afficherErreur(string $messageErreur, $controleur, $action): void {
        self::afficherVue('vueGenerale.php', [
            "titre" => "Erreur",
            "cheminCorpsVue" => "erreur.php",
            "messageErreur" => $messageErreur,
            "controleur" => $controleur,
            "action" => $action
        ]);

    }

    /**
     * Affiche le formulaire de préférence.
     *
     * @return void
     */
    public static function afficherFormulairePreference(): void {
        $chemin = [
            "Accueil" => "controleurFrontal.php?action=afficherFormulaireClassement&controleur=etudiant",
            "Péférences" => "#"
        ];
        self::afficherVue('vueGenerale.php', [
            "titre" => "formulaire préférence",
            "cheminCorpsVue" => "formulairePreference.php",
            'chemin' => $chemin
        ]);
    }

    /**
     * Effectue une redirection vers une URL donnée.
     *
     * @param string $url L'URL vers laquelle rediriger.
     * @return void
     */
    public static function redirectionVersURL($url): void {
        header("Location: $url");
        exit();
    }
}
?>